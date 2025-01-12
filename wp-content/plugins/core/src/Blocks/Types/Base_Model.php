<?php declare(strict_types=1);

namespace Tribe\Project\Blocks\Types;

abstract class Base_Model {

	/**
	 * @var mixed[]
	 */
	protected array $data;

	protected string $mode;
	protected string $name;
	protected string $classes;
	protected string $anchor;

	abstract public function get_data(): array;

	/**
	 * Base_Controller constructor.
	 *
	 * @param mixed[] $block
	 */
	public function __construct( array $block ) {
		$this->mode    = $block['mode'] ?? 'preview';
		$this->data    = $block['data'] ?? [];
		$this->name    = $block['name'] ? str_replace( 'acf/', '', $block['name'] ) : '';
		$this->classes = $block['className'] ?? '';
		$this->anchor  = $block['anchor'] ?? '';
	}

	/**
	 * @param int|string $key
	 * @param mixed $default
	 *
	 * @return false|mixed
	 */
	public function get( $key, $default = false ) {
		$value = get_field( $key );

		//check to support nullable type properties in components.
		// ACF will in some cases return and empty string when we may want it to be null.
		// This allows us to always determine the default.
		return ! empty( $value )
			? $value
			: $default;
	}

	/**
	 * Get the "Additional Class Names" value from the block editor.
	 *
	 * @return array
	 */
	public function get_classes(): array {
		return explode( ' ', $this->classes );
	}

	/**
	 * Get any block attributes from the block editor.
	 *
	 * @return array|string[]
	 */
	protected function get_attrs(): array {
		$attrs = [];

		// "HTML Anchor" attribute
		if ( ! empty( $this->anchor ) ) {
			$attrs['id '] = $this->anchor;
		}

		return $attrs;
	}

}
