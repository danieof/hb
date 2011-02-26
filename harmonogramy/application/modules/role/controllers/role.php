<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Role extends MY_Controller {
	public function __construct() {
		parent::__construct();
        if (!$this->tank_auth->is_logged_in())
            redirect('uzytkownicy/zaloguj/');
        $this->load->model('role_model', 'rm');

        $this->data['user_id'] = $this->session->userdata('user_id');
        $this->data['role_id'] = (int) $this->uri->segment(3);
	}

	public function index() {
        redirect('role/lista/');
	}

    public function lista() {
        $this->data['pagination_config']['base_url'] = site_url('role/lista/');
        $this->data['pagination_config']['num_links'] = 2;
        $this->data['pagination_config']['per_page'] = 10;
        $this->data['pagination_config']['uri_segment'] = 3;
        $this->data['pagination_config']['total_rows'] = $this->rm->countRoles();

        $this->data['total_rows'] = $this->data['pagination_config']['total_rows'];
        $this->data['roles'] = $this->rm->getRoles($this->data['pagination_config']['per_page'],
                                                   (int) $this->uri->segment(3));
        $this->data['pagination'] = $this->pagination();
        $this->data['edit_location'] = site_url('role/edytuj/');
        $this->data['css'] .= ',table';

        $this->template->set($this->data);
        $this->template->render();
    }

    public function edytuj() {
        $config = array(
            array(
                'field' => 'name',
                'label' => 'Nazwa',
                'rules' => 'required|callback_roleNotExists'
            )
        );

        $this->form_validation->set_rules($config);

        if (true === $this->form_validation->run()) {
            if (true === $this->editRole($this->data['role_id'])) {
                $this->template->current_view = 'role/role/sukces_zmien';
            } else {
                $this->template->current_view = 'role/role/error_zmien';
            }
        } else {
            if (0 !== $this->data['role_id']) {
                $role = $this->rm->getRole($this->data['role_id']);

                $_POST['name'] = $role['name'];
            }
        }
        $this->template->set($this->data);
        $this->template->render();
    }
    
    // MODEL INTERFACE
    public function roleNotExists($role_name) {
        if ($this->rm->roleExists($role_name, $this->data['role_id'])) {
            $this->form_validation->set_message('roleNotExists', 'Rola o podanych danych już istnieje.');
            return false;
        }
        return true;
    }

    public function editRole($role_id) {
        if (true === $this->rm->editRole($role_id))
            return true;
        return false;
    }

    public function deleteRole($role_id) {
        if (true === $this->rm->deleteRole($role_id))
            return true;
        return false;
    }
}

/* End of file Role.php */
/* Location: ./application/modules/Role/controllers/Role.php */