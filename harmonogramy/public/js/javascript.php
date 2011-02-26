<?php
header('Content-type: text/javascript');

if (isset($_GET['js']))
    $js = explode(',', $_GET['js']);

readfile('jquery/jquery-1.4.4.min.js');
readfile('jquery/jquery-ui-1.8.9.custom.min.js');