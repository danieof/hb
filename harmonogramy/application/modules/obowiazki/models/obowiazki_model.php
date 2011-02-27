<?php

/**
 * @param CI_Model $db
 */
class Obowiazki_model extends CI_Model {
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

    public function addUserDuty($duty_id, $user_id) {
        $d = array(
            'user_id' => $user_id,
            'duty_id' => $duty_id
        );
        $this->db->insert($this->t_users_duties, $d);
    }

    public function addScheduleDuty($duty_id, $schedule_id) {
        $d = array(
            'duty_id' => $duty_id,
            'schedule_id' => $schedule_id
        );
        $this->db->insert($this->t_schedules_duties, $d);
    }

    public function editDuty($duty_id) {
        $schedule_id = $this->input->post('schedule_id', true);
        $d = array(
            'name' => $this->input->post('name', true),
            'num_workers' => $this->input->post('num_workers', true),
            'hour_start' => $this->input->post('hour_start', true),
            'hour_end' => $this->input->post('hour_end', true)
        );

        $this->db->trans_start();

        if (0 === $duty_id) {
            $this->db->insert($this->t_duties, $d);
            $duty_id = $this->db->insert_id();
            $this->addUserDuty($duty_id, $this->user_id);
            $this->addScheduleDuty($duty_id, $schedule_id);
        } else {
            $this->db->where('id', $duty_id)->update($this->t_duties, $d);
            $this->db->where('duty_id', $duty_id)->update($this->t_schedules_duties, array('schedule_id' => $schedule_id));
        }
        $this->editDutyWeekDays($duty_id, $this->input->post('week_days', true));

        $this->db->trans_complete();
        if (false === $this->db->trans_status())
            return false;
        return true;
    }

    public function editDutyWeekDays($duty_id, $week_days) {
        $this->db->where('duty_id', $duty_id)->delete($this->t_duty_week_days);

        $data = array();
        foreach ($week_days as $day) {
            $data = array(
                'duty_id' => $duty_id,
                'week_day' => $day
            );
            $this->db->insert($this->t_duty_week_days, $data);
        }
    }

    public function getDuty($duty_id) {
        $res = $this->db->select()
                        ->from($this->t_users_duties . ' AS ud')
                        ->join($this->t_duties . ' AS d', 'd.id = ud.duty_id')
                        ->where('ud.user_id', $this->user_id)
                        ->where('ud.duty_id', $duty_id)
                        ->get()->row_array();
        $res['week_days'] = $this->getDutyWeekDays($duty_id);
        return $res;
    }

    public function getDutyWeekDays($duty_id) {
        $res = $this->db->select('week_day')
                        ->from($this->t_duty_week_days)
                        ->where('duty_id', $duty_id)
                        ->get()->result_array();
        $days = array();
        foreach ($res as $val) {
            $days[] = $val['week_day'];
        }
        return $days;
    }

    public function deleteDuty($duty_id) {

    }

    public function getSchedules() {
        $res = $this->db->select('s.id, s.name')
                        ->from($this->t_users_schedules . ' AS us')
                        ->join($this->t_schedules . ' AS s', 's.id = us.schedule_id')
                        ->where('us.user_id', $this->user_id)
                        ->get()->result_array();
        return $res;
    }

    public function getScheduleDuty($duty_id) {
        $res = $this->db->select('sd.schedule_id')
                        ->from($this->t_schedules_duties . ' AS sd')
                        ->join($this->t_duties . ' AS d', 'd.id = sd.duty_id')
                        ->join($this->t_schedules . ' AS s', 's.id = sd.schedule_id')
                        ->where('sd.duty_id', $duty_id)
                        ->get()->result_array();
        if (!empty($res))
            return $res[0]['schedule_id'];
        return 0;
    }

    public function dutyExists($duty_name, $schedule_id, $duty_id = 0) {
        $res = $this->db->select('d.id')
                        ->from($this->t_users . ' AS u')
                        ->join($this->t_users_duties . ' AS ud', 'u.id = ud.user_id')
                        ->join($this->t_duties . ' AS d', 'd.id = ud.duty_id')
                        ->join($this->t_schedules_duties . ' AS sd', 'd.id = sd.duty_id')
                        ->where('ud.user_id', $this->user_id)
                        ->where('sd.schedule_id', $schedule_id)
                        ->where('d.name', $duty_name)
                        ->get()->result_array();
        if ($duty_id == @$res[0]['id'] || empty($res))
            return false;
        // istnieje
        return true;
    }

    // LISTA
    public function getDuties($limit, $offset) {
        $res = $this->db->select('d.*, s.name AS schedule_name')
                        ->from($this->t_users_duties . ' AS ud')
                        ->join($this->t_duties . ' AS d', 'd.id = ud.duty_id')
                        ->join($this->t_schedules_duties . ' AS sd', 'd.id = sd.duty_id')
                        ->join($this->t_schedules . ' AS s', 's.id = sd.schedule_id')
                        ->where('ud.user_id', $this->user_id)
                        ->limit($limit, $offset)
                        ->get()->result_array();
        if (!empty($res)) {
            $this->load->helper('weekdays');
            foreach ($res as $key => $duty) {
                $res[$key]['week_days'] = $this->getDutyWeekDays($duty['id']);
                $res[$key]['week_days'] = getWeekDaysForList($res[$key]['week_days']);
            }
        }
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
}