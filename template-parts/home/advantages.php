<?php
/**
 * Homepage advantages — from home.html #avantaje.
 *
 * @package AC-Tech
 */

$header = ac_tech_get_home_advantages_header();
$items  = ac_tech_get_home_advantages();
?>
<section class="ac-tech-home-section ac-tech-home-advantages" id="avantaje" aria-labelledby="ac-tech-home-advantages-title">
	<div class="ac-tech-container">
		<div class="ac-tech-home-section__header ac-tech-home-section__header--center">
			<h2 id="ac-tech-home-advantages-title" class="ac-tech-home-section__title"><?php echo esc_html( $header['title'] ); ?></h2>
			<p class="ac-tech-home-section__lead"><?php echo esc_html( $header['text'] ); ?></p>
		</div>

		<ul class="ac-tech-home-advantages__grid">
			<?php foreach ( $items as $item ) : ?>
				<li class="ac-tech-home-advantage-card">
					<div class="ac-tech-home-advantage-card__icon">
						<?php ac_tech_icon( $item['icon'] ); ?>
					</div>
					<h3 class="ac-tech-home-advantage-card__title"><?php echo esc_html( $item['title'] ); ?></h3>
					<p class="ac-tech-home-advantage-card__text"><?php echo esc_html( $item['text'] ); ?></p>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>
