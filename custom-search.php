<?php
/*
* custom-search.php
* @package WordPress
* @subpackage villabrochero
* @since villabrochero 1.0
* Text Domain: villabrochero
* Template Name: Custom Search
*/
?>

<?php get_header();?>
	<div class="sidebar--main">
<?php get_sidebar(); rewind_posts();?>
		<div class="main">
			<main>
				<div class="clearfix"></div>
				<header class="main--header">
					<?php $keyword = $_GET['codigo_producto'];

					$args = array(
						'meta_key'			=>	'villabrochero_codigo',
						'meta_value'		=>	$keyword,
						'post_type'			=>	'post',
						'posts_per_page'	=>	1
					);
					$posts = get_posts($args);

					$count = $wp_query->post_count;?>
					<h2><?php echo '<strong>'.$count.'</strong>'; _e(' resultado para: '); echo '<strong>' . $keyword . '</strong>';?></h2>
				</header>
			<?php
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
									<?php $codigo = rwmb_meta( 'villabrochero_codigo', '' );
									echo $codigo;?>
								</li>
								<li>
									<span><?php _e('Operación:', 'villabrochero');?></span>
									<?php echo get_the_term_list( get_the_ID(), 'operaciones', '', '' );?>
								</li>
								<li>
									<span><?php _e('Precio:', 'villabrochero');?></span>
									<?php $villabrochero_precio = rwmb_meta('villabrochero_precio', '');
									if( $villabrochero_precio ) {
										echo '$ ';
										echo $villabrochero_precio;
									} else {
										echo __('Consultar', 'villabrochero');
									};?>
								</li>
								<li>
									<span><?php _e('Ubicación:', 'villabrochero');?></span>
									<?php echo get_the_term_list( get_the_ID(), 'zonas', '', '' );?>
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
							};?>
						</figure>
					</article>
				<?php endwhile;?>
				</section>
				<?php else : ?>
				<section>
					<article class="contenido">
						<blockquote>
							<?php _e('No encontramos nada.', 'villabrochero');?>
						</blockquote>
						<figure class="contenido--img">
							<img src="<?php echo get_stylesheet_directory_uri();?>/img/noimagen.jpg" alt="<?php _e('Sin imagen', 'villabrochero');?>" />
						</figure>
					</article>
				</section>
				<?php endif; wp_reset_query();?>
			</main>
		</div>
	</div>
<?php get_footer();?>