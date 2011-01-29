<div class="header">
	<div class="outernav">
		<div class="nav">
			<div class="innernav">
                <?php
                if (!$this->tank_auth->is_logged_in()) :
                ?>
                <ul>
                    <li>
                        <?=anchor('', lang('topmenu_mainpage'))?>
                    </li>
                    <li>
                    <?php
                        echo anchor('auth/register', lang('topmenu_register'));
                    ?>
                    </li>
                    <li>
                    <?php
                        echo anchor('auth/login', lang('topmenu_login'));
                    ?>
                    </li>
                </ul>
                <?php
                else :
                ?>
                <ul>
                    <li>
                        <?=anchor('', lang('topmenu_mainpage'))?>
                    </li>
                    <li>
                    <?php
                        echo anchor('useraccount/details', lang('topmenu_details'));
                    ?>
                    </li>
                    <li>
                    <?php
                        echo anchor('auth/unregister', lang('topmenu_delete'));
                    ?>
                    </li>
                    <li>
                    <?php
                        echo anchor('auth/logout', lang('topmenu_logout'));
                    ?>
                    </li>
                </ul>
                <?php
                endif;
                ?>
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