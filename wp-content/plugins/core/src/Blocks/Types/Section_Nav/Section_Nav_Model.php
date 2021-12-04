<?php declare(strict_types=1);

namespace Tribe\Project\Blocks\Types\Section_Nav;

use \Tribe\Project\Blocks\Types\Base_Model;
use Tribe\Project\Templates\Components\blocks\section_nav\Section_Nav_Block_Controller;

/**
 * Class Section_Nav_Model
 *
 * Responsible for mapping values from the block to arguments
 * for the component
 */
class Section_Nav_Model extends Base_Model {

	public function get_data(): array {
		return [
			Section_Nav_Block_Controller::ATTRS            => $this->get_attrs(),
			Section_Nav_Block_Controller::CLASSES          => $this->get_classes(),
			Section_Nav_Block_Controller::MENU_ID          => $this->get( Section_Nav::MENU, 0 ),
			Section_Nav_Block_Controller::MOBILE_LABEL     => $this->get( Section_Nav::MOBILE_LABEL, '' ),
			Section_Nav_Block_Controller::MORE_LABEL       => $this->get( Section_Nav::MORE_LABEL, '' ),
			Section_Nav_Block_Controller::DESKTOP_LABEL    => $this->get( Section_Nav::DESKTOP_LABEL, '' ),
			Section_Nav_Block_Controller::STICKY           => $this->get( Section_Nav::STICKY, false ),
			Section_Nav_Block_Controller::MOBILE_INIT_OPEN => $this->get( Section_Nav::MOBILE_INIT_OPEN, false ),
		];
	}

}