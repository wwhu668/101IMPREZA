<?php

/**
 * wwh_the_title 自定义文章输出标题
 * 
 * @access public
 * @return void
 */
function wwh_the_title() {
    $title = get_the_title();
    return empty($title) ? '(无标题)' : $title;
}

/**
 * wwh_slides 幻灯片
 * 
 * @access public
 * @return void
 */
function wwh_slides() {
    global $post;
    $args = array(
        'post_type'      => 'slider_type', // 文章类型(幻灯片)
        'posts_per_page' => 10, //幻灯片数量
    );
    $str = $img = $li = '';
    $flag = true;
    query_posts( $args );
    if ( have_posts() ) {
        while( have_posts() ) {
            the_post();
            $image_url = get_post_meta($post->ID,'slider_pic',true);
            if ( $image_url ) {
                $active = $flag == true ? 'active' : ''; 
                $flag = false; 
                $li .= '<li data-target="#carousel-example-generic" data-slide-to="'.$i.'" class="'.$active.'"></li>';
                $img .= '<div class="item '.$active.'">';
                $img .= '<a href="'.get_post_meta($post->ID, 'slider_link', true).'"><img src="'.$image_url.'" alt="'.wwh_the_title().'" style="height: 400px"></a>            </div>';
            }
        }
    }
    if ( $img && $li ) {
        $str .= '<div class="container shuffling">';
        $str .= '<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">';
        $str .= '<!-- Indicators -->';
        $str .= '<ol class="carousel-indicators">';
        $str .= $li;
        $str .= '</ol>';
        $str .= '<!-- Wrapper for slides -->';
        $str .= '<div class="carousel-inner" role="listbox">';
        $str .= $img;
        $str .= '</div>';
        $str .= '<!-- Controls -->';
        $str .= '<a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">';
        $str .= '<img class="previous rolling" src="'.get_bloginfo( 'template_url' ).'/images/Previous.png" />';
        $str .= '<span class="sr-only">Previous</span>';
        $str .= '</a>';
        $str .= '<a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">';
        $str .= '<img class="next rolling" src="'.get_bloginfo( 'template_url' ).'/images/Next.png" />';
        $str .= '<span class="sr-only">Next</span>';
        $str .= '</a>';
        $str .= '</div>';
        $str .= '</div>';
    }
    return $str;
}

/**
 * post_thumbnail_src 输出缩略图
 * 
 * @access public
 * @return void 返回地址
 */
function post_thumbnail_src(){
    global $post;
    if( $values = get_post_custom_values("thumb") ) {	//输出自定义域图片地址
        $values = get_post_custom_values("thumb");
		$post_thumbnail_src = $values [0];
	} elseif( has_post_thumbnail() ){    //如果有特色缩略图，则输出缩略图地址
        $thumbnail_src = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID),'full');
		$post_thumbnail_src = $thumbnail_src[0];
    } else {
		$post_thumbnail_src = '';
		ob_start();
		ob_end_clean();
		$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
		$post_thumbnail_src = $matches [1] [0];   //获取该图片 src
	};
    if(empty($post_thumbnail_src)){	//如果日志中没有图片，则显示随机图片
        $random = mt_rand(1, 10);
        return get_bloginfo('template_url').'/images/pic/'.$random.'.jpg'; 
        //如果日志中没有图片，则显示默认图片
        //echo '/images/default_thumb.jpg';
    }
	return $post_thumbnail_src;
}

/**
 * wwh_get_cats 获取除默认分类 id 
 * 
 * @access public
 * @return void
 */
function wwh_get_cats() {
    foreach ( get_the_category() as $cat )  {
        if ( $cat->term_id == 1 ) continue;
        $cats .= $cat->cat_ID . ',';
    }
    return $cats;
}

/**
 * wwh_get_category 组合查询数据
 * 
 * @access public
 * @return void
 */
function wwh_get_category() {
    global $post;
    $cats = wwh_get_cats();
    // $cats = $cats ? $cats : 1;
    /* $cats = $cats.'1,'; */
    $args = array(
        'category__in' => explode(',', $cats),
        'ignore_sticky_posts' => 1,
    );
    if ( is_single() ) {
        $args['posts_per_page']  = 3;
        $args['post__not_in']    = explode(',', $post->ID);
    } else {
        $args['posts_per_page']  = 4;
    }
    return $args;
}

/**
 * wwh_keywords_description SEO
 * 
 * @access public
 * @return void
 */
function wwh_keywords_description() {
    global $post;
    if (is_home() || is_page()) {   
        $keywords = get_option('keywords');   
        $description = get_option('description');   
    }   
    elseif (is_single()) {   
        $description1 = get_post_meta($post->ID, "description", true);   
        $description2 = mb_strimwidth(strip_tags(apply_filters('the_content', $post->post_content)), 0, 200, "…");   
        // 填写自定义字段description时显示自定义字段的内容，否则使用文章内容前200字作为描述   
        $description = $description1 ? $description1 : $description2;   
        // 填写自定义字段keywords时显示自定义字段的内容，否则使用文章tags作为关键词   
        $keywords = get_post_meta($post->ID, "keywords", true);   
        if($keywords == '') {   
            $tags = wp_get_post_tags($post->ID);       
            foreach ($tags as $tag ) {           
                $keywords = $keywords . $tag->name . ", ";       
            }   
            $keywords = rtrim($keywords, ', ');   
            $keywords = $keywords.get_the_title();   
        }   
    }   
    elseif (is_category()) {   
        $cat_id = get_query_var('cat');
        $val = get_option("cat_set_$cat_id");
        $keywords = $val['keywords'];
        $description= $val['description'];
    }   
    elseif (is_tag()){   
        $description = tag_description();   
        $keywords = single_tag_title('', false);   
    }   
    $key_desciption['description'] = trim(strip_tags($description));   
    $key_desciption['keywords'] = trim(strip_tags($keywords));   
    return $key_desciption;
}

/**
 * wwh_post_related 相关文章
 * 
 * @access public
 * @return void
 */
function wwh_post_related() {
    global $post;
    $post_num = 3;
    $exclude_id = $post->ID;
    $posttags = get_the_tags(); $i = 0;
    if ( $posttags ) :
        $tags = ''; foreach ( $posttags as $tag ) $tags .= $tag->term_id . ',';
        $args = array(
            'post_status' => 'publish',
            'tag__in' => explode(',', $tags),
            'post__not_in' => explode(',', $exclude_id),
            'caller_get_posts' => 1,
            'orderby' => 'comment_date',
            'posts_per_page' => $post_num
        );
        query_posts($args);
        while( have_posts() ) : the_post(); ?>
            <div class="col-md-4">
            <img src="<?php echo post_thumbnail_src(); ?>" alt="<?php echo wwh_the_title(); ?>"  height="122px" width="182.2px" />
            <p class="related-articles-title"><a href="<?php the_permalink(); ?>" title="<?php echo wwh_the_title(); ?>"><?php echo wwh_the_title(); ?></a></p>
            <p> <span class="glyphicon glyphicon-time" aria-hidden="true"></span> <?php the_time( 'Y-m-d' ); ?> </p>
            </div>
        <?php
        $exclude_id .= ',' . $post->ID; 
        $i ++;
        endwhile; 
        wp_reset_query();
    endif;  

    if ( $i < $post_num ) :
    $cats = ''; 
    foreach ( get_the_category() as $cat )  {
        if ( $cat->term_id == 1 ) continue;
        $cats .= $cat->cat_ID . ',';
    }
        $args = array(
            'category__in' => explode(',', $cats),
            'post__not_in' => explode(',', $exclude_id),
            'caller_get_posts' => 1,
            'orderby' => 'comment_date',
            'posts_per_page' => $post_num - $i
        );
        query_posts($args);
        while( have_posts() ) : the_post(); ?>
            <div class="col-md-4">
            <img src="<?php echo post_thumbnail_src(); ?>" alt="<?php echo wwh_the_title(); ?>"  height="122px" width="182.2px" />
            <p class="related-articles-title"><a href="<?php the_permalink(); ?>" title="<?php echo wwh_the_title(); ?>"><?php echo wwh_the_title(); ?></a></p>
            <p> <span class="glyphicon glyphicon-time" aria-hidden="true"></span> <?php the_time( 'Y-m-d' ); ?> </p>
            </div>
        <?php $i++;
        endwhile; 
        wp_reset_query();
    endif;
    if ( $i  == 0 )  echo '<div class="r_title">没有相关文章!</div>';
}

/**
 * wwh_sidebar_data_loop_body 侧边栏数据循环体
 * 
 * @access public
 * @return void
 */
function wwh_sidebar_data_loop_body() {
    $str = '<div class="column-new-posts">';
    $str .= '<p><a href="'.get_permalink().'">&gt;&nbsp;'.wwh_the_title().'</a></p>';
    $str .= '<p>'.get_the_time("Y-m-d").'</p>';
    $str .= '</div>';
    return $str;
}

/**
 * wwh_sidebar_data 侧边栏数据
 * 
 * @access public
 * @return void
 */
function wwh_sidebar_data() {
    global $post_childs;
    global $post;
    $args = wwh_get_category(); 
    query_posts( $args );  
    if ( $post_childs || have_posts() ) {
        $str = '<div class="column-new-post"> 最近的帖子 </div>';
        $str .= '<div>';
        if ( $post_childs ) {
            foreach ( $post_childs as $key => $post_child ) {
                if ( $key >= 3 ) break;
                $post = get_post($post_child->ID) ; 
                $str .= wwh_sidebar_data_loop_body();
            }
        } else {
            while ( have_posts() ) { 
                the_post();
                $str .= wwh_sidebar_data_loop_body();
            }
        } 
        $str .= '</div>';
    }else {
        $str .= '<div style="padding: 20px;"></div>';
    }
    echo $str;
}

/**
 * wwh_home_page_article 首页文章
 * 
 * @param mixed $cat_id 分类ID
 * @param string $location 位置
 * @param string $art_name 一级标题 
 * @param string $em 二级标题
 * @access public
 * @return void
 */
function wwh_home_page_article($cat_id, $location = 'top', $art_name = '文章', $em = '文章') {
    $args = array( 
        'cat'                 => $cat_id,
        'posts_per_page'      => 3,
        'ignore_sticky_posts' => 1,);
    $str = '<article class="article article-'.$location.' container container-margin">';
    $str .= '<h2>'.$art_name.'</h2><span>'.$em.'</span>';
    $str .= '<div class="row">';
    query_posts( $args );
    while ( have_posts() ) {
        the_post(); 
        $str .= '<div class="col-md-4">';
        $str .= '<a href="'.get_the_permalink().'">';
        $str .= '<img src="'.post_thumbnail_src().'" alt="'.wwh_the_title().'" width="293px" height="195px" />';
        $str .= '</a>';
        $str .= '<a href="'.get_the_permalink().'"><h4>'.wwh_the_title().'</h4></a>';
        $str .= '<p class="publish-time">';
        $str .= '<span class="glyphicon glyphicon-time" aria-hidden="true"></span>';
        $str .= ''.get_the_time('Y-m-d').'';
        $str .= '</p>';
        $str .= '<div class="post-content" id="clampjs">';
        $str .= strip_tags(get_the_content());
        $str .= '</div>';
        $str .= '<a class="btn view-more" href="'.get_the_permalink().'">查看更多</a>';
        $str .= '</div>';
    }
    $str .= '</div>';
    $str .= '</article>';
    return $str;
}
