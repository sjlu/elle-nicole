<?php if (!defined('BASEPATH')) die();
class View extends Main_Controller {

   function index()
	{
		$this->load->model('content_model');
		$data = $this->content_model->get();

		echo phpinfo();

      $this->load->view('include/header');
      $this->load->view('view', $data);
      $this->load->view('include/footer');
	}
   
   function phpinfo()
   {
		echo phpinfo();
   }
}

/* End of file frontpage.php */
/* Location: ./application/controllers/frontpage.php */
