<?php

/**
 * @param CI_Model $db
 */
class Pracownicylimity_model extends CI_Model {
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
    private $t_workers_duty_limits_week_days;

    private $user_id;
    private $worker_id;

    public function __construct() {
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
        $this->t_workers_duty_limits_week_days = 'workers_duty_limits_week_days';
        
        $this->user_id = $this->session->userdata('user_id');
        $this->worker_id = $this->uri->segment(3);
    }

    public function editWorkersDutyLimit($duty_limit_id) {
        $week_days = $this->input->post('week_days', true);
        $duty_id = $this->input->post('duty_id', true);

        $this->db->trans_start();

        if (0 === $duty_limit_id) {
            $this->db->insert($this->t_workers_duty_limits,
                    array(
                        'worker_id' => $this->worker_id,
                        'duty_id' => $duty_id
                    ));
            $duty_limit_id = $this->db->insert_id();
        } else {
            $this->db->where('id', $duty_limid_id)->update($this->t_workers_duty_limits);
        }
        $this->editWorkersDutyLimitsWeekDays($duty_limit_id, $week_days);

        $this->db->trans_complete();
        if (false === $this->db->trans_status())
            return false;
        return true;
    }

    private function editWorkersDutyLimitsWeekDays($duty_limit_id, $week_days) {
        $this->db->where('duty_limit_id', $duty_limit_id)
                 ->delete($this->t_workers_duty_limits_week_days);

        foreach ($week_days as $week_day) {
            $d = array(
                'duty_limit_id' => $duty_limit_id,
                'week_day' => $week_day
            );

            $this->db->insert($this->t_workers_duty_limits_week_days, $d);
        }
    }

    public function getWorkersDutyLimit($duty_limit_id) {
        $res = $this->db->select()
                        ->from($this->t_workers_duty_limits . ' AS wdl')
                        ->join($this->t_users_workers . ' AS uw', 'uw.worker_id = wdl.worker_id')
                        ->where('uw.user_id', $this->user_id)
                        ->where('uw.user_id', $this->worker_id)
                        ->where('wdl.id', $duty_limit_id)
                        ->get()->result_array();
        if (!empty($res)) {
            
        }
        return $res;
    }

    // LISTA LIMITY
    public function getWorkersDutyLimits($limit, $offset) {
        $res = $this->db->select()
                        ->from($this->t_workers_duty_limits . ' AS wdl')
                        ->join($this->t_users_workers . ' AS uw', 'uw.worker_id = wdl.worker_id')
                        ->where('uw.user_id', $this->user_id)
                        ->where('wdl.worker_id', $this->worker_id)
                        ->limit($limit, $offset)
                        ->get()->result_array();
        return $res;
    }

    public function countWorkersDutyLimits() {
        $res = $this->db->select()
                        ->from($this->t_workers_duty_limits . ' AS wdl')
                        ->join($this->t_users_workers . ' AS uw', 'uw.worker_id = wdl.worker_id')
                        ->where('uw.user_id', $this->user_id)
                        ->where('wdl.worker_id', $this->worker_id)
                        ->get()->num_rows();
        return $res;
    }
}