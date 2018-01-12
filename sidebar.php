<div class="main-sidebar">
    <nav class="navbar navbar-default">
    	<div class="container-fluid">
    		<ul class="nav navbar-nav navbar-right">
    			<?php if (!is_user_logged_in()) {?>
    			<li><a href="#myModalLogin" data-toggle="modal"><span class="glyphicon glyphicon-log-in"></span> <?php echo __('Login');?></a></li>
    			<li><a href="#myModalRegister" data-toggle="modal"><?php echo __('Register');?></a></li>
    			<?php } else {?>
    			<li><a href="#" data-toggle="modal"><span class="glyphicon glyphicon-log-out"></span> <?php echo __('Logout');?></a></li>
    			<?php }?>
    		</ul>
    	</div>
    </nav>
</div>