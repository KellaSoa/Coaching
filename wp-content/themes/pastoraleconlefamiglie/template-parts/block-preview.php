<div class="block-preview mt-5 bg-orange text-center">
    <div class="container">
        <div class="row">
            <div class="col-sm-9 mx-auto">
                <?php if(!empty(get_field('subtitle_block_preview'))):?>
                    <h6 class="subtitle text-white"><?php echo get_field('subtitle_block_preview'); ?></h6>
                <?php endif;?>
                <?php if(!empty(get_field('title_block_preview'))):?>
                    <h3 class="description font-title"><?php echo get_field('title_block_preview'); ?></h3>
                <?php endif;?>
                <?php if(!empty(get_field('description_block_preview'))):?>
                    <div><?php echo get_field('description_block_preview'); ?></div>
                <?php endif;?>
            </div>
        </div>

    </div>
</div>