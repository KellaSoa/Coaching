<?php
global $post;

/* Template Name: porziuncola */
get_header();
get_template_part('template-parts/button-fixed-courses');
?>
<div id="<?php echo $post->post_name;?>" class="main main-introduce pt-5">
    <?php get_template_part('template-parts/block-text-sx-image-background'); ?>
</div>
<?php
get_footer();
