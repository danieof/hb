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
        if (!$this->tank_auth->is_logged_in()) {
            redirect('');
        }

        $user = new User();
        $user->where('id', $this->tank_auth->get_user_id())->get();
        $user->profile->get();
        $data = array(
            'name' => $user->profile->name,
            'surname' => $user->profile->surname,
            'birthcity' => $user->profile->birthcity,
            'birthdate' => $user->profile->birthdate,
            'gender' => ($user->profile->gender)?'male':'famale',
        );
        $this->_render('useraccount/details', $data, __FUNCTION__, 'Details');
    }

    public function change_details() {
        if (!$this->tank_auth->is_logged_in()) {
            redirect('');
        }

        $user = new User();
        $user->where('id', $this->tank_auth->get_user_id())->get();

        $config = array(
            array(
                'field' => 'name',
                'label' => 'First name',
                'rules' => 'required'
            ),
            array(
                'field' => 'surname',
                'label' => 'Surname',
                'rules' => 'required'
            ),
            array(
                'field' => 'birthcity',
                'label' => 'City of birth',
                'rules' => ''
            ),
            array(
                'field' => 'birthdate',
                'label' => 'Date of birth',
                'rules' => 'required'
            ),
            array(
                'field' => 'gender',
                'label' => 'Gender',
                'rules' => 'required'
            ),
        );

        $data = array();

        // formularz
        $this->form_validation->set_rules($config);
        
        if ($this->form_validation->run()) {
            $user = new User();
            $user->where('id', $this->tank_auth->get_user_id())->get();
            $user->changeDetails($_POST);
            
            $this->_render('useraccount/success', $data, __FUNCTION__, lang('topmenu_details'));
        } else {
            $this->_render('useraccount/changedetails', $data, __FUNCTION__, 'Change details');
        }
    }
}