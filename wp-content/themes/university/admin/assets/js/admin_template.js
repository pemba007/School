// JavaScript Document
(function($){
	
$(document).ready(function(e) {
	//front page content
	if($('select#page_template').val()=='page-templates/front-page.php'){
		$('#front_page_content_blog.postbox').show()
	}else{
		$('#front_page_content_blog.postbox').hide()
	}
	$('select#page_template').change(function(e) {
        if($(this).val()=='page-templates/front-page.php'){
			$('#front_page_content_blog.postbox').show(200)
		}else{
			$('#front_page_content_blog.postbox').hide(100)
		}
    });
	//front page header box
	if($('select#page_template').val()=='page-templates/front-page.php'){
		$('#front_page_header.postbox').show()
	}else{
		$('#front_page_header.postbox').hide()
	}
	$('select#page_template').change(function(e) {
        if($(this).val()=='page-templates/front-page.php'){
			$('#front_page_header.postbox').show(200)
		}else{
			$('#front_page_header.postbox').hide(100)
		}
    });
	//condition meta
	$('.u-condition').each(function(index, element) {
        var condition_id = $(this).attr('name');
		var condition_value = $(this).val();
		$('.'+condition_id+'-child:not(.'+condition_id+'-'+condition_value+')').closest('.format-settings').hide();
		$(this).change(function(e){
			$('.'+condition_id+'-child').closest('.format-settings').hide(100);
			$('.'+condition_id+'-'+$(this).val()).closest('.format-settings').show(200);
		});
    });
	$(document).on('click','#id_button button',function() {
		$('.mce-foot button').trigger( "click" );
		$('#bt_shortcode button').trigger( "click" );
	});
	//member
	$(document).on('click','#id_member button',function() {
		$('.mce-foot button').trigger( "click" );
		$('#member_shortcode button').trigger( "click" );
	});
	$(document).on('click','#id_button_dropcap button',function() {
		$('.mce-foot button').trigger( "click" );
		$('#dropcap_shortcode button').trigger( "click" );
	});
	$(document).on('click','#id_button_heading button',function() {
		$('.mce-foot button').trigger( "click" );
		$('#heading_shortcode button').trigger( "click" );
	});
	$(document).on('click','#id_button_coundown button',function() {
		$('.mce-foot button').trigger( "click" );
		$('#countdown_shortcode button').trigger( "click" );
	});
	$(document).on('click','#id_button_testimonial button',function() {
		$('.mce-foot button').trigger( "click" );
		$('#testimonial_shortcode button').trigger( "click" );
	});
	//blog
	$(document).on('click','#id_button_blog button',function() {
		$('.mce-foot button').trigger( "click" );
		$('#blog_shortcode button').trigger( "click" );
	});
	//Post Carousel
	$(document).on('click','#id_button_post_carousel button',function() {
		$('.mce-foot button').trigger( "click" );
		$('#post_carousel_shortcode button').trigger( "click" );
	});
	//Post Grid
	$(document).on('click','#id_button_post_grid button',function() {
		$('.mce-foot button').trigger( "click" );
		$('#shortcode_post_grid button').trigger( "click" );
	});
	//Post scroller
	$(document).on('click','#id_button_post_scroller button',function() {
		$('.mce-foot button').trigger( "click" );
		$('#post_scroller_shortcode button').trigger( "click" );
	});
	//textbox
	$(document).on('click','#id_button_textbox button',function() {
		$('.mce-foot button').trigger( "click" );
		$('#textbox_shortcode button').trigger( "click" );
	});
	//Course list
	$(document).on('click','#id_button_course_list button',function() {
		$('.mce-foot button').trigger( "click" );
		$('#course_list_shortcode button').trigger( "click" );
	});
	$(document).on('click','#id_shortcode_video_banner button',function() {
		$('.mce-foot button').trigger( "click" );
		$('#shortcode_video_banner button').trigger( "click" );
	});
	$(document).on('click','#id_shortcode_comparetable button',function() {
		$('.mce-foot button').trigger( "click" );
		$('#cactus_compare_shortcode button').trigger( "click" );
	});

});//doc ready

})(jQuery);