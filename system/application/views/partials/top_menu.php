<div class="header">
	<div class="outernav">
		<div class="nav">
			<div class="innernav">
                <ul>
                    <li>
                        <?=anchor('', lang('topmenu_mainpage'))?>
                    </li>
                    <li>
                    <?php
                        if ($this->tank_auth->is_logged_in()) {
                            echo anchor('user/details', lang('topmenu_details'));
                        } else {
                            echo anchor('auth/register', lang('topmenu_register'));
                        }
                    ?>
                    </li>
                    <li>
                    <?php
                        if (!$this->tank_auth->is_logged_in()) {
                            echo anchor('auth/login', lang('topmenu_login'));
                        } else {
                            echo anchor('auth/logout', lang('topmenu_logout'));
                        }
                    ?>
                    </li>
                </ul>
			</div>
		</div>
	</div>

	<div class="clear"></div>

	<div class="title">
		<div class="innertitle">

			<!-- TITLE -->
			<h1><?=$subpagetitle?></h1>
			<!-- <h2>just another free template</h2> -->
			<!-- END TITLE -->

		</div>
	</div>
</div>