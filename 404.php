<?php
/*
* 404.php
* @package WordPress
* @subpackage villabrochero
* @since villabrochero 1.0
* Text Domain: villabrochero
*/
?>
<?php get_header();?>
	<div class="sidebar--main">
<?php
get_sidebar();?>
		<div class="main">
			<main>
				<section>
					<header class="main--header">
						<h2><?php _e('Error 404.', 'villabrochero');?></h2>
					</header>
					<article class="contenido">
						<blockquote>
							<?php _e('La página o el producto que estás buscando, no existe. Intentá de nuevo con las que tenemos en el menú superior o lateral.', 'villabrochero');?>
						</blockquote>
						<figure class="contenido--img">
							<img src="<?php echo get_stylesheet_directory_uri();?>/img/noimagen.jpg" alt="<?php _e('Sin imagen', 'villabrochero');?>" />
						</figure>
					</article>
				</section>
			</main>
		</div>
	</div>
<?php get_footer();?>