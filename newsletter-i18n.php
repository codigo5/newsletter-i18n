<?php

/**
 * Plugin Name: Newsletter i18n
 * Plugin URI: https://github.com/codigo5/newsletter-i18n
 * Description: Newsletter wordpress plugin translations done in the right way
 * Author: Dhyego Fernando
 * Version: 1.0.0
 * Author URI: https://github.com/dhyegofernando
 * License: MIT
 * Depends: Newsletter, Static i18n
 */

function ni18n_check_dependencies() {
  if ( !is_plugin_active( 'newsletter/plugin.php' ) ) {
    ?>
    <div class="error">
      <p>Newsletter plugin not found. Please <a href="http://www.thenewsletterplugin.com/plugins/newsletter" target="_blank">install</a> or enable it.</p>
    </div>
    <?php
  }

  if ( !is_plugin_active( 'static-i18n/static-i18n.php' ) ) {
    ?>
    <div class="error">
      <p>Static i18n plugin not found. Please <a href="https://github.com/codigo5/static-i18n" target="_blank">install</a> or enable it.</p>
    </div>
    <?php
  }
}
add_action( 'admin_notices', 'ni18n_check_dependencies' );

/**
 * @return void
 */
function ni18n_load_textdomain() {
  load_plugin_textdomain( 'newsletter', false, plugin_basename( dirname( __FILE__ ) ) . '/languages' );
}
add_action( 'plugins_loaded', 'ni18n_load_textdomain' );

/**
 * Hack newsletter options to parse shortcodes
 * @return void
 */
function ni18n_parse_newsletter_options() {
  if ( is_plugin_active( 'newsletter/plugin.php' ) ) {
    $module = NewsletterSubscription::instance();
    array_walk( $module->options, function( &$value, $key ) {
      if ( preg_match( "/_text\z/", $key ) ) {
        $value = do_shortcode( $value );
      }
    } );
  }
}
add_action( 'plugins_loaded', 'ni18n_parse_newsletter_options' );
