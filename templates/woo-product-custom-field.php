<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
//include_once(sprintf("%s/css/table_custom_css.css", dirname(__FILE__)));

if (!function_exists('write_log')) {
    function write_log ( $log )  {
        if ( true === WP_DEBUG ) {
            if ( is_array( $log ) || is_object( $log ) ) {
                error_log( print_r( $log, true ) );
            } else {
                error_log( $log );
            }
        }
    }
}

add_action( 'woocommerce_product_options_general_product_data', 'woo_add_custom_general_fields' );
/*
* Save Fields
*/
add_action( 'woocommerce_process_product_meta', 'woo_add_custom_general_fields_save' );
/*
* Function to create custom field
*/
function woo_add_custom_general_fields() {
	global $woocommerce, $post;
	/*
	* Fetching data to display in product slugs
	*/
	$text_A =  get_option('text_A');
	$text_B =  get_option('text_B');
	$text_C =  get_option('text_C');
	$text_D =  get_option('text_D');
	$text_E =  get_option('text_E');
	echo '<div class="options_group">';		  
		  // Custom fields will be created here...
		  // Number Field
					woocommerce_wp_text_input( 
						array( 
							'id'                => 'text_A', 
							'label'             => __( $text_A , 'woocommerce' ), 
							'placeholder'       => '', 
							'description'       => __( '', 'woocommerce' )
						)
					);
					woocommerce_wp_text_input( 
						array( 
							'id'                => 'text_B', 
							'label'             => __( $text_B, 'woocommerce' ), 
							'placeholder'       => '', 
							'description'       => __( '', 'woocommerce' )

						)
					);
					// Textarea
					woocommerce_wp_textarea_input( 
						array( 
							'id'          => 'text_C', 
							'label'       => __( $text_C, 'woocommerce' ), 
							'placeholder' => '', 
							'description' => __( '', 'woocommerce' ) 
						)
					);
					woocommerce_wp_textarea_input( 
						array( 
							'id'          => 'text_D', 
							'label'       => __( $text_D, 'woocommerce' ), 
							'placeholder' => '', 
							'description' => __( '', 'woocommerce' ) 
						)
					);
		  
					woocommerce_wp_textarea_input( 
						array( 
							'id'          => 'text_E', 
							'label'       => __( $text_E, 'woocommerce' ), 
							'placeholder' => '', 
							'description' => __( '', 'woocommerce' ) 
						)
					);
					// Checkbox
					woocommerce_wp_checkbox( 
					array( 
						'id'            => '_check_single_product_page', 
						'wrapper_class' => 'checkbox_class', 
						'label'         => __(' ', 'woocommerce' ), 
						'description'   => __( 'Check to show additional data to single product page', 'woocommerce' ) 
						)
					);
					// Checkbox
					woocommerce_wp_checkbox( 
						//if(get_post_meta( $post->ID, '_check_save_n_mail', true )){ $true = "true";}
					array( 
						'id'            => '_check_save_n_mail', 
						'wrapper_class' => 'checkbox_class', 
						'label'         => __(' ', 'woocommerce' ), 
						'description'   => __( 'Check to save and email the additional data when checked out', 'woocommerce' ),
						)
					);  
		  echo '</div>';
		}
		
		// Function to save the field data
		function woo_add_custom_general_fields_save( $post_id ){

				
			// Number Field for pallet ID and pallet Size
                        global $woocommerce_number_field;
			$woocommerce_text_A = $_POST['text_A'];
			if( !empty( $woocommerce_text_A ) )
				update_post_meta( $post_id, 'text_A', esc_attr( $woocommerce_text_A ) );

			$woocommerce_text_B = $_POST['text_B'];
			if( !empty( $woocommerce_text_B ) )
				update_post_meta( $post_id, 'text_B', esc_attr( $woocommerce_text_B ) );

			$woocommerce_text_C = $_POST['text_C'];
			if( !empty( $woocommerce_text_C ) )
				update_post_meta( $post_id, 'text_C', esc_html( $woocommerce_text_C ) );

			$woocommerce_text_D = $_POST['text_D'];
			if( !empty( $woocommerce_text_D ) )
				update_post_meta( $post_id, 'text_D', esc_html( $woocommerce_text_D ) );

			$woocommerce_text_E = $_POST['text_E'];
			if( !empty( $woocommerce_text_D ) )				
				update_post_meta( $post_id, 'text_E', esc_html( $woocommerce_text_E ) );				
				
			// Checkbox1 showinsingle hideinsingle
			$woocommerce_check_single_product_page = isset( $_POST['_check_single_product_page'] ) ? 'yes' : 'no';
				update_post_meta( $post_id, '_check_single_product_page', $woocommerce_check_single_product_page );
			// Checkbox2 savenmail
			$woocommerce_check_save_n_mail = isset( $_POST['_check_save_n_mail'] ) ? 'yes' : 'no';
				update_post_meta( $post_id, '_check_save_n_mail', $woocommerce_check_save_n_mail );

						
		}


/*
* Add meta data to single product page
*/
add_action( 'woocommerce_before_add_to_cart_button', 'add_custom_field', 0 );
function add_custom_field() {
    global $post;
        $text_check_single_product_page  = get_post_meta( $post->ID, '_check_single_product_page', true );
        $text_check_single_product_page = trim($text_check_single_product_page);
     	if ($text_check_single_product_page == 'yes') {

		$text_A1  = get_post_meta( $post->ID, 'text_A', true );
		$text_B1  = get_post_meta( $post->ID, 'text_B', true );
		$text_C1  = get_post_meta( $post->ID, 'text_C', true );
		$text_D1  = get_post_meta( $post->ID, 'text_D', true );
		$text_E1  = get_post_meta( $post->ID, 'text_E', true );

		echo "<table style=text-align:left;padding-left:15px;>";
		if ($text_A1){	
		  echo "<tr>";
			 echo "<td style=padding-left:15px;>".get_option('text_A')."</td>";
			 echo "<td style=padding-left:15px;>".$text_A1."</td>";     
		   echo "</tr>";
		}
		if ($text_B1){	
		  echo "<tr>";
			 echo "<td style=padding-left:15px;>".get_option('text_B')."</td>";
			 echo "<td style=padding-left:15px;>".$text_B1."</td>";     
		   echo "</tr>";
		}
		if ($text_C1){	
		  echo "<tr>";
			 echo "<td style=padding-left:15px;>".get_option('text_C')."</td>";  
			 echo "<td style=padding-left:15px;>".$text_C1."</td>";     
		   echo "</tr>";
		}
		if ($text_D1){	
		  echo "<tr>";
			 echo "<td style=padding-left:15px;>".get_option('text_D')."</td>";
			 echo "<td style=padding-left:15px;>".$text_D1."</td>";     
		   echo "</tr>";
		}
		if ($text_E1){	
		  echo "<tr>";
			 echo "<td style=padding-left:15px;>".get_option('text_E')."</td>"; 
			 echo "<td style=padding-left:15px;>".$text_E1."</td>";    
		   echo "</tr>";
		}
		  
		echo "</table>";
		echo "<br>";
      	}
      	else{
     	write_log('Something went wrong near line number: '.__LINE__ );
     	}
return true;
}
/**
 * Add the field to the checkout page
 */
add_action( 'woocommerce_after_order_notes', 'some_custom_checkout_field' ); 
function some_custom_checkout_field( $checkout ) {
	global $woocommerce, $wpdb, $post ;
	$contents = WC()->cart->cart_contents;
	if( $contents ) foreach ( $contents as $cart_item ){
	  $post_ids = $cart_item['product_id'];
	}
		$text_A1  = get_post_meta( $post_ids, 'text_A', true );
		$text_B1  = get_post_meta( $post_ids, 'text_B', true );
		$text_C1  = get_post_meta( $post_ids, 'text_C', true );
		$text_D1  = get_post_meta( $post_ids, 'text_D', true );
		$text_E1  = get_post_meta( $post_ids, 'text_E', true );
		
		echo "<table style=text-align:left;padding-left:15px;>";
		if ($text_A1){	
		  echo "<tr>";
			 echo "<td style=padding-left:15px;>".get_option('text_A')."</td>";
			 echo "<td style=padding-left:15px;>".$text_A1."</td>";     
		   echo "</tr>";
		}
		if ($text_B1){	
		  echo "<tr>";
			 echo "<td style=padding-left:15px;>".get_option('text_B')."</td>";
			 echo "<td style=padding-left:15px;>".$text_B1."</td>";     
		   echo "</tr>";
		}
		if ($text_C1){	
		  echo "<tr>";
			 echo "<td style=padding-left:15px;>".get_option('text_C')."</td>";  
			 echo "<td style=padding-left:15px;>".$text_C1."</td>";     
		   echo "</tr>";
		}
		if ($text_D1){	
		  echo "<tr>";
			 echo "<td style=padding-left:15px;>".get_option('text_D')."</td>";
			 echo "<td style=padding-left:15px;>".$text_D1."</td>";     
		   echo "</tr>";
		}
		if ($text_E1){	
		  echo "<tr>";
			 echo "<td style=padding-left:15px;>".get_option('text_E')."</td>"; 
			 echo "<td style=padding-left:15px;>".$text_E1."</td>";    
		   echo "</tr>";
		}
		  
		echo "</table>";
		echo "<br>";
	
}
/*
* save custom data in woo-commerce orders for admin view
*/
add_action( 'woocommerce_checkout_update_order_meta', 'some_custom_checkout_field_update_order_meta',10,2);
function some_custom_checkout_field_update_order_meta( $order_id, $posted ) {
	global $woocommerce, $wpdb, $post ;
	$contents = WC()->cart->cart_contents;
	if( $contents ) foreach ( $contents as $cart_item ){
	  $post_ids = $cart_item['product_id'];	
	}     
		$text_A1  = get_post_meta( $post_ids, 'text_A', true );
		$text_B1  = get_post_meta( $post_ids, 'text_B', true );
		$text_C1  = get_post_meta( $post_ids, 'text_C', true );
		$text_D1  = get_post_meta( $post_ids, 'text_D', true );
		$text_E1  = get_post_meta( $post_ids, 'text_E', true );
		if ($text_A1){
			update_post_meta( $order_id, get_option('text_A'), get_post_meta( $post_ids, 'text_A', true ) );	
		}
		if ($text_B1){
 			update_post_meta( $order_id, get_option('text_B'), get_post_meta( $post_ids, 'text_B', true ) );
		}
		if ($text_C1){
			update_post_meta( $order_id, get_option('text_C'), get_post_meta( $post_ids, 'text_C', true ) ); 
		}
		if ($text_D1){	
			update_post_meta( $order_id, get_option('text_D'), get_post_meta( $post_ids, 'text_D', true ) );
		}
		if ($text_E1){	
			update_post_meta( $order_id, get_option('text_E'), get_post_meta( $post_ids, 'text_E', true ) ); 
	
		}

}
/*
* send custom data to user through email after check out
*/
add_action('woocommerce_add_order_item_meta','wdm_add_values_to_order_item_meta',1,2);
function wdm_add_values_to_order_item_meta($item_id, $values)
  {
        global $woocommerce,$wpdb, $post;
	$contents = WC()->cart->cart_contents;
		if( $contents ) foreach ( $contents as $cart_item ){
		  $post_ids = $cart_item['product_id'];
		}
        $text_check_savenmail  = get_post_meta( $post_ids, '_check_save_n_mail', true );
        $text_check_savenmail = trim($text_check_savenmail);
     if ($text_check_savenmail == 'yes'){	 
		$text_A1  = get_post_meta( $post_ids, 'text_A', true );
		$text_B1  = get_post_meta( $post_ids, 'text_B', true );
		$text_C1  = get_post_meta( $post_ids, 'text_C', true );
		$text_D1  = get_post_meta( $post_ids, 'text_D', true );
		$text_E1  = get_post_meta( $post_ids, 'text_E', true );
		if ($text_A1){
			wc_add_order_item_meta( $item_id, get_option('text_A'), get_post_meta( $post_ids, 'text_A', true ) );	
		}
		if ($text_B1){
 			wc_add_order_item_meta( $item_id, get_option('text_B'), get_post_meta( $post_ids, 'text_B', true ) );
		}
		if ($text_C1){
			wc_add_order_item_meta( $item_id, get_option('text_C'), get_post_meta( $post_ids, 'text_C', true ) ); 
		}
		if ($text_D1){	
			wc_add_order_item_meta( $item_id, get_option('text_D'), get_post_meta( $post_ids, 'text_D', true ) );
		}
		if ($text_E1){	
			wc_add_order_item_meta( $item_id, get_option('text_E'), get_post_meta( $post_ids, 'text_E', true ) );
	
		} 
	
     } 
     else{
     	write_log('Something went wrong near line number: '.__LINE__ );
     	}
  	
  }

?>
