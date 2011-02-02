<?php
// formularz
echo 'First name: ' . $name . '<br />';
echo 'Surname: ' . $surname . '<br />';
echo 'City of birth: ' . $birthcity . '<br />';
echo 'Date of birth: ' . $birthdate . '<br />';
echo 'Gender: ' . $gender . '<br />';
echo '<br />';
echo form_open('useraccount/change_details');
echo form_button('change_details', 'Change details', 'onClick="window.location = \'' . site_url('useraccount/change_details') . '\';"');
echo form_close();
?>