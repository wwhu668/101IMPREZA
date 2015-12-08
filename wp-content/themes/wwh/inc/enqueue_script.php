<?php 
function wwh_register_scripts() {
	wp_register_style('wwh-style', get_stylesheet_uri());
}
add_action('init', 'wwh_register_scripts');

function myAdminScripts() {
    wp_enqueue_style('thickbox');
    wp_enqueue_script('media-upload');
    wp_enqueue_script('thickbox');
    wp_enqueue_script('metabox-fields-js', get_template_directory_uri() . '/js/metabox_fields.js', array( 'jquery' ));
    // wp_enqueue_style('metabox-fields-css', get_template_directory_uri() . '/css/metabox_fields.css', array());
}
add_action('admin_enqueue_scripts', 'myAdminScripts');
function wwh_enqueue_scripts() {
    wp_enqueue_style('wwh-bootstrap-min-css', get_template_directory_uri() . '/css/bootstrap.min.css', array());
	wp_enqueue_style('wwh-style');
    wp_enqueue_script('wwh-bootstrap-min-js', get_template_directory_uri() . '/js/bootstrap.min.js', array( 'jquery' ));
    wp_enqueue_script('wwh-dotdotdot-js', get_template_directory_uri() . '/js/jquery.dotdotdot.min.js', array( 'jquery' ));
    wp_enqueue_script('wwh-custom-js', get_template_directory_uri() . '/js/custom.js', array( 'jquery' ));
}
add_action('wp_enqueue_scripts', 'wwh_enqueue_scripts');
