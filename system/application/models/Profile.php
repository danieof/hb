<?php

class Profile extends DataMapper {
    public $table = 'profiles';
    public $has_one = array('user');

    public function  __construct() {
        parent::DataMapper();
    }
}

/* End of file Profile.php */
/* Location: ./application/models/Profile.php */