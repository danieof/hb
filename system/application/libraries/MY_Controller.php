<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/* load the MX_Loader class */
require APPPATH."third_party/MX/Controller.php";

/*
 * class MY_Controller
 *
 * @property Template $template
 */
class MY_Controller extends MX_Controller {
    public function  __construct() {
        parent::__construct();
        $this->load->library('tank_auth');
        $this->lang->load('top_menu');
        $this->lang->load('common');
        $this->template->set('subpagetitle', 'Welcome');
    }

    public function _addToTitle($value, $delim = '-') {
        $current = $this->template->get('site_name');
        if (is_array($value)) {
            foreach ($value as $val) {
                $this->_addToTitle($val, $delim);
            }
        } else {
            $this->template->set('site_name', $current . ' ' . $delim . ' ' . $value);
        }
    }

    public function _render($view, $data, $method, $addtotitle) {
        $this->_addToTitle(humanize($addtotitle));
        $this->template->set('subpagetitle', humanize($method));
        $this->template->set($data);
        $this->template->current_view = $view;
        $this->template->render();
    }
}