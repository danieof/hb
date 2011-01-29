<?php
class Privilege extends DataMapper {
    public $table = 'privileges';
    public $has_many = array('user');

    public function  __construct() {
        parent::DataMapper();
    }
}

/* End of file Privilege.php */
/* Location: ./application/models/Privilege.php */