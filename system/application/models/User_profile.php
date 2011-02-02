<?php
class User_profile extends DataMapper {
    public $table = 'user_profiles';
    public $has_one = array('user');

    public function  __construct() {
        parent::DataMapper();
    }
}

/* End of file User_profile.php */
/* Location: ./application/models/User_profile.php */