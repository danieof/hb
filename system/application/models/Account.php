<?php
class Account extends DataMapper {
    public $auto_populate_has_one = TRUE;
    public $has_one = array('name');
    public $has_many = array('user', 'privileges_user', 'subaccount');

    public function  __construct() {
        parent::DataMapper();
    }
}

/* End of file Account.php */
/* Location: ./application/models/Account.php */