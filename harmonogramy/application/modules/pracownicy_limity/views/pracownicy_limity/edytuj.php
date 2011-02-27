<?php
$duty = array(
    'name' => 'duty_id',
    'label' => 'Obowiązek:',
    'value' => (isset($_POST['duty_id']))?$_POST['duty_id']:set_value('duty_id')
);
$week_days = array(
    'name' => 'week_days[]',
    'label' => 'Dni tygodnia:',
    'value' => (isset($_POST['week_days']))?$_POST['week_days']:set_value('week_days')
);
//print_R($duty);
//print_r($week_days);

echo form_open(current_url());
?>
<table>
    <tr>
        <td><?php echo form_label($duty['label'], $duty['name']);?></td>
        <td><?php echo form_dropdown($duty['name'], $duties, $duty['value']);?></td>
        <td><?php echo form_error($duty['name']); ?></td>
    </tr>
    <tr>
        <td><?php echo form_label($week_days['label'], $week_days['name']);?></td>
        <td><?php echo form_multiselect($week_days['name'], $week_days_multiselect, $week_days['value']);?></td>
        <td><?php echo form_error($week_days['name']); ?></td>
    </tr>
    <tr>
        <td><?php echo form_submit('', 'Zapisz'); ?></td>
    </tr>
</table>
<?php
echo form_close();
?>