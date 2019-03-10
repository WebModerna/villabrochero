<?php
/*
* sidebar.php
* @package WordPress
* @subpackage villabrochero
* @since villabrochero 1.0
* Text Domain: villabrochero
*/
?>
		<aside class="sidebar barra_lateral">
			<section class="navegacion-secundaria">
				<header>
					<button id="chusma" class="boton-rojo">
						<?php _e('Buscar Propiedades', 'emyth');?><span class="icono-search icono-left icono-right"></span>
					</button>
				</header>
				<nav>
					<?php
					// Barra de navegación secundaria: solo páginas
					$default = array(
						'container'			=>			false,
						'depth'				=>				0,
						'menu'				=>	'second_nav',
						'theme_location'	=>	'second_nav',
						'items_wrap'		=>	'<ul class="second_nav">%3$s</ul>'
					);
					wp_nav_menu($default);?>
				</nav>
			</section>
			<section class="sidebar--section formulario--propiedades">
				<header class="sidebar--section-header">
					<h3><?php _e('Buscador', 'villabrochero');?></h3>
				</header>
				<div class="formulario--propiedades-form">
					<?php get_search_form();?>
				</div>
			</section>

			<section class="sidebar--section sidebar--banner">
				<?php $banner_web = of_get_option('banner_web', '');
				$enlace_banner = of_get_option('enlace_banner', '');
				$contenido_banner = of_get_option('contenido_banner', '');
				if ( $banner_web ) { ?>
				<article class="sidebar--section-contenido">
					<figure>
					<?php if( $enlace_banner and $contenido_banner ) { ?>
						<a href="<?php echo get_page_link($enlace_banner);?>">
					<?php }	elseif( $enlace_banner and !$contenido_banner ) { ?>
						<a href="<?php echo get_page_link($enlace_banner);?>">
					<?php }	elseif ( !$enlace_banner and $contenido_banner ) { ?>
						<a href="#reserva" class="fancybox">
					<?php } else {} ?>
							<img src="<?php echo $banner_web;?>" alt="Reservas" />
					<?php if( $enlace_banner or $contenido_banner ) { ?>
						</a>
					<?php };?>
					</figure>
					<?php if ( $contenido_banner ) { ?>
					<div id="reserva" class="contenido"><?php echo $contenido_banner;?></div>
					<?php };?>
				</article>
				<?php };?>
			</section>

			<?php $banner_web_2 = of_get_option('banner_web_2', '');
			$banner_web_2_enlace = of_get_option('banner_web_2_enlace', '');
			if ( $banner_web_2 && $banner_web_2_enlace )
			{
				echo '<section class="sidebar--section sidebar--banner"><article class="sidebar--section-contenido"><figure>';
				echo '<a href="//' . $banner_web_2_enlace . '" target="_blank">';
				echo '<img alt="'.$banner_web_2_enlace.'" src="' . $banner_web_2 . '" />';
				echo '</a></figure></article></section>';
			};?>

			<?php // dynamic_sidebar('sidebar_right');?>
		</aside>