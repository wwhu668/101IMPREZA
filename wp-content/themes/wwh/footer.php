        <div class="container container-margin public">
            <div class="row">
                <div class="col-md-4">
                    <p>文件小部件</p>
                    <div><?php echo html_entity_decode(get_option( 'the_widget' ) ); ?></div>
                </div>
                <div class="col-md-4">
                    <p>最近的帖子</p>
                    <?php
                        $args = array( 
                            'posts_per_page'       => 3,
                            'ignore_sticky_posts' => 1,
                        );
                        query_posts( $args );
                        while ( have_posts() ) : the_post();
                    ?>
                        <div>
                        <p><a href="<?php echo get_permalink(); ?>">&gt;&nbsp;<?php echo wwh_the_title(); ?></a></p>
                        <p><?php the_time( 'Y-m-d' ); ?></p>
                        </div>
                    <?php endwhile; ?>
                </div>
                <div class="col-md-4">
                    <p>联系</p>
                    <div><?php echo html_entity_decode(get_option( 'contact' ) ); ?></div>
                </div>
            </div>
        </div>
        <div class="container container-margin container-footer">
            <div class="row">
               <div class="col-md-5 icp">
                    &copy;&nbsp;<?php echo date('Y').get_option( 'zh_cn_l10n_icp_num' );?>
               </div>
               <div class="col-md-1">
                    <a href="#top">
                        <div class="back-to-the-top">
                            <span class="glyphicon glyphicon-menu-up" aria-hidden="true"></span>
                        </div>
                    </a>
               </div>
               <div class="col-md-6">
                    <?php //wp_nav_menu( array('theme_location' => 'secondary') ); ?>
                    <div class="menu-secondary-container">
                        <ul id="menu-secondary" class="menu">
                            <li id="" class="menu-item "><a href="/">首页</a></li>
                            <li id="" class="menu-item"><a href="http://www.101web.local/?cat=38">Post Formats</a></li>
                            <li id="" class="menu-item"><a href="http://www.101web.local/?cat=49">Template</a></li>
                            <li id="" class="menu-item"><a href="http://www.101web.local/?cat=49">Template</a></li>
                            <li id="" class="menu-item"><a href="http://www.101web.local/?cat=49">Template</a></li>
                            <li id="" class="menu-item"><a href="http://www.101web.local/?cat=49">Template</a></li>
                        </ul>
                    </div>
               </div>
            </div>
        </div>
<?php wp_footer(); ?>
</body>
</html>
