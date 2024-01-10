 <footer class="py-5">
    <div class="container">

        <div class="row align-items-center justify-content-center">
            <div class="col-sm-12 col-lg-5">
                <img src="<?php echo get_theme_file_uri('/images/logo-pastorale-con-le-famiglie-w.png'); ?>" alt="" />
                <img src="<?php echo get_theme_file_uri('/images/logo-evengelizzazione-farti-minori-white.png'); ?>" alt="" />

            </div>
            <div class="col-sm-12 col-lg-7">
                <div class="menu py-3">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link " aria-current="page" href="<?php echo site_url('/ci-presentiamo'); ?>">Ci presentiamo</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " aria-current="page" href="<?php echo site_url('/le-nostre-iniziative'); ?>">Le nostre iniziative</a>
                        </li>
                        <li class="nav-item  ">
                            <a class="nav-link " aria-current="page" href="<?php echo site_url('/contatti'); ?>">Contatti</a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link" aria-current="page" href="<?php echo site_url('/sostienici'); ?>">Sostienici</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>


        <hr>
        <div class="row privacy">
            <div class="col-sm-12">
                <ul>
                    <li><a href="https://www.a-piu.it/" target="_blank">Credits A+ | 2023</a></li>
                    <li><a href="">Cookies</a></li>
                    <li><a href="<?php echo site_url("privacy-policy");?>" target="_blank">Privacy policy</a></li>
                </ul>
            </div>
        </div>
    </div>
</footer>
<?php wp_footer(); ?>
    </body>
</html>