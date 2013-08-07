<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

  var $data; //Put all data for the page in this object


  function __construct()
  {
    parent::__construct();

    /**
     * Check Login
     */
    //if(!isset($this->session->userdata['customer_id'])):
      //$this->session->set_userdata('message',3);
      //redirect('/login');
    //endif;


    $this->data = new stdClass();



  }

	public function index()
	{

    $this->data->title = 'Home';
    $this->data->class = 'home-page';

		$this->load->view('inc/header',$this->data);
    $this->load->view('pages/home_page');
    $this->load->view('inc/footer');
	}
}

/* End of file home.php */
/* Location: ./application/controllers/home.php */