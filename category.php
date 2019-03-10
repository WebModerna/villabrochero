<?php
/*
* category.php
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
// Variables a utilizar en la plantilla
$add_this = of_get_option('add_this', '');
?>
		<div class="main">
			<main>
				<div><?php the_breadcrums();?></div>
				<header class="main--header">
					<h2><?php echo single_cat_title( '', false ); _e(': '); echo '<strong>'.$count = $wp_query->post_count.'</strong>';?></h2>
				</header>
				<?php global $wp_query;
				query_posts(
					array_merge(
						$wp_query->query,
						array(
							// 'meta_key'	=>	'_my_meta_value_key3',
							'meta_key'	=>	'villabrochero_codigo',
							'orderby'	=>	'meta_value',
							'order'		=>	'ASC',
						)
					)
				);
				if ( have_posts() ) : ?>
				<section class="productos">
				<?php while ( have_posts() ) : the_post();?>
					<article class="productos--article">
						<div class="productos--lista">
							<ul>
								<li>
									<h4><a href="<?php the_permalink();?>"><?php the_title();?></a></h4>
								</li>
								<li>
									<span><?php _e('Código:', 'villabrochero');?></span>
									<?php //$codigo = get_post_meta( $post->ID, '_my_meta_value_key3', true );
									$codigo = rwmb_meta( 'villabrochero_codigo', '' );
									if ( $codigo )
									{
										echo $codigo;
									} else {
										echo '<button class="boton-rojo">'.__('Falta Código', 'villabrochero').'</button>';
									};?>
								</li>
								<li>
									<span><?php _e('Operación:', 'villabrochero');?></span>
									<?php echo get_the_term_list( get_the_ID(), 'operaciones', '', '' );?>
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
									<?php echo get_the_term_list( get_the_ID(), 'zonas', '', ' - ' );?>
								</li>
								<li>
									<span><?php _e('Ambientes:', 'villabrochero');?></span>
									<?php $villabrochero_superficie = rwmb_meta( 'villabrochero_superficie', '' );
									if ( $villabrochero_superficie ) {
										echo $villabrochero_superficie;
									};?>
								</li>
								<li class="aligncenter">
									<a class="boton" href="<?php the_permalink();?>"><?php _e('Ver Propiedad', 'villabrochero');?></a>
								</li>
							</ul>
						</div>
						<figure class="productos--img">
							<?php if( has_post_thumbnail() ) {
								the_post_thumbnail('custom-thumb-400-300');
							} else {
								echo '<img src="'.get_stylesheet_directory_uri().'/img/noimagen.jpg" alt="'.__('Sin imagen', 'villabrochero').'" />';
							};
							$villabrochero_vendido = rwmb_meta('villabrochero_vendido', '' );
							if( $villabrochero_vendido )
							{
								echo '<div class="mensajes">'.__('Vendida', 'villabrochero').'</div>';
							};

							$villabrochero_reservado = rwmb_meta('villabrochero_reservado', '' );
							if( $villabrochero_reservado )
							{
								echo '<div class="mensajes reservado">'.__('Reservado', 'villabrochero').'</div>';
							};?>
						</figure>
					</article>
				<?php endwhile; ?>
				</section>
				<?php else : ?>
				<section>
					<article class="contenido">
						<blockquote>
							<?php _e('No hay productos cargados ni publicados en esta categoría.', 'villabrochero');?>
						</blockquote>
						<figure class="contenido--img">
							<img src="<?php echo get_stylesheet_directory_uri();?>/img/noimagen.jpg" alt="<?php _e('Sin imagen', 'villabrochero');?>" />
						</figure>
					</article>
				</section>
				<?php endif; wp_reset_query();?>
				<div class="pagination">
					<?php if ( function_exists("pagination") ) { pagination(); } ?>
				</div>
			</main>
		</div>
	</div>
<?php get_footer();?>