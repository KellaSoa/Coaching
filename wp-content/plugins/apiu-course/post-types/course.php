<?php

/**
 * Registers the `course` post type.
 */
function course_init()
{
    register_post_type(
        'course',
        [
            'labels' => [
                'name' => __('Corsi', 'apiu-course'),
                'singular_name' => __('Corso', 'apiu-course'),
                'all_items' => __('Tutti i Corsi', 'apiu-course'),
                'archives' => __('Corso Archives', 'apiu-course'),
                'attributes' => __('Corso Attributes', 'apiu-course'),
                'insert_into_item' => __('Insert into course', 'apiu-course'),
                'uploaded_to_this_item' => __('Uploaded to this course', 'apiu-course'),
                'featured_image' => _x('Featured Image', 'course', 'apiu-course'),
                'set_featured_image' => _x('Set featured image', 'course', 'apiu-course'),
                'remove_featured_image' => _x('Remove featured image', 'course', 'apiu-course'),
                'use_featured_image' => _x('Use as featured image', 'course', 'apiu-course'),
                'filter_items_list' => __('Filter Corsi list', 'apiu-course'),
                'items_list_navigation' => __('Corsi list navigation', 'apiu-course'),
                'items_list' => __('Corsi list', 'apiu-course'),
                'new_item' => __('Nuovo Corso', 'apiu-course'),
                'add_new' => __('Aggiungi nuovo', 'apiu-course'),
                'add_new_item' => __('Add New Course', 'apiu-course'),
                'edit_item' => __('Modifica Corso', 'apiu-course'),
                'view_item' => __('Vedi Corso', 'apiu-course'),
                'view_items' => __('Vedi Corsi', 'apiu-course'),
                'search_items' => __('Cerca Corsi', 'apiu-course'),
                'not_found' => __('No Corsi found', 'apiu-course'),
                'not_found_in_trash' => __('No Corsi found in trash', 'apiu-course'),
                'parent_item_colon' => __('Parent Course:', 'apiu-course'),
                'menu_name' => __('Corsi', 'apiu-course'),
            ],
            'public' => true,
            'hierarchical' => true,
            'show_ui' => true,
            'show_in_nav_menus' => true,
            'supports' => ['title', 'editor', 'page-attributes'],
            'has_archive' => true,
            'rewrite' => true,
            'query_var' => true,
            'menu_position' => null,
            'menu_icon' => 'dashicons-book',
            'show_in_rest' => true,
            'rest_base' => 'course',
            'rest_controller_class' => 'WP_REST_Posts_Controller',
        ]
    );
}

add_action('init', 'course_init');

/**
 * Sets the post updated messages for the `course` post type.
 *
 * @param array $messages post updated messages
 *
 * @return array messages for the `course` post type
 */
function course_updated_messages($messages)
{
    global $post;

    $permalink = get_permalink($post);

    $messages['course'] = [
        0 => '', // Unused. Messages start at index 1.
        /* translators: %s: post permalink */
        1 => sprintf(__('Course updated. <a target="_blank" href="%s">View course</a>', 'apiu-course'), esc_url($permalink)),
        2 => __('Custom field updated.', 'apiu-course'),
        3 => __('Custom field deleted.', 'apiu-course'),
        4 => __('Course updated.', 'apiu-course'),
        /* translators: %s: date and time of the revision */
        5 => isset($_GET['revision']) ? sprintf(__('Course restored to revision from %s', 'apiu-course'), wp_post_revision_title((int) $_GET['revision'], false)) : false, // phpcs:ignore WordPress.Security.NonceVerification.Recommended
        /* translators: %s: post permalink */
        6 => sprintf(__('Course published. <a href="%s">View course</a>', 'apiu-course'), esc_url($permalink)),
        7 => __('Course saved.', 'apiu-course'),
        /* translators: %s: post permalink */
        8 => sprintf(__('Course submitted. <a target="_blank" href="%s">Preview course</a>', 'apiu-course'), esc_url(add_query_arg('preview', 'true', $permalink))),
        /* translators: 1: Publish box date format, see https://secure.php.net/date 2: Post permalink */
        9 => sprintf(__('Course scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview course</a>', 'apiu-course'), date_i18n(__('M j, Y @ G:i', 'apiu-course'), strtotime($post->post_date)), esc_url($permalink)),
        /* translators: %s: post permalink */
        10 => sprintf(__('Course draft updated. <a target="_blank" href="%s">Preview course</a>', 'apiu-course'), esc_url(add_query_arg('preview', 'true', $permalink))),
    ];

    return $messages;
}

add_filter('post_updated_messages', 'course_updated_messages');

/**
 * Sets the bulk post updated messages for the `course` post type.
 *
 * @param array $bulk_messages Arrays of messages, each keyed by the corresponding post type. Messages are
 *                             keyed with 'updated', 'locked', 'deleted', 'trashed', and 'untrashed'.
 * @param int[] $bulk_counts   array of item counts for each message, used to build internationalized strings
 *
 * @return array bulk messages for the `course` post type
 */
function course_bulk_updated_messages($bulk_messages, $bulk_counts)
{
    global $post;

    $bulk_messages['course'] = [
        /* translators: %s: Number of Corsi. */
        'updated' => _n('%s course updated.', '%s Corsi updated.', $bulk_counts['updated'], 'apiu-course'),
        'locked' => (1 === $bulk_counts['locked']) ? __('1 course not updated, somebody is editing it.', 'apiu-course') :
                        /* translators: %s: Number of Corsi. */
                        _n('%s course not updated, somebody is editing it.', '%s Corsi not updated, somebody is editing them.', $bulk_counts['locked'], 'apiu-course'),
        /* translators: %s: Number of Corsi. */
        'deleted' => _n('%s course permanently deleted.', '%s Corsi permanently deleted.', $bulk_counts['deleted'], 'apiu-course'),
        /* translators: %s: Number of Corsi. */
        'trashed' => _n('%s course moved to the Trash.', '%s Corsi moved to the Trash.', $bulk_counts['trashed'], 'apiu-course'),
        /* translators: %s: Number of Corsi. */
        'untrashed' => _n('%s course restored from the Trash.', '%s Corsi restored from the Trash.', $bulk_counts['untrashed'], 'apiu-course'),
    ];

    return $bulk_messages;
}

add_filter('bulk_post_updated_messages', 'course_bulk_updated_messages', 10, 2);
