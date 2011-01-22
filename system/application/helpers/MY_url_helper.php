<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('goback_url')) {
    function goback_url() {
        return $_SERVER['HTTP_REFERER'];
    }
}

/* End of file MY_url_helper.php */
/* Location: ./system/application/helpers/MY_url_helper.php */