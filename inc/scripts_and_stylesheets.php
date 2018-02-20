<?php
function evistaStarterScripts () {
	if (!is_admin()) {
    wp_deregister_script('app-bundle');
		wp_register_script('app-bundle', get_template_directory_uri().'/build/bundle.js', false, '1.0.0', true);
		wp_enqueue_script('app-bundle');
	}
}
add_action('init', 'evistaStarterScripts');

function evistaStarterStyles () {
  if(!is_admin()){
    
		if (file_exists( get_stylesheet_directory() . '/build/bundle.css' )){
			wp_register_style( 'app', get_template_directory_uri() . '/build/bundle.css' );
  		wp_enqueue_style( 'app' );
		}

  }
}
add_action('init', 'evistaStarterStyles');

function addDeferAttributeToScripts ($tag, $handle) {
	$scriptsToDefer = array(
		'app-bundle',
		'wp-embed'
	);

	foreach($scriptsToDefer as $script) {
		if($script === $handle) {
			return str_replace(' src', ' defer src', $tag);
		}
	}

	return $tag;
}
add_filter('script_loader_tag', 'addDeferAttributeToScripts', 10, 2);

function _removeScriptVersion( $src ){
  $parts = explode( '?ver', $src );
  $parts = explode( '?v', $parts[0]);
  return $parts[0];
}
add_filter( 'script_loader_src', '_removeScriptVersion', 15, 1 );
add_filter( 'style_loader_src', '_removeScriptVersion', 15, 1 );