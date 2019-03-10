<?php
/*
* contacto.php
* @package WordPress
* @subpackage villabrochero
* @since villabrochero 1.0
* Text Domain: villabrochero
*/
?>
<?php get_header();?>
	<div class="sidebar--main">
<?php
get_sidebar();

// Para resetear todo el loop
rewind_posts();

// El loop que mostrará todos los post -->
if ( have_posts() ) : ?>
		<div class="main">
			<main>
				<?php while ( have_posts() ) : ?>
				<div><?php the_breadcrums();?></div>
				<?php the_post() ?>
				<header class="heading">
					<h1><?php the_title();?></h1>
				</header>
				<article class="contenido">
					<figure class="contenido--img">
						<?php if( has_post_thumbnail() )
						{
							$image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'custom-thumb-600-x' );
							$alt = get_post_meta($image_url, '_wp_attachment_image_alt', true);
							the_post_thumbnail('custom-thumb-600-x');
						} else {
							echo '<img src="'.get_stylesheet_directory_uri().'/img/noimagen.jpg" alt="'.__('Sin imagen', 'villabrochero').'" />';
						}?>
					</figure>
					<hr>
					<div class="formulario">
						<?php echo do_shortcode('[contact-form-7 id="5" title="Formulario de Contacto de la Web"]');?>
						<div class="clearfix"></div>
					</div>
					<?php the_content();?>
				</article>
				<?php endwhile; ?>
				<?php else : ?>
				<article class="contenido">
					<blockquote>
						<?php _e('No hay nada publicado en esta página', 'villabrochero');?>
					</blockquote>
				</article>
				<?php endif; ?>
			</main>
		</div>
	</div>
<?php get_footer();?>