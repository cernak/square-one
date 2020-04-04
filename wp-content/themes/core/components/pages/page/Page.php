<?php
declare( strict_types=1 );

namespace Tribe\Project\Templates\Components\Pages;

use Tribe\Project\Templates\Components\Context;

class Page extends Context {
	public const HEADER      = 'header';
	public const SUBHEADER   = 'subheader';
	public const SIDEBAR     = 'sidebar';
	public const FOOTER      = 'footer';
	public const COMMENTS    = 'comments';
	public const BREADCRUMBS = 'breadcrumbs';
	public const PAGINATION  = 'pagination';
	public const POST        = 'post';

	protected $path = __DIR__ . '/page.twig';

	protected $properties = [
		self::HEADER      => [
			self::DEFAULT => '',
		],
		self::SUBHEADER   => [
			self::DEFAULT => '',
		],
		self::SIDEBAR     => [
			self::DEFAULT => '',
		],
		self::FOOTER      => [
			self::DEFAULT => '',
		],
		self::COMMENTS    => [
			self::DEFAULT => '',
		],
		self::BREADCRUMBS => [
			self::DEFAULT => '',
		],
		self::PAGINATION  => [
			self::DEFAULT => '',
		],
		self::POST        => [
			self::DEFAULT => [
				'content'        => '',
				'permalink'      => '',
				'featured_image' => '',
			],
		],
	];
}
