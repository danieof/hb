<?php

/**
 * @property CI_Model $db
 */
class Users_model extends CI_Model {
    private $table = 'users';

    public function __construct() {
        parent::__construct();
    }

    public function addUser($data) {
        if (!isset($data['imie']) ||
            !isset($data['nazwisko'])) {
            return false;
        }
        if ('' != $data['imie'] &&
            '' != $data['nazwisko']) {

            $this->db->insert($this->table, $data);
            return true;
        }
        return false;
    }

    public function getUsers() {
        $res = $this->db->select()->get($this->table);
        $res = $res->result_array();
        return $res;
    }

    public function getUser($user_id) {
        $res = $this->db->where('id', $user_id)->select()->get($this->table);
        $res = $res->row_array();
        return $res;
    }
}