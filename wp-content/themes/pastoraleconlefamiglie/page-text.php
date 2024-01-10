<?php
global $post;

/* Template Name: page-text */
get_header();
?>
<div id="<?php echo $post->post_name;?>" class="main main-introduce pt-5">
    <div class="container">
        <div class="row py-5">
            <div class="col-sm-12">
                <?php echo get_field("testo");?>
            </div>
        </div>
    </div>

    <?php get_template_part('template-parts/banner-prefooter'); ?>
</div>

<?php
get_footer();