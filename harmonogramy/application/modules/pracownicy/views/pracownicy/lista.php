<?php if (0 < $total_rows) : ?>
<?=anchor(site_url('pracownicy/edytuj/'), 'Dodaj');?>
<table>
    <caption>Pracownicy</caption>
    <thead>
        <tr>
            <th scope="col">Imię</th>
            <th scope="col">Nazwisko</th>
            <th scope="col">E-mail</th>
            <th scope="col">Telefon</th>
            <th scope="col">Opcje</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($workers as $k => $worker) : ?>
    <?php if ($k % 2) : ?>
    <tr id="<?=$worker['id'];?>">
    <?php else : ?>
    <tr class="odd" id="<?=$worker['id'];?>">
    <?php endif; ?>
        <td><?=$worker['firstname'];?></td>
        <td><?=$worker['surname'];?></td>
        <td><?=$worker['email'];?></td>
        <td><?=$worker['phone'];?></td>
        <td>
            <?=anchor(site_url('pracownicy/edytuj/') . '/' . $worker['id'], 'edytuj dane');?>
            <br />
            <?=anchor(site_url('pracownicy_limity/lista/') . '/' . $worker['id'], 'pokaż limity');?>
            <br />
            <?=anchor(site_url('pracownicy/edytuj_role/') . '/' . $worker['id'], 'edytuj role');?>
        </td>
    </tr>
    <?php endforeach; ?>
    </tbody>
    <tfoot>
        <th scope="row">Wszystkich:</th>
        <td colspan="5"><?=$total_rows?></td>
    </tfoot>
</table>

<div class="pagination"><?=$pagination;?></div>

<!--
<script type="text/javascript">
    $(function(){
        $("tr[id!='']").each(function(){
            $(this).click(function(){
                id = $(this).attr('id');
                window.location = '<?=$edit_location?>/' + id;
            });
        });
    });
</script>
-->
<?php else : ?>
    Nie masz jeszcze pracowników. <?=anchor(site_url('pracownicy/edytuj/'), 'Dodaj');?>
<?php endif; ?>