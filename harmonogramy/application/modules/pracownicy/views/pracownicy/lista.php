<?php if (0 < $total_rows) : ?>
<?=anchor($edit_location, 'Dodaj');?>
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
        <td>opcje</td>
    </tr>
    <?php endforeach; ?>
    </tbody>
    <tfoot>
        <th scope="row">Wszystkich:</th>
        <td colspan="5"><?=$total_rows?></td>
    </tfoot>
</table>

<div class="pagination"><?=$pagination;?></div>

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
<?php else : ?>
    Nie masz jeszcze pracowników. <?=anchor($edit_location, 'Dodaj');?>
<?php endif; ?>