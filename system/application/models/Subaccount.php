<?php
class Subaccount extends DataMapper {
    public $has_one = array('account', 'subtype');
    public $has_many = array('transaction');

    public function  __construct() {
        parent::DataMapper();
    }
}

/* End of file Subaccount.php */
/* Location: ./application/models/Subaccount.php */