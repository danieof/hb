<?php

/**
 * @property CI_Model $db
 */
class Uzytkownicy_model extends CI_Model {
    private $t_users;
    private $t_users_workers;
    private $t_workers;

    private $user_id;

    public function __construct() {
        parent::__construct();
        $this->t_users = 'users';
        $this->t_users_workers = 'users_workers';
        $this->t_workers = 'workers';

        $this->user_id = $this->session->userdata('user_id');
    }

    public function getWorkers() {
        $res = $this->db->select()
                        ->from($this->t_users_workers . ' AS uw ')
                        ->join($this->t_workers . ' AS w ', 'w.id = uw.worker_id')
                        ->where('uw.user_id', $this->user_id)
                        ->get()->result_array();
        // ucfirst
        foreach ($res as $k => $r) {
            $res[$k]['firstname'] = ucfirst($r['firstname']);
            $res[$k]['surname']   = ucfirst($r['surname']);
        }
        return $res;
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