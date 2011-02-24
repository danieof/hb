<?php echo $this->template->block('header', 'partials/header'); ?>
<?php
    echo anchor('uzytkownicy/lista_pracownicy/', 'Lista pracownikow') . '<br />';
    echo anchor('pracownicy/edytuj', 'Dodaj pracownika') . '<br />';
    echo anchor('uzytkownicy/lista_harmonogramy/', 'Lista harmonogramow') . '<br />';
    echo anchor('uzytkownicy/lista_obowiazki/', 'Lista obowiazkow') . '<br />';
    echo anchor('uzytkownicy/lista_role/', 'Lista rol') . '<br />';
    echo anchor('uzytkownicy/zaloguj/', 'Zaloguj') . '<br />';
    echo anchor('uzytkownicy/wyloguj/', 'Wyloguj') . '<br />';

    echo '<br /><br />';
?>
<?php echo $this->template->yield(); ?>
<?php echo $this->template->block('footer', 'partials/footer'); ?>