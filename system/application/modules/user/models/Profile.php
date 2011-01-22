<?php

class Profile extends DataMapper {
    public $table = 'profiles';
    public $has_one = array('user');

    public function  __construct() {
        parent::DataMapper();
    }
}

/* End of file profile.php */
/* Location: ./application/modules/user/models/profile.php */