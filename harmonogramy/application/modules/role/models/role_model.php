<?php

/**
 * @param CI_Model $db
 */
class Role_model extends CI_Model {
    private $t_duties;
    private $t_duties_dependencies;
    private $t_duty_week_days;
    private $t_roles;
    private $t_roles_duty_limitis;
    private $t_roles_duty_priorities;
    private $t_schedules;
    private $t_schedules_duties;
    private $t_timetable_history;
    private $t_users;
    private $t_users_duties;
    private $t_users_roles;
    private $t_users_schedules;
    private $t_users_workers;
    private $t_workers;
    private $t_workers_duty_limits;

    private $user_id;

    public function  __construct() {
        parent::__construct();
        $this->config->load();

        $this->t_duties = 'duties';
        $this->t_duties_dependencies = 'duties_dependencies';
        $this->t_duty_week_days = 'duty_week_days';
        $this->t_roles = 'roles';
        $this->t_roles_duty_limitis = 'roles_duty_limitis';
        $this->t_roles_duty_priorities = 'roles_duty_priorities';
        $this->t_schedules = 'schedules';
        $this->t_schedules_duties = 'schedules_duties';
        $this->t_timetable_history = 'timetable_history';
        $this->t_users = $this->config->item('db_table_prefix', 'tank_auth') . 'users';
        $this->t_users_duties = 'users_duties';
        $this->t_users_roles = 'users_roles';
        $this->t_users_schedules = 'users_schedules';
        $this->t_users_workers = 'users_workers';
        $this->t_workers = 'workers';
        $this->t_workers_duty_limits = 'workers_duty_limits';
        
        $this->user_id = $this->session->userdata('user_id');
    }

    public function addUserRole($role_id, $user_id) {
        $d = array(
            'user_id' => $user_id,
            'role_id' => $role_id
        );
        $this->db->insert($this->t_users_roles, $d);
    }

    public function editRole($role_id) {
        $d = array(
            'name' => $this->input->post('name', true)
        );

        $this->db->trans_start();

        if (0 === $role_id) {
            $this->db->insert($this->t_roles, $d);
            $role_id = $this->db->insert_id();
            $this->addUserRole($role_id, $this->user_id);
        } else {
            $this->db->where('id', $role_id)->update($this->t_roles, $d);
        }

        $this->db->trans_complete();

        if (false === $this->db->trans_status())
            return false;
        return true;
    }

    public function getRole($role_id) {
        $res = $this->db->select()
                        ->from($this->t_users_roles . ' AS ud')
                        ->join($this->t_roles . ' AS d', 'd.id = ud.role_id')
                        ->where('ud.user_id', $this->user_id)
                        ->where('ud.role_id', $role_id)
                        ->get()->row_array();
        return $res;
    }

    public function deleteRole($role_id) {

    }
    
    public function roleExists($role_name, $role_id = 0) {
        $res = $this->db->select('r.id')
                        ->from($this->t_users_roles . ' AS ur')
                        ->join($this->t_roles . ' AS r', 'r.id = ur.role_id')
                        ->where('ur.user_id', $this->user_id)
                        ->where('r.name', $role_name)
                        ->get()->result_array();
        if ($role_id == @$res[0]['id'] || empty($res))
            return false;
        // istnieje
        return true;
    }

    // LISTA
    public function getRoles($limit, $offset) {
        $res = $this->db->select()
                        ->from($this->t_users_roles . ' AS ur')
                        ->join($this->t_roles . ' AS r', 'r.id = ur.role_id')
                        ->where('ur.user_id', $this->user_id)
                        ->limit($limit, $offset)
                        ->get()->result_array();
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
}