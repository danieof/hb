<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @property Pracownicymodel $pm
 */
class Pracownicy extends MY_Controller {
	public function __construct() {
		parent::__construct();
        if (!$this->tank_auth->is_logged_in())
            redirect('/uzytkownicy/zaloguj');
        $this->load->model('pracownicymodel','pm');
	}

	public function index() {
        redirect('pracownicy/lista');
	}

    public function dodaj() {
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
                'rules' => 'valid_email'
            ),
            array(
                'field' => 'phone',
                'label' => 'Telefon',
                'rules' => 'callback_valid_phone'
            ),
        );

        $this->form_validation->set_rules($config);

        if ($this->form_validation->run()) {
            $data = array(
                'firstname' => ucfirst($this->input->post('firstname')),
                'surname' => ucfirst($this->input->post('surname')),
                'email' => $this->input->post('email'),
                'phone' => $this->input->post('phone')
            );

            $this->pm->addWorker($data);

            $this->template->current_view = 'pracownicy/pracownicy/sukces';
            $this->template->render();
        } else {
            $this->template->render();
        }
    }

    public function edytujdane() {
        $worker_id = $this->uri->segment(3);
        $worker_id = (integer)$worker_id;
        if (0 < $worker_id) {
            $worker = $this->pm->getWorker($worker_id);

            $this->template->render();
        }
    }

    public function edytujlimity() {
        
    }

    public function lista() {
        $workers = $this->pm->getWorkers();
        $this->template->set(array('workers' => $workers, 'num_workers' => count($workers)));
        $this->template->render();
    }
}

/* End of file pracownicy.php */
/* Location: ./application/modules/pracownicy/controllers/pracownicy.php */