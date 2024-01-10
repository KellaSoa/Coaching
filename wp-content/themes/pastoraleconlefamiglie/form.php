<?php /* Template Name: form course */
get_header();
?>
<div class="main main-form">
    <div class="container inscription ">

        <form class="py-5" method="post" id="form-inscription" data-url="<?php echo admin_url('admin-ajax.php'); ?>" onsubmit="return validateForm()">
            <input type="hidden" name="action" value="add_inscription_user">
            <input type="hidden" name="idCourse" value="<?php echo sanitize_text_field($_GET['idCourse']); ?>">
            <input type="hidden" name="idTypeCourse" value="<?php echo sanitize_text_field($_GET['idTypeCourse']); ?>">
            <input type="hidden" name="dateCourse" value="<?php echo sanitize_text_field($_GET['dateCourse']); ?>">
            <?php
            if($_GET['idTypeCourse'] == 4) get_template_part("template-parts/form-coppie-fidanzati");
            else if ($_GET['idTypeCourse'] == 5) get_template_part("template-parts/form-coppie-sposi");
            else get_template_part("template-parts/form-altre-iniziative");
            ?>
            <p class="error-send error"></p>
        </form>
    </div>
</div>
<?php
get_footer();
