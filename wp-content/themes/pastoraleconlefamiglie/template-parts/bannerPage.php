<?php
global $post;
?>

<div class="banner-page pt-5 pb-5" style="background-image: url(<?php the_field('image_header'); ?>)">
    <div class="container">
        <div class="row py-5">
            <div class="col-12 col-md-8 col-xl-6 content">
                <h1><?php the_field('title_header'); ?></h1>
                <p class="mt-5"><?php the_field('description_header'); ?></p>
                <?php if(!empty(get_field('button_header'))):?>
                <a href="#<?php echo $post->post_name;?>" class="btn btn-white"><?php echo get_field('button_header'); ?></a>
                <?php endif;?>
            </div>
        </div>
    </div>
</div>