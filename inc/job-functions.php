<?php
function the_post_offer($args) {
    global $wpdb;
    
    $sql = "SELECT a.post_url, a.title, a.place_text, a.posted_date, a.salary, c.name as com_name ";
    $sql .= " FROM " . $wpdb->prefix . "new_offer a ";
    $sql .= " JOIN " . $wpdb->prefix . "company c on c.user_id = a.user_id ";
    $sql .= " WHERE a.status = 1 order by a.posted_date desc ";
    $sql .= " LIMIT " . $args[0] . ", " . $args[1];
    
    $offers = $wpdb->get_results($sql);
    $current_row = $wpdb->num_rows;
    
    
    $sql = "SELECT COUNT(*) as total ";
    $sql .= " FROM " . $wpdb->prefix . "new_offer a ";
    $sql .= " JOIN " . $wpdb->prefix . "company c on c.user_id = a.user_id ";
    $sql .= " WHERE a.status = 1 order by a.posted_date desc ";
    
    $count = $wpdb->get_results($sql);
    $rownum = 0;
    if ($wpdb->num_rows > 0) {
        $rownum = $count[0]->total;
    }
    
    $row_total = ceil($rownum/50);
?>
<?php 
    if (!empty($offers)) {
        foreach ($offers as $offer) {
?>
<div class="row" class="list-job-posted">
	<div class="col-sm-3 post-logo">
		<div class="com-logo">
			<a href="#" class="thumbnail">
    			<img src="<?php echo get_template_directory_uri() . '/assets/images/no-img.png' ?>">
			</a>
		</div>
	</div>
	<div class="col-sm-9 post-content">
		<div class="post-content">
			<div class="row">
				<div class="col-sm-12">
					<h3>
						<a href="<?php echo get_site_url() . '/' . $offer->post_url?>"><?php echo $offer->title;?></a>
					</h3>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12">
					<?php echo $offer->com_name;?>
				</div>
			</div>
			<div class="row">
    			<div class="col-sm-3">
    				<?php echo __('Salary:') . ' ' . $offer->salary;?>
    			</div>
    			<div class="col-sm-3">
    				<?php echo __('Location:') . ' ' . $offer->place_text;?>
    			</div>
    			<div class="col-sm-3">
    				<?php echo __('Posted:') . ' ' . $offer->posted_date;?>
    			</div>
			</div>
		</div>
	</div>
</div>



<?php
    }
    ?>

<?php if ($row_total > 0) {?>
<div class="row">
<div class="col-sm-12">
<nav aria-label="Page navigation">
	<ul class="pager">
		<li>
      		<a href="#" aria-label="Previous">
            	<span aria-hidden="true">&laquo;</span>
      		</a>
    	</li>
    	<?php 
    	for($i = 1; $i <= $row_total; $i++) {
    	?>
    	<li><a href="page=<?php echo $i;?>"><?php echo $i;?></a></li>
    	<?php 
    	}
    	?>
    	<li>
          	<a href="#" aria-label="Next">
            	<span aria-hidden="true">&raquo;</span>
          	</a>
        </li>
	</ul>
</nav>
</div>
</div>
<?php } ?>
    
<?php
    
    }
}

add_filter('the_post_offer', 'the_post_offer');