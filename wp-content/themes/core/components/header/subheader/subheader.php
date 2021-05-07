<?php
declare( strict_types=1 );

use \Tribe\Project\Templates\Components\header\subheader\Subheader_Controller;

/**
 * @var array $args Arguments passed to the template
 */
// phpcs:ignore VariableAnalysis.CodeAnalysis.VariableAnalysis.UndefinedVariable
$c = Subheader_Controller::factory( $args );
?>

<header <?php echo $c->get_classes(); ?> <?php echo $c->get_attrs(); ?>>		
	<div <?php echo $c->get_container_classes(); ?>>

		<?php if ( ! empty( $c->get_image_args() ) ) { ?>
			<div <?php echo $c->get_media_classes(); ?> >		
				<?php get_template_part(
					'components/image/image',
					null,
					$c->get_image_args()
				); ?>
			</div>
		<?php } ?>
		
		<div <?php echo $c->get_content_classes(); ?>>

			<?php $c->render_breadcrumbs(); ?>
		
			<?php get_template_part( 'components/text/text', null, $c->get_title_args() ); ?>
		</div>
		
	</div>	

</header>
