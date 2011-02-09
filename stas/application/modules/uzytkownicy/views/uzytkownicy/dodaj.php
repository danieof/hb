<?php
$imie = array(
    'name' => 'imie',
    'label' => 'Imię:',
    'value' => set_value('imie')
);
$nazwisko = array(
    'name' => 'nazwisko',
    'label' => 'Nazwisko:',
    'value' => set_value('nazwisko')
);
$email = array(
    'name' => 'email',
    'label' => 'E-mail:',
    'value' => set_value('email')
);

echo form_open(current_url());
?>
<table>
    <tr>
        <td><?php echo form_label($imie['label'], $imie['name']);?></td>
        <td><?php echo form_input($imie);?></td>
        <td><?php echo form_error($imie['name'],'<span>','</span>'); ?></td>
    </tr>
    <tr>
        <td><?php echo form_label($nazwisko['label'], $nazwisko['name']);?></td>
        <td><?php echo form_input($nazwisko);?></td>
        <td><?php echo form_error($nazwisko['name'],'<span>','</span>'); ?></td>
    </tr>
    <tr>
        <td><?php echo form_label($email['label'], $email['name']);?></td>
        <td><?php echo form_input($email);?></td>
        <td><?php echo form_error($email['name'],'<span>','</span>'); ?></td>
    </tr>
    <tr>
        <td><?php echo form_submit('', 'Dodaj'); ?></td>
    </tr>
</table>
<?php
echo form_close();
?>