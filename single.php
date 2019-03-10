<?php
/*
* single.php
* @package WordPress
* @subpackage villabrochero
* @since villabrochero 1.0
* Text Domain: villabrochero
*/

// Variables de datos importantes
$nombre_sitio = get_bloginfo('name');
$facebook_contact = of_get_option('facebook_contact','');
$twitter_contact = of_get_option('twitter_contact','');
$linkedin_contact = of_get_option('linkedin_contact', '');
$google_plus_contact = of_get_option('google_plus_contact','');
$email_contact = of_get_option('email_contact','');
$email_contact_ventas = of_get_option('email_contact_ventas','');
$google_analitycs = of_get_option('google_analitycs','');
$data_fiscal = of_get_option('data_fiscal','');
$telefono_fijo = of_get_option('telefono_fijo','');
$telefono_celular = of_get_option('telefono_celular','');
$direccion_web = of_get_option('direccion_web','');
$horario = of_get_option('horario_web', '');

session_start();

// Función generadora del captcha.
function generate_captcha()
{
	$digit1 = mt_rand(1,10);
	$digit2 = mt_rand(1,10);
	if( mt_rand(0,1) === 1 )
	{
		$_SESSION['math'] = "$digit1 + $digit2";
		$_SESSION['answer'] = $digit1 + $digit2;
	} else if ($digit1 < $digit2)
	{
		$_SESSION['math'] = "$digit2 - $digit1";
		$_SESSION['answer'] = $digit2 - $digit1;
	}
	else
	{
		$_SESSION['math'] = "$digit1 - $digit2";
		$_SESSION['answer'] = $digit1 - $digit2;
	}

	$_SESSION['answer'] = md5($_SESSION['answer']);
}

// Generador del captcha
if( !isset( $_SESSION['answer'] ) || !isset( $_SESSION['math'] ) )
{
	generate_captcha();
}

// Si el formulario se envió....
if ( isset( $_POST['submit'] ) )
{
	// Que el campo del nombre y apellido no esté vació
	if ( trim($_POST['nomape']) == '' )
	{
		$error1 = '<span class="respuesta--mal" id="error">' . __('Ingrese su nombre y apellido completo', 'villabrochero') . '</span><style type="text/css">.formulario--producto { display: block; }</style>';
		generate_captcha();
	}

	// Que el campo del mail no esté vacío ni tampoco incorrecto
	else if ( trim($_POST['ema']) == '' or !preg_match("/^[a-zA-Z0-9_\.\-]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+$/", $_POST['ema']) )
	{
		$error2 = '<span class="respuesta--mal" id="error">' . __('Ingrese un email correcto', 'villabrochero') . '</span><style type="text/css">.formulario--producto{display:block;}</style>';
		generate_captcha();
	}

	// que el campo del teléfono no esté vacío
	else if ( trim($_POST['tel']) == '' )
	{
		$error3 = '<span class="respuesta--mal" id="error">' . __('Ingrese un teléfono correcto', 'villabrochero') . '</span><style type="text/css">.formulario--producto{display:block;}</style>';
		generate_captcha();
	}

	// Que el área de texto no esté vacía.
	else if ( trim($_POST['oii']) == '' )
	{
		$error4 = '<span class="respuesta--mal" id="error">' . __('Tiene que ingresar un mensaje', 'villabrochero') . '</span><style type="text/css">.formulario--producto{display:block;}</style>';
		generate_captcha();
	}

	// Que el campo oculto pueda enviar el título del producto
	else if ( trim($_POST['hidden-producto']) == '' )
	{
		$error6 = '<span class="respuesta--mal" id="error">' . __('Hubo un error al enviar los datos', 'villabrochero') . '</span><style type="text/css">.formulario--producto{display:block;}</style>';
	}

	// Que el campo oculto pueda enviar el link hacia el producto
	else if ( $_POST['hidden-producto-url'] == '' )
	{
		$error6 = '<span class="respuesta--mal" id="error">' . __('Hubo un error al enviar los datos', 'villabrochero') . '</span><style type="text/css">.formulario--producto{display:block;}</style>';
	}

	// Que el campo del captcha tenga algo
	else if (  $_POST['codigo'] == '' )
	{
		$error5 = '<span class="respuesta--mal" id="error">' . __('Debe insertar el resultado', 'villabrochero') . '</span><style type="text/css">.formulario--producto{display:block;}</style>';
		generate_captcha();
	}

	// Que el campo del captcha coincida con el generado al principio
	else if (  md5($_POST['codigo']) != $_SESSION['answer'] )
	{
		$error5 = '<span class="respuesta--mal" id="error">' . __('El código ingresado es incorrecto', 'villabrochero') . '</span><style type="text/css">.formulario--producto{display:block;}</style>';
		generate_captcha();
	}

	else
	{
		// Si pasó todas las pruebas entonces que el formulario se envíe correctamente
		include_once "formulario_producto.php";

		// Cabeceras del correo
		$headers .= "From: " . $nombre  ."<" . $email . ">" . "\r\n";
		$headers .= "Reply-To: $email \r\n";
		$headers .= "X-Mailer: PHP5 \n";
		$headers .= "MIME-Version: 1.0 \n";
		$headers .= "Content-type: text/html; charset=utf-8 \r\n";

		if ( mail ( $dest, $asunto, $cuerpo, $headers ) )
		{
			generate_captcha();
			$result_ok = '<span class="respuesta--ok" id="error">' . __('Mensaje enviado correctamente :)', 'villabrochero') . '</span>';

			// si el envio fue exitoso reseteamos lo que el usuario escribio:
			$_POST['nomape']				=	'';
			$_POST['ema']					=	'';
			$_POST['tel']					=	'';
			$_POST['oii']					=	'';
			$_POST['hidden-producto']		=	'';
			$_POST['hidden-producto-url']	=	'';
		}
		else
		{
			// Si hubo algún error en el envío, la cuenta del mail falló, se cortó la conexión, etc...
			generate_captcha();
			$result = '<span class="respuesta--error" id="error">' . __('Hubo un error al enviar el mensaje :-(', 'villabrochero') . '</span><style type="text/css">.formulario--producto { display: block; }</style>';
		}
	}
}

generate_captcha();

get_header();?>
	<div class="sidebar--main">
<?php get_sidebar();

// Para resetear todo el loop
rewind_posts();

// Variables a utilizar en la plantilla
$add_this = of_get_option('add_this', '');
$add_this_script = of_get_option('add_this_script', '');
$codigo = rwmb_meta('villabrochero_codigo', '' );
$villabrochero_vendido = rwmb_meta('villabrochero_vendido', '' );
$villabrochero_reservado = rwmb_meta('villabrochero_reservado', '' );
$villabrochero_precio = rwmb_meta( 'villabrochero_precio', '' );
$villabrochero_precio_dolar = rwmb_meta( 'villabrochero_precio_dolar', '' );
$villabrochero_direccion = rwmb_meta( 'villabrochero_direccion', '' );
$villabrochero_superficie = rwmb_meta( 'villabrochero_superficie', '' );
$villabrochero_comodidades = rwmb_meta( 'villabrochero_comodidades', '' );

// El loop que mostrará todos los post
if ( have_posts() ) : ?>
	<div class="main">
		<main>
			<?php while ( have_posts() ) : ?>
			<div class="relativo">
				<?php the_breadcrums();
				?>

				<div class="clearfix"></div>
			</div>
			<section class="productos">
			<?php the_post();
			if ( $add_this_script )
				{
					echo '<script type="text/javascript" src="' . $add_this_script . '"></script>';
				};
			?>
				<article class="productos--article">
					<div class="productos--lista">
						<figure class="productos--img movil">
							<?php
							$optional_size	= 'custom-thumb-400-300';
							$optional_size2	= 'custom-thumb-800-x';
							$img_id			= get_post_thumbnail_id( $post->ID );
							$image			= wp_get_attachment_image_src( $img_id, $optional_size );
							$image2			= wp_get_attachment_image_src( $img_id, $optional_size2 );
							$alt_text		= get_post_meta( $img_id , '_wp_attachment_image_alt', true );
							$perm			= get_permalink ($post->ID );
							if ( $image )
							{
								// Solo para desktops y tablets
								if ( wpmd_is_notphone() )
								{
									echo '<a data-fancybox-group="single2" class="fancybox" href="' . $image2[0] . '">';
									echo '<img src="' . $image[0] . '" alt="' . $alt_text . '" />';
									echo '</a>';
								} else { // Para celulares
									echo '<img src="' . $image2[0] . '" alt="' . $alt_text . '" />';
								}
							} else {
								echo '<img src="' . get_stylesheet_directory_uri() . '/img/1.jpg" alt="' . __('Sin imagen', 'villabrochero') . '" />';
							};

							if( $villabrochero_vendido )
							{
								echo '<div class="mensajes">'.__('Vendida', 'villabrochero').'</div>';
							}
							if( $villabrochero_reservado )
							{
								echo '<div class="mensajes reservado">'.__('Reservado', 'villabrochero').'</div>';
							};?>
						</figure>
						<ul>
							<li><h1><?php the_title();?></h1></li>
							<li>
								<span><?php _e('Código:', 'villabrochero');?></span>
								<?php if ( $codigo ) {
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
								<span><?php _e('Ambientes:', 'villabrochero');?></span>
								<?php if ( $villabrochero_superficie ) {
									echo $villabrochero_superficie;
								};?>
							</li>
							<li>
								<span><?php _e('Zona:', 'villabrochero');?></span>
								<?php echo get_the_term_list( get_the_ID(), 'zonas', '', ' - ' );?>
							</li>
							<li>
								<span><?php _e('Precio:', 'villabrochero');?></span>
								<?php if( $villabrochero_precio ) {
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
								<span><?php _e('Propiedad:', 'villabrochero');?></span>
								<?php $cats = get_the_category();
								echo $cat_name = $cats[0]->name;?>
							</li>

							<?php if ( $villabrochero_direccion )
							{
								echo '<li><span>';
								_e('Dirección:', 'villabrochero');
								echo '</span>';
								echo $villabrochero_direccion;
								echo '</li>';
							};

							if ( $villabrochero_comodidades )
							{
								echo '<li><span>';
								_e('Comodidades:', 'villabrochero');
								echo '</span>';
								echo $villabrochero_comodidades;
								echo '</li>';
							};?>
							<li>
								<span><?php _e('Descripción:', 'villabrochero');?></span>
								<?php the_content();?>
							</li>
						</ul>
					</div>
					<div class="productos--img single">
					<?php if ( wpmd_is_notphone() ) { ?>
						<div id="slide-1" class="cycle-slideshow"
						data-cycle-speed="500"
						data-cycle-auto-height="4:3"
						data-cycle-slides="> a">
						<div class="cycle-prev"></div>
						<div class="cycle-next"></div>
					<?php } else { ?>
						<div>
					<?php };?>
						<?php
						// nueva
						$images = rwmb_meta( 'villabrochero_imagenes', 'size=custom-thumb-400-300' );
						if ( !empty( $images ) )
						{
							// Para ver en desktop y tables
							if ( wpmd_is_notphone() )
							{
								foreach ( $images as $image )
								{
									echo "<a data-fancybox-group='single' class='fancybox' href='{$image['large']}'>";
									echo "<img src='{$image['url']}' alt='{$image['alt']}' />";
									echo '</a>';
								}
							} else { // Solo para teléfonos
								foreach ( $images as $image )
								{
									echo "<img class='bordes' src='{$image['url']}' alt='{$image['alt']}' />";
								}
							}

						} else { ?>

							<a data-fancybox-group="single" class="fancybox" href="<?php bloginfo('stylesheet_directory');?>/img/2.jpg"><img src="<?php bloginfo('stylesheet_directory');?>/img/2.jpg" alt="propiedad" /></a>
							<a data-fancybox-group="single" class="fancybox" href="<?php bloginfo('stylesheet_directory');?>/img/1.jpg"><img src="<?php bloginfo('stylesheet_directory');?>/img/1.jpg" alt="propiedad" /></a>
							<a data-fancybox-group="single" class="fancybox" href="<?php bloginfo('stylesheet_directory');?>/img/3.jpg"><img src="<?php bloginfo('stylesheet_directory');?>/img/3.jpg" alt="propiedad" /></a>
							<a data-fancybox-group="single" class="fancybox" href="<?php bloginfo('stylesheet_directory');?>/img/2.jpg"><img src="<?php bloginfo('stylesheet_directory');?>/img/2.jpg" alt="propiedad" /></a>

						<?php };
						if( $villabrochero_vendido )
						{
							echo '<div class="mensajes">'.__('Vendida', 'villabrochero').'</div>';
						};
						if( $villabrochero_reservado )
						{
							echo '<div class="mensajes reservado">'.__('Reservado', 'villabrochero').'</div>';
						};
						?>

						</div>
						<div class="clearfix"></div>

					<?php if( wpmd_is_notphone() ) { ?>
						<div id="slide-2" class="cycle-slideshow"
						data-cycle-slides="> a"
						data-cycle-fx="carousel"
						data-cycle-timeout="4000"
						data-cycle-speed="500"
						data-cycle-swipe="true"
						data-cycle-carousel-visible="5"
						data-cycle-carousel-fluid="true"
						>
						<?php $images2 = rwmb_meta( 'villabrochero_imagenes', 'thumbnail' );
						if ( !empty( $images2 ) )
						{
							foreach ( $images2 as $image )
							{
								echo "<a data-fancybox-group='single2' class='fancybox' href='{$image['large']}'>";
								echo "<img src='{$image['url']}' alt='{$image['alt']}' />";
								echo '</a>';
							}

						} else { ?>

							<a data-fancybox-group="single2" class="fancybox" href="<?php bloginfo('stylesheet_directory');?>/img/2.jpg"><img src="<?php bloginfo('stylesheet_directory');?>/img/2.jpg" alt="propiedad" /></a>
							<a data-fancybox-group="single2" class="fancybox" href="<?php bloginfo('stylesheet_directory');?>/img/1.jpg"><img src="<?php bloginfo('stylesheet_directory');?>/img/1.jpg" alt="propiedad" /></a>
							<a data-fancybox-group="single2" class="fancybox" href="<?php bloginfo('stylesheet_directory');?>/img/3.jpg"><img src="<?php bloginfo('stylesheet_directory');?>/img/3.jpg" alt="propiedad" /></a>
							<a data-fancybox-group="single2" class="fancybox" href="<?php bloginfo('stylesheet_directory');?>/img/2.jpg"><img src="<?php bloginfo('stylesheet_directory');?>/img/2.jpg" alt="propiedad" /></a>
							<a data-fancybox-group="single2" class="fancybox" href="<?php bloginfo('stylesheet_directory');?>/img/2.jpg"><img src="<?php bloginfo('stylesheet_directory');?>/img/2.jpg" alt="propiedad" /></a>

							<?php };?>
						</div>
					<?php }; ?>

						<label id="label-check" for="check" class="boton small">
							<?php _e('Consulte Esta Propiedad', 'villabrochero');?>
						</label>
						<input type="checkbox" id="check" name="check" />
						<div class="formulario--producto">
							<div>
								<form id="form2" name="form2" method="post" action="#error">
									<fieldset>
										<legend><?php _e('Complete todos los campos del formulario', 'villabrochero');?></legend>
										<div>
											<div class="respuesta"><?php echo $error1;?></div>
											<label for="nomape"><?php _e('Nombre y Apellido:', 'villabrochero');?></label>
											<input name="nomape" id="nomape" type="text" maxlength="40" placeholder="..." value="<?php echo $_POST['nomape'];?>" />
										</div>
										<div>
											<div class="respuesta"><?php echo $error2;?></div>
											<label for="ema"><?php _e('Correo Electrónico:', 'villabrochero');?></label>
											<input name="ema" id="ema" type="text" maxlength="50" placeholder="@" value="<?php echo $_POST['ema'];?>" />
										</div>
										<div>
											<div class="respuesta"><?php echo $error3;?></div>
											<label for="tel"><?php _e('Teléfono:', 'villabrochero');?></label>
											<input name="tel" id="tel" type="tel" minlength="8" maxlength="10" placeholder="..." value="<?php echo $_POST['tel'];?>" />
										</div>
										<div>
											<div class="respuesta"><?php echo $error4;?></div>
											<label for="oii"><?php _e('Mensaje:', 'villabrochero');?></label>
											<textarea name="oii" id="oii" placeholder="..." ><?php echo $_POST['oii'];?></textarea>
										</div>
										<div>
											<div class="respuesta"><?php echo $error5;?></div>
											<div class="respuesta"><?php echo $error6;?></div>
											<label for="codigo"><?php echo $_SESSION['math']; ?> =</label>
											<input placeholder="?" type="number" class="codigo" id="codigo" name="codigo" min="0" max="20" value="" />

											<input type="hidden" name="hidden-producto" id="hidden-producto" value="<?php the_title();?>" />
											<input type="hidden" name="hidden-producto-url" id="hidden-producto-url" value="<?php the_permalink();?>" />
										</div>
										<div>
											<!-- <button type="submit" name="submit" id="submit" class="boton-negro" form="form2">
												<?php //_e('Enviar', 'villabrochero');?>
											</button> -->
											<input type="submit" name="submit" class="boton-negro" value="<?php _e('Enviar', 'villabrochero');?>" />
											<button type="reset" name="submit2" id="submit2" class="boton-rojo">
												<?php _e('Borrar', 'villabrochero');?>
											</button>
										</div>
										<div class="respuesta"><?php echo $result;?></div>
									</fieldset>
								</form>
								<div class="clearfix"></div>
							</div>
							<div class="clearfix"></div>
						</div>
						<div class="respuesta"><?php echo $result_ok;?></div>

						<?php
						$args = array(
							'type'         => 'map',
							'width'        => '100%', // Map width, default is 640px. Can be '%' or 'px'
							'height'       => '300px', // Map height, default is 480px. Can be '%' or 'px'
							// 'zoom'         => 25,  // Map zoom, default is the value set in admin, and if it's omitted - 14
							'marker'       => true, // Display marker? Default is 'true',
							'marker_title' => '', // Marker title when hover
							'info_window'  => '<h3>Info Window Title</h3>Info window content. HTML <strong>allowed</strong>', // Info window content, can be anything. HTML allowed.
							'js_options'   => array(
								// 'mapTypeId'   => 'HYBRID',
								'zoomControl' => true,
								'zoom'        => 15, // You can use 'zoom' inside 'js_options' or as a separated parameter
							)
						);
						$mapa = rwmb_meta( 'villabrochero_map', $args );
						if ( $mapa )
						{
							echo '<div id="map" class="googlemaps">';
							echo '<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true&;amp;language=es"></script>';
							echo $mapa;
							echo '</div>';
						}

						// Calendario de Reservas
						$calendario = get_post_meta( $post->ID, '_my_meta_value_key2', true );
						if ( $calendario )
						{
							echo '<div class="datepicker"><h3>Días Reservados</h3></div>';
						};?>
					</div>
				</article>
			</section>
			<!-- Post navigation, o sea la paginación -->
			<section class="enlaces__navegacion">
				<?php previous_post_link('<div class="prev">%link</div>' );?>
				<?php next_post_link( '<div class="next">%link</div>' ); ?>
			</section>
			<?php endwhile; ?>
			<?php else : ?>
			<section>
				<article class="contenido">
					<blockquote>
						<?php _e('No hay nada publicado en esta página', 'villabrochero');?>
					</blockquote>
				</article>
			</section>
			<?php endif; ?>
			</main>
		</div>
	</div>
<?php get_footer();?>