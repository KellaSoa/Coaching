<?php
/* Template Name: payment */
get_header();
//Get template page
if(isset($_GET['orderID'])) {
    $donation = Donation::Instance()->getDonation($_GET['orderID']);
    $success = NexiHPP::Instance()->checkOrderStatus($_GET['orderID']);
    Donation::Instance()->statusPaymentTemplate($success, $_GET['orderID'], $donation[0]->donation);
    get_template_part('template-parts/banner-prefooter.php');
} else {
    wp_safe_redirect(site_url('sostienici'));
}
get_footer();