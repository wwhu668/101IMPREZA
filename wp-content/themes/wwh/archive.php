<?php get_header(); ?>
<div class="nav-back">
    <div class="container container-margin nav-lists">
        <a href="/">首页</a> > <?php single_cat_title(); ?>
    </div>
</div>
    <div class="container column">
        <div class="row">
            <div class="col-md-8">
            <?php 
            if ( $cat == 1 ) {
                /* 固定链接 兼容 */
                $current_url = home_url(add_query_arg(array(),$wp->request));
                $curent_arr = explode('/', $current_url);
                $paged = $curent_arr[count($curent_arr)-2] == 'page' ? array_pop($curent_arr) : 1; 
                if ( isset( $_GET['paged'] ) && $paged == 1) 
                    $paged = $_GET['paged']; 
                $post_args = array(
                    'post_status' => 'publish',
                    'ignore_sticky_posts' => 1,
                    'orderby' => 'date',
                    'order' => 'DESC',
                    'paged' => $paged, 
                );
                $posts_all = new WP_Query($post_args);
                while ($posts_all->have_posts()) {
                    $posts_all->the_post();
                    get_template_part( 'column', get_post_format() );
                }
            } else {
                while ( have_posts( $args ) ) {
                    the_post();   
                    get_template_part( 'column', get_post_format() );
                }
            }
            // 页码
            the_posts_pagination( 
                array(
                    'prev_text'          => __( '<', 'wwh' ),
                    'next_text'          => __( '>', 'wwh' ),
                    'screen_reader_text' => ' ',
                ) ); 
            ?>
            </div>
            <div class="col-md-4">
                <?php get_template_part( 'sidebar', get_post_format() ); ?>
            </div>
        </div>
    </div>
<?php get_footer(); ?>
