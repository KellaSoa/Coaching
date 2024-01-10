<?php
$terms_param = [
    'taxonomy' => 'type-course',
    'hide_empty' => 0,
    'orderby' => 'ID',
    'order' => 'ASC',
];
$types = get_terms($terms_param);
?>

<?php
get_header();
get_template_part('template-parts/banner');
get_template_part('template-parts/button-fixed-courses');
?>
<div id="home" class="main">
    <div class="bg-red py-5">
        <div class="block-citazione">
            <div class="container" style="background-image: url(<?php echo get_theme_file_uri('/images/Vector1.png'); ?>)">
                <div class="row w-100">
                    <div class="col-12">
                        <h3><?php echo get_field('testo_citazione');?></h3>
                        <h4><?php echo get_field('autore_citazione');?></h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="container my-5 py-5">
            <div class="row text-center">
                <div class="col-12 col-lg-8 mx-auto"><?php echo get_field('descrizione_citazione');?></div>
            </div>
        </div>
    </div>

    <?php get_template_part("template-parts/block-text-sx-image-background");?>

    <?php get_template_part("template-parts/block-text-dx-image-background")?>

    <?php get_template_part("template-parts/block-preview")?>

    <div class="bloc-card">
        <div class="container">
            <div class="row">
                <?php foreach ($types as $type) :?>
                    <?php
                    $args_corsi = [
                        'post_type' => 'course',
                        'tax_query' => [
                            [
                                'taxonomy' => 'type-course',
                                'field' => 'slug',
                                'terms' => $type->slug,
                            ],
                        ],
                        'orderby' => 'ID',
                        'order' => 'ASC'
                    ];

                    $loop = new WP_Query($args_corsi);
                    if ($loop->have_posts()) :?>
                        <div class="col-12 col-sm-6 col-md-4 card border-primary mb-3">
                            <div class="card-body">
                                <h3 class="card-title"><?php echo get_field('titoletto_anteprima', $type);?></h3>
                                <ul>
                                    <?php while ($loop->have_posts()) {
                                        $loop->the_post();
                                        ?>
                                        <li>
                                            <a href="<?php echo site_url('/le-nostre-iniziative#'.get_post_field('post_name', get_the_ID()));?>"><?php echo get_the_title();?></a>
                                        </li>
                                    <?php }
                                    wp_reset_query();
                                    ?>
                                </ul>
                                <div class="footer">
                                    <a href="<?php echo site_url('/le-nostre-iniziative#'.$type->slug);?>" class="btn btn-redBgWhite ">Scopri di più</a>
                                </div>
                            </div>
                        </div>
                    <?php endif;?>
                <?php endforeach;?>
            </div>
        </div>
    </div>

    <div class="block-sostienici">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <div class="blocDescription">
                        <?php if(!empty(get_field('subtitle_block_preview_sostienici'))):?>
                        <h6 class="subtitle text-white"><?php echo get_field('subtitle_block_preview_sostienici'); ?></h6>
                        <?php endif;?>
                        <?php if(!empty(get_field('title_block_preview_sostienici'))):?>
                        <h3 class="description font-title"><?php echo get_field('title_block_preview_sostienici'); ?></h3>
                        <?php endif;?>
                        <?php if(!empty(get_field('description_block_preview_sostienici'))):?>
                        <div><?php echo get_field('description_block_preview_sostienici'); ?></div>
                        <?php endif;?>
                        <?php if(!empty(get_field('button_block_preview_sostienici'))):?>
                        <div class="my-5">
                            <a href="<?php echo site_url('/sostienici');?>" class="btn btn-white"><?php echo get_field('button_block_preview_sostienici');?></a>
                        </div>
                        <?php endif;?>
                    </div>
                </div>
                <div class="col-sm-6 text-center">
                    <img src="<?php echo get_field('image_block_preview_sostienici'); ?>" />
                </div>
            </div>
        </div>
    </div>
    <?php $isActive = get_field('visibilita_gallery');
    $images = get_field('gallery');
    if($isActive):?>
        <div class="bloc-slide py-5" style="background-image: url(<?php echo get_theme_file_uri('/images/Vector5.png'); ?>)">
            <div class="swiper">
                <div class="swiper-wrapper">
                    <?php
                    foreach ($images as $key => $image) :?>
                        <div class="swiper-slide">
                            <div class="image-container">
                                <div class="title"><span><?php echo $image['description']; ?></span></div>
                                <img class="d-block imgDocument img-fluid" src="<?php echo $image['url']; ?>">
                            </div>
                        </div>
                    <?php endforeach;?>
                </div>
              <div class="swiper-button-prev"></div>
              <div class="swiper-button-next"></div>
            </div>
        </div>
    <?php endif;
    get_template_part('template-parts/banner-prefooter'); ?>

</div>
<?php get_footer(); ?>