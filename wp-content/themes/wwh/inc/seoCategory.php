<?php

/**
 * 分类后台关键字、描述
 */
add_action('category_add_form_fields','wwh_add_cat_field');   
function wwh_add_cat_field(){   
    echo '<div class="form-field ">';
    echo '<label for="cat_keywords">关键词</label>';
    echo '<input name="cat_keywords" id="cat_keywords" type="text" value="" size="40">';
    echo '<p>多个关键词用小写逗号“,”分隔开。</p>';
    echo '</div>';
    echo '<div class="form-field ">';
    echo '<label for="cat_description">描述</label>';
    echo '<textarea name="cat_description" id="cat_description" rows="5" cols="40"></textarea>';
    echo '<p>描述不要超过255个字。</p>';
    echo '</div>';
}  
 
add_action('edit_category_form_fields', 'wwh_edit_cat_field');
function wwh_edit_cat_field(){
    if(isset($_GET['action']) && $_GET['action'] == 'edit') $value = get_option('cat_set_' . $_GET['tag_ID']);
    $keywords = 'cat_keywords';
    $description = 'cat_description';
    echo '<tr class="form-field">';
    echo '<th scope="row" valign="top"><label for="'.$keywords.'">关键词</label></th>';
    echo '<td><input name="'.$keywords.'" id="'.$keywords.'" type="text" value="'.$value['keywords'].'">';
    echo '<p class="description">多个关键词用小写逗号“,”分隔开。</p>';
    echo '</td>';
    echo '</tr>';
    echo '<tr class="form-field">';
    echo '<th scope="row" valign="top"><label for="'.$description.'">描述</label></th>';
    echo '<td><textarea name="'.$description.'" id="'.$description.'" rows="3" cols="30">'.stripslashes($value['description']).'</textarea>';
    echo '<p class="description">描述不要超过255个字。”作为Head中Description信息。</p>';
    echo '</td>';
    echo '</tr>';
}

/* 修改 | 添加 */ 
add_action('edit_category', 'save_category_metadata', 10, 1);
add_action('created_category', 'save_category_metadata', 10, 1);
function save_category_metadata($term_id){
    if( $_POST['taxonomy'] == 'category'){
        update_option('cat_set_' . $term_id, 
            array(
            'description' => $_POST['cat_description'],
            'keywords' => $_POST['cat_keywords'],)
        );
    }
}
/* 删除 */
add_action('delete_category', 'delete_category_metadata', 10, 1);   
function delete_category_metadata($term_id) {
    delete_option('cat_set_' .$term_id);
}
