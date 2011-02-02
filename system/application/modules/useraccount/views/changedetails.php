<?php
$name = array(
    'name' => 'name',
    'id' => 'name',
    'label' => 'First name',
    'value' => set_value('name')
);
$surname = array(
    'name' => 'surname',
    'id' => 'surname',
    'label' => 'Surname',
    'value' => set_value('surname')
);
$birthcity = array(
    'name' => 'birthcity',
    'id' => 'birthcity',
    'label' => 'City of birth',
    'value' => set_value('birthcity')
);
$birthdate = array(
    'name' => 'birthdate',
    'id' => 'birthdate',
    'label' => 'Date of birth',
    'value' => set_value('birthdate')
);
$gender = array(
    'name' => 'gender',
    'id' => 'gender',
    'label' => 'Gender',
    'value' => set_value('gender')
);

// formularz
echo form_open(current_url());
?>
<link rel="stylesheet" href="<?php echo base_url() . 'public/javascript/development-bundle/themes/base/jquery.ui.all.css'; ?>">
<script src="<?php echo base_url() . 'public/javascript/js/jquery-1.4.4.min.js'; ?>"></script>
<script src="<?php echo base_url() . 'public/javascript/development-bundle/ui/jquery.ui.core.js'; ?>"></script>
<script src="<?php echo base_url() . 'public/javascript/development-bundle/ui/jquery.ui.widget.js'; ?>"></script>

<script src="<?php echo base_url() . 'public/javascript/development-bundle/ui/jquery.ui.datepicker.js'; ?>"></script>

<script type="text/javascript">
    $(function(){
        $('#birthdate').datepicker({ dateFormat: 'yy-mm-dd' });
    });
</script>
<table>
	<tr>
		<td><?php echo form_label($name['label'], $name['id']); ?></td>
		<td><?php echo form_input($name); ?></td>
		<td style="color: red;"><?php echo form_error($name['name']); ?><?php echo isset($errors[$name['name']])?$errors[$name['name']]:''; ?></td>
	</tr>
	<tr>
		<td><?php echo form_label($surname['label'], $surname['id']); ?></td>
		<td><?php echo form_input($surname); ?></td>
		<td style="color: red;"><?php echo form_error($surname['name']); ?><?php echo isset($errors[$surname['name']])?$errors[$surname['name']]:''; ?></td>
	</tr>
	<tr>
		<td><?php echo form_label($birthcity['label'], $birthcity['id']); ?></td>
		<td><?php echo form_input($birthcity); ?></td>
		<td style="color: red;"><?php echo form_error($birthcity['name']); ?><?php echo isset($errors[$birthcity['name']])?$errors[$birthcity['name']]:''; ?></td>
	</tr>
	<tr>
		<td><?php echo form_label($birthdate['label'], $birthdate['id']); ?></td>
		<td><?php echo form_input($birthdate); ?></td>
		<td style="color: red;"><?php echo form_error($birthdate['name']); ?><?php echo isset($errors[$birthdate['name']])?$errors[$birthdate['name']]:''; ?></td>
	</tr>
	<tr>
		<td><?php echo form_label($gender['label'], $gender['id']); ?></td>
        <td><?php echo form_radio($gender['name'], 'male', ('male' == $gender['value'])?true:false) . 'Male'; ?>&nbsp;&nbsp;&nbsp;<?php echo form_radio($gender['name'], 'female', ('female' == $gender['value'])?true:false) . 'Female'; ?></td>
		<td style="color: red;"><?php echo form_error($gender['name']); ?><?php echo isset($errors[$gender['name']])?$errors[$gender['name']]:''; ?></td>
	</tr>
</table>
<?php
echo form_submit('submit_details', 'Submit');
echo form_close();
?>