<?php declare(strict_types=1);

namespace Tribe\Project\Blocks\Types\Quote;

use Tribe\Project\Blocks\Types\Base_Model;
use Tribe\Project\Templates\Components\blocks\quote\Quote_Block_Controller;

class Quote_Model extends Base_Model {

	/**
	 * @return array
	 */
	public function get_data(): array {
		$group_citation_field = $this->get( Quote::GROUP_CITE, [] );

		return [
			Quote_Block_Controller::ATTRS      => $this->get_attrs(),
			Quote_Block_Controller::CLASSES    => $this->get_classes(),
			Quote_Block_Controller::CITE_TITLE => $group_citation_field[ Quote::CITE_TITLE ] ?? '',
			Quote_Block_Controller::CITE_NAME  => $group_citation_field[ Quote::CITE_NAME ] ?? '',
			Quote_Block_Controller::CITE_IMAGE => $group_citation_field[ Quote::CITE_IMAGE ] ?? 0,
			Quote_Block_Controller::QUOTE_TEXT => $this->get( Quote::QUOTE, '' ),
			Quote_Block_Controller::MEDIA      => $this->get( Quote::IMAGE, 0 ),
			Quote_Block_Controller::LAYOUT     => $this->get( Quote::LAYOUT, Quote::MEDIA_OVERLAY ),
		];
	}

}
