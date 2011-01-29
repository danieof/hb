<?php
class Subtype extends DataMapper {
    public $has_one = array();
    public $has_many = array();

    public function  __construct() {
        parent::DataMapper();
    }
}

/* End of file Subtype.php */
/* Location: ./application/models/Subtype.php */