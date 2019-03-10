<?php
/*
* footer.php
* @package WordPress
* @subpackage villabrochero
* @since villabrochero 1.0
* Text Domain: villabrochero
*/

// Variables de datos importantes
$facebook_contact = of_get_option('facebook_contact','');
$twitter_contact = of_get_option('twitter_contact','');
$linkedin_contact = of_get_option('linkedin_contact', '');
$google_plus_contact = of_get_option('google_plus_contact','');
$youtube_contact = of_get_option('youtube_contact','');
$email_contact = of_get_option('email_contact','');
$email_contact_ventas = of_get_option('email_contact_ventas','');
$google_analitycs = of_get_option('google_analitycs','');
$data_fiscal = of_get_option('data_fiscal','');
$telefono_fijo = of_get_option('telefono_fijo','');
$telefono_celular = of_get_option('telefono_celular','');
$direccion_web = of_get_option('direccion_web','');
$horario = of_get_option('horario_web', '');

?>
	<footer class="footer gradient">
		<div class="footer--tabla">
			<div class="copyright">
				<h4><?php _e('Dirección', 'villabrochero');?></h4>
				<?php if( $direccion_web ) {
					echo $direccion_web;
				};?>
			</div>
			<div class="copyright">
				<h4><?php _e('Horario de atención', 'villabrochero');?></h4>
				<?php if( $horario ) {
					echo $horario;
				};?>

				<?php if( $data_fiscal ) {
					echo '<div class="data_fiscal">' . $data_fiscal . '</div>';
				};?>
			</div>
			<div class="copyright">
				<h4><?php _e('Contacto', 'villabrochero');?></h4>
				<ul>
					<?php if ( $email_contact ) {
						echo '<li><span class="icono-mail icono-right"></span>';
						echo $email_contact;
						echo '</li>';
					}
					if ( $email_contact_ventas ) {
						echo '<li><span class="icono-cart icono-right"></span>';
						echo $email_contact_ventas;
						echo '</li>';
					}
					if( $telefono_fijo ) {
						echo '<li><span class="icono-phone icono-right"></span>';
						echo $telefono_fijo;
						echo '</li>';
					}
					if( $telefono_celular ) {
						echo '<li><span class="icono-mobile icono-right"></span>';
						echo $telefono_celular;
						echo '</li>';
					};?>
					<li>
						<ul>
						<?php if( $linkedin_contact )
						{
						echo '
							<li class="redes_sociales">
								<a title="LinkedIn" target="_blank" class="icono-linkedin" href="//' . $linkedin_contact . '"></a>
							</li>';
						}
						if( $facebook_contact )
						{
						echo '
							<li class="redes_sociales">
								<a title="Facebook" target="_blank" class="icono-facebook2" href="//' . $facebook_contact . '"></a>
							</li>';
						}

						if( $twitter_contact )
						{
						echo '
							<li class="redes_sociales">
								<a title="Twitter" target="_blank" class="icono-twitter2" href="//' . $twitter_contact . '"></a>
							</li>';
						}

						if( $google_plus_contact )
						{
						echo '
							<li class="redes_sociales">
								<a title="Google+" target="_blank" class="icono-google-plus2" href="//' . $google_plus_contact . '"></a>
							</li>';
						};

						if( $youtube_contact )
						{
						echo '
							<li class="redes_sociales">
								<a title="Youtube" target="_blank" class="icono-youtube4" href="//' . $youtube_contact . '"></a>
							</li>';
						};?>
						</ul>
					</li>
				</ul>
			</div>
		</div>

		<div>
			<p>
				<?php if ( function_exists( 'display_copyright' ) ) display_copyright();?>
			</p>
			<p><?php _e('Desarrollado por: ', 'villabrochero');?><a href="http://www.webmoderna.com.ar" target="_blank">WebModerna</a>
			</p>
		</div>

		<a id="ir_arriba" class="gotop gradient" href="#" title="<?php _e('Ir arriba', 'villabrochero');?>"></a>
	</footer>
<script type="text/javascript" src="<?php bloginfo('stylesheet_directory');?>/js/scripts.js"></script>
<?php
// Esto es un experimento para acelerar la navegación
// echo '<script type="text/javascript">';
// require_once 'js/scripts.js';
// echo '</script>';
if( wpmd_is_notdevice() ) { ?>
<!--[if IE 8]>
	<script type="text/javascript" defer src="<?php bloginfo('stylesheet_directory');?>/js/scriptsIE8.js"></script>
<![endif]-->
<?php };
if ( is_single() )
{
	$calendario = get_post_meta( $post->ID, '_my_meta_value_key2', true );
	if ( $calendario )
	{
		echo '<script type="text/javascript" src="' . get_stylesheet_directory_uri() . '/js/datepicker.js"></script>';
?>
		<script type="text/javascript">
			(function()
			{
				// Deshabilitador de fechas del almanaque
				$(document).on("ready", fechador);
				function fechador()
				{
					// Días deshabilitados guardados en la base de datos
					var DiasDeshabilitados = [<?php echo $calendario;?>];
					$(function()
					{
						$(".datepicker").datepicker(
						{
							showButtonPanel: true,
							beforeShowDay : function(date)
							{
								var string = jQuery.datepicker.formatDate("dd-mm-yy", date);
								return [ $.inArray(string, DiasDeshabilitados) == -1 ];
							}
						});
					});
				}
			}());
		</script>
<?php };
};
if ( $google_analitycs )
{
	echo '<script type="text/javascript">' . $google_analitycs . '</script>';
};?>
</div><!-- .wrapper -->
<?php wp_footer();?>
</body>
</html>