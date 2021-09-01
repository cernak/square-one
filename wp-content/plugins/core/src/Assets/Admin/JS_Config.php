<?php declare(strict_types=1);

namespace Tribe\Project\Assets\Admin;

class JS_Config {

	private $data;

	public function get_data() {
		if ( ! isset( $this->data ) ) {
			$this->data = [
				'images_url'     => trailingslashit( get_stylesheet_directory_uri() ) . 'assets/img/admin/',
				'block_denylist' => apply_filters( 'tribe/project/blocks/denylist', [] ),
			];
			$this->data = apply_filters( 'core_admin_js_config', $this->data );
		}

		return $this->data;
	}

}
