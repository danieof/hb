<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @property Pracownicymodel $pm
 */
class Pracownicy extends MY_Controller {
    private $worker_id;
    
	public function __construct() {
		parent::__construct();
        if (!$this->tank_auth->is_logged_in())
            redirect('uzytkownicy/zaloguj/');

        $this->worker_id = (int) $this->uri->segment(3);
        if (0 > $this->worker_id) {
            redirect('pracownicy/edytuj/0');
        }

        $this->load->model('pracownicy_model','pm');
	}

	public function index() {
        redirect('pracownicy/edytuj/0');
	}

    public function edytuj() {
        $worker_form_config = array(
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
                'rules' => 'valid_email|required'
            ),
            array(
                'field' => 'phone',
                'label' => 'Telefon',
                'rules' => ''
            ),
        );

        $this->form_validation->set_rules($worker_form_config);
        
        if (true === $this->form_validation->run()) {
            if (true === $this->editWorker()) {
                $this->template->current_view = 'pracownicy/pracownicy/sukces_zmien';
            } else {
                $this->template->current_view = 'pracownicy/pracownicy/error_zmien';
            }
        } else {
            if (0 !== $this->worker_id) {
                $worker = $this->pm->getWorker($this->worker_id);

                $_POST['firstname'] = $worker['firstname'];
                $_POST['surname'] = $worker['surname'];
                $_POST['email'] = $worker['email'];
                $_POST['phone'] = $worker['phone'];
            }
        }
        $this->template->render();
    }

    public function lista_obowiazki() {
        $this->template->render();
    }

    public function edytuj_obowiazki() {
        $this->template->render();
    }

    public function usun() {
        $this->deleteWorker();
    }

    // MODEL INTERFACE
    public function editWorker() {
        if ($this->pm->editWorker($this->worker_id))
            return true;
        return false;
    }

    public function deleteWorker() {
        if (true === $this->pm->deleteWorker($this->worker_id)) {
            return true;
        }
        return false;
    }
}

/* End of file pracownicy.php */
/* Location: ./application/modules/pracownicy/controllers/pracownicy.php */