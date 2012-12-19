<?php

class Content_model extends CI_Model
{
	private $cache = array();

	function __construct()
	{
		parent::__construct();
		$this->load->helper('directory');
		$this->load->library('image_lib');

		$image_map = directory_map('cache');
		foreach ($image_map as $object)
		{
			if (!is_array($object))
				$this->cache['images'][$object] = true;
		}
	}

	private function __cached_image_exists($file)
	{
		return isset($this->cache['images'][basename($file)]);
	}

	private function _image($file, $hidpi = false)
	{
		$output = 'cache/'.md5($file);

      if ($hidpi)
         $output .= '@2x';

      $output .= '.'.pathinfo($file, PATHINFO_EXTENSION);

		if ($this->__cached_image_exists($output))
			return $output;

		$config = array(
			'image_library' => 'gd2',
			'source_image' => $file,
			'new_image' => $output,
			'maintain_ratio' => true,
			'height' => ($hidpi) ? 920 : 460,
			'width' => 9999999999 // simulate infinity
		);

		$this->image_lib->initialize($config);
		if (!$this->image_lib->resize())
			exit('GD2 does not seem to be configured correctly.');

		$this->image_lib->clear();

      // make a hidpi version
      $this->_image($file, true);

		return $output;
	}

	private function _text($file)
	{
		$output = array();
		$input = read_file($file);
		$lines = explode("\n", $input);

		if (count($lines) == 1)
			return utf8_encode($lines[0]);

		foreach ($lines as &$line)
		{
			$data = explode(":", $line, 2);
			if (count($data) < 2)
				continue;

			$key = trim($data[0]);
			$value = utf8_encode(trim($data[1]));

			$output[$key] = $value;
		}

		return $output;
	}

	private function _parse($map, $path)
	{
		$output = array();
		asort($map);

		foreach ($map as $key => $object)
		{
			if (is_array($object))
				$output['directories'][strtolower($key)] = $this->_parse($object, $path.'/'.$key);
			else if (preg_match('/jpg|jpeg|png|gif/i', $object))
				if ($returned = $this->_image($path.'/'.$object))
					$output['images'][] = $returned;
			else if (preg_match('/txt/i', $object))
				$output['properties'] = $this->_text($object); 
		}
		
		return $output;
	}

	function get()
	{
		$map = directory_map('content');
		return $this->_parse($map, 'content');
	}

}
