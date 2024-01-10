<div class="block-text-dx-image-bg py-5" style="background-image: url(<?php echo get_field('image_block_dx'); ?>);">
    <div class="container py-5 my-5">
        <div class="row justify-content-end py-5">
            <div class="col-sm-8 col-md-6 py-5">
                <?php if(!empty(get_field('subtitle_block_dx'))):?>
                    <h6 class="subtitle"><?php echo get_field('subtitle_block_dx'); ?></h6>
                <?php endif;?>
                <?php if(!empty(get_field('title_block_dx'))):?>
                    <h2 class="text-orange mb-4"><?php echo get_field('title_block_dx'); ?></h2>
                <?php endif;?>
                <?php if(!empty(get_field('description_block_dx'))):?>
                <div><?php echo get_field('description_block_dx'); ?></div>
                <?php endif;?>
                <?php if(!empty(get_field('citazione_block_dx'))):?>
                <div class="citazione">
                    <div class="text-citazione"><?php echo get_field('citazione_block_dx'); ?></div>
                    <?php if(!empty(get_field('citazione_autore_block_dx'))):?>
                    <div class="autore"><?php echo get_field('citazione_autore_block_dx'); ?></div>
                    <?php endif;?>
                </div>

                <?php endif;?>
                <?php if(!empty(get_field('button_block_dx')) && !empty(get_field('link_block_dx'))):?>
                    <div class="my-5">
                        <a href="<?php echo get_field('link_block_dx');?>" class="btn btn-white"><?php echo get_field('button_block_dx');?></a>
                    </div>
                <?php endif;?>
            </div>
        </div>
    </div>
</div>