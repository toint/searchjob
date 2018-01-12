<?php 

?>
<nav class="navbar navbar-default navbar-search">
	<form class="form-inline navbar-form">
		<div class="row">
    		<div class="col-sm-10">
    			<div class="col-sm-4">
        			<div class="input-group col-sm-12">
            			<span class="input-group-addon" id="sizing-addon1"><i class="glyphicon glyphicon-search"></i></span>
            			<input type="text" class="form-control" aria-describedby="sizing-addon1" placeholder="<?php echo __('Chức danh, vị trí, kỹ năng...');?>" />
            		</div>
        		</div>
        		<div class="col-sm-4">
            		<div class="input-group col-sm-12">
            			<span class="input-group-addon" id="sizing-addon2"><i class="glyphicon glyphicon-th-list"></i></span>
            			<input type="text" class="form-control" aria-describedby="sizing-addon2" placeholder="<?php echo __('Ngành nghề');?>" />
            		</div>
        		</div>
        		<div class="col-sm-4">
            		<div class="input-group col-sm-12">
            			<span class="input-group-addon" id="sizing-addon3"><i class="glyphicon glyphicon-map-marker"></i></span>
            			<input type="text" class="form-control" aria-describedby="sizing-addon3" placeholder="<?php echo __('Địa điểm');?>" />
            		</div>
        		</div>
    		</div>
    		<div class="col-sm-2">
    			<button type="submit" class="col-sm-12 btn btn-default"><?php echo __('Search');?></button>
    		</div>
		</div>
	</form>
</nav>

<nav class="navbar navbar-default navbar-filter">
	<div class="containerf-fluid">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-filter-form" aria-expanded="false">
				<span class="sr-only">Toogle navigation</span>
				<span class="icon-bar"></button>
				<span class="icon-bar"></button>
				<span class="icon-bar"></button>
			</button>
			<a class="navbar-brand" href="#"><?php echo __('Tìm kiếm theo:');?></a>
		</div>
		<div class="collapse navbar-collapse" id="bs-filter-form">
			<ul class="nav navbar-nav">
				<li><a href="#"><?php echo __('Job Level:');?></a></li>
				<li class="dropdown">
					<a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                  		<?php echo __('All ranges');?> <span class="caret"></span>
                	</a>
                	<ul class="dropdown-menu">
                		<li><a href="#"><?php echo __('All job levels');?></a></li>
                	</ul>
				</li>
				<li><a href="#"><?php echo __('Salary:');?></a></li>
				<li class="dropdown">
					<a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                  		<?php echo __('All ranges');?> <span class="caret"></span>
                	</a>
                	<ul class="dropdown-menu">
                		<li><a href="#"><?php echo __('All ranges');?></a></li>
                	</ul>
            	</li>
			</ul>
		</div>
	</div>
</nav>