<?php
class Privileges_user extends DataMapper {
    public $table = 'privileges_users';
    public $has_one = array();
    public $has_many = array('account');

    public function  __construct() {
        parent::DataMapper();
    }
}

/* End of file Privileges_user.php */
/* Location: ./application/models/Privileges_user.php */