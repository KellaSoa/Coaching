<?php
/**
 * @var array $args
 */
?>
<h6 class="subtitle text-center mt-5">RICHIESTA D’ISCRIZONE</h6>
<h2>
    <?php if (!empty($_GET['idCourse'])) echo get_the_title($_GET['idCourse']);?>
    <?php if(!empty($args['form_double'])):?><span class="ml-2">Chi siete?</span><?php endif;?>
</h2>