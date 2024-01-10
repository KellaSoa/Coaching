<?php
/**
 * @var array $args
 */
$typeSlug = $args['typeSlug'];
$nameCourse = $args['nameCourse'];
$idCourse = $args['idCourse'];
$slug = $args['slug'];
$typeCourse = $args['typeCourse'];
$idTypeCourse = $args['idTypeCourse'];

$current_post_type = get_post_type($idCourse);

$post_type_object = get_post_type_object($current_post_type);
$child_posts = false;
if ($post_type_object && $post_type_object->hierarchical) {
    // The post type is hierarchical, it can have child posts
    $current_post_id = $idCourse;
    // Check if there are child posts
    $args = [
        'post_type' => $current_post_type,
        'post_parent' => $current_post_id,
        'posts_per_page' => -1, // Get all child posts
    ];
    $child_posts = get_posts($args);
}
$descrizione = get_field('descrizione', $idCourse);

$informativa_preview = get_field("info_preview", $idCourse);
$informativa = get_field("info", $idCourse);
$faqs= get_field('faq', $idCourse);
$bibliografia = get_field('bibliografia', $idCourse);
$urlGeneratepdf = site_url('generatepdf?idCourse='.$idCourse);
?>

 <div class="child <?php echo $typeSlug; ?> mt-3">
    <div class="row mt-3"><span class="title text-left mt-3 mb-3"><?php echo $nameCourse; ?></span></div>

    <div class="row mt-3 details <?php echo $typeSlug; ?>">
        <div class="col-sm-12 col-md-4 col-lg-4 image">
            <img src="<?php echo get_field('image', $idCourse); ?>" alt="" class="imgInfo">
            <?php if ($child_posts) :?>
            <a class="openChildPostType text-center mt-3" data-idposttype="<?php echo $idCourse; ?>">
                Altre tappe
                <?php $scriptUriShow = get_theme_file_uri('/images/altreShow.png'); ?>
                <img class="ms-2 " src="<?php echo get_theme_file_uri('/images/altreHide.png'); ?>" alt=""/>
            </a>
            <?php endif; ?>
        </div>
        <div class="col-sm-12 col-md-8 col-lg-5 cnt-description">
            <?php if(!empty($descrizione)):?>
            <h6 class="subtitle">Descrizione</h6>
            <div>
                <?php if(strlen(strip_tags($descrizione))>200): ?>
                <?php echo substr(strip_tags($descrizione), 0, 200).'...'; ?>
                <br>
                <a class="open-panel" data-target="#description-<?php echo $slug; ?>">
                    Leggi altro
                </a>
                <?php else:?>
                <?php echo $descrizione; ?>
                <?php endif;?>
            </div>
            <?php endif;?>
            <div class="row dates">
                <div class="col dateDetail">
                    <?php
                    setlocale(LC_TIME, 'ita', 'it_IT.utf8');
                    // get all dates of courses
                    $dates = get_field('dates', $idCourse);
                    if (!empty($dates)) {
                        foreach ($dates as $key => $date) {
                            if($date['start']==$date['end']){
                                $date_end = utf8_encode(ucwords(strftime("%d %B %Y", strtotime($date['end']))));
                                $strDate = $date_end;
                            }
                            else{
                                $date_start = strftime("%d", strtotime($date['start']));
                                $monthStart = strftime("%B", strtotime($date['start']));
                                $monthEnd   = strftime("%B", strtotime($date['end']));
                                if($monthStart != $monthEnd)
                                    $date_start = strftime("%d %B", strtotime($date['start']));
                                $date_end = utf8_encode(ucwords(strftime("%d %B %Y", strtotime($date['end']))));
                                $strDate = $date_start.'-'.$date_end;
                            }
                            if ($key == 0) {
                                $data_iscrizione_aperta = $strDate;
                                ?>
                                <span class="firstCourse"><?php echo $strDate; ?></span>
                            <?php } else { ?>
                                <span class="date-tooltip" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Iscrizioni non aperte">
                                    <?php echo $strDate; ?>
                                </span>
                            <?php }
                        }
                    }?>
                </div>
                <div class="col request">
                    <?php if(!empty($dates)):?>
                        <form class="paramFormCourse" method="post" action="<?php echo esc_url(site_url('/form')); ?>">
                            <input type="hidden" name="idCourse" value="<?php echo $idCourse; ?>">
                            <input type="hidden" name="typeCourse" value="<?php echo $typeCourse; ?>">
                            <input type="hidden" name="idTypeCourse" value="<?php echo $idTypeCourse; ?>">
                            <input type="hidden" name="dateCourse" value="<?php echo $data_iscrizione_aperta; ?>">
                        </form>
                        <a href="#" class="sendRequest" data-form="paramFormCourse">INVIA RICHIESTA D’ISCRIZIONE</a>
                    <?php endif;?>
                    <div>
                        <a href="<?php echo site_url("/contatti");?>" class="infoRequest">Richiedi info</a>
                    </div>
                </div>
            </div>
        </div>
        <?php if(!empty($informativa) || !empty($faqs) || !empty($bibliografia)): ?>
        <div class="col-sm-12 col-lg-3 other-info">

            <div class="row">
                <?php if(!empty($informativa)):?>
                <div class="col-6 col-md-3 col-lg-12 py-2 open-panel" data-target="#informativa-<?php echo $slug ?>">
                    <img src="<?php echo esc_url(get_template_directory_uri().'/images/'.$typeSlug.'/info.png'); ?>" alt="Informativa">
                    <span>Informativa</span>
                </div>
                <?php endif;?>
                <?php if(!empty($faqs)):?>
                <div class="col-6 col-md-3 col-lg-12 py-2  open-panel" data-target="#faq-<?php echo $slug ?>">
                    <img src="<?php echo esc_url(get_template_directory_uri().'/images/'.$typeSlug.'/faq.png'); ?>" alt="FAQ">
                    <span>FAQ</span>
                </div>
                <?php endif;?>
                <?php if(!empty($bibliografia)):?>
                <div class="col-6 col-md-3 col-lg-12 py-2 open-panel" data-target="#biblio-<?php echo $slug ?>">
                    <img src="<?php echo esc_url(get_template_directory_uri().'/images/'.$typeSlug.'/biblio.png'); ?>" alt="Bibliografia">
                    <span>Bibliografia</span>
                </div>
                <?php endif;?>
                <?php /*
                <div class="col-6 col-md-3 col-lg-12 py-2 open-panel" data-target="#testimo-<?php echo $slug ?>">
                    <img src="<?php echo esc_url(get_template_directory_uri().'/images/'.$typeSlug.'/testimo.png'); ?>" alt="Testimonianze">
                    <span>Testimonianze</span>
                </div>
                */?>
            </div>
        </div>
        <?php endif;?>
    </div>
</div>

<?php if(!empty($informativa) || !empty($faqs) || !empty($bibliografia)): ?>
<div class="panel <?php echo $typeCourse; ?>" >
    <div class="card card-body collapseSelected ">
        <div class="panel-target" id="description-<?php echo $slug?>">
            <div class="mt-3">
                <h6 class="subtitle">Descrizione</h6>
                <p><?php echo $descrizione; ?></p>
            </div>
        </div>
        <?php if(!empty($informativa)):?>
        <div class="panel-target" id="informativa-<?php echo $slug; ?>">
            <div class="mt-3 informativa">
                <h6 class="subtitle">Informativa</h6>
                <?php if(!empty($informativa_preview)):?>
                <div><?php echo $informativa_preview; ?></div>
                <?php else: ?>
                <div><?php echo substr(strip_tags($informativa), 0, 1000)."... "; ?></div>
                <?php endif;?>

                <div class="generatePDF py-5 text-center">
                    <a href="<?php echo $urlGeneratepdf; ?>"  target="_blank" class="btn btn-redBgWhite generatePDF" data-url="<?php echo admin_url('admin-ajax.php'); ?>">Scarica PDF Informativa</a>
                </div>
            </div>
        </div>
        <?php endif;?>

        <?php if(!empty($faqs)):?>
        <div class="panel-target" id="faq-<?php echo $slug; ?>">
            <div class="mt-3 faq">
                <h6 class="subtitle">FAQ</h6>
                <div id="accordion-<?php echo $slug; ?>" class="accordion">
                    <?php
                    if($faqs):
                        foreach ($faqs as $key =>$faq): ?>
                            <div class="accordion-cnt mt-2">
                                <div class="accordion-header">
                                    <a class="btn-accordion collapsed" data-bs-toggle="collapse" href="#collapse-<?php echo $key; ?>">
                                        <?php echo $faq['domanda']; ?>
                                    </a>
                                </div>
                                <div id="collapse-<?php echo $key; ?>" class="collapse" data-bs-parent="#accordion-<?php echo $slug; ?>">
                                    <div class="accordion-body">
                                        <?php echo $faq['risposta'];?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach;
                    endif;?>
                </div>
            </div>
        </div>
        <?php endif;?>
        <?php if(!empty($bibliografia)):?>
        <div class="panel-target" id="biblio-<?php echo $slug; ?>">
            <div class="mt-3 biblio">
                <h6 class="subtitle">Bibliografia</h6>
                <p><?php echo $bibliografia; ?></p>
            </div>
        </div>
        <?php endif;?>
        <?php //get_template_part("template-parts/panel-testimonianze");?>
    </div>
</div>
<?php endif;?>