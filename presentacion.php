<?php
/*
* presentacion.php
* @package WordPress
* @subpackage villabrochero
* @since villabrochero 1.0
* Text Domain: villabrochero
* Template Name: Presentación
*/
?>
<?php get_header();?>
	<div class="sidebar--main">
<?php


// Para resetear todo el loop
rewind_posts();
$args = array (
	'post_type'              => array( 'post' ),
);

// The Query
$query = new WP_Query( $args );
// El loop que mostrará todos los post -->
?>
		<div class="main">
			<main>
			<div id="carrusel_principal_desktop" class="home--section cycle-slideshow presentacion"
				data-cycle-timeout="4000"
				data-cycle-pause-on-hover="true"
				data-cycle-loader="true"
				data-cycle-auto-height="container"
				data-cycle-slides=".home--banners--slide">
				<div class="cycle-prev"></div>
				<div class="cycle-next"></div>
<?php // The Loop
if ( $query->have_posts() ) {
	while ( $query->have_posts() ) {
		$query->the_post();
		// do something ?>
				<article class="home--banners--slide">
					<div class="figure">
						<?php if( wpmd_is_notphone() ) { // Desktop
							$image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'custom-thumb-1024-400' );
							$alt = get_post_meta($image_url, '_wp_attachment_image_alt', true);
							echo '<img src="' . $image_url[0] . '" alt="' . $alt . '"  />';
						} else { // Móviles
							$image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'custom-thumb-400-300' );
							$alt = get_post_meta($image_url, '_wp_attachment_image_alt', true);
							echo '<img src="' . $image_url[0] . '" alt="' . $alt . '"  />';
						};?>
						<div class="figcaption"><?php the_title();?></div>
						<div class="slide--descripcion">
							<ul>
								<li>
									<span><?php _e('Código:', 'villabrochero');?></span>
									<?php $codigo = rwmb_meta( 'villabrochero_codigo', '' );
									if ( $codigo )
									{
										echo $codigo;
									} else {
										echo '<button class="boton-rojo">'.__('Falta Código', 'villabrochero').'</button>';
									};?>
								</li>
								<li>
									<span><?php _e('Operación:', 'villabrochero');?></span>
									<?php echo get_the_term_list( get_the_ID(), 'operaciones', '<a></a>', '' );?>
								</li>
								<li>
									<span><?php _e('Precio:', 'villabrochero');?></span>
									<?php $villabrochero_precio = rwmb_meta( 'villabrochero_precio', '' );
									$villabrochero_precio_dolar = rwmb_meta('villabrochero_precio_dolar', '');
									if( $villabrochero_precio ) {
										echo '$ ';
										echo $villabrochero_precio;
									} else if( $villabrochero_precio_dolar ) {
										echo 'U$s ';
										echo $villabrochero_precio_dolar;
									} else {
										echo __('Consultar', 'villabrochero');
									};?>
								</li>
								<li>
									<span><?php _e('Ubicación:', 'villabrochero');?></span>
									<?php echo get_the_term_list( get_the_ID(), 'zonas', '', '' );?>
								</li>
								<li class="centro">
									<a class="boton" href="<?php the_permalink();?>"><?php _e('Ver Propiedad', 'villabrochero');?></a>
								</li>
							</ul>
						</div>
					</div>
				</article>
<?php	}
} else {
	// no posts found ?>
				<article class="home--banners--slide">
					<div class="figure">
						<img src="<?php bloginfo('stylesheet_directory');?>/img/slide-1.jpg" alt="baners 1" data-cycle-title="Spring 1" data-cycle-desc="Sonnenberg " />
						<div class="figcaption">
							<a href="#">Rservando algo</a>
						</div>
						<div class="slide--descripcion"><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. </p></div>
					</div>
				</article>
				<article class="home--banners--slide">
					<div class="figure">
						<img src="<?php bloginfo('stylesheet_directory');?>/img/slide-2.jpg" alt="baners 2" data-cycle-title="Spring 2" data-cycle-desc=" Gardens" />
						<div class="figcaption">
							<a href="#">Buscando Alojamiento</a>
						</div>
						<div class="slide--descripcion"><p>Te recomendamos los mejores hoteles</p></div>
					</div>
				</article>
				<article class="home--banners--slide">
					<div class="figure">
						<img src="<?php bloginfo('stylesheet_directory');?>/img/slide-3.jpg" alt="baners 3" data-cycle-title="Spring 3" data-cycle-desc="lsdkjlsdfjslfdkj" />
						<div class="figcaption">
							<a href="slideshow.html">Ir al Slideshow</a>
						</div>
						<div class="slide--descripcion"><p>ñlaksjdñflaskdj fapoeijñak fjñsldk </p></div>
					</div>
				</article>
<?php }

// Restore original Post Data

wp_reset_postdata();?>
			</div>
			</main>
		</div>
	</div>
<?php get_footer();?>