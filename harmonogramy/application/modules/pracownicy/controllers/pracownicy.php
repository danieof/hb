<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @property Pracownicymodel $pm
 */
class Pracownicy extends MY_Controller {
	public function __construct() {
		parent::__construct();
        if (!$this->tank_auth->is_logged_in())
            redirect('uzytkownicy/zaloguj/');

        $this->data['worker_id'] = (int) $this->uri->segment(3);
        if (0 > $this->data['worker_id'] &&
            !preg_match('#pracownicy/lista#i', current_url()))
            redirect('pracownicy/edytuj/');

        $this->load->model('pracownicy_model','pm');
        $this->data['pagination_config']['num_links'] = 2;
        $this->data['pagination_config']['per_page'] = 10;
	}

	public function index() {
        redirect('pracownicy/lista/');
	}

    public function lista() {
        $this->data['pagination_config']['base_url'] = site_url('pracownicy/lista/');
        $this->data['pagination_config']['uri_segment'] = 3;
        $this->data['pagination_config']['total_rows'] = $this->pm->countWorkers();

        $this->data['total_rows'] = $this->data['pagination_config']['total_rows'];
        $this->data['workers'] = $this->pm->getWorkers($this->data['pagination_config']['per_page'],
                                                       (int) $this->uri->segment(3));
        $this->data['pagination'] = $this->pagination();
        $this->data['css'] .= ',table';

        $this->template->set($this->data);
        $this->template->render();
    }

    public function edytuj() {
        $config = array(
            array(
                'field' => 'firstname',
                'label' => 'Imię',
                'rules' => 'required'
            ),
            array(
                'field' => 'surname',
                'label' => 'Nazwisko',
                'rules' => 'required'
            ),
            array(
                'field' => 'email',
                'label' => 'E-mail',
                'rules' => 'valid_email|required|callback_workernotexists'
            ),
            array(
                'field' => 'phone',
                'label' => 'Telefon',
                'rules' => ''
            ),
        );

        $this->form_validation->set_rules($config);
        
        if (true === $this->form_validation->run()) {
            if (true === $this->editWorker()) {
                $this->template->current_view = 'pracownicy/pracownicy/sukces_zmien';
            } else {
                $this->template->current_view = 'pracownicy/pracownicy/error_zmien';
            }
        } else {
            if (0 !== $this->data['worker_id']) {
                $worker = $this->pm->getWorker($this->data['worker_id']);

                $_POST['firstname'] = $worker['firstname'];
                $_POST['surname'] = $worker['surname'];
                $_POST['email'] = $worker['email'];
                $_POST['phone'] = $worker['phone'];
            }
        }
        $this->template->set($this->data);
        $this->template->render();
    }

    public function usun() {
        //$this->deleteWorker();
    }

    // MODEL INTERFACE
    public function workerNotExists($worker_email) {
        if ($this->pm->workerExists($worker_email, $this->data['worker_id'])) {
            $this->form_validation->set_message('workernotexists', 'Pracownik o podanym emailu już istnieje.');
            return false;
        }
        return true;
    }

    public function editWorker() {
        if (true === $this->pm->editWorker($this->data['worker_id']))
            return true;
        return false;
    }

    public function deleteWorker() {
        if (true === $this->pm->deleteWorker($this->data['worker_id']))
            return true;
        return false;
    }
}

/* End of file pracownicy.php */
/* Location: ./application/modules/pracownicy/controllers/pracownicy.php */