<?php
/**
 * The front page template file
 *
 * If the user has selected a static page for their homepage, this is what will
 * appear.
 * Learn more: https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */

get_header(); ?>

    <?php echo get_template_part('template-parts/content', 'search'); ?>
    
    <?php echo get_template_part('template-parts/content', 'list-job'); ?>
    

<?php get_footer();