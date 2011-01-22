<?php
/**
 * Description of MY_Input
 *
 * @author danio
 */
class MY_Input extends CI_Input {
    public function  __construct() {
        parent::CI_Input();
    }

    public function  _sanitize_globals() {
        $this->allow_get_array = TRUE;
        parent::_sanitize_globals();
    }
}