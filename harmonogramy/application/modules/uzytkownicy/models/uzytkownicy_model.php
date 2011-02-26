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
    private $t_duty_week_days;
    private $t_roles;
    private $t_schedules;
    private $t_schedules_duties;
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
        $this->t_duty_week_days = 'duty_week_days';
        $this->t_roles = 'roles';
        $this->t_schedules = 'schedules';
        $this->t_schedules_duties = 'schedules_duties';
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

    // GET MULTIPLE DATA
    public function getUsers() {
        $res = $this->db->select()->get($this->table)->result_array();
        return $res;
    }

}