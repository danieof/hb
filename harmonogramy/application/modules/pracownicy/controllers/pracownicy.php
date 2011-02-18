<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @property Pracownicymodel $pm
 */
class Pracownicy extends MY_Controller {
    private $worker_form_config;
    
	public function __construct() {
		parent::__construct();
        if (!$this->tank_auth->is_logged_in())
            redirect('/uzytkownicy/zaloguj');
        
        $this->load->model('pracownicymodel','pm');
        $this->worker_form_config = array(
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
                'rules' => 'valid_email'
            ),
            array(
                'field' => 'phone',
                'label' => 'Telefon',
                'rules' => ''
            ),
        );
	}

	public function index() {
        redirect('pracownicy/lista');
	}

    public function lista() {
        $workers = $this->pm->getWorkers();
        $this->template->set(array('workers' => $workers, 'num_workers' => count($workers)));
        $this->template->render();
    }

    public function dodaj() {
        $this->form_validation->set_rules($this->worker_form_config);

        if ($this->form_validation->run()) {
            $data = array(
                'firstname' => strtolower($this->input->post('firstname')),
                'surname' => strtolower($this->input->post('surname')),
                'email' => strtolower($this->input->post('email')),
                'phone' => $this->input->post('phone')
            );

            if (!$this->pm->checkWorkerExistance($data['firstname'], $data['surname'])) {
                $this->pm->addWorker($data);
                $this->template->current_view = 'pracownicy/pracownicy/sukces_dodaj';
            } else {
                $this->template->current_view = 'pracownicy/pracownicy/error_dodaj';
            }
            $this->template->render();
        } else {
            $this->template->set('button_label', 'Dodaj');
            $this->template->render();
        }
    }

    public function edytuj() {
        $worker_id = $this->uri->segment(3);
        $worker_id = (int)$worker_id;
        if ($worker = $this->pm->getWorker($worker_id)) {
            $this->form_validation->set_rules($this->worker_form_config);

            if ($this->form_validation->run()) {
                $data = array(
                    'firstname' => strtolower($this->input->post('firstname')),
                    'surname' => strtolower($this->input->post('surname')),
                    'email' => strtolower($this->input->post('email')),
                    'phone' => $this->input->post('phone'),
                    'worker_id' => $worker['id']
                );

                if (!$this->pm->checkWorkerExistance($data['firstname'], $data['surname'], $data['worker_id'])) {
                    $this->pm->updateWorker($data);
                    $this->template->current_view = 'pracownicy/pracownicy/sukces_zmien';
                } else {
                    $this->template->current_view = 'pracownicy/pracownicy/error_zmien';
                }
                $this->template->render();
            } else {
                $_POST['firstname'] = $worker['firstname'];
                $_POST['surname'] = $worker['surname'];
                $_POST['email'] = $worker['email'];
                $_POST['phone'] = $worker['phone'];
                
                $this->template->current_view = 'pracownicy/pracownicy/dodaj';
                $this->template->set('button_label', 'Zapisz');
                $this->template->render();
            }
        }
    }
}

/* End of file pracownicy.php */
/* Location: ./application/modules/pracownicy/controllers/pracownicy.php */