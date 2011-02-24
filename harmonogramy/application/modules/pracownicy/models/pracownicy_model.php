<?php

/**
 * @param CI_Model $db
 */
class Pracownicy_model extends CI_Model {
    private $t_users;
    private $t_workers;
    private $t_users_workers;
    private $t_timetable_history;
    private $t_workers_duty_limits;
    private $t_workers_roles;

    private $user_id;

    public function __construct() {
        parent::__construct();
        $this->config->load();
        $this->t_users = $this->config->item('db_table_prefix', 'tank_auth') . 'users';
        $this->t_users_workers = 'users_workers';
        $this->t_workers = 'workers';
        $this->t_workers_roles = 'workers_roles';
        $this->t_workers_duty_limits = 'workers_duty_limits';
        $this->t_timetable_history = 'timetable_history';
        
        $this->user_id = $this->session->userdata('user_id');
    }

    public function editWorker($worker_id) {
        $d = array(
            'firstname' => $this->input->post('firstname', true),
            'surname'   => $this->input->post('surname', true),
            'email'     => $this->input->post('email', true),
            'phone'     => $this->input->post('phone', true)
        );

        if ($this->checkWorkerExistance($d['firstname'], $d['surname'], $worker_id)) {
            return false;
        }

        if (0 === $worker_id) {
            $this->db->insert($this->t_workers, $d);
            $id = $this->db->insert_id();
            $this->addUserWorker($id);
        } else {
            $this->db->where('id', $worker_id)->update($this->t_workers, $d);
        }
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

        if (false === $this->db->trans_status()) {
            return false;
        } else {
            return true;
        }
    }

    public function checkWorkerExistance($worker_name, $worker_surname, $worker_id = 0) {
        $res = $this->db->select('w.id')
                        ->from($this->t_users . ' AS u')
                        ->join($this->t_users_workers . ' AS uw', 'u.id = uw.user_id')
                        ->join($this->t_workers . ' AS w', 'w.id = uw.worker_id')
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