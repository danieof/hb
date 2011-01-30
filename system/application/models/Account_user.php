<?php
class Account_user extends DataMapper {
    public $table = 'accounts_users';
    public $has_one = array();
    public $has_many = array();

    public function  __construct() {
        parent::DataMapper();
    }
}

/* End of file Account.php */
/* Location: ./application/models/Account.php */