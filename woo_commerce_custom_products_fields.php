<?php
/*
Plugin Name: woo-commerce custom products fields
Plugin URI :
Description: A plugin to add Custom product field for WooCommerce
Version    : 1.0
Author     : Joydip Nath
License    : GPL2
*/
if(!class_exists('woo_commerce_custom_products_fields'))
{ 
    class woo_commerce_custom_products_fields
    {
        /**
         * Construct the plugin object
         */
        public function __construct()
        {
            
		require_once(sprintf("%s/templates/woocommerce-product-custom-field.php", dirname(__FILE__)));
		//require_once(sprintf("%s/css/table_custom_css.css", dirname(__FILE__)));
			// register actions
                add_action('admin_init', array(&$this, 'admin_init'));
        	add_action('admin_menu', array(&$this, 'add_menu'));
	        //require_once(sprintf("%s/settings.php", dirname(__FILE__)));

                // register actions
		 add_action( 'woocommerce_product_options_general_product_data', 'woo_add_custom_general_fields' );
		// Save Fields
		add_action( 'woocommerce_process_product_meta', 'woo_add_custom_general_fields_save' );
		/*
		* Add meta data to single product page
		*/
		add_action( 'woocommerce_before_add_to_cart_button', 'add_custom_field', 0 );
		/**
		 * Add the field to the checkout page
		 */
		add_action( 'woocommerce_after_order_notes', 'some_custom_checkout_field' ); 
		/*
		* save custom data in woo-commerce orders for admin view
		*/
		add_action( 'woocommerce_checkout_update_order_meta', 'some_custom_checkout_field_update_order_meta',10,2);
		/*
		* send custom data to user through email after check out
		*/
		add_action('woocommerce_add_order_item_meta','wdm_add_values_to_order_item_meta',1,2);
        } // END public function __construct
    
        

	/**
	 * add a menu
	 */     
	public function add_menu()
	{
	    add_options_page('Add your custom name for each tabs', 'woo_commerce_custom_products_fields', 'manage_options', 'woo_commerce_custom_products_fields', array(&$this, 'plugin_settings_page'));
	} // END public function add_menu()

	/**
	 * Menu Callback
	 */     
	public function plugin_settings_page()
	{
	    if(!current_user_can('manage_options'))
	    {
		wp_die(__('You do not have sufficient permissions to access this page.'));
	    }

	    // Render the settings template
	    include(sprintf("%s/templates/settings.php", dirname(__FILE__)));
	} // END public function plugin_settings_page()


		public function admin_init()
        	{
        	// register your plugin's settings
        	register_setting('wp_plugin_template-group', 'text_A');
        	register_setting('wp_plugin_template-group', 'text_B');
        	register_setting('wp_plugin_template-group', 'text_C');
        	register_setting('wp_plugin_template-group', 'text_D');
        	register_setting('wp_plugin_template-group', 'text_E');
        	

        	// add your settings section
        	add_settings_section(
        	    'joy_wp_plugin_template-section', 
        	    'Add your custom name for each tabs', 
        	    array(&$this, 'settings_section_wp_plugin_template'), 
        	    'woo_commerce_custom_products_fields'
        	);
        	
        	// add your setting's fields
            add_settings_field(
                'wp_plugin_template-setting_a', 
                'Text A', 
                array(&$this, 'settings_field_input_text'), 
                'woo_commerce_custom_products_fields', 
                'joy_wp_plugin_template-section',
                array(
                    'field' => 'text_A'
                )
            );
            add_settings_field(
                'wp_plugin_template-setting_b', 
                'Text B', 
                array(&$this, 'settings_field_input_text'), 
                'woo_commerce_custom_products_fields', 
                'joy_wp_plugin_template-section',
                array(
                    'field' => 'text_B'
                )
            );
            add_settings_field(
                'wp_plugin_template-product_ID', 
                'Text c', 
                array(&$this, 'settings_field_input_text'), 
                'woo_commerce_custom_products_fields', 
                'joy_wp_plugin_template-section',
                array(
                    'field' => 'text_C'
                )
            );
            add_settings_field(
                'wp_plugin_template-pallet_ID', 
                'Text D', 
                array(&$this, 'settings_field_input_text'), 
                'woo_commerce_custom_products_fields', 
                'joy_wp_plugin_template-section',
                array(
                    'field' => 'text_D'
                )
            );
            add_settings_field(
                'wp_plugin_template-discount', 
                'Text E', 
                array(&$this, 'settings_field_input_text'), 
                'woo_commerce_custom_products_fields', 
                'joy_wp_plugin_template-section',
                array(
                    'field' => 'text_E'
                )
            );
            // Possibly do additional admin_init tasks
        } // END public static function activate

	public function settings_section_wp_plugin_template()
        {
            // Think of this as help text for the section.
            echo 'Set the name of the field, So, thats how they would appear in product page in woo-commerce add new product. ';
        }
        
        /**
         * This function provides text inputs for settings fields
         */
        public function settings_field_input_text($args)
        {
            // Get the field name from the $args array
            $field = $args['field'];
            // Get the value of this setting
            $value = get_option($field);
            // echo a proper input type="text"
            echo sprintf('<input type="text" name="%s" id="%s" value="%s" />', $field, $field, $value);
        } // END public function settings_field_input_text($args)

    } // END class WP_Plugin_Template
} // END if(!class_exists('WP_Plugin_Template'))

if(class_exists('woo_commerce_custom_products_fields'))
{
    // instantiate the plugin class
    $woo_commerce_custom_products_fields = new woo_commerce_custom_products_fields();
}

?>
