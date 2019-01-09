<?php
/* SHORT CODE FOR COMPARE TABLE
 *
 *
 */
function parse_compare_table($atts, $content)
{
    $id                 	= (isset($atts['id']) && $atts['id'] != '') ? $atts['id'] : '';
    $output_id              = ' id= "' . $id . '"';

    $class                 	= (isset($atts['class']) && $atts['class'] != '') ? $atts['class'] : '';
    $color 					= (isset($atts['color']) && $atts['color'] != '') ? 'color:' . $atts['color'] . ';' : '';
 
	$html = '
		<div class="row ' . $class . '"' . $output_id . '>
			'.do_shortcode(str_replace('<br class="nc" />', '', $content)).'
		</div>
	';

	$style = '';
	$style .= '<style type="text/css">';
	$style .= '#' . $id . '{' . $color . '}';
	$style .= '</style>';

	return $html . $style;
}

function parse_compare_table_column($atts, $content)
{

 	$rand_ID              	=  rand(1, 9999);
    $id                 	= 'compare-table-colum-' . $rand_ID;
    $output_id              = ' id= "' . $id . '"';

    $class                 	= (isset($atts['class']) && $atts['class'] != '') ? $atts['class'] : '';
    $color 					= (isset($atts['color']) && $atts['color'] != '') ? 'color:' . $atts['color'] . ';' : '';
    $bg_color 				= (isset($atts['bg_color']) && $atts['bg_color'] != '') ? 'background:' . $atts['bg_color'] . ';' : '';
    $title 					= (isset($atts['title']) && $atts['title'] != '') ? $atts['title'] : 'Default Title';
	$recommended_text 			=  isset($atts['recommended_text']) ? $atts['recommended_text'] : '';
	
	if((isset($atts['column']) && ($atts['column'] != '')))
	{
		if($atts['column'] == 1)
			$md_column = 12;
		else if($atts['column'] == 2)
			$md_column = 6;
		else if($atts['column'] == 3)
			$md_column = 4;
		else if($atts['column'] == 4)
			$md_column = 3;
		else
			$md_column = 4;
	}
	else
	{
		$md_column = 12;
	}
	
	//$price_html = '<div class="compare-table-price"'. ($price_color != ''? 'style="color:'.$price_color.'"':''). '><span>' . $currency . '</span> ' . $price . '<span>' . $price_text . '</span></div>';

	$md_class = 'class="col-md-' . $md_column . ' col-sm-' . $md_column . ' ' . $class .' compare-table-wrapper"';

	$html = '
		<div ' . $md_class . '>
			<div class="compare-table">
				<div class="compare-table-border" ' . $output_id . '>';
				if($class=="recommended" && $recommended_text!=''){
					$html .='<span class="recommended_text"><span class="main-color-1-bg">'.$recommended_text.'</span></span>';
				}
				$html .='
					<div class="compare-table-title"><span class="title main-color-1">' . $title . '</span><span></span></div>
					'.do_shortcode(str_replace('<br class="nc" />', '', $content)).'
				</div>
			</div>
		</div>
	';

	$style = '';
	$style .= '<style type="text/css">';
	$style .= '#' . $id . '{' . $color . $bg_color . '}';
	$style .= '</style>';

	$html=str_replace("<p></p>","",$html);
	return $html . $style;
}

function parse_compare_table_row($atts, $content)
{
	$rand_ID              	=  rand(1, 9999);
    $id                 	= 'compare-table-row-' . $rand_ID;
    $output_id              = ' id= "' . $id . '"';

	
	$html ='';
	$html .= '<div class="table-options" ' . $output_id . '>';
	$html .= do_shortcode($content) . '</div><span class="underline-u"></span>';
	$html=str_replace("<p></p>","",$html);
	return $html;
}

add_shortcode( 'comparetable', 'parse_compare_table' );
add_shortcode( 'c_column', 'parse_compare_table_column' );
add_shortcode( 'c_row', 'parse_compare_table_row' );

add_action( 'after_setup_theme', 'reg_ct_comparetable' );
function reg_ct_comparetable(){
	if(function_exists('vc_map')){
	vc_map( array(
			"name" => __("Comparetable", "cactusthemes"),
			"base" => "c_column",
			"content_element" => true,
			"as_parent" => array('only' => 'c_row'),
			"icon" => "icon-comparetable",
			"params" => array(
				array(
					"type" => "textfield",
					"heading" => __("Column Title", "cactusthemes"),
					"param_name" => "title",
					"value" => "Compare Table Column",
					"description" => "",
					"admin_label" => true
				  ),
				array(
					"type" => "textfield",
					"heading" => __("CSS Class", "cactusthemes"),
					"param_name" => "class",
					"value" => "",
					"description" => "",
				  ),
				  array(
					 "type" => "colorpicker",
					 "holder" => "div",
					 "class" => "",
					 "heading" => __("Color", 'cactusthemes'),
					 "param_name" => "color",
					 "value" => '',
					 "description" => '',
				  ),
				  array(
					 "type" => "colorpicker",
					 "holder" => "div",
					 "class" => "",
					 "heading" => __("Background Color", 'cactusthemes'),
					 "param_name" => "bg_color",
					 "value" => '',
					 "description" => '',
				  ),
				  array(
					"type" => "textfield",
					"heading" => __("Recommended text ", "cactusthemes"),
					"param_name" => "recommended_text",
					"value" => "",
					"description" => __("Text that appears in a recommended column","cactusthemes"),
				  ),
				  
			),
			"js_view" => 'VcColumnView'
		) );
		vc_map( array(
			"name" => __("Row", "cactusthemes"),
			"base" => "c_row",
			"content_element" => true,
			"as_child" => array('only' => 'c_column'), // Use only|except attributes to limit parent (separate multiple values with comma)
			"icon" => "icon-comparetable-row",
			"params" => array(
				array(
					"type" => "textarea_html",
					"heading" => __("Row Content", "cactusthemes"),
					"param_name" => "content",
					"value" => "Content",
					"description" => "",
					"admin_label" => true
				  ),
			),
		) );
	}
	if(class_exists('WPBakeryShortCode') && class_exists('WPBakeryShortCodesContainer')){
		class WPBakeryShortCode_c_column extends WPBakeryShortCodesContainer{}
		class WPBakeryShortCode_c_row extends WPBakeryShortCode{}
	}
}
