// JavaScript Document
(function() {
    tinymce.PluginManager.add('shortcode_blog', function(editor, url) {
		editor.addButton('shortcode_blog', {
			text: '',
			tooltip: 'Blog',
			id: 'blog_shortcode',
			icon: 'icon-blog',
			onclick: function() {
				// Open window
				editor.windowManager.open({
					title: 'Blog',
					body: [
						{type: 'textbox', name: 'title', label: 'Title'},
						{type: 'listbox', 
							name: 'post_type', 
							label: 'Post Type', 
							'values': [
								{text: 'Post', value: 'post'},
								{text: 'Event', value: 'u_event'},
								{text: 'Course', value: 'u_course'},
								{text: 'LearnDash Course', value: 'sfwd-courses'}
							]
						},
						{type: 'textbox', name: 'cat', label: 'Category (List of cat ID or slug)'},
						{type: 'textbox', name: 'tag', label: 'Tags (List of tags, separated by a comma)'},
						{type: 'textbox', name: 'ids', label: 'Ids (Specify post IDs to retrieve)'},
						{type: 'textbox', name: 'number', label: 'Number of posts to show.'},
						{type: 'listbox', 
							name: 'order', 
							label: 'Order', 
							'values': [
								{text: 'DESC', value: 'DESC'},
								{text: 'ASC', value: 'ASC'}
							]
						},
						{type: 'listbox', 
							name: 'orderby', 
							label: 'Order by', 
							'values': [
								{text: 'Date', value: 'date'},
								{text: 'ID', value: 'ID'},
								{text: 'Author', value: 'author'},
								{text: 'Title', value: 'title'},
								{text: 'Name', value: 'name'},
								{text: 'Modified', value: 'modified'},
								{text: 'Parent', value: 'parent'},
								{text: 'Random', value: 'rand'},
								{text: 'Comment count', value: 'comment_count'},
								{text: 'Menu order', value: 'menu_order'},
								{text: 'Meta value', value: 'meta_value'},
								{text: 'Meta value num', value: 'meta_value_num'},
								{text: 'Post__in', value: 'post__in'},
								{text: 'None', value: 'none'}
							]
						},
						{type: 'textbox', name: 'meta_key', label: 'Meta key (Name of meta key for ordering)'},
						{type: 'listbox', 
							name: 'show_date', 
							label: 'Show date', 
							'values': [
								{text: 'Show', value: '1'},
								{text: 'Hide', value: '0'}
							]
						},
						{type: 'listbox', 
							name: 'show_comment_count', 
							label: 'Show comment count', 
							'values': [
								{text: 'Show', value: '1'},
								{text: 'Hide', value: '0'}
							]
						},
						{type: 'textbox', name: 'more_text', label: '"More" text (Default is "Visit Blog")'},
						{type: 'textbox', name: 'more_link', label: '"More" link'},
						{type: 'textbox', name: 'detail_text', label: '"Detail" text'},
						{type: 'listbox', 
							name: 'column', 
							label: 'Column', 
							'values': [
								{text: '2 Column', value: '2'},
								{text: '1 Column', value: '1'},
							]
						},
						{type: 'listbox', 
							name: 'css_animation', 
							label: 'CSS Animation', 
							'values': [
								{text: 'No', value: ''},
								{text: 'Top to bottom', value: 'top-to-bottom'},
								{text: 'Bottom to top', value: 'bottom-to-top'},
								{text: 'Left to right', value: 'left-to-right'},
								{text: 'Right to left', value: 'right-to-left'},
								{text: 'Appear from center', value: 'appear'}
							]
						},
						{type: 'textbox', name: 'animation_delay', label: 'Animation Delay'},
					],
					onsubmit: function(e) {
						var uID =  Math.floor((Math.random()*100)+1);
						editor.insertContent('[u_blog   title="'+e.data.title+'" post_type="'+e.data.post_type+'" cat="'+e.data.cat+'" tag="'+e.data.tag+'" ids="'+e.data.ids+'" count="'+e.data.number+'" order="'+e.data.order+'" orderby="'+e.data.orderby+'" meta_key="'+e.data.meta_key+'" show_date="'+e.data.show_date+'" show_comment_count="'+e.data.show_comment_count+'" more_text="'+e.data.more_text+'" more_link="'+e.data.more_link+'" detail_text="'+e.data.detail_text+'" column="'+e.data.column+'" css_animation="'+e.data.css_animation+'" animation_delay="'+e.data.animation_delay+'"]<br class="nc"/>');
					}
				});
			}
		});
	});
})();
