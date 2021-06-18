<?php declare(strict_types=1);

namespace Tribe\Project\Taxonomies\Featured;

use Tribe\Libs\Taxonomy\Taxonomy_Config;
use Tribe\Project\Post_Types\Post\Post;

class Config extends Taxonomy_Config {

	protected $taxonomy   = Featured::NAME;
	protected $post_types = [
		Post::NAME,
	];

	protected $version = 1;

	/**
	 * Arguments to pass when registering the taxonomy.
	 *
	 * @see register_extended_taxonomy() for accepted args.
	 *
	 * @return array
	 */
	public function get_args() {
		return [
			'hierarchical' => false,
			'exclusive'    => true,
			'meta_box'     => 'radio',
			'show_in_menu' => false,
			'show_ui'      => true,
			'public'       => false,
		];
	}

	public function get_labels() {
		return [
			'singular' => __( 'Featured', 'tribe' ),
			'plural'   => __( 'Featured', 'tribe' ),
			'slug'     => __( 'featured', 'tribe' ),
		];
	}

	public function default_terms() {
		return [
			'yes' => __( 'yes', 'tribe' ),
		];
	}

}
