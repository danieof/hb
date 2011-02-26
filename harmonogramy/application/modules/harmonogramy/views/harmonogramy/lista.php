<?php if (0 < $total_rows) : ?>
<?=anchor($edit_location, 'Dodaj');?>
<table>
    <caption>Harmonogramy</caption>
    <thead>
        <tr>
            <th scope="col">Nazwa</th>
            <th scope="col">Obowiązki</th>
            <th scope="col">Opcje</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($schedules as $k => $schedule) : ?>
    <?php if ($k % 2) : ?>
    <tr id="<?=$schedule['id'];?>">
    <?php else : ?>
    <tr class="odd" id="<?=$schedule['id'];?>">
    <?php endif; ?>
        <td><?=$schedule['name'];?></td>
        <td><?=ul($schedule['duties']);?></td>
        <td>opcje</td>
    </tr>
    <?php endforeach; ?>
    </tbody>
    <tfoot>
        <th scope="row">Wszystkich:</th>
        <td colspan="4"><?=$total_rows?></td>
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
    Nie masz jeszcze harmonogramów. <?=anchor($edit_location, 'Dodaj');?>
<?php endif; ?>