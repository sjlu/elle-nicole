<?php if (!defined('BASEPATH')) die();
class View extends Main_Controller {

   function index($specific = null)
	{
		$this->load->model('content_model');
		$content = $this->content_model->get();
		$content = $content['directories'];

		$nav = array();
		foreach ($content as $page => &$folder)
			$nav[] = $page;

		if (!empty($specific))
			if (!isset($content[$specific]))
				show_404();
			else
				$content = $content[$specific];

      $this->load->view('include/header', array('nav' => $nav));
      $this->load->view('view', array('content' => $content));
      $this->load->view('include/footer');
	}
   
   function phpinfo()
   {
		echo phpinfo();
   }
}

/* End of file frontpage.php */
/* Location: ./application/controllers/frontpage.php */
