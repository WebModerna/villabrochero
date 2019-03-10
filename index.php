<?php
/*
* index.php
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
rewind_posts();?>
		<div class="main">
			<main>
				<div><?php the_breadcrums();?></div>
				<header class="main--header">
					<h2><?php _e('Todos los productos', 'villabrochero');?></h2>
				</header>
			<?php if ( have_posts() ) : while ( have_posts() ) : ?>
				<section class="productos">
				<?php the_post();?>
					<article class="productos--article">
						<div class="productos--lista">
							<ul>
								<li>
									<h4><a href="<?php the_permalink();?>"><?php the_title();?></a></h4>
								</li>
								<li>
									<span><?php _e('Código:', 'villabrochero');?></span>
									A342
								</li>
								<li>
									<span><?php _e('Operación:', 'villabrochero');?></span>
									<?php echo get_the_term_list( get_the_ID(), 'operaciones', '<a></a>', '' );?>
								</li>
								<li>
									<span><?php _e('Precio:', 'villabrochero');?></span>
									$23.435.534,98
								</li>
								<li>
									<span><?php _e('Ubicación:', 'villabrochero');?></span>
									<?php echo get_the_term_list( get_the_ID(), 'zonas', '', '' );?>
								</li>
								<li class="aligncenter">
									<a class="boton" href="<?php the_permalink();?>"><?php _e('Ver Propiedad', 'villabrochero');?></a>
								</li>
							</ul>
						</div>
						<figure class="productos--img">
							<?php if( has_post_thumbnail() )
							{
								$image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'custom-thumb-600-x' );
								$alt = get_post_meta($image_url, '_wp_attachment_image_alt', true);
								the_post_thumbnail('custom-thumb-600-x');
							} else {
								echo '<img src="'.get_stylesheet_directory_uri().'/img/noimagen.jpg" alt="'.__('Sin imagen', 'villabrochero').'" />';
							}?>
							<figcaption class="mensajes">Vendido</figcaption>
						</figure>
					</article>
				<?php endwhile; ?>
				</section>
				<?php else : ?>
				<section>
					<article class="contenido">
						<blockquote>
							<?php _e('No hay productos cargados ni publicados.', 'villabrochero');?>
						</blockquote>
						<figure class="contenido--img">
							<img src="<?php echo get_stylesheet_directory_uri();?>/img/noimagen.jpg" alt="<?php _e('Sin imagen', 'villabrochero');?>" />
						</figure>
					</article>
				</section>
				<?php endif; ?>
				<div class="pagination">
					<?php if ( function_exists("pagination") ) { pagination(); } ?>
				</div>
			</main>
		</div>
	</div>
<?php get_footer();?>