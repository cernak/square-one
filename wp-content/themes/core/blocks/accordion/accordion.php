<?php declare(strict_types=1);

use Tribe\Project\Blocks\Types\Accordion\Accordion_Model;

/**
 * @var array $args ACF block data.
 */
$model = new Accordion_Model( $args['block'] );

get_template_part(
	'components/blocks/accordion/accordion',
	null,
	$model->get_data()
);
