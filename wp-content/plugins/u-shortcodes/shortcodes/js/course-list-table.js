// JavaScript Document
(function() {
    tinymce.PluginManager.add('shortcode_course_list', function(editor, url) {
		editor.addButton('shortcode_course_list', {
			text: '',
			tooltip: 'Course list table',
			id: 'course_list_shortcode',
			icon: 'icon-course-list',
			onclick: function() {
				// Open window
				editor.windowManager.open({
					title: 'Course list table',
					body: [
						{type: 'textbox', name: 'count', label: 'Number of item'},
						{type: 'textbox', name: 'cat', label: 'Categories (Fill slug or ID)'},
						{type: 'listbox', 
							name: 'order', 
							label: 'Order', 
							'values': [
								{text: 'DESC', value: 'DESC'},
								{text: 'ASC', value: 'ASC'},
							]
						},
						{type: 'listbox', 
							name: 'orderby', 
							label: 'Order by', 
							'values': [
								{text: 'Title', value: 'title'},
								{text: 'Publish Date', value: 'date'},
								{text: 'Start Date', value: 'meta_value_num'},
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
						// Insert content when the window form is submitted
						editor.insertContent('[u_course_list count="'+e.data.count+'" cat="'+e.data.cat+'" order="'+e.data.order+'" orderby="'+e.data.orderby+'" css_animation="'+e.data.css_animation+'" animation_delay="'+e.data.animation_delay+'"]<br class="nc"/>');
					}
				});
			}
		});
	});
})();
