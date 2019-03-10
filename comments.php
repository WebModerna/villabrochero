<?php
/*
* comments.php
* @package WordPress
* @subpackage emythargentina
* @since emythargentina 1.0
*/
?>

<?php
	if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die (__('Por favor, no cargues esta página directamente. Gracias :-D', 'emythargentina'));

	if ( post_password_required() )
	{ 
		_e('Esta publicación está protegida con contraseña. Iniciá sesión para ver los comentarios.', 'emythargentina');
		return;
	}
?>

<?php if ( have_comments() ) : ?>
	<header class="heading">
		<h2 id="comments">
			<span class="icon-comment-discussion right left"></span>
			<?php comments_number(__('No hay respuestas', 'emythargentina'), __('Una Respuesta', 'emythargentina'), __('% Respuestas', 'emythargentina'));?>
		</h2>
	</header>

	<div class="navigation">
		<div class="next-posts"><?php previous_comments_link();?></div>
		<div class="prev-posts"><?php next_comments_link();?></div>
	</div>

	<ul class="commentlist">
		<?php 
			wp_list_comments();
			$args = array(
				'walker'            => null,
				'max_depth'         => '',
				'style'             => 'ul',
				'callback'          => null,
				'end-callback'      => null,
				'type'              => 'all',
				'reply_text'        => __('Responder', 'emythargentina'),
				'page'              => '',
				'per_page'          => '',
				'avatar_size'       => 64,
				'reverse_top_level' => null,
				'reverse_children'  => '',
				'format'            => 'html5',	// or 'xhtml' if no 'HTML5' theme support
				'short_ping'        => false,	// @since 3.6
				'echo'              => true		// boolean, default is true
			);
		?>
	</ul>

	<div class="navigation">
		<div class="next-posts"><?php previous_comments_link();?></div>
		<div class="prev-posts"><?php next_comments_link();?></div>
	</div>

<?php else : // this is displayed if there are no comments so far ?>

	<?php if ( comments_open() ) : ?>
		<!-- If comments are open, but there are no comments. -->

	 <?php else : // comments are closed ?>

		<div class="alerta alerta-rojo">
			<div class="alerta--icono">
				<span class="icon-denied"></span>
			</div>
			<div class="alerta--mensaje">
				<h4><?php _e('Los comentarios están cerrados.', 'emythargentina');?></h4>
			</div>
			<div class="alerta--close">
				<a class="icon-x" href="#"></a>
			</div>
		</div>
 
	<?php endif; ?>

<?php endif; ?>

<?php if ( comments_open() ) : ?>

<div id="respond">
	<h2>
		<?php comment_form_title( __('Dejar un Comentario', 'emythargentina'), __('Dejar un Comentario a %s', 'emythargentina') ); ?>
	</h2>

	<div class="cancel-comment-reply">
		<?php cancel_comment_reply_link(); ?>
	</div>

	<?php if ( get_option('comment_registration') && !is_user_logged_in() ) : ?>
		<p>
			<a class="boton black small" href="<?php echo wp_login_url( get_permalink() ); ?>">
				<?php _e('Iniciar sesión', 'emythargentina');?>
			</a> 
			<?php _e('para publicar un comentario', 'emythargentina');?>.
		</p>
	<?php else : ?>


	<form class="vform" action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">

		<?php if ( is_user_logged_in() ) : ?>

			<div>
				<?php _e('Hola', 'emythargentina');?> 
				<a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php">
					<span class="icon-user2"></span>
					<?php echo $user_identity; ?>
				</a>
				<a class="boton rojo small" href="<?php echo wp_logout_url(get_permalink()); ?>" title="<?php __('Cerrar sesión', 'emythargentina') ?>">
					<?php _e('Salir', 'emythargentina');?>
                	<span class="icon-exit left"></span>
				</a>
			</div>

		<?php else : ?>

			<div>
				<input required="required" placeholder="<?php _e('Apellido y Nombre', 'emythargentina');?>" type="text" name="author" id="author" value="<?php echo esc_attr($comment_author); ?>" size="22" tabindex="1" <?php if ($req) echo "aria-required='true'"; ?> />
			</div>

			<div>
				<input required="required" placeholder="<?php _e('E-Mail. No será publicado', 'emythargentina');?>" type="text" name="email" id="email" value="<?php echo esc_attr($comment_author_email); ?>" size="22" tabindex="2" <?php if ($req) echo "aria-required='true'"; ?> />
			</div>

			<!-- <div>
				<input type="text" name="url" id="url" value="<?php // echo esc_attr($comment_author_url); ?>" size="22" tabindex="3" />
				<label for="url">Pagina Web</label>
			</div> -->

		<?php endif; ?>

		<!--<p>You can use these tags: <code><?php // echo allowed_tags(); ?></code></p>-->

		<div>
			<textarea required="required" placeholder="<?php _e('Comentario', 'emythargentina');?>" name="comment" id="comment" cols="58" rows="10" tabindex="4"></textarea>
		</div>

		<div>
			<button class="boton azul small" name="submit" type="submit" id="submit">
				<span class="icon-upload right"></span>
				<?php _e('Enviar Comentario', 'emythargentina');?>
			</button>
			<button class="boton rojo small" name="reset" type="reset" id="reset">
				<span class="icon-x right"></span>
				<?php _e('Limpiar', 'emythargentina');?>
			</button>
			<?php comment_id_fields(); ?>
		</div>

		<?php do_action('comment_form', $post->ID); ?>

	</form>

	<?php endif; // If registration required and not logged in ?>

</div>

<?php endif; ?>