<?php
/**
 * @var array $args
 */

$typeCourse = $args['typeCourse'];

$informativa = get_field("info", $_GET['idCourse']);
$informativa_preview = get_field("info_preview", $_GET['idCourse']);
$urlGeneratepdf = site_url('generatepdf?idCourse='.$_GET['idCourse']);
?>

<div class="form-container">
    <div class="row">
        <div class="col-sm-12 col-md-10 mx-auto">
            <h4 class="title-form">Informativa del corso</h4>
            <?php if(!empty($informativa_preview)):?>
            <div><?php echo $informativa_preview; ?></div>
            <?php else: ?>
            <div class="mb-5"><?php echo substr(strip_tags($informativa), 0, 1000)."... "; ?></div>
            <?php endif;?>

            <?php if(!empty($informativa)):?>
            <div class="FormGeneratePDF mt-5 text-center">
                <a href="<?php echo $urlGeneratepdf; ?>" target="_blank" class="btn btn-redBgWhite generatePDF" data-url="<?php echo admin_url('admin-ajax.php'); ?>">Scarica PDF Informativa</a>
            </div>
            <?php endif;?>
        </div>
    </div>
    <div class="row mt-5 mb-5">
        <div class="col-sm-12 mt-5 readInfoCourse">
            <div class="toggle-container text-center isReadInfoCourse">
                <input type="checkbox" id="isReadInfoCourse" name="isReadInfoCourse" value="1" required /><label for="isReadInfoCourse">Toggle</label>
            </div>
            <label for="isReadInfoCourse">Ho letto l'informativa del corso</label>
        </div>
        <div class="error-message text-center fw-bold" id="error-message"></div>
    </div>
    <div class="row">
        <div class="col-sm-12 text-center">
            <a class="btn btn-next btnNext" href="#myCarousel" role="button" data-slide="next">AVANTI</a>
        </div>
    </div>
</div>