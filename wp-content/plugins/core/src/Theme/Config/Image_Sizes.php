<?php declare(strict_types=1);

namespace Tribe\Project\Theme\Config;

class Image_Sizes {

	public const SQUARE_XSMALL          = 'square-xsmall';
	public const SQUARE_MEDIUM          = 'square-medium';
	public const SQUARE_LARGE           = 'square-large';
	public const SIXTEEN_NINE           = 'sixteen-nine';
	public const SIXTEEN_NINE_SMALL     = 'sixteen-nine-small';
	public const SIXTEEN_NINE_LARGE     = 'sixteen-nine-large';
	public const CORE_FULL              = 'core-full';
	public const CORE_MOBILE            = 'core-mobile';
	public const COMPONENT_CARD         = 'component-card';
	public const FOUR_THREE             = 'four-three';
	public const FOUR_THREE_SMALL       = 'four-three-small';
	public const FOUR_THREE_LARGE       = 'four-three-large';
	public const SOCIAL_SHARE_OPENGRAPH = 'social-share-opengraph';
	public const SOCIAL_SHARE_TWITTER   = 'social-share-twitter';

	/**
	 * @var array<string, int|bool>
	 */
	private array $sizes = [
		self::SQUARE_XSMALL          => [
			'width'  => 150,
			'height' => 150,
			'crop'   => true,
		],
		self::SQUARE_MEDIUM          => [
			'width'  => 376,
			'height' => 376,
			'crop'   => true,
		],
		self::SQUARE_LARGE           => [
			'width'  => 650,
			'height' => 650,
			'crop'   => true,
		],
		self::SIXTEEN_NINE_SMALL     => [
			'width'  => 680,
			'height' => 383,
			'crop'   => true,
		],
		self::SIXTEEN_NINE           => [
			'width'  => 1280,
			'height' => 720,
			'crop'   => true,
		],
		self::SIXTEEN_NINE_LARGE     => [
			'width'  => 1920,
			'height' => 1080,
			'crop'   => true,
		],
		self::CORE_FULL              => [
			'width'  => 1600,
			'height' => 0,
			'crop'   => true,
		],
		self::CORE_MOBILE            => [
			'width'  => 1152,
			'height' => 0,
			'crop'   => true,
		],
		self::COMPONENT_CARD         => [
			'width'  => 600,
			'height' => 400,
			'crop'   => true,
		],
		self::FOUR_THREE_SMALL       => [
			'width'  => 375,
			'height' => 281,
			'crop'   => true,
		],
		self::FOUR_THREE             => [
			'width'  => 768,
			'height' => 576,
			'crop'   => true,
		],
		self::FOUR_THREE_LARGE       => [
			'width'  => 1536,
			'height' => 1152,
			'crop'   => true,
		],
		self::SOCIAL_SHARE_OPENGRAPH => [
			'width'  => 1200,
			'height' => 630,
			'crop'   => true,
		],
		self::SOCIAL_SHARE_TWITTER   => [
			'width'  => 1024,
			'height' => 512,
			'crop'   => true,
		],
	];

	/**
	 * @action after_setup_theme
	 */
	public function register_sizes(): void {
		foreach ( $this->sizes as $key => $attributes ) {
			add_image_size( $key, $attributes['width'], $attributes['height'], $attributes['crop'] );
		}
	}

}
