<?php declare(strict_types=1);

namespace Tribe\Project\Templates\Components\blocks\logos;

use Tribe\Libs\Utils\Markup_Utils;
use Tribe\Project\Blocks\Types\Logos\Logos;
use Tribe\Project\Templates\Components\Abstract_Controller;
use Tribe\Project\Templates\Components\container\Container_Controller;
use Tribe\Project\Templates\Components\content_block\Content_Block_Controller;
use Tribe\Project\Templates\Components\Deferred_Component;
use Tribe\Project\Templates\Components\image\Image_Controller;
use Tribe\Project\Templates\Components\link\Link_Controller;
use Tribe\Project\Templates\Components\text\Text_Controller;

class Logos_Block_Controller extends Abstract_Controller {

	public const ATTRS             = 'attrs';
	public const CLASSES           = 'classes';
	public const CONTAINER_CLASSES = 'container_classes';
	public const CONTENT_CLASSES   = 'content_classes';
	public const CTA               = 'cta';
	public const DESCRIPTION       = 'description';
	public const LEADIN            = 'leadin';
	public const LOGOS             = 'logos';
	public const TITLE             = 'title';

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
	 * @var string[]
	 */
	private array $content_classes;

	/**
	 * @var string[]
	 */
	private array $cta;

	/**
	 * @see Logos::get_logos_section()
	 *
	 * @var mixed[]
	 */
	private array $logos;
	private string $description;
	private string $leadin;
	private string $title;

	public function __construct( array $args = [] ) {
		$args = $this->parse_args( $args );

		$this->attrs             = (array) $args[ self::ATTRS ];
		$this->classes           = (array) $args[ self::CLASSES ];
		$this->container_classes = (array) $args[ self::CONTAINER_CLASSES ];
		$this->content_classes   = (array) $args[ self::CONTENT_CLASSES ];
		$this->cta               = (array) $args[ self::CTA ];
		$this->description       = (string) $args[ self::DESCRIPTION ];
		$this->leadin            = (string) $args[ self::LEADIN ];
		$this->logos             = (array) $args[ self::LOGOS ];
		$this->title             = (string) $args[ self::TITLE ];
	}

	public function get_classes(): string {
		return Markup_Utils::class_attribute( $this->classes );
	}

	public function get_attrs(): string {
		return Markup_Utils::concat_attrs( $this->attrs );
	}

	public function get_container_classes(): string {
		return Markup_Utils::class_attribute( $this->container_classes );
	}

	public function get_content_classes(): string {
		$this->content_classes[] = sprintf( 'b-logos--count-%d', count( $this->logos ) );

		return Markup_Utils::class_attribute( $this->content_classes );
	}

	public function get_header_args(): array {
		if ( empty( $this->title ) && empty( $this->description ) ) {
			return [];
		}

		return [
			Content_Block_Controller::TAG     => 'header',
			Content_Block_Controller::LEADIN  => $this->get_leadin(),
			Content_Block_Controller::TITLE   => $this->get_title(),
			Content_Block_Controller::CONTENT => $this->get_content(),
			Content_Block_Controller::CTA     => $this->get_cta(),
			Content_Block_Controller::LAYOUT  => Content_Block_Controller::LAYOUT_CENTER,
			Content_Block_Controller::CLASSES => [
				'c-block__content-block',
				'c-block__header',
				'b-logos__header',
			],
		];
	}

	public function get_logos(): array {
		$component_args = [];
		if ( empty( $this->logos ) ) {
			return [];
		}
		foreach ( $this->logos as $logo ) {
			// Don't add a logo if there's no image set in the block.
			if ( empty( $logo[ Logos::LOGO_IMAGE ] ) ) {
				continue;
			}
			$image_args = [
				Image_Controller::IMG_ID       => (int) $logo[ Logos::LOGO_IMAGE ],
				Image_Controller::USE_LAZYLOAD => true,
				Image_Controller::CLASSES      => [ 'b-logo__figure' ],
				Image_Controller::IMG_CLASSES  => [ 'b-logo__img' ],
				Image_Controller::SRC_SIZE     => 'large',
				Image_Controller::SRCSET_SIZES => [ 'medium', 'large' ],
			];

			$link = wp_parse_args( $logo[ Logos::LOGO_LINK ], [
				'title'  => '',
				'url'    => '',
				'target' => '',
			] );

			if ( ! empty( $logo[ Logos::LOGO_LINK ] ) ) {
				$image_args[ Image_Controller::LINK_URL ]     = $link['url'];
				$image_args[ Image_Controller::LINK_TARGET ]  = $link['target'];
				$image_args[ Image_Controller::LINK_TITLE ]   = $link['title'];
				$image_args[ Image_Controller::LINK_CLASSES ] = [ 'b-logo__link' ];
			}
			$component_args[] = $image_args;
		}

		return $component_args;
	}

	protected function defaults(): array {
		return [
			self::ATTRS             => [],
			self::CLASSES           => [],
			self::CONTAINER_CLASSES => [],
			self::CONTENT_CLASSES   => [],
			self::CTA               => [],
			self::DESCRIPTION       => '',
			self::LEADIN            => '',
			self::LOGOS             => [],
			self::TITLE             => '',
		];
	}

	protected function required(): array {
		return [
			self::CLASSES           => [ 'c-block', 'b-logos' ],
			self::CONTAINER_CLASSES => [ 'l-container', 'b-logos__container' ],
			self::CONTENT_CLASSES   => [ 'b-logos__list' ],
		];
	}

	private function get_leadin(): Deferred_Component {
		return defer_template_part( 'components/text/text', null, [
			Text_Controller::CLASSES => [
				'c-block__leadin',
				'b-logos__leadin',
				'h6',
			],
			Text_Controller::CONTENT => $this->leadin ?? '',
		] );
	}

	private function get_title(): Deferred_Component {
		return defer_template_part( 'components/text/text', null, [
			Text_Controller::TAG     => 'h2',
			Text_Controller::CLASSES => [
				'c-block__title',
				'b-logos__title',
				'h3',
			],
			Text_Controller::CONTENT => $this->title ?? '',
		] );
	}

	private function get_content(): Deferred_Component {
		return defer_template_part( 'components/container/container', null, [
			Container_Controller::CLASSES => [
				'c-block__description',
				'b-logos__description',
				't-sink',
				's-sink',
			],
			Container_Controller::CONTENT => $this->description ?? '',
		] );
	}

	private function get_cta(): Deferred_Component {
		$cta = wp_parse_args( $this->cta, [
			'content'        => '',
			'url'            => '',
			'target'         => '',
			'add_aria_label' => false,
			'aria_label'     => '',
		] );

		return defer_template_part( 'components/link/link', null, [
			Link_Controller::URL            => $cta['url'],
			Link_Controller::CONTENT        => $cta['content'] ?: $cta['url'],
			Link_Controller::TARGET         => $cta['target'],
			Link_Controller::ADD_ARIA_LABEL => $cta['add_aria_label'],
			Link_Controller::ARIA_LABEL     => $cta['aria_label'],
			Link_Controller::CLASSES        => [
				'c-block__cta-link',
				'a-btn',
				'a-btn--has-icon-after',
				'icon-arrow-right',
			],
		] );
	}

}
