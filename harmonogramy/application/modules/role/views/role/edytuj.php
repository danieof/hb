<?php
$name = array(
    'name' => 'name',
    'label' => 'Nazwa:',
    'value' => (isset($_POST['name']))?$_POST['name']:set_value('name')
);

echo form_open(current_url());
?>
<table>
    <tr>
        <td><?php echo form_label($name['label'], $name['name']);?></td>
        <td><?php echo form_input($name);?></td>
        <td><?php echo form_error($name['name']); ?></td>
    </tr>
    <tr>
        <td><?php echo form_submit('', 'Zapisz'); ?></td>
    </tr>
</table>
<?php
echo form_close();
?>