<?php
echo link_tag(base_url() . 'public/css/table.css', 'stylesheet', 'text/css');
echo '<script type="text/javascript" src="' . base_url() . '/public/javascript/js/jquery-1.4.4.min.js"></script>';
?>
<table>
    <caption>Użytkownicy</caption>
    <thead>
        <tr>
            <th scope="col">L.p.</th>
            <th scope="col">Imię</th>
            <th scope="col">Nazwisko</th>
            <th scope="col">E-mail</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($users as $k => $user) : ?>
    <?php if ($k % 2) : ?>
    <tr id="<?=$user['id'];?>">
    <?php else : ?>
    <tr class="odd" id="<?=$user['id'];?>">
    <?php endif; ?>
        <th scope="row"><?=$k+1?></th>
        <td><?=$user['imie'];?></td>
        <td><?=$user['nazwisko'];?></td>
        <td><?=$user['email'];?></td>
    </tr>
    <?php endforeach; ?>
    </tbody>
    <tfoot>
        <th scope="row">Wszystkich:</th>
        <td colspan="3"><?=$liczba_uzytkownikow?></td>
    </tfoot>
</table>

<script type="text/javascript">
    $(function(){
        $("tr[id!='']").each(function(){
            $(this).click(function(){
                id = $(this).attr('id');
                window.location = '<?=site_url('uzytkownicy/ustawienia');?>/' + id;
            });
        });
    });
</script>