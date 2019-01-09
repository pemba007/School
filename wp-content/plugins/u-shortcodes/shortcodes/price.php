<?php
/* SHORT CODE FOR PRICE
 *
 *
 */
function parse_price($atts, $content)
{

 	$rand_ID              	=  rand(1, 9999);
    $id                 	= 'compare-table-colum-' . $rand_ID;
    $output_id              = ' id= "' . $id . '"';
	$price					= (isset($atts['price']) && $atts['price'] != '') ? $atts['price'] : '120';
	$price_text				= (isset($atts['price_text']) && $atts['price_text'] != '') ? $atts['price_text'] : '/MONTH';
	$currency				= (isset($atts['currency']) && $atts['currency'] != '') ? $atts['currency'] : '$';
	$price_color 			=  isset($atts['price_color']) ? $atts['price_color'] : '';
	
	$html = '<div class="compare-table-price"><span class="price main-color-1" '. ($price_color != ''? 'style="color:'.$price_color.'"':''). '>' . $currency . '' . $price . '</span><span>' . $price_text . '</span></div>';

	$html=str_replace("<p></p>","",$html);
	return $html;
}

add_shortcode( 'price', 'parse_price' );

add_action( 'after_setup_theme', 'reg_ct_price' );
function reg_ct_price(){
	if(function_exists('vc_map')){
	vc_map( array(
			"name" => __("Price", "cactusthemes"),
			"base" => "price",
			"content_element" => true,
			"icon" => "icon-price",
			"params" => array(
				  array(
					"type" => "textfield",
					"heading" => __("Price", "cactusthemes"),
					"param_name" => "price",
					"value" => "120",
					"description" => "",
					"admin_label" => true
				  ),
				   array(
					"type" => "textfield",
					"heading" => __("Price Text", "cactusthemes"),
					"param_name" => "price_text",
					"value" => "/MONTH",
					"description" => "",
				  ),
				  array(
					"type" => "textfield",
					"heading" => __("Currency", "cactusthemes"),
					"param_name" => "currency",
					"value" => "$",
					"description" => "",
				  ),
				   array(
					 "type" => "colorpicker",
					 "holder" => "div",
					 "class" => "",
					 "heading" => __("Price Color", 'cactusthemes'),
					 "param_name" => "price_color",
					 "value" => '',
					 "description" => '',
				  ),
				  
			),
			"js_view" => 'VcColumnView'
		) );
	}
}
