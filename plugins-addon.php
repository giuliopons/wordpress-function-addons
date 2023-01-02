<?php


// add url to settings in list of plugins
add_filter( 'plugin_action_links_YOURPLUGINFOLDER/index.php', 'blpwp_settings_link' );
function blpwp_settings_link($links ) {
	
	$url = esc_url( add_query_arg(
		'page',
		'YOURPLUGINSETTINGPAGESLUG',
		get_admin_url() . 'options-general.php'
	) );
	
	$settings_link = "<a href='$url'>" . __( 'Settings' ) . '</a>';
	
	array_push(
		$links,
		$settings_link
	);
	return $links;
}

