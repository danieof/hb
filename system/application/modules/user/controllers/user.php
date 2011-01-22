<?php
/*
 * Description
 *
 * @property MX_Loader $load
 */
class user extends MY_Controller {
    public function  __construct() {
        parent::__construct();
        //$this->load->model('user');
    }

    public function index() {
        redirect('user/details');
    }

    public function details() {
        $this->user = new User();
        //$this->load->model('user');
        $data = '';//$this->user->get();
        //print_r($data);exit;

        $this->_render('user/details', $data, __FUNCTION__, lang('topmenu_details'));
    }
}