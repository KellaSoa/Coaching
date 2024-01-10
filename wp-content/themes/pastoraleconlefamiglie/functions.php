<?php

require_once __DIR__.'/includes/Inscription.php';
require_once __DIR__.'/classes/InscriptionsTable.php';
require_once __DIR__.'/classes/UserInscription.php';
require_once __DIR__.'/classes/Donation.php';
require_once __DIR__.'/classes/DonationsTable.php';
require_once __DIR__.'/classes/NexiHPP.php';
require_once __DIR__ . '/classes/Pdf.php';
require_once __DIR__.'/classes/Mail.php';

const VERSION = 4.0;

add_action('wp_enqueue_scripts', 'wpdocs_theme_name_scripts');
function wpdocs_theme_name_scripts()
{
    wp_enqueue_style('montserrat-font', 'https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');
    wp_enqueue_style('noto-serif-font', 'https://fonts.googleapis.com/css2?family=Noto+Serif:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');
    wp_enqueue_style('dancing-script-font', 'https://fonts.googleapis.com/css2?family=Dancing+Script&display=swap');
    wp_enqueue_style('allison-font', 'https://fonts.googleapis.com/css2?family=Allison&display=swap" rel="stylesheet');

    wp_enqueue_style('bootstrap-css', 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css');
    wp_enqueue_style('bootstrap-carousel-css', 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap-modal-carousel.css');
    wp_enqueue_style('swiper-css', 'https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css');

    wp_enqueue_style('style', get_stylesheet_uri());
    wp_enqueue_style('jquery-ui-css', 'https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css');

    wp_enqueue_style('pastorale-style', get_stylesheet_directory_uri().'/css/styles.css', [], VERSION);


    wp_enqueue_script('swiper-js', 'https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js');
    wp_enqueue_script('slim-js', 'https://code.jquery.com/jquery-3.5.1.slim.min.js');
    wp_enqueue_script('bootstrap-js', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js');
    wp_enqueue_script('popper-js', 'https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.3/dist/umd/popper.min.js');
    wp_enqueue_script('bootstrap-min-js', 'https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js');
    wp_enqueue_script('jquery-js', 'https://code.jquery.com/jquery-3.6.0.min.js');
    wp_enqueue_script('bootstrap-modal-carousel', get_theme_file_uri('/js/bootstrap-modal.js'), ['jquery'], false, true);
    wp_enqueue_script('jquery-ui', 'https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js');

    wp_enqueue_script('custom', get_stylesheet_directory_uri().'/js/script.js', ['jquery'], VERSION, true);
}

// remove editor post_type
add_action('init', 'my_remove_editor_from_post_type');
function my_remove_editor_from_post_type()
{
    remove_post_type_support('page', 'editor');
    remove_post_type_support('course', 'editor');
}

// Add Bootstrap in Backend wp
function enqueue_bootstrap_admin()
{
    wp_enqueue_style('bootstrap-css-admin', 'https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css');
    wp_enqueue_style('pastorale-style-admin', get_stylesheet_directory_uri().'/css/admin-styles.css', [], VERSION);
    wp_enqueue_script('custom-js-admin', get_stylesheet_directory_uri().'/js/scriptEditStatus.js',
        ['jquery'], false, true);
}
add_action('admin_enqueue_scripts', 'enqueue_bootstrap_admin');



// Enqueue custom script and pass proxy URL to it
function enqueue_custom_script_with_proxy_info() {

    // Pass proxy URL to the script
    wp_localize_script('custom', 'proxyInfo', array(
        'proxyUrl' => admin_url('admin-ajax.php?action=nexi_hpp'),
    ));
}
add_action('wp_enqueue_scripts', 'enqueue_custom_script_with_proxy_info');

add_filter('manage_flamingo_inbound_posts_columns', 'my_custom_filter_flamingo_inbound_message_table_column_order');
add_filter('manage_flamingo_inbound_posts_columns', 'my_custom_filter_flamingo_inbound_message_table_columns', 10, 1);
add_action('manage_flamingo_inbound_posts_custom_column', 'my_custom_filter_flamingo_action_inbound_message_table_column_value', 10, 2);
// Order columns
function my_custom_filter_flamingo_inbound_message_table_column_order($columns) {
    $n_columns = array();
    $before = 'from'; // move before this

    foreach($columns as $key => $value) {
        if ($key==$before){
            $n_columns['company'] = '';
            $n_columns['recapito'] = '';
            $n_columns['your-email'] = '';
            $n_columns['tel'] = '';
            $n_columns['your-message'] = '';
            $n_columns['date'] = '';
        }
        $n_columns[$key] = $value;
    }
    return $n_columns;
}

//Manage column remove & add new
function my_custom_filter_flamingo_inbound_message_table_columns($columns){
    unset($columns['from']);
    unset($columns['subject']);
    unset($columns['channel']);
    $columns['company'] = 'Company';
    $columns['recapito'] = 'Recapito di riferimento';
    $columns['your-email'] = 'Indirizzo e-mail';
    $columns['tel'] = 'Telefono';
    $columns['your-message'] = 'Messaggio';
    return $columns;
}

//Print column values
function my_custom_filter_flamingo_action_inbound_message_table_column_value($column, $entry_id){

    if ( empty($column) || empty($entry_id) ) {
        return;
    }

    switch($column) {
        case 'tel':
            echo esc_html(get_post_meta($entry_id, '_field_tel', true));
            break;

        case 'company':
            echo esc_html(get_post_meta($entry_id, '_field_company', true));
            break;

        case 'your-email':
            echo esc_html(get_post_meta($entry_id, '_field_your-email', true));
            break;

        case 'your-message':
            echo esc_html(get_post_meta($entry_id, '_field_your-message', true));
            break;

        case 'recapito':
            echo esc_html(get_post_meta($entry_id, '_field_your-name', true).' '.get_post_meta($entry_id, '_field_your-last-name', true));
            break;

    }

}

function is_production(){
    if (defined('ENVIRONMENT') && ENVIRONMENT === 'development') {
        return false;
    }
    return true;
}