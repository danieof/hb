<?php
$name = array(
    'name' => 'name',
    'label' => 'Nazwa:',
    'value' => (isset($_POST['name']))?$_POST['name']:set_value('name')
);
$schedule = array(
    'name' => 'schedule_id',
    'label' => 'Harmonogram:',
    'value' => (isset($_POST['schedule_id']))?$_POST['schedule_id']:set_value('schedule_id')
);
$num_workers = array(
    'name' => 'num_workers',
    'label' => 'Liczba pracowników:',
    'value' => (isset($_POST['num_workers']))?$_POST['num_workers']:set_value('num_workers')
);
$hour_start = array(
    'name' => 'hour_start',
    'label' => 'Godzina rozpoczęcia:',
    'value' => (isset($_POST['hour_start']))?$_POST['hour_start']:set_value('hour_start')
);
$hour_end = array(
    'name' => 'hour_end',
    'label' => 'Godzina zaczkończenia:',
    'value' => (isset($_POST['hour_end']))?$_POST['hour_end']:set_value('hour_end')
);
$week_days = array(
    'name' => 'week_days[]',
    'label' => 'Dni tygodnia:',
    'value' => (isset($_POST['week_days']))?$_POST['week_days']:set_value('week_days')
);
echo form_open(current_url());
?>
<table>
    <tr>
        <td><?php echo form_label($schedule['label'], $schedule['name']);?></td>
        <td><?php echo form_dropdown($schedule['name'], $schedules, $schedule['value']);?></td>
        <td><?php echo form_error($schedule['name']); ?></td>
    </tr>
    <tr>
        <td><?php echo form_label($name['label'], $name['name']);?></td>
        <td><?php echo form_input($name);?></td>
        <td><?php echo form_error($name['name']); ?></td>
    </tr>
    <tr>
        <td><?php echo form_label($num_workers['label'], $num_workers['name']);?></td>
        <td><?php echo form_input($num_workers);?></td>
        <td><?php echo form_error($num_workers['name']); ?></td>
    </tr>
    <tr>
        <td><?php echo form_label($hour_start['label'], $hour_start['name']);?></td>
        <td><?php echo form_input($hour_start);?></td>
        <td><?php echo form_error($hour_start['name']); ?></td>
    </tr>
    <tr>
        <td><?php echo form_label($hour_end['label'], $hour_end['name']);?></td>
        <td><?php echo form_input($hour_end);?></td>
        <td><?php echo form_error($hour_end['name']); ?></td>
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