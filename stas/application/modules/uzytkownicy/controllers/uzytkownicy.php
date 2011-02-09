<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @property Template $template
 * @property Users_Model $users_model
 * @property CI_URI $uri
 * @property CI_Form_validation $form_validation
 */
class Uzytkownicy extends MY_Controller {
	public function __construct() {
		parent::__construct();
        $this->load->model('users_model');
	}

	public function index() {
        redirect('uzytkownicy/lista');
	}

    public function dodaj() {
        // form validation
        $config = array(
            array(
                'field' => 'imie',
                'label' => 'Imię',
                'rules' => 'required'
            ),
            array(
                'field' => 'nazwisko',
                'label' => 'Nazwisko',
                'rules' => 'required'
            ),
            array(
                'field' => 'email',
                'label' => 'E-mail',
                'rules' => 'valid_email'
            ),
        );

        $this->form_validation->set_rules($config);

        if ($this->form_validation->run()) {
            // add user
            $data = array(
                'imie' => ucfirst($this->input->post('imie')),
                'nazwisko' => ucfirst($this->input->post('nazwisko')),
                'email' => $this->input->post('email'),
            );
            
            $this->users_model->addUser($data);

            // display sukces
            $this->template->current_view = 'uzytkownicy/uzytkownicy/sukces';
            $this->template->render();
        } else {
            // display form
            $this->template->render();
        }
    }

    public function lista() {
        $users = $this->users_model->getUsers();
        $this->template->set(array('users' => $users, 'liczba_uzytkownikow' => count($users)));
        $this->template->render();
    }

    public function ustawienia() {
        $user_id = $this->uri->segment(3);
        $user_id = (integer)$user_id;
        if (0 < $user_id) {
            $user = $this->users_model->getUser($user_id);
            print_r($user);
        }
    }
}

/* End of file uzytkownicy.php */
/* Location: ./application/modules/uzytkownicy/controllers/uzytkownicy.php */