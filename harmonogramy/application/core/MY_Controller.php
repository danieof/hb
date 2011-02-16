<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . 'third_party/MX/Controller.php';

class MY_Controller extends MX_Controller {
	public function __construct() {
		parent::__construct();
        $this->load->library('tank_auth');
		$this->lang->load('tank_auth');
        $this->load->config('tank_auth');
	}
}

/* End of file MY_Controller.php */
/* Location: ./application/libraries/MY_Controller.php */