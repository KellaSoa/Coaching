<?php
/* Template Name: initiative */
$terms_param = [
    'taxonomy' => 'type-course',
    'hide_empty' => 0,
    'orderby' => 'id',
    'order' => 'ASC',
];
$types = get_terms($terms_param);
?>

<?php get_header(); ?>

<div class="banner-page pt-5 pb-5" style="background-image: url(<?php the_field('image_header'); ?>)">
    <div class="container">
        <div class="row py-5">
            <div class="col-12 col-md-8 col-xl-6 content">
                <h1><?php the_field('title_header'); ?></h1>
                <p class="mt-5">
                    <?php the_field('description_header'); ?>
                </p>
            </div>
            <div class="clear"> </div>

            <div class="col-12 col-md-12 col-xl-6 group-btn">
                <?php foreach ($types as $type) { ?>
                <a href="#<?php echo $type->slug; ?>" class="btn btn-white"><?php echo $type->name; ?></a>
                <?php }?>
            </div>
        </div>
    </div>
</div>

<div class="main">
    <div class="bloc1 initiative">
        <div class="container">
            <?php

            foreach ($types as $type) {
                $slug = strtoupper($type->slug);
                $args_corsi = [
                    'post_type' => 'course',
                    'orderby' => 'ID, menu_order',
                    'order' => 'ASC',
                    'tax_query' => [
                        [
                            'taxonomy' => 'type-course',
                            'field' => 'slug',
                            'terms' => $type->slug,
                        ],

                    ],
                ];

                $loop = new WP_Query($args_corsi);

                if ($loop->have_posts()) {
                    $data_blocco = [];
                    $data_blocco['subtitle_bloc1'] = get_field('subtitle_bloc1', $type);
                    $data_blocco['title_bloc1'] = get_field('title_bloc1', $type);
                    $data_blocco['description_bloc1'] = get_field('description_bloc1', $type);
                    $data_blocco['image_bloc1'] = get_field('image_bloc1', $type);
                    ?>
                    <div id="<?php echo $type->slug; ?>" class="parent pt-5">

                        <?php get_template_part('template-parts/blocco-2col-text-img', null, ['data_blocco' => $data_blocco]);?>
                        <?php
                        // All courses by slug taxonomy
                        while ($loop->have_posts()) {
                            $loop->the_post();
                            $idCourse = get_the_ID();
                            $nameCourse = get_the_title();
                            $slug = get_post_field('post_name', $idCourse);
                            $typeCourse = $type->slug;
                            $parent_id = wp_get_post_parent_id($idCourse); // get id parent post_type
                            $args = [
                                'typeSlug' => $type->slug,
                                'nameCourse' => $nameCourse,
                                'idCourse' => $idCourse,
                                'slug' => $slug,
                                'idTypeCourse' => $type->term_id,
                                'typeCourse' => $typeCourse];
                            // template when child have children
                            if ($parent_id) { ?>
                                <div id="<?php echo $slug;?>" class="childPanel idParent-<?php echo $parent_id; ?> hasParentPost" data-idparentpost ="<?php echo $parent_id; ?>"  data-idposttype="<?php echo $idCourse; ?>">
                                    <?php get_template_part('template-parts/childPanel', null, $args); ?>
                                </div>
                            <?php } else { ?>
                                <div id="<?php echo $slug;?>" class="childPanel" data-idposttype="<?php echo $idCourse; ?>">
                                    <?php get_template_part('template-parts/childPanel', null, $args); ?>
                                </div>
                            <?php } ?>


                        <?php }
                        wp_reset_query();
                        ?>
                    </div>
                <?php }
                }   ?>
        </div>
    </div>
</div>
<?php
get_footer();
