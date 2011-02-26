<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Obowiazki extends MY_Controller {
	public function __construct() {
		parent::__construct();
        if (!$this->tank_auth->is_logged_in())
            redirect('uzytkownicy/zaloguj/');
        $this->load->model('obowiazki_model', 'om');

        $this->data['user_id'] = $this->session->userdata('user_id');
        $this->data['duty_id'] = (int) $this->uri->segment(3);
        $this->data['schedule_id'] = $this->om->getScheduleDuty($this->data['duty_id']);
        $this->data['schedules'] = $this->getSchedulesForDropdown($this->om->getSchedules());

        // no schedules - no duties !!!
        if (empty($this->data['schedules']) &&
            !preg_match('#obowiazki/lista#i', current_url()))
            redirect('harmonogramy/lista');
	}

	public function index() {
        redirect('obowiazki/lista/');
	}

    public function lista() {
        $this->data['pagination_config']['base_url'] = site_url('obowiazki/lista/');
        $this->data['pagination_config']['num_links'] = 2;
        $this->data['pagination_config']['per_page'] = 10;
        $this->data['pagination_config']['uri_segment'] = 3;
        $this->data['pagination_config']['total_rows'] = $this->om->countDuties();

        $this->data['total_rows'] = $this->data['pagination_config']['total_rows'];
        $this->data['duties'] = $this->om->getDuties($this->data['pagination_config']['per_page'],
                                                           (int) $this->uri->segment(3));
        $this->data['pagination'] = $this->pagination();
        $this->data['edit_location'] = site_url('obowiazki/edytuj');
        $this->data['css'] .= ',table';

        $this->template->set($this->data);
        $this->template->render();
    }

    public function edytuj() {
        $config = array(
            array(
                'field' => 'schedule_id',
                'label' => 'Harmonogram',
                'rules' => 'required'
            ),
            array(
                'field' => 'name',
                'label' => 'Nazwa',
                'rules' => 'required|callback_dutynotexists[' . $this->input->post('schedule_id') . ']'
            ),
            array(
                'field' => 'num_workers',
                'label' => 'Liczba pracowników',
                'rules' => 'callback_natural|required'
            ),
            array(
                'field' => 'hour_start',
                'label' => 'Godzina rozpoczęcia',
                'rules' => 'required|callback_properHour'
            ),
            array(
                'field' => 'hour_end',
                'label' => 'Godzina zaczkończenia',
                'rules' => 'required|callback_properHour'
            ),
            array(
                'field' => 'week_days[]',
                'label' => 'Dni tygodnia',
                'rules' => 'required'
            )
        );

        // date('w');
        $this->load->helper('weekdays');
        $this->data['week_days_multiselect'] = getWeekDays();

        $this->form_validation->set_rules($config);

        if (true === $this->form_validation->run()) {
            if (true === $this->editDuty($this->data['duty_id'])) {
                $this->template->current_view = 'obowiazki/obowiazki/sukces_zmien';
            } else {
                $this->template->current_view = 'obowiazki/obowiazki/error_zmien';
            }
        } else {
            if (0 !== $this->data['schedule_id']) {
                $duty = $this->om->getDuty($this->data['duty_id']);

                $_POST['schedule_id'] = $this->data['schedule_id'];
                $_POST['name'] = $duty['name'];
                $_POST['num_workers'] = $duty['num_workers'];
                $_POST['hour_start'] = $duty['hour_start'];
                $_POST['hour_end'] = $duty['hour_end'];
                $_POST['week_days'] = $duty['week_days'];
            }
        }
        $this->template->set($this->data);
        $this->template->render();
    }

    private function getSchedulesForDropdown($schedules) {
        $sched = array();
        foreach ($schedules as $val) {
            $sched[$val['id']] = $val['name'];
        }
        return $sched;
    }

    // MODEL INTERFACE
    public function dutyNotExists($duty_name, $schedule_id) {
        if ($this->om->dutyExists($duty_name, $schedule_id, $this->data['duty_id'])) {
            $this->form_validation->set_message('dutynotexists', 'Obowiązek o podanej nazwie już istnieje dla wybranego harmonogramu.');
            return false;
        }
        return true;
    }

    public function editDuty($duty_id) {
        if (true === $this->om->editDuty($duty_id))
            return true;
        return false;
    }

    public function deleteDuty($duty_id) {
        if (true === $this->om->deleteDuty($duty_id))
            return true;
        return false;
    }
}

/* End of file Obowiazki.php */
/* Location: ./application/modules/Obowiazki/controllers/Obowiazki.php */