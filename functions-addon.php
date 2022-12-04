<?php



/* ----------------------------------------------------------------------------*/
/* 1. add filters for post parent field on specific post type list (book in    */
/*    example) in the Wordpress Admin post list                                */
/* ----------------------------------------------------------------------------*/
add_filter( 'views_edit-book', 'wfa_add_filter_link' );
function wfa_add_filter_link( array $views ) {
	$link = wfa_get_post_parent_link_filter( str_replace("views_edit-","", current_action() ) );
    $views[ 'post_parent' ] = $link;
    return $views;
}
function wfa_get_post_parent_link_filter($post_type) {
	global $wpdb;
	$query = "SELECT COUNT(1) FROM {$wpdb->posts} WHERE post_parent = 0 AND post_type = %s AND post_status IN ('publish','draft','pending')";
	$count = $wpdb->get_var($wpdb->prepare($query, $post_type));
	$url = add_query_arg( array('bfilter'=>'parents','post_parent'=>0,'post_type'=>$post_type), 'edit.php' );
	return '<a href="'.esc_url($url).'" '.(wfa_is_filter_active()  ? ' class="current" aria-current="page"' : '').'>Post Parents ('.$count.')</a>';
}
function wfa_is_filter_active() {
    return (filter_input( INPUT_GET, 'bfilter' ) ==='parents');
}
function wfa_make_post_parent_public_qv() {
    global $pagenow;
    if ( is_admin() && $pagenow == 'edit.php' )
        $GLOBALS['wp']->add_query_var( 'post_parent' );
}
add_action( 'init', 'wfa_make_post_parent_public_qv' );
/* ----------------------------------------------------------------------------*/



?>
