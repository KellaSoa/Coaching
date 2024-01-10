<?php
$tariffe_corso = get_field('testo_tariffe_corso', $_GET['idCourse']);
if(!empty($tariffe_corso)):
?>
<div class="row mb-5 ">
    <div class="col-sm-12">
        <?php echo $tariffe_corso;?>
    </div>
</div>
<?php endif;?>