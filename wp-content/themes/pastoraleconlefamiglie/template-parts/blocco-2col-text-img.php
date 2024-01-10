<?php
/**
 * @var array $args
 */
if(empty($args['data_blocco'])){
    $data_blocco['subtitle_bloc1'] = get_field('subtitle_bloc1');
    $data_blocco['title_bloc1'] = get_field('title_bloc1');
    $data_blocco['description_bloc1'] = get_field('description_bloc1');
    $data_blocco['image_bloc1'] = get_field('image_bloc1');
}
else $data_blocco = $args['data_blocco'];
?>

<div class="bloc-text-img py-5">
    <div class="container">
        <div class="row pt-5 info">
            <div class="col-12 col-md-6">
                <?php if(!empty($data_blocco['subtitle_bloc1'])):?>
                <h6 class="subtitle"><?php echo $data_blocco['subtitle_bloc1']; ?></h6>
                <?php endif;?>
                <?php if(!empty($data_blocco['title_bloc1'])):?>
                <h2><?php echo $data_blocco['title_bloc1']; ?></h2>
                <?php endif;?>
                <?php if(!empty($data_blocco['description_bloc1'])):?>
                <div class="py-4"><?php echo $data_blocco['description_bloc1']; ?></div>
                <?php endif;?>
            </div>
            <?php if(!empty($data_blocco['image_bloc1'])):?>
            <div class="col-12 col-md-6 imgInfo">
                <img src="<?php echo $data_blocco['image_bloc1']; ?>" alt=""/>
            </div>
            <?php endif;?>
        </div>
    </div>
</div>