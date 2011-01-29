<?php
//require_once(APPPATH . 'models/User.php');
//require_once(APPPATH . 'models/Profile.php');
/*
 * Description
 *
 * @property MX_Loader $load
 */
class useraccount extends MY_Controller {
    public function  __construct() {
        parent::__construct();
    }

    public function index() {
        redirect('account/details');
    }

    public function details() {
        $user = new User();
        $user->where('id', $this->tank_auth->get_user_id())->get();

        if ('' != $user->id) {
            $data['id'] = $user->id;
            $data['name'] = $user->email;
            $data['surname'] = $user->last_ip;
            $data['accounts'] = array();
            foreach ($user->account->get()->all as $acc) {
                $data['accounts'][] = $acc->id . ' - ' .$acc->name->nazwa;
            }
        } else {
            $data['id'] = '';
            $data['name'] = '';
            $data['surname'] = '';
            $data['accounts'] = array();
        }

        $this->_render('useraccount/details', $data, __FUNCTION__, lang('topmenu_details'));
    }
}