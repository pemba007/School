// JavaScript Document
(function() {
    tinymce.PluginManager.add('shortcode_member', function(editor, url) {
		editor.addButton('shortcode_member', {
			text: '',
			tooltip: 'Member',
			id: 'member_shortcode',
			icon: 'icon-member',
			onclick: function() {
				// Open window
				editor.windowManager.open({
					title: 'Member',
					body: [
						{type: 'textbox', name: 'ids', label: 'Ids (List of member Ids)'},
						{type: 'listbox', 
							name: 'col', 
							label: 'Width', 
							'values': [
								{text: '3/12 width', value: '3'},
								{text: '4/12 width', value: '4'},
								{text: 'Fullwidth', value: '12'}
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
						editor.insertContent('[member ids="'+e.data.ids+'" col="'+e.data.col+'" css_animation="'+e.data.css_animation+'" animation_delay="'+e.data.animation_delay+'"]<br class="nc"/>');
					}
				});
			}
		});
	});
})();
