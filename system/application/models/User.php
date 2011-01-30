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
            $pu->where('privilege_id', $this->privilege->where('privilege_name', 'admin')->get()->id)  // admin privilege
               ->where('user_id', $this->id) // for this user
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
            $account->save($pu);
            $account->save($name);
            
            $this->save($account);
            return true;
        }
        return false;
    }

    public function deleteAccounts() {
        // pobierz id wszystkich kont
        foreach ($this->account->get()->all as $acc) {
            $id = $acc->id;

            if (1 < $acc->user->count()) {
                //echo $id . ' - wiecej niz jeden user<br />';continue;
                // delete only accounts_users
                $au = new Account_user();
                $au->where('user_id', $this->id)
                   ->where('account_id', $id)
                   ->get()->delete();
                // delete only accounts_privilege_users
                $acc->privileges_user->where('user_id', $this->id)->get()->delete();
            } else {
                //echo $id . ' - jeden user<br />';continue;
                $acc->name->get()->delete();
                $acc->subaccount->get()->delete_all();
                $acc->privileges_user->where('user_id', $this->id)->get()->delete();
                $acc->delete();
            }
        }

        // usun profil
        $this->delete($this->profile->get());
        // usun privilege dla usera
        $this->privilege->get()->delete_all();
    }
}

/* End of file User.php */
/* Location: ./application/models/User.php */