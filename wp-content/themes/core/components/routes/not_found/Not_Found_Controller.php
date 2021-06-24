<?php declare(strict_types=1);

namespace Tribe\Project\Templates\Components\routes\not_found;

use Tribe\Project\Templates\Components\Abstract_Controller;
use Tribe\Project\Templates\Components\search_form\Search_Form_Controller;
use Tribe\Project\Templates\Components\sidebar\Sidebar_Controller;

class Not_Found_Controller extends Abstract_Controller {

	/**
	 * @var int|string
	 */
	private $sidebar_id = '';

	/**
	 * Render the header component
	 *
	 * Bypasses the get_header() function to
	 * load our component instead of header.php
	 *
	 * @return void
	 */
	public function render_header(): void {
		do_action( 'get_header', null );
		get_template_part( 'components/document/header/header', 'index' );
	}


	/**
	 * Render the sidebar component
	 *
	 * Bypasses the get_sidebar() function to
	 * load our component instead of sidebar.php
	 *
	 * @return void
	 */
	public function render_sidebar(): void {
		do_action( 'get_sidebar', null );
		get_template_part(
			'components/sidebar/sidebar',
			'index',
			[ Sidebar_Controller::SIDEBAR_ID => $this->sidebar_id ]
		);
	}

	/**
	 * Render the footer component
	 *
	 * Bypasses the get_footer() function to
	 * load our component instead of footer.php
	 *
	 * @return void
	 */
	public function render_footer(): void {
		do_action( 'get_footer', null );
		get_template_part( 'components/document/footer/footer', 'index' );
	}

	/**
	 * @return array
	 */
	public function get_search_form_args(): array {
		return [
			Search_Form_Controller::FORM_ID     => uniqid( 's-' ),
			Search_Form_Controller::PLACEHOLDER => __( 'Search', 'tribe' ),
		];
	}

}
