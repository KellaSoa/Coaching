<?php
global $post;
$data_blocco['subtitle_bloc1'] = get_field('subtitle_bloc1');
$data_blocco['title_bloc1'] = get_field('title_bloc1');
$data_blocco['description_bloc1'] = get_field('description_bloc1');
$data_blocco['image_bloc1'] = get_field('image_bloc1');
?>
<?php
/* Template Name: contatti */
get_header();
//get_template_part('template-parts/bannerPage');
get_template_part('template-parts/button-fixed-courses');
?>
<div id="<?php echo $post->post_name;?>" class="main main-introduce pt-5">

    <div class="bloc-text-img py-5">
        <div class="container">
            <div class="row pt-5 info">
                <div class="col-12 col-md-6">
                    <?php if(!empty($data_blocco['title_bloc1'])):?>
                        <h2><?php echo $data_blocco['title_bloc1']; ?></h2>
                    <?php endif;?>
                    <?php if(!empty($data_blocco['description_bloc1'])):?>
                        <div class="py-4"><?php echo $data_blocco['description_bloc1']; ?></div>
                    <?php endif;?>

                    <div class="form-container " style="margin-top: 20px;">
                        <?php echo do_shortcode('[contact-form-7 id="1a65576" title="Form Contatti"]'); ?>
                    </div>

                </div>
                <div class="col-12 col-md-6 col-map">
                    <section id="map">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2915.2675260405094!2d12.577443076145485!3d43.056840671136705!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x132e9cfe14c7d415%3A0x8f47888fee07cd06!2sHotel%20Domus%20Pacis%20Assisi!5e0!3m2!1sit!2sit!4v1701700098965!5m2!1sit!2sit" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </section>

                    <?php if(!empty(get_field('titoletto_riferimenti_contatto'))):?>
                        <h6 class="subtitle"><?php echo get_field('titoletto_riferimenti_contatto'); ?></h6>
                    <?php endif;?>
                    <?php if(!empty(get_field('riferimenti_contatto'))):?>
                        <div class="font-title py-4"><?php echo get_field('riferimenti_contatto'); ?></div>
                    <?php endif;?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
get_footer();
