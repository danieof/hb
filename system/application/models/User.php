<?php

class User extends DataMapper {
    public $table = 'users';
    public $has_one = array('profile');
    public $has_many = array('account', 'privilege');

    public function  __construct() {
        parent::DataMapper();
    }

    public function makeFirstAccount() {
        if (!$this->account->get()->id) {
            // make privilege
            $privilege = new Privilege();
            $privilege->where('privilege_name', 'admin')->get();
            $this->save($privilege);

            // make privileges_user
            $pu = new Privileges_user();
            $pu->where('user_id', $this->id) // for this user
               ->where('privilege_id', $this->privilege->where('privilege_name', 'admin')->get()->id)  // admin privilege
               ->get();
            
            // make account
            $name = new Name();
            $name->nazwa = 'Main account';
            $name->save();
            $account = new Account();
            if ($account->count()) {
                $number = $account->count() + 1;
            } else {
                $number = 1;
            }
            $account->number = $number;
            $account->save(array($name, $pu));
            
            $this->save($account);
            return true;
        }
        return false;
    }

    public function deleteAccount() {
        
    }
}

/* End of file User.php */
/* Location: ./application/models/User.php */