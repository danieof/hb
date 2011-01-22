<?php
/*
 * Description
 *
 * @property MX_Loader $load
 */
class account extends MY_Controller {
    public function  __construct() {
        parent::__construct();
    }

    public function index() {
        redirect('account/details');
    }

    public function details() {
        $user = new User();
        //$data = $user->get()->all;
        
        foreach ($user->profile->get()->all as $d) {
            //echo $d->__toString();
            echo $d->id . '<br />';
            echo $d->name . '<br />';
            echo $d->surname . '<br />';
            //echo $d->id . '<br />';
        }
        exit;

        $this->_render('account/details', $data, __FUNCTION__, lang('topmenu_details'));
    }
}