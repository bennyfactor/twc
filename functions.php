<?php
add_theme_support('post-thumbnails');


 ?>
<?php
add_action( 'init', 'create_my_post_types' );

function create_my_post_types() {
	register_post_type( 'gallo',
		array(
			'labels' => array(
				'name' => __( 'gallo' ),
				'singular_name' => __( 'gallo' )
			),
			'public' => true,
			'show_ui' => false,
			'rewrite' => array(
				'slug' => 'project',
				'with_front' => false
			),
			'has_archive' => false
		)
	);
		register_post_type( 'projects', array(
		'labels' => array(
			'name' => __('Projects'),
			'singular_name' => __('Project')
			),
		'public' => true,
		'show_ui' => true,
		'rewrite' => array(
			'slug' => 'project',
			'with_front' => false
			),
		'has_archive' => false
	) );
}

?>