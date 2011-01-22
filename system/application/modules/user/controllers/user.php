<?php
class user extends MY_Controller {
    public function  __construct() {
        parent::__construct();
    }

    public function index() {
        redirect('user/details');
    }

    public function details() {
        $data = '';

        $this->_render('user/details', $data, __FUNCTION__, lang('topmenu_details'));
    }
}