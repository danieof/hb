<?php
echo link_tag(base_url() . 'public/css/table.css', 'stylesheet', 'text/css');
echo '<script type="text/javascript" src="' . base_url() . '/public/javascript/js/jquery-1.4.4.min.js"></script>';
if (0 < $num_workers) :
?>
<table>
    <caption>Pracownicy</caption>
    <thead>
        <tr>
            <th scope="col">L.p.</th>
            <th scope="col">Imię</th>
            <th scope="col">Nazwisko</th>
            <th scope="col">E-mail</th>
            <th scope="col">Telefon</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($workers as $k => $worker) : ?>
    <?php if ($k % 2) : ?>
    <tr id="<?=$worker['id'];?>">
    <?php else : ?>
    <tr class="odd" id="<?=$worker['id'];?>">
    <?php endif; ?>
        <th scope="row"><?=$k+1?></th>
        <td><?=$worker['firstname'];?></td>
        <td><?=$worker['surname'];?></td>
        <td><?=$worker['email'];?></td>
        <td><?=$worker['phone'];?></td>
    </tr>
    <?php endforeach; ?>
    </tbody>
    <tfoot>
        <th scope="row">Wszystkich:</th>
        <td colspan="4"><?=$num_workers?></td>
    </tfoot>
</table>

<script type="text/javascript">
    $(function(){
        $("tr[id!='']").each(function(){
            $(this).click(function(){
                id = $(this).attr('id');
                window.location = '<?=site_url('pracownicy/edytuj');?>/' + id;
            });
        });
    });
</script>
<?php
else :
echo 'Nie ma pracownikow.';
endif;
?>