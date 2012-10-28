<?php

class Content_model extends CI_Model
{

	function __construct()
	{
		parent::__construct();

		$this->load->helper('directory');
	}

	private function _image($file)
	{
		$output = 'cache/' . md5($file).'.'.pathinfo($file, PATHINFO_EXTENSION);

		$config = array(
			'image_library' => 'imagick',
			'source_image' => $file,
			'new_image' => $output,
			'maintain_ratio' => true,
			'height' => 460
		);

		$this->load->library('image_lib', $config);
		$this->image_lib->resize();

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
		foreach ($map as $key => $object)
		{
			if (is_array($object))
				$output['directories'] = $this->_parse($object, $path.'/'.$key);
			else if (preg_match('/jpg|jpeg|png|gif/i', $object))
				// $output['images'][] = $path.'/'.$object;
				$output['images'][] = $this->_image($path.'/'.$object);
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