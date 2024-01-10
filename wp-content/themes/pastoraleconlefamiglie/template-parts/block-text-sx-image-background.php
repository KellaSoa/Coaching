<div class="block-text-sx-image-bg pt-5" style="background-image: url(<?php echo get_field('image_block_sx'); ?>)">
    <div class="container pt-5 text-white">
        <div class="row py-5">
            <div class="col-sm-8 col-md-6 py-5 info">
                <?php if(!empty(get_field('subtitle_block_sx'))):?>
                <h6 class="subtitle"><?php echo get_field('subtitle_block_sx'); ?></h6>
                <?php endif;?>
                <?php if(!empty(get_field('title_block_sx'))):?>
                <h2 class="text-orange mb-4"><?php echo get_field('title_block_sx'); ?></h2>
                <?php endif;?>
                <?php if(!empty(get_field('description_block_sx'))):?>
                <div><?php echo get_field('description_block_sx'); ?></div>
                <?php endif;?>
                <?php if(!empty(get_field('button_block_sx')) && !empty(get_field('link_block_sx'))):?>
                <div class="my-5">
                    <a href="<?php echo get_field('link_block_sx');?>" class="btn btn-white"><?php echo get_field('button_block_sx');?></a>
                </div>
                <?php endif;?>
            </div>
        </div>
    </div>
</div>