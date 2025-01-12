<?php declare(strict_types=1);

namespace Tribe\Project\Templates\Components\blocks\lead_form;

use Tribe\Libs\Utils\Markup_Utils;
use \Tribe\Project\Blocks\Types\Lead_Form\Lead_Form as Lead_Form_Block;
use Tribe\Project\Templates\Components\Abstract_Controller;
use Tribe\Project\Templates\Components\container\Container_Controller;
use Tribe\Project\Templates\Components\content_block\Content_Block_Controller;
use Tribe\Project\Templates\Components\Deferred_Component;
use Tribe\Project\Templates\Components\link\Link_Controller;
use Tribe\Project\Templates\Components\text\Text_Controller;

class Lead_Form_Block_Controller extends Abstract_Controller {

	public const ATTRS             = 'attrs';
	public const BACKGROUND        = 'background';
	public const CLASSES           = 'classes';
	public const CONTAINER_CLASSES = 'container_classes';
	public const CTA               = 'cta';
	public const DESCRIPTION       = 'description';
	public const FORM_CLASSES      = 'form_classes';
	public const FORM_FIELDS       = 'form_fields';
	public const LAYOUT            = 'layout';
	public const LEADIN            = 'leadin';
	public const TITLE             = 'title';
	public const WIDTH             = 'width';

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
	private array $cta;

	/**
	 * @var string[]
	 */
	private array $form_classes;
	private string $background;
	private string $description;
	private string $form_fields;
	private string $layout;
	private string $leadin;
	private string $title;
	private string $width;

	public function __construct( array $args = [] ) {
		$args = $this->parse_args( $args );

		$this->attrs             = (array) $args[ self::ATTRS ];
		$this->background        = (string) $args[ self::BACKGROUND ];
		$this->classes           = (array) $args[ self::CLASSES ];
		$this->container_classes = (array) $args[ self::CONTAINER_CLASSES ];
		$this->cta               = (array) $args[ self::CTA ];
		$this->description       = (string) $args[ self::DESCRIPTION ];
		$this->form_classes      = (array) $args[ self::FORM_CLASSES ];
		$this->form_fields       = (string) $args[ self::FORM_FIELDS ];
		$this->layout            = (string) $args[ self::LAYOUT ];
		$this->leadin            = (string) $args[ self::LEADIN ];
		$this->title             = (string) $args[ self::TITLE ];
		$this->width             = (string) $args[ self::WIDTH ];
	}

	public function get_classes(): string {
		$this->classes[] = 'b-lead-form--layout-' . $this->layout;
		$this->classes[] = 'b-lead-form--width-' . $this->width;

		// CASE: Full Width and Background Dark
		if ( $this->width === Lead_Form_Block::WIDTH_FULL && $this->background === Lead_Form_Block::BACKGROUND_DARK ) {
			$this->classes[] = 't-theme--light';
		}

		if ( $this->width === Lead_Form_Block::WIDTH_GRID ) {
			$this->classes[] = 'l-container';
		}

		if ( $this->width === Lead_Form_Block::WIDTH_FULL ) {
			$this->classes[] = 'c-block--full-bleed';
		}

		return Markup_Utils::class_attribute( $this->classes );
	}

	public function get_attrs(): string {
		return Markup_Utils::concat_attrs( $this->attrs );
	}

	public function get_container_classes(): string {
		if ( $this->width === Lead_Form_Block::WIDTH_FULL ) {
			$this->container_classes[] = 'l-container';
		}

		// CASE: Grid Width and Background Dark
		if ( $this->width === Lead_Form_Block::WIDTH_GRID && $this->background === Lead_Form_Block::BACKGROUND_DARK ) {
			$this->container_classes[] = 't-theme--light';
		}

		return Markup_Utils::class_attribute( $this->container_classes );
	}

	public function get_form_classes(): string {
		// CASE: Inline Forms
		if ( $this->form_fields === Lead_Form_Block::FORM_INLINE ) {
			$this->form_classes[] = 'gform_inline';
		}

		return Markup_Utils::class_attribute( $this->form_classes );
	}

	public function get_header_args(): array {
		if ( empty( $this->title ) && empty( $this->description ) ) {
			return [];
		}

		return [
			Content_Block_Controller::TAG     => 'header',
			Content_Block_Controller::LAYOUT  => $this->layout === Lead_Form_Block::LAYOUT_BOTTOM ? Content_Block_Controller::LAYOUT_CENTER : Content_Block_Controller::LAYOUT_LEFT,
			Content_Block_Controller::LEADIN  => $this->get_leadin(),
			Content_Block_Controller::TITLE   => $this->get_title(),
			Content_Block_Controller::CONTENT => $this->get_content(),
			Content_Block_Controller::CTA     => $this->get_cta(),
			Content_Block_Controller::CLASSES => [
				'c-block__content-block',
				'c-block__header',
				'b-lead-form__content',
			],
		];
	}

	public function get_form(): string {
		if ( ! function_exists( 'gravity_form' ) ) {
			return '';
		}

		// TODO: turn this into a filterable thing
		$template = [
			[ 'gravityforms/form', [] ],
		];

		return sprintf( '<InnerBlocks template="%s" templateLock="all" />', esc_attr( wp_json_encode( $template ) ) );
	}

	protected function defaults(): array {
		return [
			self::ATTRS             => [],
			self::BACKGROUND        => Lead_Form_Block::BACKGROUND_LIGHT,
			self::CLASSES           => [],
			self::CONTAINER_CLASSES => [],
			self::CTA               => [],
			self::DESCRIPTION       => '',
			self::FORM_CLASSES      => [],
			self::FORM_FIELDS       => Lead_Form_Block::FORM_STACKED,
			self::LAYOUT            => Lead_Form_Block::LAYOUT_BOTTOM,
			self::LEADIN            => '',
			self::TITLE             => '',
			self::WIDTH             => Lead_Form_Block::WIDTH_GRID,
		];
	}

	protected function required(): array {
		return [
			self::CONTAINER_CLASSES => [ 'b-lead-form__container' ],
			self::FORM_CLASSES      => [ 'b-lead-form__form' ],
			self::CLASSES           => [ 'c-block', 'b-lead-form' ],
		];
	}

	private function get_leadin(): Deferred_Component {
		return defer_template_part( 'components/text/text', null, [
			Text_Controller::CLASSES => [
				'c-block__leadin',
				'b-lead-form__leadin',
			],
			Text_Controller::CONTENT => $this->leadin ?? '',
		] );
	}

	private function get_title(): Deferred_Component {
		return defer_template_part( 'components/text/text', null, [
			Text_Controller::TAG     => 'h2',
			Text_Controller::CLASSES => [
				'c-block__title',
				'b-lead-form__title',
				'h3',
			],
			Text_Controller::CONTENT => $this->title ?? '',
		] );
	}

	private function get_content(): Deferred_Component {
		return defer_template_part( 'components/container/container', null, [
			Container_Controller::CLASSES => [
				'c-block__description',
				'b-lead-form__description',
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
