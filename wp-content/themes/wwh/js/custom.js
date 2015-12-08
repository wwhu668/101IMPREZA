jQuery(document).ready(function() {
    /* 幻灯片时间设置 */
    jQuery('.carousel').carousel({
        interval: 5000,
    });
    /* column.php 内容忽略 自适应 */
    jQuery(".column-post").dotdotdot({
        wrap  : 'letter',
        after : 'a.column-view-more',
        watch: 'window',
    });  

    /* index.php 内容忽略 */
    jQuery(".post-content").dotdotdot({
        wrap    : 'letter',
    });  

    /* content.php 内容图片自适应 */
    changeImageSize();
    jQuery(window).resize(function() {
        changeImageSize();
    });
    function changeImageSize(){
        var maxWidth = jQuery(".column-post").width();
        jQuery(".column-post img").each(function(i){
            jQuery(this).removeAttr("height");
            if ( jQuery(this).width() > maxWidth ) {
                jQuery(this).width("100%");
                jQuery(this).css("max-width", maxWidth);
            }
        });
    }

    /* 点击弹出大图 */
    jQuery(".column-post img").each(function(){
        jQuery(this).attr("data-toggle", "modal");
        jQuery(this).attr("data-target", "#myModal");
    });
    jQuery(".column-post img").click(function(){
        img = jQuery(this).attr("src");
        jQuery(".modal-content>img").attr("src", img);
    }); 
    
}); 
