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
        $z = $this->db->insert_id();
        if (0 < $z) {
            $this->addUserWorker($z);
            return true;
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

    public function updateWorker($data) {
        $d = array(
            'firstname' => $data['firstname'],
            'surname'   => $data['surname'],
            'email'     => @$data['email'],
            'phone'     => @$data['phone']
        );
        $worker_id = $data['worker_id'];
        $this->db->where('id', $worker_id)->update($this->table_workers, $d);
    }

    public function getWorkers() {
        $res = $this->db->select()
                        ->from($this->table_users_workers . ' AS uw ')
                        ->join($this->table_workers . ' AS w ', 'w.id = uw.worker_id')
                        ->where('uw.user_id', $this->user_id)
                        ->get()->result_array();
        // ucfirst
        foreach ($res as $k => $r) {
            $res[$k]['firstname'] = ucfirst($r['firstname']);
            $res[$k]['surname']   = ucfirst($r['surname']);
        }
        return $res;
    }

    public function getWorker($worker_id) {
        $res = $this->db->select()
                        ->from($this->table_users_workers . ' AS uw ')
                        ->join($this->table_workers . ' AS w ', 'w.id = uw.worker_id')
                        ->where('uw.user_id', $this->user_id)
                        ->where('uw.worker_id', $worker_id)
                        ->get()->row_array();
        $res['firstname'] = ucfirst($res['firstname']);
        $res['surname']   = ucfirst($res['surname']);
        return $res;
    }

    public function checkWorkerExistance($worker_name, $worker_surname, $worker_id = 0) {
        $res = $this->db->select('w.id')
                        ->from($this->table_users . ' AS u')
                        ->join($this->table_users_workers . ' AS uw', 'u.id = uw.user_id')
                        ->join($this->table_workers . ' AS w', 'w.id = uw.worker_id')
                        ->where('uw.user_id', $this->user_id)
                        ->where('w.firstname', $worker_name)
                        ->where('w.surname', $worker_surname)
                        ->get()->result_array();
        if ($worker_id == @$res[0]['id'] || empty($res))
            return false;
        // istnieje
        return true;
    }
}