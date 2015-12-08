<!DOCTYPE html>
<html lang="zh-CN">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width">
	<link rel="profile" href="http://gmpg.org/xfn/11">
    <?php $key_desciption = wwh_keywords_description(); ?>   
    <meta name="keywords" content="<?php echo $key_desciption['keywords']; ?>" />  
    <meta name="description" content="<?php echo $key_desciption['description']; ?>" />   
	<!--[if lt IE 9]>
	<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js"></script>
	<![endif]-->
	<?php wp_head(); ?>
</head>
<?php flush(); ?>
<body <?php body_class(); ?>>

<nav class="navbar">
  <div class="container container-header">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
        <a href="#top"></a>
        <a class="navbar-brand" href="/"><img src="<?php bloginfo( 'template_directory' ); ?>/images/logo.JPG"></img></a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <?php 
            wp_nav_menu( array(   
            'theme_location'       => 'primary',
            'depth'                => 2,
            'container'            => false,
            'menu_class'           => 'nav navbar-nav navbar-right',
            'fallback_cb'          => 'wp_page_menu',
            //添加或更改walker参数
            'walker'               => new BootstrapNavClass())
            );   
        ?> 
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
