<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Harmonogramy extends MY_Controller {
	public function __construct() {
		parent::__construct();
        if (!$this->tank_auth->is_logged_in())
            redirect('uzytkownicy/zaloguj/');
        $this->load->model('harmonogramy_model', 'hm');
        
        $this->data['user_id'] = $this->session->userdata('user_id');
        $this->data['schedule_id'] = (int) $this->uri->segment(3);
	}

	public function index() {
        redirect('harmonogramy/lista/');
	}

    public function lista() {
        $this->data['pagination_config']['base_url'] = site_url('harmonogramy/lista/');
        $this->data['pagination_config']['num_links'] = 2;
        $this->data['pagination_config']['per_page'] = 10;
        $this->data['pagination_config']['uri_segment'] = 3;
        $this->data['pagination_config']['total_rows'] = $this->hm->countSchedules();
        
        $this->data['total_rows'] = $this->data['pagination_config']['total_rows'];
        $this->data['schedules'] = $this->hm->getSchedules($this->data['pagination_config']['per_page'],
                                                           (int) $this->uri->segment(3));
        $this->data['pagination'] = $this->pagination();
        $this->data['edit_location'] = site_url('harmonogramy/edytuj');
        $this->data['css'] .= ',table';

        $this->template->set($this->data);
        $this->template->render();
    }

    public function edytuj() {
        $config = array(
            array(
                'field' => 'name',
                'label' => 'Nazwa',
                'rules' => 'required|callback_schedulenotexists'
            ),
        );

        $this->form_validation->set_rules($config);

        if (true === $this->form_validation->run()) {
            if (true === $this->editSchedule()) {
                $this->template->current_view = 'harmonogramy/harmonogramy/sukces_zmien';
            } else {
                $this->template->current_view = 'harmonogramy/harmonogramy/error_zmien';
            }
        } else {
            if (0 !== $this->data['schedule_id']) {
                $schedule = $this->hm->getSchedule($this->data['schedule_id']);
                
                $_POST['name'] = $schedule['name'];
            }
        }
        $this->template->set($this->data);
        $this->template->render();
    }

    // MODEL INTERFACE
    public function scheduleNotExists($schedule_name) {
        if ($this->hm->scheduleExists($schedule_name, $this->data['schedule_id'])) {
            $this->form_validation->set_message('schedulenotexists', 'Harmonogram o podanych danych już istnieje.');
            return false;
        }
        return true;
    }

    public function editSchedule() {
        if (true === $this->hm->editSchedule($this->data['schedule_id']))
            return true;
        return false;
    }

    public function deleteSchedule() {
        if (true === $this->hm->deleteSchedule($this->data['schedule_id']))
            return true;
        return false;
    }
}

/* End of file Harmonogramy.php */
/* Location: ./application/modules/Harmonogramy/controllers/Harmonogramy.php */