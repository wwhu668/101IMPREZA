<?php

/**
 * wwh_register_nav 注册导航
 * 
 * @access public
 * @return void
 */
function wwh_register_nav() {
    register_nav_menus(
        array(
            'primary'   => __( '主导航', 'wwh' ),
            'secondary' => __( '副导航', 'wwh' )
        )
    );
}
add_action( 'init', 'wwh_register_nav' );


/**
 * wwh_setup 设置 WordPress 支持各种功能
 * 
 * @access public
 * @return void
 */
function wwh_setup() {
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'custom-background' );
    add_theme_support( 'title-tag' );
}
add_action( 'after_setup_theme', 'wwh_setup' );

// 禁用自动保存，所以编辑长文章前请注意手动保存。
add_action( 'admin_print_scripts', create_function( '$a', "wp_deregister_script('autosave');" ) ); 

// 文章编辑页删除相关模块
function customize_meta_boxes() {
     // 删除以下两个模块categorydiv、tagsdiv-post_tag
     remove_meta_box('postexcerpt','post','normal');
     remove_meta_box('trackbacksdiv','post','normal');
     remove_meta_box('commentstatusdiv','post','normal');
     remove_meta_box('commentsdiv','post','normal');
     remove_meta_box('revisionsdiv','post','normal'); 
}
add_action('admin_init','customize_meta_boxes');

/**
 * WordPress 后台禁用Google Open Sans字体，加速网站
 * http://www.wpdaxue.com/disable-google-fonts.html
 */
function wpdx_disable_open_sans( $translations, $text, $context, $domain ) {
  if ( 'Open Sans font: on or off' == $context && 'on' == $text ) {
    $translations = 'off';
  }
  return $translations;
}
add_filter( 'gettext_with_context', 'wpdx_disable_open_sans', 888, 4 ); 

// 禁用页面的评论功能
function disable_page_comments( $posts ) {
    if ( is_page()) {
    $posts[0]->comment_status = 'disabled';
    $posts[0]->ping_status = 'disabled';
}
return $posts;
} 
add_filter( 'the_posts', 'disable_page_comments' ); 

// 去除登陆错误时出现标准错误信息
add_filter('login_errors', create_function('$a', "return 用户名或密码错误;"));

// 同时删除head和feed中的WP版本号
function ludou_remove_wp_version() {
  return '';
}
add_filter('the_generator', 'ludou_remove_wp_version');
// 隐藏js/css附加的WP版本号
function ludou_remove_wp_version_strings( $src ) {
  global $wp_version;
  parse_str(parse_url($src, PHP_URL_QUERY), $query);
  if ( !empty($query['ver']) && $query['ver'] === $wp_version ) {
    // 用WP版本号 + 12.8来替代js/css附加的版本号
    // 既隐藏了WordPress版本号，也不会影响缓存
    // 建议把下面的 12.8 替换成其他数字，以免被别人猜出
    $src = str_replace($wp_version, $wp_version + 111, $src);
  }
  return $src;
}
add_filter( 'script_loader_src', 'ludou_remove_wp_version_strings' );
add_filter( 'style_loader_src', 'ludou_remove_wp_version_strings' ); 

// 禁用修订版本
function specs_wp_revisions_to_keep( $num, $post ) {
   if ( 'post_type' == $post->post_type )
      $num = 0;
   return $num;
}
add_filter( 'wp_revisions_to_keep', 'specs_wp_revisions_to_keep', 10, 2 ); 

remove_action( 'wp_head', 'feed_links_extra', 3 ); //去除评论feed
remove_action( 'wp_head', 'feed_links', 2 ); //去除文章feed
remove_action( 'wp_head', 'rsd_link' ); //针对Blog的远程离线编辑器接口
remove_action( 'wp_head', 'wlwmanifest_link' ); //Windows Live Writer接口
remove_action( 'wp_head', 'index_rel_link' ); //移除当前页面的索引
remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 ); //移除后面文章的url
remove_action( 'wp_head', 'start_post_rel_link', 10, 0 ); //移除最开始文章的url
remove_action( 'wp_head', 'wp_shortlink_wp_head', 10, 0 );//自动生成的短链接
remove_action( 'wp_head', 'adjacent_posts_rel_link', 10, 0 ); ///移除相邻文章的url
remove_action( 'wp_head', 'wp_generator' ); // 移除版本号 */

/* 去掉文章里的图片链接 */
update_option('image_default_link_type', 'none');

// remove_filter('the_content', 'wptexturize'); // 取消内容转义

/* 加载样式、js */
require get_template_directory() . "/inc/enqueue_script.php"; 
/* 常规设置 */
require get_template_directory() . "/inc/GeneralSettingClass.php"; 
/* bootstrap 菜单 */
require get_template_directory() . "/inc/BootstrapNavClass.php"; 
/* 自定义栏目 */
require get_template_directory() . "/inc/MetaBoxClass.php";
require get_template_directory() . "/inc/metabox.php";   
/* 幻灯片 */
require get_template_directory() . "/inc/slider_type.php"; 
/* 自定义函数 */
require get_template_directory() . "/inc/custom_func.php"; 
/* 分类 SEO */
require get_template_directory() . "/inc/seoCategory.php"; 

