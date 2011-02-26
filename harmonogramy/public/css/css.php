<?php
header('Content-type: text/css');

if (isset($_GET['css']))
    $css = explode(',', $_GET['css']);

readfile('main.css');

if (in_array('table', $css)) {
    readfile('table.css');
}