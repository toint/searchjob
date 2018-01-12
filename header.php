<?php ?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js no-svg">
    <head>
        <meta charset="<?php bloginfo( 'charset' ); ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="profile" href="http://gmpg.org/xfn/11">
        <title>Search Job Engine</title>
        <?php wp_head(); ?>
    </head>
    <body>
		
        <?php echo get_template_part('template-parts/common/content', 'modal-validation'); ?>
        <?php echo get_template_part('template-parts/common/content', 'progress'); ?>
        <?php echo get_sidebar(); ?>
        <?php echo get_template_part('template-parts/authentication/content', 'register'); ?>
        <?php echo get_template_part('template-parts/authentication/content', 'login'); ?>
        <div class="page">
            <div class="container">
            
    