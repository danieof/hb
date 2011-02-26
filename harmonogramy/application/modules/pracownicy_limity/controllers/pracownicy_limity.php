<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @property Pracownicymodel $pm
 */
class Pracownicy_limity extends MY_Controller {
	public function __construct() {
		parent::__construct();
        if (!$this->tank_auth->is_logged_in())
            redirect('uzytkownicy/zaloguj/');

        $this->data['worker_id'] = (int) $this->uri->segment(3);
        $this->data['duty_limit_id'] = (int) $this->uri->segment(4);
        if (0 > $this->data['duty_limit_id'] &&
            !preg_match('#pracownicy_limity/lista#i', current_url()))
            redirect('pracownicy_limity/edytuj/' . $this->data['worker_id']);

        $this->load->model('pracownicylimity_model','plm');
        $this->data['pagination_config']['num_links'] = 2;
        $this->data['pagination_config']['per_page'] = 10;
        $this->data['css'] .= ',table';
	}

	public function index() {
        redirect('pracownicy_limity/lista/' . $this->data['worker_id']);
	}

    public function lista() {
        $this->data['pagination_config']['base_url'] = site_url('pracownicy_limity/lista/') .
                                                       '/' . $this->data['worker_id'];
        $this->data['pagination_config']['uri_segment'] = 4;
        $this->data['pagination_config']['total_rows'] = $this->plm->countWorkersDutyLimits();

        $this->data['total_rows'] = $this->data['pagination_config']['total_rows'];
        $this->data['workers_limits'] = $this->plm->getWorkersDutyLimits($this->data['worker_id'],
                                                                         $this->data['pagination_config']['per_page'],
                                                                         (int) $this->uri->segment(4));
        $this->data['pagination'] = $this->pagination();

        $this->template->set($this->data);
        $this->template->render();
    }

    public function edytuj() {
        $config = array(
            array(
                'field' => 'duty_id',
                'label' => 'Obowiązek',
                'rules' => 'required'
            ),
            array(
                'field' => 'week_days[]',
                'label' => 'Dni tygodnia',
                'rules' => 'required'
            )
        );

        $this->load->model('obowiazki/obowiazki_model', 'om');
        $this->data['duties'] = $this->getDutiesForDropdown($this->om->getDuties('', ''));

        $this->load->helper('weekdays');
        $this->data['week_days_multiselect'] = getWeekDays();

        $this->form_validation->set_rules($config);

        if (true === $this->form_validation->run()) {
            if (true === $this->editWorkersLimit($this->data['duty_limit_id'])) {
                $this->template->current_view = 'pracownicy/pracownicy/sukces_zmien';
            } else {
                $this->template->current_view = 'pracownicy/pracownicy/error_zmien';
            }
        } else {
            if (0 !== $this->data['duty_limit_id']) {
                $workers_duty_limit = $this->plm->getWorkersDutyLimit($this->data['duty_limit_id']);

                $_POST['duty_id'] = $workers_duty_limit['id'];
                $_POST['week_days'] = $workers_duty_limit['week_days'];
            }
        }
        $this->template->set($this->data);
        $this->template->render();
    }

    private function getDutiesForDropdown($duties) {
        $data = array();
        foreach ($duties as $val) {
            $data[$val['id']] = $val['name'] . ' - ' . $val['schedule_name'] .
                                ' - ' . $val['hour_start'] . ' - ' . $val['hour_end'];
            // days of week
            $data[$val['id']] .= ' - ' . implode(', ', $val['week_days']);
        }
        return $data;
    }

    public function usun() {
        $this->deleteWorker();
    }

    // MODEL INTERFACE
    public function editWorkersLimit($duty_limit_id) {
        if (true === $this->plm->editWorkersDutyLimit($duty_limit_id))
            return true;
        return false;
    }

    public function deleteWorkersLimit() {
        if (true === $this->plm->deleteWorkersDutyLimit($this->data['duty_limit_id']))
            return true;
        return false;
    }
}

/* End of file pracownicy.php */
/* Location: ./application/modules/pracownicy/controllers/pracownicy.php */