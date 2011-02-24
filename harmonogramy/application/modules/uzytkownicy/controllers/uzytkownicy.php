<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @property Template $template
 * @property CI_URI $uri
 * @property CI_Form_validation $form_validation
 * @property Uzytkownicy_model $um
 */
class Uzytkownicy extends MY_Controller {
    private $user_id;
    public $data;

	public function __construct() {
		parent::__construct();
        $this->load->library('security');
        $this->load->model('uzytkownicy_model', 'um');
        $this->user_id = $this->session->userdata('user_id');
        $this->data['per_page'] = 10;
	}

	public function index() {
        if (!$this->tank_auth->is_logged_in())
            redirect('uzytkownicy/zaloguj/');
        redirect('uzytkownicy/powitanie');
	}

    public function powitanie() {
        if (!$this->tank_auth->is_logged_in())
            redirect('uzytkownicy/zaloguj/');
        $this->template->render();
    }

    public function lista_pracownicy() {
        if (!$this->tank_auth->is_logged_in()) redirect('uzytkownicy/zaloguj/');

        $this->data['base_url'] = site_url('uzytkownicy/lista_pracownicy/');
        $this->data['total_rows'] = $this->um->countWorkers();
        $this->data['workers'] = $this->um->getWorkers($this->data['per_page'], (int) $this->uri->segment(3));
        $this->data['pagination'] = $this->pagination();
        
        $this->template->set($this->data);
        $this->template->render();
    }

    public function lista_obowiazki() {
        if (!$this->tank_auth->is_logged_in()) redirect('uzytkownicy/zaloguj/');

        $this->data['base_url'] = site_url('uzytkownicy/lista_obowiazki/');
        $this->data['total_rows'] = $this->um->countDuties();
        $this->data['duties'] = $this->um->getDuties($this->data['per_page'], (int) $this->uri->segment(3));
        $this->data['pagination'] = $this->pagination();
        
        $this->template->set($this->data);
        $this->template->render();
    }

    public function lista_harmonogramy() {
        if (!$this->tank_auth->is_logged_in()) redirect('uzytkownicy/zaloguj/');

        $this->data['base_url'] = site_url('uzytkownicy/lista_harmonogramy/');
        $this->data['total_rows'] = $this->um->countSchedules();
        $this->data['schedules'] = $this->um->getSchedules($this->data['per_page'], (int) $this->uri->segment(3));
        $this->data['pagination'] = $this->pagination();

        $this->template->set($this->data);
        $this->template->render();
    }

    public function lista_role() {
        if (!$this->tank_auth->is_logged_in()) redirect('uzytkownicy/zaloguj/');

        $this->data['base_url'] = site_url('uzytkownicy/lista_role/');
        $this->data['total_rows'] = $this->um->countRoles();
        $this->data['roles'] = $this->um->getRoles($this->data['per_page'], (int) $this->uri->segment(3));
        $this->data['pagination'] = $this->pagination();

        $this->template->set($this->data);
        $this->template->render();
    }

    private function pagination() {
        $this->load->library('pagination');
        
        $config = array(
            'base_url' => $this->data['base_url'],
        	'total_rows' => $this->data['total_rows'],
        	'per_page' => $this->data['per_page'],
        	'uri_segment' => 3,
        	'num_links' => 2
        );

        $this->pagination->initialize($config);

        return $this->pagination->create_links();
    }

// AUTORYZACJA
    public function zaloguj() {
		if ($this->tank_auth->is_logged_in()) {									// logged in
			redirect('uzytkownicy/powitanie/');

		} elseif ($this->tank_auth->is_logged_in(FALSE)) {						// logged in, not activated
			redirect('uzytkownicy/wyslij_ponownie/');

		} else {
			$data['login_by_username'] = ($this->config->item('login_by_username', 'tank_auth') AND
					$this->config->item('use_username', 'tank_auth'));
			$data['login_by_email'] = $this->config->item('login_by_email', 'tank_auth');

			$this->form_validation->set_rules('login', 'Login', 'trim|required|xss_clean');
			$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
			$this->form_validation->set_rules('remember', 'Remember me', 'integer');

			// Get login for counting attempts to login
			if ($this->config->item('login_count_attempts', 'tank_auth') AND
					($login = $this->input->post('login'))) {
				$login = $this->security->xss_clean($login);
			} else {
				$login = '';
			}

			$data['use_recaptcha'] = $this->config->item('use_recaptcha', 'tank_auth');
			if ($this->tank_auth->is_max_login_attempts_exceeded($login)) {
				if ($data['use_recaptcha'])
					$this->form_validation->set_rules('recaptcha_response_field', 'Confirmation Code', 'trim|xss_clean|required|callback__check_recaptcha');
				else
					$this->form_validation->set_rules('captcha', 'Confirmation Code', 'trim|xss_clean|required|callback__check_captcha');
			}
			$data['errors'] = array();

			if ($this->form_validation->run()) {								// validation ok
				if ($this->tank_auth->login(
						$this->form_validation->set_value('login'),
						$this->form_validation->set_value('password'),
						$this->form_validation->set_value('remember'),
						$data['login_by_username'],
						$data['login_by_email'])) {								// success
					redirect('uzytkownicy/powitanie/');

				} else {
					$errors = $this->tank_auth->get_error_message();
					if (isset($errors['banned'])) {								// banned user
						$this->_show_message($this->lang->line('auth_message_banned').' '.$errors['banned']);
						return;

					} elseif (isset($errors['not_activated'])) {				// not activated user
						redirect('uzytkownicy/wyslij_ponownie/');

					} else {													// fail
						foreach ($errors as $k => $v)	$data['errors'][$k] = $this->lang->line($v);
					}
				}
			}
			$data['show_captcha'] = FALSE;
			if ($this->tank_auth->is_max_login_attempts_exceeded($login)) {
				$data['show_captcha'] = TRUE;
				if ($data['use_recaptcha']) {
					$data['recaptcha_html'] = $this->_create_recaptcha();
				} else {
					$data['captcha_html'] = $this->_create_captcha();
				}
			}
        }
        $this->template->set($data);
        $this->template->render();
    }

    public function wyloguj() {
        if (!$this->tank_auth->is_logged_in())
            redirect('uzytkownicy/zaloguj/');
		$this->tank_auth->logout();
        $this->template->render();
    }

    public function zarejestruj() {
		if ($this->tank_auth->is_logged_in()) {									// logged in
			redirect('uzytkownicy/powitanie/');

		} elseif ($this->tank_auth->is_logged_in(FALSE)) {						// logged in, not activated
			redirect('uzytkownicy/wyslij_ponownie/');

		} elseif (!$this->config->item('allow_registration', 'tank_auth')) {	// registration is off
			$this->_show_message($this->lang->line('auth_message_registration_disabled'));
			return;

		} else {
			$use_username = $this->config->item('use_username', 'tank_auth');
			if ($use_username) {
				$this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean|min_length['.$this->config->item('username_min_length', 'tank_auth').']|max_length['.$this->config->item('username_max_length', 'tank_auth').']|alpha_dash');
			}
			$this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean|valid_email');
			$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean|min_length['.$this->config->item('password_min_length', 'tank_auth').']|max_length['.$this->config->item('password_max_length', 'tank_auth').']|alpha_dash');
			$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|xss_clean|matches[password]');

			$captcha_registration	= $this->config->item('captcha_registration', 'tank_auth');
			$use_recaptcha			= $this->config->item('use_recaptcha', 'tank_auth');
			if ($captcha_registration) {
				if ($use_recaptcha) {
					$this->form_validation->set_rules('recaptcha_response_field', 'Confirmation Code', 'trim|xss_clean|required|callback__check_recaptcha');
				} else {
					$this->form_validation->set_rules('captcha', 'Confirmation Code', 'trim|xss_clean|required|callback__check_captcha');
				}
			}
			$data['errors'] = array();

			$email_activation = $this->config->item('email_activation', 'tank_auth');

			if ($this->form_validation->run()) {								// validation ok
				if (!is_null($data = $this->tank_auth->create_user(
						$use_username ? $this->form_validation->set_value('username') : '',
						$this->form_validation->set_value('email'),
						$this->form_validation->set_value('password'),
						$email_activation))) {									// success

					$data['site_name'] = $this->config->item('website_name', 'tank_auth');

					if ($email_activation) {									// send "activate" email
						$data['activation_period'] = $this->config->item('email_activation_expire', 'tank_auth') / 3600;

						$this->_send_email('activate', $data['email'], $data);

						unset($data['password']); // Clear password (just for any case)

						//$this->_show_message($this->lang->line('auth_message_registration_completed_1'));
						return;

					} else {
						if ($this->config->item('email_account_details', 'tank_auth')) {	// send "welcome" email

							//$this->_send_email('welcome', $data['email'], $data);
						}
						unset($data['password']); // Clear password (just for any case)

						//$this->_show_message($this->lang->line('auth_message_registration_completed_2').' '.anchor('/auth/login/', 'Login'));
                        $this->template->current_view = 'uzytkownicy/uzytkownicy/zarejestrujsukces';
                        $this->template->render();
						return;
					}
				} else {
					$errors = $this->tank_auth->get_error_message();
					foreach ($errors as $k => $v)	$data['errors'][$k] = $this->lang->line($v);
				}
			}
			if ($captcha_registration) {
				if ($use_recaptcha) {
					$data['recaptcha_html'] = $this->_create_recaptcha();
				} else {
					$data['captcha_html'] = $this->_create_captcha();
				}
			}
			$data['use_username'] = $use_username;
			$data['captcha_registration'] = $captcha_registration;
			$data['use_recaptcha'] = $use_recaptcha;

            $this->template->set($data);
            $this->template->render();
		}
    }

    public function wyslij_ponownie() {
		if (!$this->tank_auth->is_logged_in(FALSE)) {							// not logged in or activated
			redirect('uzytkownicy/zaloguj/');

		} else {
			$this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean|valid_email');

			$data['errors'] = array();

			if ($this->form_validation->run()) {								// validation ok
				if (!is_null($data = $this->tank_auth->change_email(
						$this->form_validation->set_value('email')))) {			// success

					$data['site_name']	= $this->config->item('website_name', 'tank_auth');
					$data['activation_period'] = $this->config->item('email_activation_expire', 'tank_auth') / 3600;

					$this->_send_email('activate', $data['email'], $data);

					$this->_show_message(sprintf($this->lang->line('auth_message_activation_email_sent'), $data['email']));
					return;
				} else {
					$errors = $this->tank_auth->get_error_message();
					foreach ($errors as $k => $v)	$data['errors'][$k] = $this->lang->line($v);
				}
			}
            
            $this->template->set($data);
            $this->template->render();
		}
    }

    public function przypomnij_haslo() {
		if ($this->tank_auth->is_logged_in()) {									// logged in
			redirect('uzytkownicy/powitanie/');

		} elseif ($this->tank_auth->is_logged_in(FALSE)) {						// logged in, not activated
			redirect('uzytkownicy/wyslij_ponownie/');

		} else {
			$this->form_validation->set_rules('login', 'Email or login', 'trim|required|xss_clean');

			$data['errors'] = array();

			if ($this->form_validation->run()) {								// validation ok
				if (!is_null($data = $this->tank_auth->forgot_password(
						$this->form_validation->set_value('login')))) {

					$data['site_name'] = $this->config->item('website_name', 'tank_auth');

					// Send email with password activation link
					$this->_send_email('forgot_password', $data['email'], $data);

					$this->_show_message($this->lang->line('auth_message_new_password_sent'));
					return;

				} else {
					$errors = $this->tank_auth->get_error_message();
					foreach ($errors as $k => $v)	$data['errors'][$k] = $this->lang->line($v);
				}
			}

            $this->template->set($data);
            $this->template->render();
		}
    }

    public function usun_konto() {
		if (!$this->tank_auth->is_logged_in()) {
			redirect('uzytkownicy/zaloguj/');
		} else {
			$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');

			$data['errors'] = array();

			if ($this->form_validation->run()) {
                // usuwamy konto (wszystkich pracownikow)


                $this->template->current_view = 'uzytkownicy/uzytkownicy/sukces_usun';
			} else {
                $this->template->set($data);
            }
            $this->template->render();
		}
    }
}

/* End of file uzytkownicy.php */
/* Location: ./application/modules/uzytkownicy/controllers/uzytkownicy.php */