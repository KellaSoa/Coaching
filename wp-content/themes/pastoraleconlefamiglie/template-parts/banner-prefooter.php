<?php if(!empty(get_field('cta_prefooter'))):?>
<div class="bg-blu text-center text-white pt-5 pb-3">
    <div class="container">
        <?php if(!empty(get_field('titolo_prefooter'))):?>
        <div class="description my-5"><?php echo get_field('titolo_prefooter'); ?></div>
        <?php endif;?>

        <div class="mt-5">
            <a href="<?php echo get_field('link_cta_prefooter'); ?>" class="btn btn-white border-1 btn-arrow">
                <label><?php echo get_field('cta_prefooter'); ?></label>
            </a>
        </div>
    </div>
</div>
<?php endif;?>
