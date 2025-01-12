<?php declare(strict_types=1);

namespace Tribe\Project\Blocks\Types\Lead_Form;

use Tribe\Project\Blocks\Fields\Cta_Field;
use Tribe\Project\Blocks\Types\Base_Model;
use Tribe\Project\Templates\Components\blocks\lead_form\Lead_Form_Block_Controller;
use Tribe\Project\Templates\Components\link\Link_Controller;

class Lead_Form_Model extends Base_Model {

	/**
	 * @return array
	 */
	public function get_data(): array {
		return [
			Lead_Form_Block_Controller::ATTRS       => $this->get_attrs(),
			Lead_Form_Block_Controller::CLASSES     => $this->get_classes(),
			Lead_Form_Block_Controller::LAYOUT      => $this->get( Lead_Form::LAYOUT, Lead_Form::LAYOUT_BOTTOM ),
			Lead_Form_Block_Controller::WIDTH       => $this->get( Lead_Form::WIDTH, Lead_Form::WIDTH_GRID ),
			Lead_Form_Block_Controller::TITLE       => $this->get( Lead_Form::TITLE, '' ),
			Lead_Form_Block_Controller::LEADIN      => $this->get( Lead_Form::LEAD_IN, '' ),
			Lead_Form_Block_Controller::DESCRIPTION => $this->get( Lead_Form::DESCRIPTION, '' ),
			Lead_Form_Block_Controller::CTA         => $this->get_cta_args(),
			Lead_Form_Block_Controller::BACKGROUND  => $this->get( Lead_Form::BACKGROUND, Lead_Form::BACKGROUND_LIGHT ),
			Lead_Form_Block_Controller::FORM_FIELDS => $this->get( Lead_Form::FORM_FIELDS, Lead_Form::FORM_STACKED ),

		];
	}

	/**
	 * @return array
	 */
	private function get_cta_args(): array {
		$cta  = $this->get( Cta_Field::GROUP_CTA, [] );
		$link = wp_parse_args( $cta['link'] ?? [], [
			'title'  => '',
			'url'    => '',
			'target' => '',
		] );

		return [
			Link_Controller::CONTENT        => $link['title'],
			Link_Controller::URL            => $link['url'],
			Link_Controller::TARGET         => $link['target'],
			Link_Controller::ADD_ARIA_LABEL => $cta['add_aria_label'] ?? false,
			Link_Controller::ARIA_LABEL     => $cta['aria_label'] ?? '',
		];
	}

}
