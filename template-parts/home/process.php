<?php
/**
 * Homepage process — from home.html #proces.
 *
 * @package AC-Tech
 */

$header = ac_tech_get_home_process_header();
$steps  = ac_tech_get_home_process_steps();
?>
<section class="ac-tech-home-section ac-tech-home-process" id="proces" aria-labelledby="ac-tech-home-process-title">
	<div class="ac-tech-container">
		<div class="ac-tech-home-section__header ac-tech-home-section__header--center">
			<h2 id="ac-tech-home-process-title" class="ac-tech-home-section__title"><?php echo esc_html( $header['title'] ); ?></h2>
			<p class="ac-tech-home-section__lead"><?php echo esc_html( $header['text'] ); ?></p>
		</div>

		<ol class="ac-tech-home-process__grid">
			<?php foreach ( $steps as $step ) : ?>
				<li class="ac-tech-home-process__step">
					<div class="ac-tech-home-process__number<?php echo ! empty( $step['is_final'] ) ? ' ac-tech-home-process__number--final' : ''; ?>">
						<?php echo esc_html( $step['step'] ); ?>
					</div>
					<h3 class="ac-tech-home-process__title"><?php echo esc_html( $step['title'] ); ?></h3>
					<p class="ac-tech-home-process__text"><?php echo esc_html( $step['text'] ); ?></p>
				</li>
			<?php endforeach; ?>
		</ol>
	</div>
</section>
