<?php echo $this->template->block('header', 'partials/header') ?>
<?php echo $this->template->block('top_menu', 'partials/top_menu') ?>
<div id="message">
    <?php echo $this->template->message(); ?>
</div>
<div id="wrap">
	<div class="pagewrapper">
		<div class="innerpagewrapper">
			<div class="page">
    <?php echo $this->template->yield(); ?>
<?php echo $this->template->block('footer', 'partials/footer') ?>