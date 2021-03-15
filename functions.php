<?php
/**
 * Twenty Nineteen functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage Twenty_Nineteen
 * @since Twenty Nineteen 1.0
 */



/**
 * Enqueue scripts and styles.
 */
/* function twentynineteen_scripts() { */
/* 	wp_enqueue_style( 'twentynineteen-style', get_stylesheet_uri(), array(), wp_get_theme()->get( 'Version' ) ); */

/* 	wp_style_add_data( 'twentynineteen-style', 'rtl', 'replace' ); */

/* 	if ( has_nav_menu( 'menu-1' ) ) { */
/* 		wp_enqueue_script( 'twentynineteen-priority-menu', get_theme_file_uri( '/js/priority-menu.js' ), array(), '20181214', true ); */
/* 		wp_enqueue_script( 'twentynineteen-touch-navigation', get_theme_file_uri( '/js/touch-keyboard-navigation.js' ), array(), '20181231', true ); */
/* 	} */

/* 	wp_enqueue_style( 'twentynineteen-print-style', get_template_directory_uri() . '/print.css', array(), wp_get_theme()->get( 'Version' ), 'print' ); */

/* 	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) { */
/* 		wp_enqueue_script( 'comment-reply' ); */
/* 	} */
/* } */
/* add_action( 'wp_enqueue_scripts', 'twentynineteen_scripts' ); */

add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );
function my_theme_enqueue_styles() {
    $parenthandle = 'twentynineteen-style'; // This is 'twentyfifteen-style' for the Twenty Fifteen theme.
    $theme = wp_get_theme();
    wp_enqueue_style( $parenthandle, get_template_directory_uri() . '/style.css',
        array(),  // if the parent theme code has a dependency, copy it to here
        $theme->parent()->get('Version')
    );
    wp_enqueue_style( 'twentynineteen-child', get_stylesheet_uri(),
        array( $parenthandle ),
        $theme->get('Version') // this only works if you have Version in the style header
    );
}

// Hook in
add_filter( 'woocommerce_default_address_fields' , 'custom_override_default_address_fields2' );

// Our hooked in function - $address_fields is passed via the filter!
function custom_override_default_address_fields2( $address_fields ) {
     $address_fields['address_1']['required'] = false;
     $address_fields['address_2']['required'] = false;
     $address_fields['city']['required'] = false;
     $address_fields['state']['required'] = false;
     $address_fields['country']['required'] = false;
     $address_fields['postcode']['required'] = false;
     /* unset($address_fields['postcode']); */

     return $address_fields;
}


// odstranit zbytečné položky
add_filter( 'woocommerce_checkout_fields' , 'custom_override_checkout_fields2' );
function custom_override_checkout_fields2( $fields ) {
  /* unset($fields['billing']['billing_first_name']); */
  /* unset($fields['billing']['billing_last_name']); */
  unset($fields['billing']['billing_company']);
  unset($fields['billing']['billing_address_1']);
  unset($fields['billing']['billing_address_2']);
  unset($fields['billing']['billing_city']);
  unset($fields['billing']['billing_postcode']);
  unset($fields['billing']['billing_country']);
  unset($fields['billing']['billing_state']);
  /* unset($fields['billing']['billing_phone']); */
  /* unset($fields['order']['order_comments']); */
  /* unset($fields['billing']['billing_email']); */
  unset($fields['account']['account_username']);
  unset($fields['account']['account_password']);
  unset($fields['account']['account_password-2']);
  return $fields;
}


add_filter( 'gettext', 'bbloomer_translate_woocommerce_strings2', 999, 3 );
  
function bbloomer_translate_woocommerce_strings2( $translated, $untranslated, $domain ) {
 
   if ( ! is_admin() && 'woocommerce' === $domain ) {
 
      switch ( $translated ) {
 
         case 'Fakturační údaje':
 
            $translated = 'Kontaktní údaje';
            break;
         case 'Fakturační adresa':
            $translated = 'Kontaktní údaje';
            break;
 
         case 'Product Description':
 
            $translated = 'Product Specifications';
            break;
 
         // ETC
       
      }
 
   }   
  
   return $translated;
 
}

