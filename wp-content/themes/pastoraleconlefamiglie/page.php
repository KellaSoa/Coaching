<?php
global $post;

get_header();
get_template_part('template-parts/bannerPage');
?>
<div id="<?php echo $post->post_name;?>" class="main main-introduce pt-5">
    <?php get_template_part('template-parts/blocco-2col-text-img');?>
</div>
<?php
get_footer();
