<?php declare(strict_types=1);

namespace Tribe\Project\Templates\Components\header\subheader;

use Tribe\Libs\Utils\Markup_Utils;
use Tribe\Project\Templates\Components\Abstract_Controller;
use Tribe\Project\Templates\Components\breadcrumbs\Breadcrumbs_Controller;
use Tribe\Project\Templates\Components\image\Image_Controller;
use Tribe\Project\Templates\Components\text\Text_Controller;
use Tribe\Project\Templates\Components\Traits\Page_Title;
use Tribe\Project\Templates\Models\Breadcrumb;
use Tribe\Project\Theme\Config\Image_Sizes;

class Subheader_Controller extends Abstract_Controller {

	use Page_Title;

	public const CLASSES           = 'classes';
	public const ATTRS             = 'attrs';
	public const CONTAINER_CLASSES = 'container_classes';
	public const MEDIA_CLASSES     = 'media_classes';
	public const CONTENT_CLASSES   = 'content_classes';
	public const TITLE             = 'title';
	public const DESCRIPTION       = 'description';
	public const HERO_IMAGE_ID     = 'hero_image';

	private array $classes;
	private array $attrs;
	private array $container_classes;
	private array $media_classes;
	private array $content_classes;
	private string $title;
	private string $description;
	private ?int $hero_image_id;

	public function __construct( array $args = [] ) {
		$args = $this->parse_args( $args );

		$this->classes           = (array) $args[ self::CLASSES ];
		$this->attrs             = (array) $args[ self::ATTRS ];
		$this->container_classes = (array) $args[ self::CONTAINER_CLASSES ];
		$this->media_classes     = (array) $args[ self::MEDIA_CLASSES ];
		$this->content_classes   = (array) $args[ self::CONTENT_CLASSES ];
		$this->title             = (string) ( $args[ self::TITLE ] ?? '' );
		$this->description       = (string) ( $args[ self::DESCRIPTION ] ?? '' );
		$this->hero_image_id     = (int) ( $args[ self::HERO_IMAGE_ID ] ?? null );
	}

	protected function defaults(): array {
		return [
			self::CLASSES           => [],
			self::ATTRS             => [],
			self::CONTAINER_CLASSES => [],
			self::MEDIA_CLASSES     => [],
			self::CONTENT_CLASSES   => [],
		];
	}

	protected function required(): array {
		return [
			self::CONTAINER_CLASSES => [ 'l-container' ],
			self::MEDIA_CLASSES     => [ 'c-subheader__media' ],
			self::CONTENT_CLASSES   => [ 'c-subheader__content' ],
			self::CLASSES           => [ 'c-subheader' ],
		];
	}

	public function get_classes(): string {
		if ( ! empty( $this->hero_image_id ) ) {
			$this->classes[] = 'c-subheader--has-image';
		}

		return Markup_Utils::class_attribute( $this->classes );
	}

	public function get_attrs(): string {
		return Markup_Utils::concat_attrs( $this->attrs );
	}

	public function get_container_classes(): string {
		return Markup_Utils::class_attribute( $this->container_classes );
	}

	public function get_media_classes(): string {
		return Markup_Utils::class_attribute( $this->media_classes );
	}

	public function get_content_classes(): string {
		return Markup_Utils::class_attribute( $this->content_classes );
	}

	public function get_title_args(): array {
		return [
			Text_Controller::TAG     => 'h1',
			Text_Controller::CLASSES => [ 'page-title', 'h1', 'c-subheader__title' ],
			Text_Controller::CONTENT => $this->title,
		];
	}

	public function get_description_args(): array {
		return [
			Text_Controller::TAG     => 'p',
			Text_Controller::CLASSES => [ 'c-subheader__description' ],
			Text_Controller::CONTENT => $this->description,
		];
	}

	public function get_image_args(): array {
		if (  empty( $this->hero_image_id ) ) {
			return [];
		}

		return [
			Image_Controller::IMG_ID       => (int) $this->hero_image_id,
			Image_Controller::AUTO_SHIM    => false,
			Image_Controller::USE_LAZYLOAD => true,
			Image_Controller::CLASSES      => [ 'c-image--overlay', 'c-image--object-fit' ],
			Image_Controller::IMG_CLASSES  => [ 'c-subheader__media__image' ],
			Image_Controller::SRC_SIZE     => Image_Sizes::SIXTEEN_NINE,
			Image_Controller::SRCSET_SIZES => [
				Image_Sizes::SIXTEEN_NINE,
				Image_Sizes::SIXTEEN_NINE_SMALL,
			],
		];
	}


	public function get_breadcrumbs_args(): array {
		$name = get_bloginfo( 'name' );
		$url  = get_bloginfo( 'url' );

		$breadcrumbs = [
			new Breadcrumb( $url, __( 'Home', 'tribe' ) ),
		];

		$ancestors = (array) get_post_ancestors( get_the_ID() );

		$ancestors = array_reverse( $ancestors, true );

		foreach ( $ancestors as $ancestor ) {
			$ancestor_url	= get_the_permalink( $ancestor );
			$ancestor_label = get_the_title( $ancestor );

			$breadcrumbs[] = new Breadcrumb( $ancestor_url, $ancestor_label );
		}

		return [
			Breadcrumbs_Controller::BREADCRUMBS  => $breadcrumbs,
			Breadcrumbs_Controller::MAIN_CLASSES => [ 'u-sep-arrow' ],
		];
	}

}
