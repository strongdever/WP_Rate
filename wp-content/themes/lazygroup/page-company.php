<?php
/*
Template Name: Company Template
*/

if( ! defined( 'ABSPATH' ) ) exit;
get_header();
$paged = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;
?>  

<main>
    <?php the_content(); ?>
</main>

<?php get_footer(); ?>