// JavaScript Document
(function() {
    tinymce.PluginManager.add('cactus_compare_table', function(editor, url) {
		editor.addButton('cactus_compare_table', {
			text: '',
			tooltip: 'Compare Table',
			id: 'cactus_compare_shortcode',
			icon: 'icon-compare-table',
			onclick: function() {
				// Open window
				editor.windowManager.open({
					title: 'Compare Table',
					body: [
						{type: 'textbox', name: 'column', label: 'Number of column', value: '3'},
						{type: 'textbox', name: 'row', label: 'Number of row', value: '6'},
					],
					onsubmit: function(e) {
						var uID =  Math.floor((Math.random()*100)+1);
						var column 				= e.data.column;
						var row 				= e.data.row;
						var shortcode = '[comparetable class="" id="compare-table-' + uID + '" color=""]<br class="nc"/>';
						for(i=0;i<column;i++)
						{
							if(i==1){
								shortcode+= '[c_column  class="recommended" recommended_text="popular" column="' + column + '" color="" bg_color="" title=""]<br class="nc"/>';
								for(j=0; j<row-3; j++)
								{
									shortcode+= '[c_row id="row-' + j + '"]Content[/c_row]<br class="nc"/>';
								}
								shortcode+= '[c_row id="row-' + (row-2) + '"][price price="59.99" price_text="/MONTH" currency="$"][/c_row]<br class="nc"/>';
								shortcode+= '[c_row id="row-' + (row-1) + '"][ct_button id="button_6" size="small" solid="1" link="#" icon="" arrow="1" color="#" css_animation="" animation_delay=""]BUY THIS PLAN[/ct_button][/c_row]<br class="nc"/>';
							}else{
								shortcode+= '[c_column  class="" column="' + column + '" color="" bg_color="" title=""]<br class="nc"/>';
								for(j=0; j<row-3; j++)
								{
									shortcode+= '[c_row id="row-' + j + '"]Content[/c_row]<br class="nc"/>';
								}
								shortcode+= '[c_row id="row-' + (row-2) + '"][price price="59.99" price_text="/MONTH" currency="$"][/c_row]<br class="nc"/>';
								shortcode+= '[c_row id="row-' + (row-1) + '"][ct_button id="button_6" size="small" solid="1" link="#" icon="" arrow="1" color="#" css_animation="" animation_delay=""]BUY THIS PLAN[/ct_button][/c_row]<br class="nc"/>';
							}
							shortcode += '[/c_column]<br class="nc"/>';
						}
						shortcode+= '[/comparetable]<br class="nc"/>';
						// Insert content when the window form is submitted
						editor.insertContent(shortcode);
					}
				});
			}
		});
	});
})();

