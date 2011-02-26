<?php if (0 < $total_rows) : ?>
<?=anchor($edit_location, 'Dodaj');?>
<table>
    <caption>Obowiązki</caption>
    <thead>
        <tr>
            <th scope="col">Nazwa</th>
            <th scope="col">Harmonogram</th>
            <th scope="col">Liczba pracowników</th>
            <th scope="col">Godzina rozpoczęcia</th>
            <th scope="col">Godzina zakończenia</th>
            <th scope="col">Dni tygodnia</th>
            <th scope="col">Opcje</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($duties as $k => $duty) : ?>
    <?php if ($k % 2) : ?>
    <tr id="<?=$duty['id'];?>">
    <?php else : ?>
    <tr class="odd" id="<?=$duty['id'];?>">
    <?php endif; ?>
        <td><?=$duty['name'];?></td>
        <td><?=$duty['schedule_name'];?></td>
        <td><?=$duty['num_workers'];?></td>
        <td><?=$duty['hour_start'];?></td>
        <td><?=$duty['hour_end'];?></td>
        <td><?=ul($duty['week_days']);?></td>
        <td>opcje</td>
    </tr>
    <?php endforeach; ?>
    </tbody>
    <tfoot>
        <th scope="row">Wszystkich:</th>
        <td colspan="6"><?=$total_rows?></td>
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
    Nie masz jeszcze obowiązków. <?=anchor($edit_location, 'Dodaj');?>
<?php endif; ?>