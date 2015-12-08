<?php get_header();
// 轮播图
echo wwh_slides();

/* primary 菜单对象 */
$menu = wp_get_nav_menu_object( 'primary' );
/* 获取导航项目 id */
$posts_id = $wpdb->get_results("
    select ID,meta_value as object_id from wp_term_relationships term_rel,wp_posts post,wp_postmeta meta
    where term_rel.term_taxonomy_id = 190
    and post.ID = term_rel.object_id
    and post.ID = meta.post_id 
    and meta.meta_key = '_menu_item_object_id'
    order by post.menu_order ") ;
?>
<!-- 上部分文章 -->
<?php echo wwh_home_page_article($posts_id[1]->object_id, 'top', '文章', '文章'); ?>
<!-- 中间图 -->
<div class="container container-banner">
    <?php if (get_option( 'banner' )) : ?>
    <a href="<?php echo get_option( 'banner_link' );?>">
    <img src="<?php echo get_option( 'banner' );?>" height="200px" />
    </a>
    <?php endif;?>
</div>
<!-- 下部分文章 -->
<?php echo wwh_home_page_article($posts_id[2]->object_id, 'bottom', '文章', '文章'); ?>

<?php get_footer(); ?>
    <script>
</script>

