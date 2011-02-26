<?php

/**
 * @param CI_Model $db
 */
class Pracownicy_model extends CI_Model {
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
        
        $this->user_id = $this->session->userdata('user_id');
    }

    public function editWorker($worker_id) {
        $d = array(
            'firstname' => $this->input->post('firstname', true),
            'surname'   => $this->input->post('surname', true),
            'email'     => $this->input->post('email', true),
            'phone'     => $this->input->post('phone', true)
        );

        $this->db->trans_start();

        if (0 === $worker_id) {
            $this->db->insert($this->t_workers, $d);
            $id = $this->db->insert_id();
            $this->addUserWorker($id);
        } else {
            $this->db->where('id', $worker_id)->update($this->t_workers, $d);
        }

        $this->db->trans_complete();
        if (false === $this->db->trans_status())
            return false;
        return true;
    }

    public function addUserWorker($worker_id) {
        $d = array(
            'user_id' => $this->user_id,
            'worker_id' => $worker_id
        );
        $this->db->insert($this->t_users_workers, $d);
    }

    public function getWorker($worker_id) {
        $res = $this->db->select()
                        ->from($this->t_users_workers . ' AS uw ')
                        ->join($this->t_workers . ' AS w ', 'w.id = uw.worker_id')
                        ->where('uw.user_id', $this->user_id)
                        ->where('uw.worker_id', $worker_id)
                        ->get()->row_array();
        $res['firstname'] = ucfirst($res['firstname']);
        $res['surname']   = ucfirst($res['surname']);
        return $res;
    }

    public function deleteWorker($worker_id){
        $this->db->trans_start();
        
        // z timetable history
        $this->db->where('worker_id', $worker_id)->delete($this->t_timetable_history);
        // z users workers
        $this->db->where('worker_id', $worker_id)->delete($this->t_users_workers);
        // z workers roles
        $this->db->where('worker_id', $worker_id)->delete($this->t_workers_roles);
        // z worker duty limits
        $this->db->where('worker_id', $worker_id)->delete($this->t_workers_duty_limits);
        // usuwamy z workers na koncu
        $this->db->where('id', $worker_id)->delete($this->t_workers);

        $this->db->trans_complete();

        if (false === $this->db->trans_status())
            return false;
        return true;
    }

    public function workerExists($worker_email, $worker_id = 0) {
        $res = $this->db->select('w.id')
                        ->from($this->t_users_workers . ' AS uw')
                        ->join($this->t_workers . ' AS w', 'w.id = uw.worker_id')
                        ->where('uw.user_id', $this->user_id)
                        ->where('w.email', $worker_email)
                        ->get()->result_array();
        if ($worker_id == @$res[0]['id'] || empty($res))
            return false;
        // istnieje
        return true;
    }

    // LISTA
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

    public function countWorkers() {
        $res = $this->db->select()
                        ->from($this->t_users_workers . ' AS uw ')
                        ->join($this->t_workers . ' AS w ', 'w.id = uw.worker_id')
                        ->where('uw.user_id', $this->user_id)
                        ->get()->num_rows();
        return $res;
    }

    // LISTA LIMITY
    public function getWorkersDutyLimits($worker_id, $limit, $offset) {
        $res = $this->db->select()
                        ->from($this->t_workers_duty_limits . ' AS wdl')
                        ->join($this->t_users_workers . ' AS uw', 'uw.worker_id = wdl.worker_id')
                        ->where('uw.user_id', $this->user_id)
                        ->get()->result_array();
        return $res;
    }

    public function countWorkersDutyLimits() {
        $res = $this->db->select()
                        ->from($this->t_workers_duty_limits . ' AS wdl')
                        ->join($this->t_users_workers . ' AS uw', 'uw.worker_id = wdl.worker_id')
                        ->where('uw.user_id', $this->user_id)
                        ->get()->num_rows();
        return $res;
    }
}