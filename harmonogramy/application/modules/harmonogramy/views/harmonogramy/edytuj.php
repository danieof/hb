<?php
$nazwa = array(
    'name' => 'name',
    'label' => 'Nazwa:',
    'value' => (isset($_POST['name']))?$_POST['name']:set_value('name')
);
echo form_open(current_url());
?>
<table>
    <tr>
        <td><?php echo form_label($nazwa['label'], $nazwa['name']);?></td>
        <td><?php echo form_input($nazwa);?></td>
        <td><?php echo form_error($nazwa['name']); ?></td>
    </tr>
    <tr>
        <td><?php echo form_submit('', 'Zapisz'); ?></td>
    </tr>
</table>
<?php
echo form_close();
?>