<?php
$imie = array(
    'name' => 'firstname',
    'label' => 'Imię:',
    'value' => set_value('firstname')
);
$nazwisko = array(
    'name' => 'surname',
    'label' => 'Nazwisko:',
    'value' => set_value('surname')
);
$email = array(
    'name' => 'email',
    'label' => 'E-mail:',
    'value' => set_value('email')
);
$phone = array(
    'name' => 'phone',
    'label' => 'Telefon:',
    'value' => set_value('phone')
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
        <td><?php echo form_label($phone['label'], $phone['name']);?></td>
        <td><?php echo form_input($phone);?></td>
        <td><?php echo form_error($phone['name'],'<span>','</span>'); ?></td>
    </tr>
    <tr>
        <td><?php echo form_submit('', 'Dodaj'); ?></td>
    </tr>
</table>
<?php
echo form_close();
?>