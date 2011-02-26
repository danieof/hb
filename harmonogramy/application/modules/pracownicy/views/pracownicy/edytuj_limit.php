<?php
$imie = array(
    'name' => 'firstname',
    'label' => 'Imię:',
    'value' => (isset($_POST['firstname']))?$_POST['firstname']:set_value('firstname')
);

echo form_open(current_url());
?>
<table>
    <tr>
        <td><?php echo form_label($imie['label'], $imie['name']);?></td>
        <td><?php echo form_input($imie);?></td>
        <td><?php echo form_error($imie['name']); ?></td>
    </tr>
    <tr>
        <td><?php echo form_submit('', 'Zapisz'); ?></td>
    </tr>
</table>
<?php
echo form_close();
?>