<?php
/**
 * Description of rename
 *
 * @author danio
 * @property Template $template
 */
class welcome extends MY_Controller {
    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->_render('welcome/index', array(), lang('common_welcome_title'), lang('common_welcome_title'));
    }
}
