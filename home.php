<?php
/*
* home.php
* @package WordPress
* @subpackage villabrochero
* @since villabrochero 1.0
* Text Domain: villabrochero
*/
?>
<?php get_header(); ?>
	<div class="sidebar--main">
<?php get_sidebar();?>
		<div class="main">
			<main>
			<header class="main--header">
				<h2><?php _e('Propiedades Destacadas', 'villabrochero');?></h2>
			</header>
<?php if( wpmd_is_notdevice() )
{
	// Desktop
	echo '<section id="carrusel_principal_desktop" class="home--section cycle-slideshow"
			data-cycle-fx="carousel"
			data-cycle-timeout="3000"
			data-cycle-carousel-visible="3"
			data-cycle-carousel-fluid="true"
			data-cycle-pause-on-hover="true"
			data-cycle-swipe="true"
			data-cycle-slides=".home--section--article">
			<div class="cycle-prev"></div>
			<div class="cycle-next"></div>';
}
else if ( wpmd_is_tablet() )
{
	// Solo tabletas
	echo '<section id="carrusel_principal_desktop" class="home--section cycle-slideshow"
			data-cycle-fx="carousel"
			data-cycle-timeout="3000"
			data-cycle-carousel-visible="2"
			data-cycle-carousel-fluid="true"
			data-cycle-pause-on-hover="true"
			data-cycle-swipe="true"
			data-cycle-slides=".home--section--article">
			<div class="cycle-prev"></div>
			<div class="cycle-next"></div>';
}
else
{
	// Móviles
	echo '<section class="home--section cycle-slideshow"
			data-cycle-fx="scrollHorz"
			data-cycle-timeout="3000"
			data-cycle-swipe="true"
			data-cycle-slides=".home--section--article">
			<div class="cycle-prev"></div>
			<div class="cycle-next"></div>';
};

// Para mostrar las últimas 6 propiedades destacadas
$args = array (
	'post_type'				=>	array( 'post' ),
	'posts_per_page'		=>	'6',
	'ignore_sticky_posts'	=>	false,
);

// The Query
$propiedades_destacadas = new WP_Query( $args );

// The Loop
if ( $propiedades_destacadas->have_posts() )
{
	while ( $propiedades_destacadas->have_posts() )
	{
		$propiedades_destacadas->the_post();?>

			<article class="home--section--article">
				<div class="home--section--img">
					<?php if ( has_post_thumbnail() )
					{
						if ( wpmd_is_notdevice() )
						{
							// Para desktops
							the_post_thumbnail('custom-thumb-400-300');
						}
						else if ( wpmd_is_tablet() )
						{
							// Para tabletas
							the_post_thumbnail('large');
						}
						else
						{
							// Para teléfonos
							the_post_thumbnail('custom-thumb-400-300');
						}
					}
					else
					{
						echo '<img src="' . get_stylesheet_directory_uri() . '/img/noimagen.jpg" alt="Inmobiliaria Villa Brochero" />';
					};

					$villabrochero_vendido = rwmb_meta('villabrochero_vendido', $post->ID );
					if ( $villabrochero_vendido )
					{
						echo '<div class="mensajes">' . __('Vendido', 'villabrochero') . '</div>';
					};?>
					<div class="home--section--lista">
						<ul>
							<li>
								<?php $titular = get_the_title();
								$caracteres_titular = strlen($titular);
								if ( $caracteres_titular > 30 )
								{
									$titular = substr($titular, 0, 30) . "&hellip;";
								};?>
								<h4><?php echo $titular;?></h4>
							</li>
							<li>
								<span><?php _e('Código:', 'villabrochero');?></span>
								<?php $villabrochero_codigo = rwmb_meta( 'villabrochero_codigo', $post->ID );
								if ( $villabrochero_codigo )
								{
									echo $villabrochero_codigo;
								};?>
							</li>
							<li>
								<span><?php _e('Operación:', 'villabrochero');?></span>
								<?php echo get_the_term_list( get_the_ID(), 'operaciones', '', '' );?>
							</li>
							<li>
								<a href="<?php the_permalink();?>" class="boton small"><?php _e('Ver Producto', 'villabrochero');?></a>
							</li>
						</ul>
					</div>
				</div>
			</article>
<?php	}
	echo '</section>';
} else {
	echo 'no hay nada';
};

// Restore original Post Data
wp_reset_postdata();?>
		<section class="home--section cycle-slideshow home--banners"
			data-cycle-timeout="3000"
			data-cycle-speed="500"
			data-cycle-loader="true"
			data-cycle-pause-on-hover="true"
			data-cycle-auto-height="container"
			data-cycle-slides=".home--banners--slide"
			>
			<div class="cycle-prev"></div>
			<div class="cycle-next"></div>
<?php // WP_Query arguments
rewind_posts();
$args = array (
	'post_type'	=>	array( 'sliders' ),
);

// The Query
$slideshow_query = new WP_Query( $args );

// The Loop
if ( $slideshow_query->have_posts() )
{
	while ( $slideshow_query->have_posts() )
	{
		$slideshow_query->the_post();?>
				<article class="home--banners--slide">
					<div class="figure">
						<?php if( wpmd_is_notphone() )
						{
							// Desktop y tabletas
							$image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'custom-thumb-1024-400' );
							$alt = get_post_meta($image_url, '_wp_attachment_image_alt', true);
							echo '<img src="' . $image_url[0] . '" alt="' . $alt . '"  />';
						}
						else
						{
							// Móviles
							$image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'custom-thumb-400-300' );
							$alt = get_post_meta($image_url, '_wp_attachment_image_alt', true);
							echo '<img src="' . $image_url[0] . '" alt="' . $alt . '"  />';
						};?>
						<div class="figcaption"><?php the_title();?></div>
						<?php if( get_the_content() )
						{
							echo '<div class="slide--descripcion">' . get_the_content() . '</div>';
						}?>
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
<?php }
	echo '</section>';

// Restore original Post Data
wp_reset_postdata(); rewind_posts();?>
			<div class="clearfix"></div>
		</main>
		</div>
	</div>
<?php get_footer();?>