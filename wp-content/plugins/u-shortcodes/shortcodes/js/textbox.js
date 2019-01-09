// JavaScript Document
(function() {
    tinymce.PluginManager.add('shortcode_textbox', function(editor, url) {
		editor.addButton('shortcode_textbox', {
			text: '',
			tooltip: 'Textbox',
			id: 'textbox_shortcode',
			icon: 'icon-textbox',
			onclick: function() {
				// Open window
				editor.windowManager.open({
					title: 'Textbox',
					body: [
						{type: 'textbox', name: 'icon', label: 'Icon ( For example: fa-star.)' , value:""},
						{type: 'textbox', name: 'link', label: 'Link in title' , value:""},
						{type: 'listbox', 
							name: 'target', 
							label: 'Open Link in', 
							'values': [
								{text: 'Curent Tab', value: ''},
								{text: 'New Tab', value: '1'},
							]
						},
						{type: 'textbox', name: 'heading', label: 'Heading' , value:"" },
						{type: 'textbox', name: 'content', label: 'Content text' , value:"" , multiline:true },
						{type: 'listbox', 
							name: 'layout', 
							label: 'Layout', 
							'values': [
								{text: 'Left', value: 'left'},
								{text: 'Right', value: 'right'},
								{text: 'Center', value: 'center'},
							]
						},
						{type: 'listbox', 
							name: 'schema', 
							label: 'Schema', 
							'values': [
								{text: 'Default', value: ''},
								{text: 'Light', value: 'light'},
								{text: 'Dark', value: 'dark'},
							]
						},
						{type: 'textbox', name: 'icon_background_color', label: 'Icon Background Color', value:"#", id: ''},
						{type: 'textbox', name: 'icon_background_hover', label: 'Icon Background Hover', value:"#", id: ''},
						{type: 'textbox', name: 'heading_color', label: 'Heading Color', value:"#", id: ''},
						{type: 'textbox', name: 'content_color', label: 'Content Color', value:"#", id: ''},
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
						editor.insertContent('[textbox  icon="'+e.data.icon+'" link="'+e.data.link+'" target="'+e.data.target+'" heading="'+e.data.heading+'" layout="'+e.data.layout+'" schema="'+e.data.schema+'" icon_background_color="'+e.data.icon_background_color+'" icon_background_hover="'+e.data.icon_background_hover+'" heading_color="'+e.data.heading_color+'" content_color="'+e.data.content_color+'" css_animation="'+e.data.css_animation+'" animation_delay="'+e.data.animation_delay+'"]'+e.data.content+'[/textbox]<br class="nc"/>');
					}
				});
			}
		});
	});
})();
