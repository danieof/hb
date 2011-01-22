<?php

class User extends DataMapper {
    public $table = 'users';
    public $has_one = array('profile');

    public function  __construct() {
        parent::DataMapper();
    }
}

/* End of file user.php */
/* Location: ./application/modules/user/models/user.php */