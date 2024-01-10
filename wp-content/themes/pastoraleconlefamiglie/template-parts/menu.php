<?php $slug =  get_post_field( 'post_name', get_post() );?>
<div class="collapse navbar-collapse rigthside" id="navbarNav">
    <ul class="navbar-nav ml-auto">
        <li class="nav-item <?php if($slug == 'ci-presentiamo') echo 'current-menu-item';  ?>">
            <a class="nav-link " aria-current="page" href="<?php echo site_url('/ci-presentiamo'); ?>">Ci presentiamo</a>
        </li>
        <li class="nav-item <?php if($slug == 'le-nostre-iniziative') echo 'current-menu-item';  ?>">
            <a class="nav-link " aria-current="page" href="<?php echo site_url('/le-nostre-iniziative'); ?>">Le nostre iniziative</a>
        </li>
        <li class="nav-item <?php if($slug == 'contatti') echo 'current-menu-item';  ?> ">
            <a class="nav-link " aria-current="page" href="<?php echo site_url('/contatti'); ?>">Contatti</a>
        </li>
        <li class="nav-item <?php if($slug == 'sostienici') echo 'current-menu-item';  ?>">
            <a class="nav-link btn btn-orange" aria-current="page" href="<?php echo site_url('/sostienici'); ?>">Sostienici</a>
        </li>
    </ul>
</div>