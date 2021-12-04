<?php declare(strict_types=1);

namespace Tribe\Project\Templates\Components\blocks\section_nav;

use Tribe\Libs\Utils\Markup_Utils;
use Tribe\Project\Templates\Components\Abstract_Controller;
use \Tribe\Project\Templates\Components\section_nav\Section_Nav_Controller;

class Section_Nav_Block_Controller extends Abstract_Controller {

	public const ATTRS             = 'attrs';
	public const CLASSES           = 'classes';
	public const CONTAINER_CLASSES = 'container_classes';
	public const MENU_ID           = 'menu_id';
	public const MOBILE_LABEL      = 'mobile_label';
	public const MORE_LABEL        = 'more_label';
	public const DESKTOP_LABEL     = 'desktop_label';
	public const STICKY            = 'sticky';
	public const MOBILE_INIT_OPEN  = 'mobile_init_open';

	/**
	 * @var string[]
	 */
	private array $attrs;

	/**
	 * @var string[]
	 */
	private array $classes;

	/**
	 * @var string[]
	 */
	private array $container_classes;

	/**
	 * @var int
	 */
	private int $menu_id;

	/**
	 * @var string
	 */
	private string $mobile_label;

	/**
	 * @var string
	 */
	private string $more_label;

	/**
	 * @var string
	 */
	private string $desktop_label;

	/**
	 * @var bool
	 */
	private bool $sticky;

	/**
	 * @var bool
	 */
	private bool $mobile_init_open;

	public function __construct( array $args = [] ) {
		$args = $this->parse_args( $args );

		$this->attrs             = (array) $args[ self::ATTRS ];
		$this->classes           = (array) $args[ self::CLASSES ];
		$this->container_classes = (array) $args[ self::CONTAINER_CLASSES ];
		$this->menu_id           = (int) $args[ self::MENU_ID ];
		$this->mobile_label      = (string) $args[ self::MOBILE_LABEL ];
		$this->more_label        = (string) $args[ self::MORE_LABEL ];
		$this->desktop_label     = (string) $args[ self::DESKTOP_LABEL ];
		$this->sticky            = (bool) $args[ self::STICKY ];
		$this->mobile_init_open  = (bool) $args[ self::MOBILE_INIT_OPEN ];
	}

	/**
	 * @return string
	 */
	public function get_attrs(): string {
		return Markup_Utils::concat_attrs( $this->attrs );
	}

	/**
	 * @return string
	 */
	public function get_classes(): string {
		return Markup_Utils::class_attribute( $this->classes );
	}

	/**
	 * @return string
	 */
	public function get_container_classes(): string {
		return Markup_Utils::class_attribute( $this->container_classes );
	}

	/**
	 * @return array
	 */
	public function get_section_nav_args(): array {
		return [
			Section_Nav_Controller::MENU             => $this->menu_id,
			Section_Nav_Controller::MOBILE_LABEL     => $this->mobile_label,
			Section_Nav_Controller::MORE_LABEL       => $this->more_label,
			Section_Nav_Controller::DESKTOP_LABEL    => $this->desktop_label,
			Section_Nav_Controller::STICKY           => $this->sticky,
			Section_Nav_Controller::MOBILE_INIT_OPEN => $this->mobile_init_open,

		];
	}

	/**
	 * @return array
	 */
	protected function defaults(): array {
		return [
			self::ATTRS             => [],
			self::CLASSES           => [],
			self::CONTAINER_CLASSES => [],
			self::MENU_ID           => 0,
			self::MOBILE_LABEL      => esc_html__( 'In this section', 'tribe' ),
			self::MORE_LABEL        => esc_html__( 'More', 'tribe' ),
			self::DESKTOP_LABEL     => '',
			self::STICKY            => false,
			self::MOBILE_INIT_OPEN  => false,
		];
	}

	/**
	 * @return array
	 */
	protected function required(): array {
		return [
			self::CLASSES           => [ 'c-block', 'b-section-nav' ],
			self::CONTAINER_CLASSES => [ 'b-section-nav__container', 'l-container' ],
		];
	}

}
