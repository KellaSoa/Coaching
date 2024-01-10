<?php
global $post;

$team = get_field("team");

/* Template Name: introduce */
get_header();
get_template_part('template-parts/bannerPage');
get_template_part('template-parts/button-fixed-courses');
?>
<div id="<?php echo $post->post_name;?>" class="main main-introduce pt-5">
    <?php get_template_part('template-parts/blocco-2col-text-img');?>

    <div class="bloc-card card-team py-5 mb-5">
        <div class="container">
            <div class="row">
                <?php foreach ($team as $k => $v) : ?>

                    <div class="col-12 col-sm-6 col-md-4">
                        <div class="card border-primary">
                            <div class="body" style="background-image: url('<?php echo $v['image_team']; ?>');">
                            </div>
                            <div class="footer row">
                                <?php if(!empty($v['biografia_team'])):?>
                                <div class="col-4">
                                    <a data-toggle="collapse" href="#bio-<?php echo $k;?>" role="button" aria-expanded="false" aria-controls="bio-<?php echo $k;?>">
                                        <img src="<?php echo get_theme_file_uri('/images/iconGroup.png'); ?>" alt="">
                                    </a>
                                </div>
                                <?php endif; ?>
                                <?php if(!empty($v['facebook_team']) || !empty($v['instagram_team'])):?>
                                <div class="col-4">
                                    <a data-toggle="collapse" href="#social-<?php echo $k;?>" role="button" aria-expanded="false" aria-controls="social-<?php echo $k;?>">
                                        <img src="<?php echo get_theme_file_uri('/images/iconShare.png'); ?>" alt="">
                                    </a>
                                </div>
                                <?php endif; ?>
                                <?php if(!empty($v['email_team'])):?>
                                <div class="col-4">
                                    <a data-toggle="collapse" data-target="#email-<?php echo $k; ?>" aria-expanded="false" aria-controls="email-<?php echo $k; ?>">
                                        <img src="<?php echo get_theme_file_uri('/images/iconMessage.png'); ?>" alt="">
                                    </a>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div id="team-<?php echo $k?>" class="row-collapse" >
                            <div class="collapse" id="bio-<?php echo $k?>" data-parent="#team-<?php echo $k;?>">
                                <label class="fw-bold">BIOGRAFIA</label>
                                <?php echo $v['biografia_team'];?>
                            </div>

                            <div class="collapse" id="social-<?php echo $k?>" data-parent="#team-<?php echo $k;?>">
                                <div class="row align-items-center justify-content-center">
                                    <?php if(!empty($v['facebook_team'])):?>
                                    <div class="col text-center">
                                        <a href="<?php echo $v['facebook_team'];?>" target="_blank">
                                            <img src="<?php echo get_theme_file_uri('/images/icon-facebook.svg'); ?>" alt="">
                                        </a>
                                    </div>
                                    <?php endif; ?>

                                    <?php if(!empty($v['instagram_team'])):?>
                                        <div class="col  text-center">
                                            <a href="<?php echo $v['instagram_team'];?>" target="_blank">
                                                <img src="<?php echo get_theme_file_uri('/images/icon-instagram.svg'); ?>" alt="">
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                </div>


                            </div>

                            <div class="collapse text-center" id="email-<?php echo $k; ?>" data-parent="#team-<?php echo $k;?>">
                                <a href="mailto:<?php echo $v['email_team'];?>" target="_blank" class="btn btn-white">Contattami</a>
                            </div>
                        </div>

                    </div>
                <?php endforeach;?>
            </div>
        </div>
    </div>

    <?php get_template_part('template-parts/banner-prefooter'); ?>
</div>

<?php
get_footer();