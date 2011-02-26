<?php echo $this->template->block('header', 'partials/header'); ?>
<div id="top">
    <div id="top_menu">
        <?php
        if ($this->tank_auth->is_logged_in()) {
            echo anchor('pracownicy/lista/', 'Lista pracownikow') . '<br />';
            echo anchor('harmonogramy/lista/', 'Lista harmonogramow') . '<br />';
            echo anchor('obowiazki/lista/', 'Lista obowiazkow') . '<br />';
            echo anchor('role/lista/', 'Lista rol') . '<br />';
            echo anchor('uzytkownicy/wyloguj/', 'Wyloguj') . '<br />';
            echo '<br />';
        }
        ?>
    </div>
</div>
<div id="center">
<?php echo $this->template->yield(); ?>
</div>
<div id="bottom">

</div>
<?php echo $this->template->block('footer', 'partials/footer'); ?>