            <!-- 栏目页文章列表 -->
            <div class="row column-row">
                <div class="col-md-4">
                <a href="<?php echo the_permalink(); ?>">
                <img class="column-img" src="<?php echo post_thumbnail_src(); ?>" alt="<?php wwh_the_title(); ?>" width="194px" height="194px" />
                </a>
                </div>
                <div class="col-md-8">
                    <h1><a href="<?php echo the_permalink(); ?>"><?php echo wwh_the_title(); ?></a></h1>
                    <div class="entry-footer">
                        <span class="glyphicon glyphicon-time" aria-hidden="true"></span>
                        <?php the_time('Y-m-d'); ?>
                        <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
                        <?php the_author();
                            if ( get_the_category() ) :
                            $categoryName = '';
                            $i = 0;
                            foreach((get_the_category()) as $category)
                            {
                                if ( $category->term_id == 1 ) continue;
                                if ( $i >= 5 ) break;$i++;
                                 $categoryName[] = '<a href="'.get_category_link($category->term_id).'">'.$category->cat_name.'</a>';
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
                        <?php 
                            echo get_the_content();
                        ?>
                        <a class="column-view-more" href="<?php echo the_permalink(); ?>">查看更多</a>
                    </div>
                </div>
            </div>
        <?php wp_reset_query() ?>

