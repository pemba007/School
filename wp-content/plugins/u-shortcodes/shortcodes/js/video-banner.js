// JavaScript Document
(function() {
    tinymce.PluginManager.add('shortcode_video_banner', function(editor, url) {
		editor.addButton('shortcode_video_banner', {
			text: '',
			tooltip: 'Video Banner',
			icon: 'icon-video-banner',
			id: 'shortcode_video_banner',
			onclick: function() {
				// Open window
				editor.windowManager.open({
					title: 'Video Banner',
					body: [
						{type: 'textbox', name: 'image', label: 'Image (attachment ID)'},
						{type: 'listbox', 
							name: 'style', 
							label: 'Style', 
							'values': [
								{text: 'Fullwidth', value: 'fullwidth'},
								{text: 'Boxed', value: 'boxed'}
							]
						},
						{type: 'textbox', name: 'width', label: 'Width in pixel (ex: 400)'},
						{type: 'textbox', name: 'height', label: 'Height in pixel (ex: 300)'},
						{type: 'textbox', name: 'text', label: 'Text'},
						{type: 'textbox', name: 'opacity', label: 'Opacity (0 - 0.99)'},
						{type: 'textbox', name: 'hover_opacity', label: 'Hover Opacity (0 - 0.99)'},
						{type: 'textbox', name: 'video_url', label: 'Video URL'},
						{type: 'listbox', 
							name: 'parallax', 
							label: 'Parallax', 
							'values': [
								{text: 'Yes', value: '1'},
								{text: 'no', value: '0'}
							]
						},
						{type: 'listbox', 
							name: 'target', 
							label: 'URL Target', 
							'values': [
								{text: 'Popup', value: 'popup'},
								{text: 'Current', value: 'current'},
								{text: 'Open in New Tab', value: 'blank'}
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
						editor.insertContent('[u_video_link id="'+uID+'" image="'+e.data.image+'" style="'+e.data.style+'" width="'+e.data.width+'" height="'+e.data.height+'" parallax="'+e.data.parallax+'" target="'+e.data.target+'" video_url="'+e.data.video_url+'" opacity="'+e.data.opacity+'" hover_opacity="'+e.data.hover_opacity+'" css_animation="'+e.data.css_animation+'" animation_delay="'+e.data.animation_delay+']'+e.data.text+'[/u_video_link]<br class="nc"/>');
					}
				});
			}
		});
	});
})();
