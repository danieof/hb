<?php

/**
 * @param CI_Model $db
 */
class Pracownicymodel extends CI_Model {
    private $table_users;
    private $table_workers;
    private $table_users_workers;

    private $user_id;

    public function __construct() {
        parent::__construct();
        $this->config->load();
        $this->table_users = $this->config->item('db_table_prefix', 'tank_auth') . 'users';
        $this->table_workers = 'workers';
        $this->table_users_workers = 'users_workers';
        $this->user_id = $this->session->userdata('user_id');
    }

    public function addWorker($data) {
        $d = array(
            'firstname' => $data['firstname'],
            'surname'   => $data['surname'],
            'email'     => @$data['email'],
            'phone'     => @$data['phone']
        );
        $this->db->insert($this->table_workers, $d);
        $z = $this->db->select('LAST_INSERT_ID() AS id')
                      ->get()->result_array();
        if (!empty($z)) {
            if (0 < $z[0]['id']) {
                $this->addUserWorker($z[0]['id']);
                return true;
            }
        }
        return false;
    }

    public function addUserWorker($worker_id) {
        if ('' != $this->user_id) {
            $d = array(
                'user_id' => $this->user_id,
                'worker_id' => $worker_id
            );
            $this->db->insert($this->table_users_workers, $d);
        }
    }

    public function getWorkers() {
        $res = $this->db->select()
                        ->from($this->table_users_workers . ' AS uw ')
                        ->join($this->table_workers . ' AS w ', 'w.id = uw.worker_id')
                        ->where('uw.user_id', $this->user_id)
                        ->get()->result_array();
        return $res;
    }

    public function getWorker($worker_id) {
        $res = $this->db->select()
                        ->from($this->table_users_workers . ' AS uw ')
                        ->join($this->table_workers . ' AS w ', 'w.id = uw.worker_id')
                        ->where('uw.user_id', $this->user_id)
                        ->get()->row_array();
        return $res;
    }
}