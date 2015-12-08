jQuery.noConflict();
jQuery(document).ready(function(){	
	hijack_media_uploader();
	hijack_preview_pic();
    description_str_length();
});

/* 显示上传图片 */
function hijack_preview_pic(){
	jQuery('.kriesi_preview_pic_input').each(function(){
		jQuery(this).bind('change focus blur ktrigger', function(){	
			$select = '#' + jQuery(this).attr('name') + '_div';
			$value = jQuery(this).val();
			$image = '<img src ="'+$value+'" />';
			var $image = jQuery($select).html('').append($image).find('img');
			//set timeout because of safari
			window.setTimeout(function(){
			 	if(parseInt($image.attr('width')) < 20){	
					jQuery($select).html('');
				}
			},500);
		});
	});
}

/* 上传图片 */
function hijack_media_uploader(){		
		$buttons = jQuery('.k_hijack');
		$realmediabuttons = jQuery('.media-buttons a');
		window.custom_editor = false;
		$buttons.click(function(){	
			window.custom_editor = jQuery(this).attr('id');			
         tb_show('', 'media-upload.php?type=image&TB_iframe=true');
            return false;
		});
		$realmediabuttons.click(function(){

			window.custom_editor = false;
		});
		window.original_send_to_editor = window.send_to_editor;
		window.send_to_editor = function(html){	
			if (custom_editor) {	
				$img = jQuery(html).attr('src') || jQuery(html).find('img').attr('src') || jQuery(html).attr('href');
				
				jQuery('input[name='+custom_editor+']').val($img).trigger('ktrigger');
				custom_editor = false;
				window.tb_remove();
			}else{
				window.original_send_to_editor(html);
			}
		};
}

/* 描述字符限制 */
function description_str_length(){
    jQuery('#post_description').after('<span>还能输入 255 个字符</span>');
    jQuery('#post_description').keyup(function (event) {
        str_length = 255 - jQuery(this).val().length;
        jQuery(this).next().html('');
        jQuery(this).next().html('还能输入 '+str_length+' 个字符');
    }); 
}

