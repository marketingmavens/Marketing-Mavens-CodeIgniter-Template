<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ajax extends CI_Controller {

  var $data; //Put all data for the page in this object
  var $post; //Object with all of POST data


  function __construct()
  {
    parent::__construct();
    $this->data = new stdClass();
    $this->post = array_to_object($this->input->post());
  }

	public function index()
	{
    redirect('/');
	}


}