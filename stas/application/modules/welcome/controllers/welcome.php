<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends MY_Controller {
	function __construct() {
		parent::__construct();
	}

	function index() {
        $this->template->render();
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */