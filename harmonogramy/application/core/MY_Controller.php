<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . 'third_party/MX/Controller.php';

/**
 * @property CI_Form_validation $form_validation
 */
class MY_Controller extends MX_Controller {
    public $data;

	public function __construct() {
		parent::__construct();
        $this->load->library('tank_auth');
		$this->lang->load('tank_auth');
        $this->load->config('tank_auth');

        $this->form_validation->set_error_delimiters('<span class="alert">', '</span>');
        $this->form_validation->CI = &$this; // !!! for callback functions to work
        
        $this->data['js'] = '';
        $this->data['css'] = '';
        $this->template->set($this->data);
	}

    protected function pagination() {
        $this->load->library('pagination');

        $config = array(
            'base_url'    => $this->data['pagination_config']['base_url'],
        	'total_rows'  => $this->data['pagination_config']['total_rows'],
        	'per_page'    => $this->data['pagination_config']['per_page'],
        	'uri_segment' => $this->data['pagination_config']['uri_segment'],
        	'num_links'   => $this->data['pagination_config']['num_links']
        );

        $this->pagination->initialize($this->data['pagination_config']);

        return $this->pagination->create_links();
    }

    // validation callbacks
    public function properHour($text) {
        if (preg_match('#^(\d|[01]\d|2[0-3]):[0-5]\d(:[0-5]\d)?$#', $text))
            return true;
        $this->form_validation->set_message('properHour', 'Pole %s musi zawierać poprawną godzinę, np. 14:26');
        return false;
    }

    public function natural($text) {
        if (!preg_match('#^\d+$#', $text)) {
            $this->form_validation->set_message('natural',
                'Pole %s musi zawierać liczbę naturalną (łącznie z 0).');
            return false;
        }
        return true;
    }
}

/* End of file MY_Controller.php */
/* Location: ./application/libraries/MY_Controller.php */