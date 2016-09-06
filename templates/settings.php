<div class="wrap">
    <h2>woo-commerce custom products field setting page</h2>
    <form method="post" action="options.php"> 
        <?php @settings_fields('wp_plugin_template-group'); ?>
        <?php @do_settings_fields('wp_plugin_template-group'); ?>

        <?php do_settings_sections('woo_commerce_custom_products_fields'); ?>

        <?php @submit_button(); ?>
    </form>
</div>
<!-- action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>" -->
