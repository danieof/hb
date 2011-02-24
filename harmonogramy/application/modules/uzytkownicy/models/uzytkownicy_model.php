<?php

/**
 * @property CI_Model $db
 */
class Uzytkownicy_model extends CI_Model {
    private $t_users;
    private $t_users_duties;
    private $t_users_roles;
    private $t_users_schedules;
    private $t_users_workers;
    private $t_duties;
    private $t_roles;
    private $t_schedules;
    private $t_workers;

    private $user_id;

    public function __construct() {
        parent::__construct();
        $this->config->load();
        $this->t_users = $this->config->item('db_table_prefix', 'tank_auth') . 'users';
        $this->t_users_duties = 'users_duties';
        $this->t_users_schedules = 'users_schedules';
        $this->t_users_roles = 'users_roles';
        $this->t_users_workers = 'users_workers';
        $this->t_duties = 'duties';
        $this->t_roles = 'roles';
        $this->t_schedules = 'schedules';
        $this->t_workers = 'workers';
        
        $this->user_id = $this->session->userdata('user_id');
    }

    // ADD/UPDATE
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

    // GET SINGLE DATA
    public function getUser($user_id) {
        $res = $this->db->where('id', $user_id)->select()->get($this->table);
        $res = $res->row_array();
        return $res;
    }

    // COUNT DATA
    public function countWorkers() {
        $res = $this->db->select()
                        ->from($this->t_users_workers . ' AS uw ')
                        ->join($this->t_workers . ' AS w ', 'w.id = uw.worker_id')
                        ->where('uw.user_id', $this->user_id)
                        ->get()->num_rows();
        return $res;
    }

    public function countDuties() {
        $res = $this->db->select()
                        ->from($this->t_users_duties . ' AS ud')
                        ->join($this->t_duties . ' AS d', 'd.id = ud.duty_id')
                        ->where('ud.user_id', $this->user_id)
                        ->get()->num_rows();
        return $res;
    }

    public function countSchedules() {
        $res = $this->db->select()
                        ->from($this->t_users_schedules . ' AS us')
                        ->join($this->t_schedules . ' AS s', 's.id = us.schedule_id')
                        ->where('us.user_id', $this->user_id)
                        ->get()->num_rows();
        return $res;
    }

    public function countRoles() {
        $res = $this->db->select()
                        ->from($this->t_users_roles . ' AS ur')
                        ->join($this->t_roles . ' AS r', 'r.id = ur.role_id')
                        ->where('ur.user_id', $this->user_id)
                        ->get()->num_rows();
        return $res;
    }

    // GET MULTIPLE DATA
    public function getUsers() {
        $res = $this->db->select()->get($this->table);
        $res = $res->result_array();
        return $res;
    }

    public function getWorkers($limit, $offset) {
        $res = $this->db->select()
                        ->from($this->t_users_workers . ' AS uw ')
                        ->join($this->t_workers . ' AS w ', 'w.id = uw.worker_id')
                        ->where('uw.user_id', $this->user_id)
                        ->limit($limit, $offset)
                        ->get()->result_array();
        // ucfirst
        foreach ($res as $k => $r) {
            $res[$k]['firstname'] = ucfirst($r['firstname']);
            $res[$k]['surname']   = ucfirst($r['surname']);
        }
        return $res;
    }

    public function getRoles($limit, $offset) {
        $res = $this->db->select()
                        ->from($this->t_users_roles . ' AS ur')
                        ->join($this->t_roles . ' AS r', 'r.id = ur.role_id')
                        ->where('ur.user_id', $this->user_id)
                        ->limit($limit, $offset)
                        ->get()->result_array();
        return $res;
    }

    public function getDuties($limit, $offset) {
        $res = $this->db->select()
                        ->from($this->t_users_duties . ' AS ud')
                        ->join($this->t_duties . ' AS d', 'd.id = ud.duty_id')
                        ->where('ud.user_id', $this->user_id)
                        ->limit($limit, $offset)
                        ->get()->result_array();
        return $res;
    }

    public function getSchedules($limit, $offset) {
        $res = $this->db->select()
                        ->from($this->t_users_schedules . ' AS us')
                        ->join($this->t_schedules . ' AS s', 's.id = us.schedule_id')
                        ->where('us.user_id', $this->user_id)
                        ->limit($limit, $offset)
                        ->get()->result_array();
        return $res;
    }
}