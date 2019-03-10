<?php
/*
* servicios.php
* @package WordPress
* @subpackage villabrochero
* @since villabrochero 1.0
* Text Domain: villabrochero
* Template Name: Servicios
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
		$error1 = '<span class="respuesta--mal" id="error">' . __('Ingrese su nombre y apellido completo', 'villabrochero') . '</span>';
		generate_captcha();
	}

	// Que el campo del mail no esté vacío ni tampoco incorrecto
	else if ( trim($_POST['ema']) == '' or !preg_match("/^[a-zA-Z0-9_\.\-]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+$/", $_POST['ema']) )
	{
		$error2 = '<span class="respuesta--mal" id="error">' . __('Ingrese un email correcto', 'villabrochero') . '</span>';
		generate_captcha();
	}

	// que el campo del teléfono no esté vacío
	else if ( trim($_POST['tel']) == '' )
	{
		$error3 = '<span class="respuesta--mal" id="error">' . __('Ingrese un teléfono correcto', 'villabrochero') . '</span>';
		generate_captcha();
	}

	// Que el área de texto no esté vacía.
	else if ( trim($_POST['oii']) == '' )
	{
		$error4 = '<span class="respuesta--mal" id="error">' . __('Tiene que ingresar un mensaje', 'villabrochero') . '</span>';
		generate_captcha();
	}

	// Que el campo del captcha tenga algo
	else if (  $_POST['codigo'] == '' )
	{
		$error5 = '<span class="respuesta--mal" id="error">' . __('Debe insertar el resultado', 'villabrochero') . '</span>';
		generate_captcha();
	}

	// Que el campo del captcha coincida con el generado al principio
	else if (  md5($_POST['codigo']) != $_SESSION['answer'] )
	{
		$error5 = '<span class="respuesta--mal" id="error">' . __('El código ingresado es incorrecto', 'villabrochero') . '</span>';
		generate_captcha();
	}

	else
	{
		// Si pasó todas las pruebas entonces que el formulario se envíe correctamente
		include_once "formulario_servicios.php";

		// Cabeceras del correo
		$headers .= "From: " . $nombre  ."<" . $email . ">" . "\r\n";
		$headers .= "Reply-To: $ema \r\n";
		$headers .= "X-Mailer: PHP5 \n";
		$headers .= "MIME-Version: 1.0 \n";
		$headers .= "Content-type: text/html; charset=utf-8 \r\n";

		if ( mail ( $dest, $asunto, $cuerpo, $headers ) )
		{
			generate_captcha();
			$result = '<span class="respuesta--ok" id="error">' . __('Mensaje enviado correctamente :)', 'villabrochero') . '</span>';

			// Si el envio fue exitoso reseteamos lo que el usuario escribio:
			$_POST['nomape']	=	'';
			$_POST['ema']		=	'';
			$_POST['tel']		=	'';
			$_POST['car']		=	'';
			$_POST['loc']		=	'';
			$_POST['otr']		=	'';
			$_POST['sup']		=	'';
			$_POST['val']		=	'';
			$_POST['val_dolar']	=	'';
			$_POST['fin']		=	'';
			$_POST['oii']		=	'';
		}
		else
		{
			// Si hubo algún error en el envío, la cuenta del mail falló, se cortó la conexión, etc...
			generate_captcha();
			$result = '<span class="respuesta--error" id="error">' . __('Hubo un error al enviar el mensaje :-(', 'villabrochero') . '</span>';
		}
	}
}

generate_captcha();

get_header();?>
	<div class="sidebar--main">
<?php get_sidebar();

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
					<?php the_content();?>
					<div class="formulario">
						<form id="form2" name="form2" method="post" action="#error">
							<fieldset>
								<legend><?php _e('Complete todos los campos del formulario', 'villabrochero');?></legend>
								<div>
									<label for="tipo_propiedad"><?php _e('Tipo de Propiedad:', 'villabrochero');?></label>
									<select name="tipo_propiedad" id="tipo_propiedad">
										<option value="" selected="selected"><?php _e('Seleccionar', 'villabrochero');?></option>
										<?php
											$categories = get_categories();
											foreach ($categories as $cat)
											{
												echo  '<option value="' . $cat->slug . '" >' . $cat->cat_name . '</option>';
											};?>
									</select>
								</div>
								<div>
									<div class="respuesta"><?php echo $error1;?></div>
									<label for="nomape"><?php _e('Nombre y Apellido:', 'villabrochero');?></label>
									<input name="nomape" id="nomape" type="text" maxlength="40" placeholder="..." value="<?php echo $_POST['nomape'];?>" />
								</div>
								<div>
									<div class="respuesta"><?php echo $error2;?></div>
									<label for="ema"><?php _e('Correo Electrónico:', 'villabrochero');?></label>
									<input name="ema" id="ema" type="email" maxlength="50" placeholder="@" value="<?php echo $_POST['ema'];?>" />
								</div>
								<div>
									<div class="respuesta"><?php echo $error3;?></div>
									<label for="tel"><?php _e('Teléfono:', 'villabrochero');?></label>
									<input name="tel" id="tel" type="tel" minlength="8" maxlength="10" placeholder="..." value="<?php echo $_POST['tel'];?>" />
								</div>
								<div>
									<label for="car"><?php _e('Características del Inmueble:', 'villabrochero');?></label>
									<input name="car" id="car" type="text" maxlength="50" placeholder="..." value="<?php echo $_POST['car'];?>" />
								</div>
								<div>
									<label for="loc"><?php _e('Localización Preferida:', 'villabrochero');?></label>
									<input name="loc" id="loc" type="text" maxlength="40" placeholder="..." value="<?php echo $_POST['loc'];?>" />
								</div>
								<div>
									<label for="otr"><?php _e('Otras Localizaciones Posibles:', 'villabrochero');?></label>
									<input name="otr" id="otr" type="text" maxlength="40" placeholder="..." value="<?php echo $_POST['otr'];?>" />
								</div>
								<div>
									<label for="sup"><?php _e('Superficie Aproximada', 'villabrochero');?> Mts<sup>2</sup></label>
									<input name="sup" id="sup" min="0" type="number" placeholder="..." value="<?php echo $_POST['sup'];?>" />
								</div>
								<div>
									<label for="val"><?php _e('Valor Aproximado  en $:', 'villabrochero');?></label>
									<input name="val" id="val" min="0" type="number" placeholder="..." value="<?php echo $_POST['val'];?>" />
								</div>
								<div>
									<label for="val_dolar"><?php _e('Valor Aproximado  en U$s:', 'villabrochero');?></label>
									<input name="val_dolar" id="val_dolar" min="0" type="number" placeholder="..." value="<?php echo $_POST['val_dolar'];?>" />
								</div>
								<div>
									<label for="fin"><?php _e('Fin Principal del Inmueble:', 'villabrochero');?></label>
									<input name="fin" id="fin" type="text" maxlength="40" placeholder="..." value="<?php echo $_POST['fin'];?>" />
								</div>
								<div>
									<div class="respuesta"><?php echo $error4;?></div>
									<label for="oii"><?php _e('Mensaje:', 'villabrochero');?></label>
									<textarea name="oii" id="oii" placeholder="..." ><?php echo $_POST['oii'];?></textarea>
								</div>
								<div>
									<div class="respuesta"><?php echo $error5;?></div>
									<label for="codigo"><?php echo $_SESSION['math']; ?> =</label>
									<input placeholder="?" type="number" class="codigo" id="codigo" name="codigo" min="0" max="20" />
								</div>
								<div>
									<div class="clearfix"></div>
									<!-- <button type="submit" name="submit" id="submit" class="boton-negro">
										<?php //_e('Enviar', 'villabrochero');?>
									</button> -->
									<input type="submit" name="submit" class="boton-negro" value="<?php _e('Enviar', 'villabrochero');?>" />
									<button type="reset" name="submit2" id="submit2" class="boton-rojo">
										<?php _e('Borrar', 'villabrochero');?>
									</button>
									<div class="clearfix"></div>
								</div>
								<div class="respuesta"><?php echo $result;?></div>
							</fieldset>
						</form>
						<div class="clearfix"></div>
					</div>
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