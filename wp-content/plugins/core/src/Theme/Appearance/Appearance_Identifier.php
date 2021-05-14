<?php declare(strict_types=1);

namespace Tribe\Project\Theme\Appearance;

use Tribe\Libs\ACF\Traits\With_Get_Field;
use Tribe\Project\Object_Meta\Appearance\Appearance;

/**
 * Identify the current appearance configuration.
 *
 * @package Tribe\Project\Theme\Appearance
 */
class Appearance_Identifier {

	use With_Get_Field;

	protected Appearance_Class_Manager $class_manager;

	public function __construct( Appearance_Class_Manager $class_manager ) {
		$this->class_manager = $class_manager;
	}

	/**
	 * Get the current theme, first checking if it's overridden at the post level.
	 *
	 * @return string
	 */
	public function current_theme(): string {
		if ( is_singular() ) {
			$post_id       = get_the_ID() ?: 0;
			$is_overridden = $this->get( Appearance::PAGE_THEME_OVERRIDE, false, $post_id );
			$post_theme    = $this->get( Appearance::COLOR_THEME, '', $post_id );

			if ( $is_overridden && ! empty( $post_theme ) ) {
				return (string) $post_theme;
			}
		}

		return $this->current_global_theme();
	}

	/**
	 * Get the global theme set in Settings > General Settings.
	 *
	 * @return string
	 */
	public function current_global_theme(): string {
		return (string) $this->get( Appearance::COLOR_THEME, Appearance::COLOR_THEME_DEFAULT, 'option' );
	}

	/**
	 * Get the Light or Dark class depending on the selection.
	 *
	 * @return string The Light or Dark Class.
	 */
	public function get_body_class(): string {
		$hex = $this->current_theme();

		return $this->class_manager->get_class_from_hex( $hex );
	}
}