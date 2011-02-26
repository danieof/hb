<?php if (0 < $total_rows) : ?>
<?=anchor(site_url('pracownicy_limity/edytuj/') . '/' . $worker_id, 'Dodaj');?>
<table>
    <caption>Limity pracownika</caption>
    <thead>
        <tr>
            <th scope="col">Nazwa obowiązku</th>
            <th scope="col">Dni tygodnia</th>
            <th scope="col">Opcje</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($workersdutylimis as $k => $wdl) : ?>
    <?php if ($k % 2) : ?>
    <tr id="<?=$wdl['id'];?>">
    <?php else : ?>
    <tr class="odd" id="<?=$wdl['id'];?>">
    <?php endif; ?>
        <td><?=$wdl['duty_name'];?></td>
        <td><?=$wdl['duty_week_days'];?></td>
        <td>
            <?=anchor(site_url('pracownicy_limity/edytuj/') . '/' . $worker_id . '/' . $wdl['id'], 'edytuj limit');?>
        </td>
    </tr>
    <?php endforeach; ?>
    </tbody>
    <tfoot>
        <th scope="row">Wszystkich:</th>
        <td colspan="3"><?=$total_rows?></td>
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
    Nie masz jeszcze limitów dla tego pracownika. <?=anchor(site_url('pracownicy_limity/edytuj/') . '/' . $worker_id, 'Dodaj');?>
<?php endif; ?>