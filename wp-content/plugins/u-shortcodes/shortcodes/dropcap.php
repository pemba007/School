<?php
function parse_u_dropcap($atts, $content){
	$html = '<span class="dropcap">'.$content.'</span>';
	return $html;
}
add_shortcode( 'dropcap', 'parse_u_dropcap' );




















