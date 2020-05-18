<?php

defined( 'ABSPATH' ) or die;

// Action to add menu
add_action('admin_menu', 'spg_register_how_to_use_page');

//Posts ID column
add_filter('manage_posts_columns', 'posts_columns_id', 5);
add_action('manage_posts_custom_column', 'posts_custom_id_columns', 5, 2);
add_filter('manage_pages_columns', 'posts_columns_id', 5);
add_action('manage_pages_custom_column', 'posts_custom_id_columns', 5, 2);

function posts_columns_id($defaults){
    $defaults['wps_post_id'] = __('ID');
    return $defaults;
}
function posts_custom_id_columns($column_name, $id){
    if($column_name === 'wps_post_id'){
        echo $id;
    }
}


// Category ID Column on Category Page
add_filter( 'manage_edit-category_columns', 'category_column_header' );

function category_column_header($columns) {
    $columns['header_name'] = 'ID';
    return $columns;
}

add_filter( 'manage_category_custom_column', 'category_column_content', 10, 3 );

function category_column_content($content, $column_name, $term_id){
    return $term_id;
}
/* Category ID Column on Category Page Ends */

/**
 * Register plugin 'how to use' page in admin menu
 */
function spg_register_how_to_use_page() {
    add_menu_page( __('Shuffle Post Gallery', 'shuffle-post-gallery'), __('Shuffle Post Gallery', 'shuffle-post-gallery'), 'manage_options', 'spg-about', 'spg_howitwork_page', 'dashicons-sticky', 6 );
}

/**
 * Function to get 'How It Works' HTML
 */
function spg_howitwork_page() { ?>

    <style type="text/css">
        .spg-shortcode-preview{background-color: #e7e7e7; font-weight: bold; padding: 2px 5px; display: inline-block; margin:0 0 2px 0;}
    </style>

    <div class="post-box-container">
        <div id="poststuff" >
            <div id="post-body" class="metabox-holder columns-2">

                <div id="post-body-content" >
                    <div class="metabox-holder">
                        <div class="meta-box-sortables ui-sortable">
                            <div class="postbox">

                                <h3 class="hndle">
                                    <span><?php _e( 'How It Works - Display and Shortcode', 'shuffle-post-gallery' ); ?></span>
                                </h3>

                                <div class="inside">
                                    <table class="form-table">
                                        <tbody>
                                        <tr>
                                            <th>
                                                <label><?php _e('Geeting Started with Shuffle Post Gallery', 'shuffle-post-gallery'); ?>:</label>
                                            </th>
                                            <td>
                                                <ul>
                                                    <li><?php _e('Step-1. This plugin create a menu "Shuffle Post Gallery".', 'shuffle-post-gallery'); ?></li>
                                                    <li><?php _e('Step-2. This plugin get all the latest POST from WordPress Post section with a simple shortcode', 'shuffle-post-gallery'); ?></li>
                                                </ul>
                                            </td>
                                        </tr>

                                        <tr>
                                            <th>
                                                <label><?php _e('How Shortcode Works', 'shuffle-post-gallery'); ?>:</label>
                                            </th>
                                            <td>
                                                <ul>
                                                    <li><?php _e('Step-1. Create a homepage where to display the gallery or  add the shortcode in a page.', 'shuffle-post-gallery'); ?></li>
                                                    <li><?php _e('Step-2. Put below shortcode as per your need. This plugin adds ID column for posts, pages and categories to make it easier to retrieve them.', 'shuffle-post-gallery'); ?></li>
                                                </ul>
                                            </td>
                                        </tr>

                                        <tr>
                                            <th>
                                                <label><?php _e('All Shortcodes', 'shuffle-post-gallery'); ?>:</label>
                                            </th>
                                            <td>
                                                <span class="spg-shortcode-preview">[ShuffleGallery] </span> – <?php _e('Default Shortcode. All published posts will be displayed in the gallery.', 'shuffle-post-gallery'); ?><br/>
                                                <span class="spg-shortcode-preview">[ShuffleGallery category="id1, id2 ..."] </span> – <?php _e('This shortcode will display only the posts that belong to the specified categories.', 'shuffle-post-gallery'); ?><br/>
                                                <span class="spg-shortcode-preview">[ShuffleGallery hide-post="id1, id2, ..."] </span> – <?php _e('This shortcode will EXCLUDE the specified posts from the gallery.', 'shuffle-post-gallery'); ?><br/>
                                                <span class="spg-shortcode-preview">[ShuffleGallery posts="id1, id2, ..."] </span> – <?php _e('This shortcode will display ONLY the specified posts.', 'shuffle-post-gallery'); ?><br/>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div><!-- .inside -->
                            </div><!-- #general -->
                        </div><!-- .meta-box-sortables ui-sortable -->
                    </div><!-- .metabox-holder -->
                </div><!-- #post-body-content -->

            </div><!-- #post-body -->
        </div><!-- #poststuff -->
    </div><!-- #post-box-container -->
<?php }