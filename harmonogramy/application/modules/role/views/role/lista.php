<?php if (0 < $total_rows) : ?>
<?=anchor($edit_location, 'Dodaj');?>
<table>
    <caption>Role</caption>
    <thead>
        <tr>
            <th scope="col">Nazwa</th>
            <th scope="col">Opcje</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($roles as $k => $role) : ?>
    <?php if ($k % 2) : ?>
    <tr id="<?=$role['id'];?>">
    <?php else : ?>
    <tr class="odd" id="<?=$role['id'];?>">
    <?php endif; ?>
        <td><?=$role['name'];?></td>
        <td>
            <?=anchor(site_url('role/edytuj/') . '/' . $role['id'], 'edytuj dane');?>
        </td>
    </tr>
    <?php endforeach; ?>
    </tbody>
    <tfoot>
        <th scope="row">Wszystkich:</th>
        <td colspan="2"><?=$total_rows?></td>
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
    Nie masz jeszcze ról. <?=anchor($edit_location, 'Dodaj');?>
<?php endif; ?>