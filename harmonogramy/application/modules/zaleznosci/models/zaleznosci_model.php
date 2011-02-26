<?php

/**
 * @param CI_Model $db
 */
class rename extends CI_Model {
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
}