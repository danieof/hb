<?php
class Name extends DataMapper {
    public $has_one = array('account');
    public $has_many = array();

    public function  __construct() {
        parent::DataMapper();
    }
}

/* End of file Name.php */
/* Location: ./application/models/Name.php */