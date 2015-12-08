<?php 

$GeneralSettingClass = new GeneralSettingClass();
/**
 * GeneralSettingClass 后台常规设置
 * 
 * @package 
 * @version $id$
 * @copyright 1997-2005 The PHP Group
 * @author Tobias Schlitt <toby@php.net> 
 * @license PHP Version 3.0 {@link http://www.php.net/license/3_0.txt}
 */
class GeneralSettingClass {
	function __construct( ) {
		add_filter( 'admin_init' , array( &$this , 'register_keywords' ) );
        add_filter( 'admin_init' , array( &$this , 'register_description' ) );
		add_filter( 'admin_init' , array( &$this , 'register_fields' ) );
		add_filter( 'admin_init' , array( &$this , 'register_widget' ) );
        add_filter( 'admin_init' , array( &$this , 'register_banner' ) );
        add_filter( 'admin_init' , array( &$this , 'register_banner_link' ) );
	}
    /* 关键字 */
	function register_keywords() {
		register_setting( 'general', 'keywords', 'esc_attr' );
		add_settings_field('fav_keywords', '<label for="keywords">'.__('首页关键字' ).'</label>' , array(&$this, 'keywords_html') , 'general' );
	}
	function keywords_html() {
		$value = get_option( 'keywords', '' );
		echo '<input type="text" class="regular-text code" id="keywords" name="keywords" value="'.$value.'">';
	}
    /* 描述 */
	function register_description() {
		register_setting( 'general', 'description', 'esc_attr' );
		add_settings_field('fav_description', '<label for="description">'.__('首页描述' ).'</label>' , array(&$this, 'description_html') , 'general' );
	}
	function description_html() {
		$value = get_option( 'description', '' );
		echo '<textarea class="regular-textarea code" id="description" name="description" cols="40" rows="4">'.$value.'</textarea>';
	}
    /* 中间图 */
    function register_banner() {
        register_setting('general','banner','esc_attr');
        add_settings_field('fav_banner','<label for="banner">'.__('中间图片 ( 1000 * 200 )').'</label>', array(&$this,'banner_html'),'general');
    }
    function banner_html(){
        $value = get_option('banner','');
        echo '<input type="text" class="regular-text ltr"  name="banner" maxlength="200" value="'. $value .'" readonly/> 
            <input type="button" id="banner" class="upload button insert-media add_media k_hijack" value="上传">'; 
    }

    function register_banner_link() {
        register_setting('general','banner_link','esc_attr');
        add_settings_field('fav_banner_link','<label for="banner_link">'.__('中间图片链接').'</label>', array(&$this,'banner_link_html'),'general');
    }
    function banner_link_html(){
        $value = get_option('banner_link','');
		echo '<input type="url" class="regular-text code" id="banner_link" name="banner_link" value="'.$value.'">';
    }
    /* 联系 */
	function register_fields() {
		register_setting( 'general', 'contact', 'esc_attr' );
		add_settings_field('fav_contact', '<label for="contact">'.__('联系' ).'</label>' , array(&$this, 'fields_html') , 'general' );
	}
	function fields_html() {
		$value = get_option( 'contact', '' );
        echo '<textarea class="regular-textarea code" id="contact" name="contact" cols="40" rows="4">'.$value.'</textarea>';
	}
    /* 文件小部件 */
	function register_widget() {
		register_setting( 'general', 'the_widget', 'esc_attr' );
		add_settings_field('fav_widget', '<label for="the_widget">'.__('文件小部件' ).'</label>' , array(&$this, 'widget_html') , 'general' );
	}
	function widget_html() {
		$value = get_option( 'the_widget', '' );
        echo '<textarea class="regular-textarea code" id="the_widget" name="the_widget" cols="40" rows="4">'.$value.'</textarea>';
	}
}

