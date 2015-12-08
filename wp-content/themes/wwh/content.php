<!-- 文章内容 -->
    <?php while ( have_posts() ) : the_post(); ?>
            <div>
                <img src="<?php echo post_thumbnail_src(); ?>" alt="<?php wwh_the_title(); ?>"  height="296px" width="89%" />
            </div>
            <h1><?php echo wwh_the_title(); ?></h1>
            <div class="entry-footer">
                <span class="glyphicon glyphicon-time" aria-hidden="true"></span>
                <?php the_date('Y-m-d'); ?>
                <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
                <?php the_author();
                    if ( get_the_category() ) :
                    $i = 0;
                    $categoryName = '';
                    foreach((get_the_category()) as $category)
                    {
                        if ( $i == 5 ) break;
                        if ( $category->term_id == 1 ) continue;
                         $categoryName[] = '<a href="'.get_category_link($category->term_id).'">'.$category->cat_name.'</a>';
                        $i++;
                    }
                    if ( $categoryName ) :
                ?>
                <span class="glyphicon glyphicon-folder-open" aria-hidden="true"></span>
                <?php
                    echo '&nbsp;'.implode(',', $categoryName);
                    endif;
                endif;
                ?>
            </div>
            <div class="column-post">
                <?php echo get_the_content(); ?>
            </div>
            <?php 
            if ( $post_childs ) {
                foreach ( $post_childs as $key => $post_child ) {
                    if ($post_child->ID == get_the_ID()) {
                        $next_post = ($key-1 >= 0) ? get_post($post_childs[$key-1]->ID) : '';
                        $prev_post = ($key+1 < count($post_childs)) ? get_post($post_childs[$key+1]->ID) : '';
                    }
                }
            } else {
                $next_post = get_next_post(true); 
                $prev_post = get_previous_post(true); 
            }
            if ( $next_post || $prev_post ) :
            ?>
            <div class=" screen-reader-text">
                <div>
                    <?php if( $next_post) :?>
                    <a href="<?php echo get_permalink($next_post->ID);?>">
                        <img class="menu-left" src="<?php bloginfo( 'stylesheet_directory' )?>/images/iconfont-xiangzuo.png" alt="" width="14px">
                        <div> <p>上一篇</p> <p><?php if ($next_post->post_title) echo $next_post->post_title; else echo '(无标题)'; ?></p> </div>
                    </a>
                    <?php else : ?>
                    <img> <div> <p>&nbsp;</p></div>
                    <?php endif;?>
                </div>
                <div>
                    <?php if( $prev_post) :?>
                    <a href="<?php echo get_permalink($prev_post->ID);?>">
                        <img class="menu-right" src="<?php bloginfo( 'stylesheet_directory' )?>/images/iconfont-xiangyou.png" alt="" width="14px">
                        <div> <p>下一篇</p> <p><?php if ($prev_post->post_title) echo $prev_post->post_title; else echo '(无标题)'; ?></p> </div>
                    </a>
                    <?php endif;?>
                </div>
            </div>
            <?php endif; ?>
    <?php endwhile; ?>
<?php if( empty($parent)) : ?>
     <div class="related-articles">
        <p>相关文章</p>
        <div class="row">
        <?php wwh_post_related(); ?>
        </div>
    </div>
<?php endif; ?>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <img src="" style="max-width: 100%;">
    </div>
  </div>
</div>
<style>
</style>
