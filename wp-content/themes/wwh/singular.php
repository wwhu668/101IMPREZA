<?php get_header(); 
    /* 文章页  */
    $cats = wwh_get_cats();
    if ( ! $cats )
        $cats = 1; 
    $cat_name = get_cat_name( $cats );
    $cat_links = get_category_link( $cats );

    echo $posts_to_show;

    /* 当前文章id */
    $post_id = get_the_ID();
    /* primary 菜单对象 */
    $menu = wp_get_nav_menu_object( 'primary' );
    /* $wpdb->postmeta 父级菜单 post_id */
    $parent = $wpdb->get_results("
        select meta_value as parent from $wpdb->postmeta where post_id = 
        (select post_id from $wpdb->postmeta,$wpdb->term_relationships term_rel where meta_value = $post_id and meta_key = '_menu_item_object_id'
            and term_rel.object_id = post_id and term_rel.term_taxonomy_id = {$menu->term_id}
        )
        and meta_key = '_menu_item_menu_item_parent'") ;
    /* 当前文章所有同级文章信息 $wpdb->postmet  */
    $renchilds = $wpdb->get_results("
        select post_id from $wpdb->postmeta meta,$wpdb->posts post where meta_value = {$parent[0]->parent} and meta_key = '_menu_item_menu_item_parent'
        and meta.post_id = post.ID
        order by post.menu_order
            ");
    /* 获得文章 ID */
    foreach( $renchilds as $renchild ) {
        $post_child = $wpdb->get_results("
            select meta_value as ID from $wpdb->postmeta where post_id = {$renchild->post_id}
            and meta_key = '_menu_item_object_id'
        ");
        $post_childs[] = $post_child[0];
    }

?>
<div class="nav-back">
    <div class="container container-margin nav-lists">
        <div>
            <a href="/">首页</a> > 
            <?php 
            /* 输出分类名或父级 名称 */
            if ( $cat_name && !$renchilds) 
                echo '<a href="'.$cat_links.'">'.$cat_name.'</a>&nbsp;&gt';
            else 
                echo ''.get_post($parent[0]->parent)->post_title.'&nbsp;&gt';
            ?> </div>
            <div><nobr>&nbsp;<?php echo wwh_the_title(); ?></nobr>
        </div>
    </div>
</div>
<div class="column-back">
    <div class="container  column">
        <div class="row single">
            <div class="col-md-8">
                <?php include('content.php');  ?>
            </div>
            <div class="col-md-4">
                <?php include('sidebar.php');  ?>
            </div>
        </div>
    </div>
</div>
<?php get_footer(); ?>

