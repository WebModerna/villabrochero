<?php
/*
* functions.php
* @package WordPress
* @subpackage villabrochero
* @since villabrochero 1.0
*/

// Captcha en el login
function start_login_session()
{
	if(!session_id())
	{
		session_start();
	}
}
add_action('init','start_login_session', 1);
function destroy_login_session()
{
	session_destroy();
}
add_action('wp_logout','destroy_login_session');
add_action('wp_login','destroy_login_session');


function add_captcha_field()
{
	// Lo de antes
	// $cap = rand(1000,9999);
	// $_SESSION['captcha'] = $cap;

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
	$_SESSION['captcha'] = $_SESSION['answer'];

	echo '<p><label for="user_catpcha">' . __('Cuánto es ', 'emyth') . $_SESSION['math'] . ' = ';
	echo '<input class="input" type="number" min="0" max="20" placeholder="...?" id="user_catpcha" name="user_catpcha" style="width:100px;" />';
	echo '</label></p>';
}
add_action( 'login_form', 'add_captcha_field' );

function user_captcha_authenticate( $user, $username, $password )
{
	$submission = $_POST['user_catpcha'];
	$user = get_user_by('login', $username);
	$random = $_SESSION['captcha'];
	if (!$user||empty($submission)||$submission != $random)
	{
		remove_action( 'authenticate', 'wp_authenticate_username_password', 20);
		return new WP_Error( 'die', '<strong>ERROR</strong>!' );
		unset( $_SESSION['captcha'] );
	}
	return;
	unset( $_SESSION['captcha'] );
}
add_filter( 'authenticate', 'user_captcha_authenticate', 10, 3 );

// Detección de móviles.
require_once "includes/wp-mobile-detect.php";

// Configuración del slider
require_once "includes/options-slider.php";

// Regenerar los thumbnails
require_once "includes/regenerate-thumbnails.php";

// Cargar Panel de Opciones
if ( !function_exists( 'optionsframework_init' ) )
{
	define( 'OPTIONS_FRAMEWORK_DIRECTORY', get_template_directory_uri() . '/includes/' );
	require_once dirname( __FILE__ ) . '/includes/options-framework.php';
}

// Acortar títulos acorde al SEO
function titulolargo($title)
{
	global $post;
	$title = $post->post_title;
	if (str_word_count($title) >= 12 ) //aqui definimos el máximo de palabras permitidas
	wp_die( __('Error: tu título sobrepasa el máximo de palabras razonable, vuelve atrás y mejóralo, tus lectores te lo agradecerán.', 'villabrochero') );
}
add_action('publish_post', 'titulolargo');

// Deshabilitar Iconos Emoji
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');

// Remover los rel="wp-att de las imágenes"
function my_remove_rel_attr($content) {
	return preg_replace('/\s+rel="attachment wp-att-[0-9]+"/i', '', $content);
}
add_filter('the_content', 'my_remove_rel_attr');

// Agregando un favion al área de administración
function admin_favicon()
{
	echo '<link rel="shortcut icon" type="image/x-icon" href="'.get_bloginfo('stylesheet_directory').'/favicon.ico" />';
}
add_action('admin_head', 'admin_favicon', 1);


// Deshabilitar el mensaje de actualización del WordPress
if ( !current_user_can( 'edit_users' ) )
{
	add_action( 'init', create_function( '$a', "remove_action( 'init', 'wp_version_check' );" ), 1 );
	add_filter( 'pre_option_update_core', create_function( '$a', "return null;" ) );
}

// Desactivar el rest api
add_filter('rest_enabled', '_return_false');
add_filter('rest_jsonp_enabled', '_return_false');
remove_action( 'wp_head', 'rest_output_link_wp_head', 10 );
remove_action( 'wp_head', 'wp_oembed_add_discovery_links', 10 );

// Agregar clases a los enlaces de los posts next y back
function add_class_next_post_link($html)
{
	$html = str_replace('<a','<a title="'.__('Siguiente', 'villabrochero').'" ', $html);
	return $html;
}
add_filter('next_post_link','add_class_next_post_link', 10, 1);

function add_class_previous_post_link($html)
{
	$html = str_replace('<a','<a title="'.__('Anterior', 'villabrochero').'" ', $html);
	return $html;
	echo '<span style="padding-right:2em;"></span>';
}
add_filter('previous_post_link','add_class_previous_post_link', 10, 1);

// Desactivar el script de embebidos
function my_deregister_scripts()
{
 	wp_deregister_script( 'wp-embed' );
}
add_action( 'wp_footer', 'my_deregister_scripts' );

// Permitir comentarios encadenados
function enable_threaded_comments()
{
	if( is_singular() AND comments_open() AND ( get_option( 'thread_comments' ) == 1 ) )
	{
		wp_enqueue_script('comment-reply');
	}
};
add_action( 'get_header','enable_threaded_comments', 1 );

// Desactivar el código HTML en los comentarios
add_filter('pre_comment_content', 'wp_specialchars');


// Remover clases automáticas del the_post_thumbnail
function the_post_thumbnail_remove_class( $output )
{
	$output = preg_replace( '/class=".*?"/', '', $output );
	return $output;
}
add_filter( 'post_thumbnail_html', 'the_post_thumbnail_remove_class'  );


//Remover atributos de ancho y alto de las imágenes insertadas
add_filter( 'post_thumbnail_html', 'remove_width_attribute', 10 );
add_filter( 'image_send_to__ditor', 'remove_width_attribute', 10 );
function remove_width_attribute( $html )
{
   $html = preg_replace( '/(width|height)="\d*"\s/', "", $html );
   return $html;
};


//Cambiar el logo del login y la url del mismo y el título
function custom_login_logo()
{
	echo '<link rel="shortcut icon" type="image/x-icon" href="'.get_stylesheet_directory_uri().'/favicon.ico" />';
	echo '<style type="text/css">
		body.login
		{
			background: rgb(0,100,78);
			background: url("data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiA/Pgo8c3ZnIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgd2lkdGg9IjEwMCUiIGhlaWdodD0iMTAwJSIgdmlld0JveD0iMCAwIDEgMSIgcHJlc2VydmVBc3BlY3RSYXRpbz0ibm9uZSI+CiAgPHJhZGlhbEdyYWRpZW50IGlkPSJncmFkLXVjZ2ctZ2VuZXJhdGVkIiBncmFkaWVudFVuaXRzPSJ1c2VyU3BhY2VPblVzZSIgY3g9IjUwJSIgY3k9IjUwJSIgcj0iNzUlIj4KICAgIDxzdG9wIG9mZnNldD0iMCUiIHN0b3AtY29sb3I9IiMwMDY0NGUiIHN0b3Atb3BhY2l0eT0iMSIvPgogICAgPHN0b3Agb2Zmc2V0PSI3NSUiIHN0b3AtY29sb3I9IiMwMDQxMzQiIHN0b3Atb3BhY2l0eT0iMSIvPgogIDwvcmFkaWFsR3JhZGllbnQ+CiAgPHJlY3QgeD0iLTUwIiB5PSItNTAiIHdpZHRoPSIxMDEiIGhlaWdodD0iMTAxIiBmaWxsPSJ1cmwoI2dyYWQtdWNnZy1nZW5lcmF0ZWQpIiAvPgo8L3N2Zz4=");
			background: -moz-radial-gradient(center, ellipse cover, rgba(0,100,78,1) 0%,rgba(0,65,52,1) 75%);
			background: -webkit-radial-gradient(center, ellipse cover, rgba(0,100,78,1) 0%,rgba(0,65,52,1) 75%);
			background: radial-gradient(ellipse at center, rgba(0,100,78,1) 0%,rgba(0,65,52,1) 75%);
			filter: progid:DXImageTransform.Microsoft.gradient( startColorstr="#00644e", endColorstr="#004134",GradientType=1 );
			height: 100% !important;
			height: 100vw !important;
		}
		h1
		{
			padding-top: 20px !important;
		}
		h1 a
		{
			background: transparent url('.get_bloginfo('stylesheet_directory').'/img/logo_small2.png) center center no-repeat !important;
			background-size: auto 80px !important;
			-o-background-size: auto 80px !important;
			-ms-background-size: auto 80px !important;
			-moz-background-size: auto 80px !important;
			-webkit-background-size: auto 80px !important;
			height: 80px !important;
			position: relative;
			overflow: hidden !important;
			width: 320px !important;
			text-indent: none !important;
		}
		div#login
		{
			padding: 0 !important;
		}
		.message, #loginform, h1 a
		{
			border-radius: 5px;
			-moz-border-radius: 5px;
			-webkit-border-radius: 5px;

		}

		</style>';
};
add_action( 'login_head', 'custom_login_logo', 1 );
function the_url( $url )
{
	return get_bloginfo( 'url' );
}
add_filter( 'login_headerurl', 'the_url' );
function change_wp_login_title()
{
	return get_option('blogname');
}
add_filter( 'login_headertitle', 'change_wp_login_title' );


//Permitir svg en las imágenes para cargar.
function cc_mime_types( $mimes )
{
	$mimes['svg'] = 'image/svg+xml';
	return $mimes;
}
add_filter( 'upload_mimes', 'cc_mime_types' );


// Deshabilitar la edición desde otros programas, el link corto y la versión del WP.
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'feed_links', 2);
remove_action('wp_head', 'index_rel_link', 1);
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'feed_links__xtra', 3);
remove_action('wp_head', 'wp_shortlink_wp_head');
remove_action('wp_head', 'parent_post_rel_link', 10, 0);
remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0);
remove_action('wp_head', 'start_post_rel_link', 10, 0);
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
remove_action('wp_head', 'rel_canonical');

// Renombramiento de la sección de Categorías y Etiquetas
function revcon_change_post_label()
{
	global $menu;
	global $submenu;
	$menu[5][0] = 'Propiedades';
	$submenu['edit.php'][5][0] = 'Todas las Propiedades';
	$submenu['edit.php'][10][0] = 'Agregar Propiedades';
	$submenu['edit.php'][15][0] = 'Tipos de Propiedades'; // Change name for categories
	// $submenu['edit.php'][16][0] = 'Precios de Propiedades'; // Change name for tags
	echo '';
}

// Renombrar la denominación de las entradas por "Propiedades"
function renombramiento_entradas()
{
	global $wp_post_types;
	$labels = &$wp_post_types['post']->labels;
	$labels->name = 'Propiedades';
	$labels->singular_name = 'Propiedades';
	$labels->add_new = 'Agregar nueva Propiedad';
	$labels->add_new_item = 'Agregar Propiedades';
	$labels->edit_item = 'Editar Propiedades';
	$labels->new_item = 'Propiedades';
	$labels->view_item = 'Ver Propiedad';
	$labels->search_items = 'Buscar Propiedades';
	$labels->not_found = 'No hay Propiedades';
	$labels->not_found_in_trash = 'No Propiedades en la Papelera';
	$labels->all_items = 'Todos los Propiedades';
	$labels->menu_name = 'Propiedades';
	$labels->name_admin_bar = 'Propiedades';
}
add_action( 'init', 'renombramiento_entradas', 1 );
add_action( 'admin_menu', 'revcon_change_post_label', 1 );

//Remover clases e ids automáticos de los menúes
add_filter('nav_menu_css_class', 'my_css_attributes_filter', 100, 1);
add_filter('nav_menu_item_id', 'my_css_attributes_filter', 100, 1);
add_filter('page_css_class', 'my_css_attributes_filter', 100, 1);
function my_css_attributes_filter( $var )
{
	return is_array( $var ) ? array_intersect( $var, array( 'current-menu-item', 'current_page_item' ) ) : '';
};


// Personalizar las palabras del excerpt.
function custom__xcerpt_length( $length )
{
	return 40;
};
add_filter( 'excerpt_length', 'custom__xcerpt_length' );


/*
//Remover versiones de los scripts y css innecesarios
function remove_script_version( $src )
{
	$parts = explode( '?', $src ); return $parts[0];
};
add_filter('script_loader_src', 'remove_script_version', 15, 1);
add_filter('style_loader_src', 'remove_script_version', 15, 1);
*/


// Deshabilitar los enlaces automáticos en los comentarios
remove_filter( 'comment_text', 'make_clickable', 9 );


//Cambio del avatar de WordPress por uno personalizado
function sp_gravatar ($avatar)
{
	$custom_avatar = get_stylesheet_directory_uri() . '/img/logo.png';
	$avatar[$custom_avatar] = "villabrochero ícono";
	return $avatar;
}
add_filter( 'avatar_defaults', 'sp_gravatar' );


//Modifica el pie de página del panel de administarción
function remove_footer_admin()
{
	echo _e('Desarrollado por', 'villabrochero').' <a title="'.__('WebModerna | el futuro de la web', 'villabrochero').'" href="http://www.webmoderna.com.ar" target="_blank"> <img alt="WebModerna" title="WebModerna" src="'.get_bloginfo("stylesheet_directory").'/img/webmoderna11.png" width="150" style="display:inline-block;vertical-align:middle;" /></a>';
	echo '<style type="text/css">.column-Codigo_Propiedad { width: 8em !important;}</style>';
};
add_filter('admin_footer_text','remove_footer_admin');


//Modificar los campos del perfil de usuario de WordPress
function extra_contact_info($contactmethods)
{
	unset($contactmethods['aim']);
	unset($contactmethods['yim']);
	unset($contactmethods['jabber']);
	// $contactmethods['facebook']='Facebook';
	// $contactmethods['twitter']='Twitter';
	// $contactmethods['google_mas']='Google+';
	return $contactmethods;
};
add_filter( 'user_contactmethods', 'extra_contact_info' );


//Remover versión del WordPress
function remove_wp_version() { return ''; };
add_filter( 'the_generator', 'remove_wp_version' );


//Eliminar el atributo rel="category tag".
function remove_category_list_rel($output)
{
	return str_replace( 'rel="category tag"', '', $output );
};
add_filter( 'wp_list_categories', 'remove_category_list_rel' );
add_filter( 'the_category', 'remove_category_list_rel' );


//Eliminar css y scripts de comentarios cuando no hagan falta
function clean_header()
{
	wp_deregister_script( 'comment-reply' );
};
add_action( 'init', 'clean_header', 1 );

// Cargar scripts para comentarios solo en single.php
function wd_single_scripts()
{
   if( is_singular() )
	{
		// Carga el javascript necesario para los comentarios anidados
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action('wp_print_scripts', 'wd_single_scripts', 1);


//Definir tamaños personalizados de miniaturas - hay que configurarlas
add_theme_support( 'post-thumbnails', array(
	'post',
	'page',
	'sliders'
	)
);

// Todos los tamaños de imágnes
add_action( 'after_setup_theme', 'setup_thumbnails' );
function setup_thumbnails()
{
	// add_image_size( 'image', 240, 240 );
	// add_image_size( 'image-2x', 480, 480 );
	// add_image_size( 'image-3x', 620, 620 );
	the_post_thumbnail( 'thumbnail' );
	the_post_thumbnail( 'medium' );
	the_post_thumbnail( 'large' );
	the_post_thumbnail( 'full' ); // Full resolution (original size uploaded)

	add_image_size('custom-thumb-1024-600', 1990, 1200, true);
	add_image_size('custom-thumb-1024-400', 1990, 1000, true);
	add_image_size('custom-thumb-400-300', 800, 600, true);

	// Fotos redimensionables según el tamaño de pantalla
	add_image_size('custom-thumb-800-x', 1600, false);
	add_image_size('custom-thumb-600-x', 1200, false);
}


// Habilitar la compresión de imágenes
add_filter( 'jpeg_quality', create_function( '', 'return 50;' ) );

//Las miguitas de pan ;-)
function the_breadcrums()
{
// Defino la ubicación como una variable; así la puedo cargar en la función del breadcrums.
	$ubicacion = __('Ud. está aquí: ', 'villabrochero');
	echo '<ul class="breadcrums">';
	if ( !is_home() )
	{
		echo '<li class="breadcrums--label">' . $ubicacion . '</li>';
		echo '<li><a href="';
		echo get_option('home');
		echo '">';
		echo _e('Inicio', 'villabrochero');
		echo '</a></li>';

		if ( is_category() )
		{
			echo single_cat_title( "<li>", true, "</li>" );
		};

		if ( is_single() )
		{
			echo '<li>';
			the_category( '<li></li>' );
			echo '</li>';
			echo '<li class="breadcrums-muted">';
			echo the_title();
			echo '</li>';
		};

		if ( is_page() )
		{
			echo '<li class="breadcrums-muted">';
			echo the_title();
			echo '</li>';
		};
	};
echo '</ul>';
};


// gets the value of the custom field featured_image and prints it.
if ( function_exists( 'get_custom_field_value' ) ) get_custom_field_value( 'featured_image', true );



//Registrar las menúes de navegación
register_nav_menus ( array(
	'header_nav'	=>	__( 'Menú Principal', 'villabrochero' ),
	'second_nav'	=>	__( 'Menú Secundario', 'villabrochero' )
	)
);


// Agregar nofollow a los enlaces externos
function auto_nofollow( $content )
{
	return preg_replace_callback( '/<a>]+/', 'auto_nofollow_callback', $content );
}
function auto_nofollow_callback( $matches )
{
	$link = $matches[0];
	$site_link = get_bloginfo( 'url' );
	if ( strpos( $link, 'rel' ) === false )
	{
		$link = preg_replace( "%(href=S(?!$site_link))%i", 'rel="nofollow" $1', $link );
	}
	elseif ( preg_match( "%href=S(?!$site_link)%i", $link ) )
	{
		$link = preg_replace( '/rel=S(?!nofollow)S*/i', 'rel="nofollow"', $link );
	}
	return $link;
}
add_filter( 'comment_text', 'auto_nofollow' );


//Habilitar botones de edición avanzados
function habilitar_mas_botones( $buttons )
{
	$buttons[] = 'hr';
	$buttons[] = 'sub';
	$buttons[] = 'sup';
	$buttons[] = 'fontselect';
	$buttons[] = 'fontsizeselect';
	$buttons[] = 'cleanup';
	$buttons[] = 'styleselect';
	return $buttons;
};
add_filter( "mce_buttons_3", "habilitar_mas_botones" );


// Paginación avanzada
function pagination($pages = '', $range = 2 )
{
	$pagina_palabra			= __('Página', 'villabrochero');
	$de_palabra				= __('de', 'villabrochero');
	$primero				= __('Primero', 'villabrochero');
	$atras					= __('Atrás', 'villabrochero');
	$siguiente				= __('Siguiente', 'villabrochero');
	$ultimo					= __('Último', 'villabrochero');
	$showitems				= ($range * 2) + 1;
	global $paged;
	if( empty( $paged ) ) $paged = 1;
	if( $pages == '' )
	{
		global $wp_query;
		$pages = $wp_query->max_num_pages;
		if( !$pages )
		{
			$pages = 1;
		}
	}
	if( 1 != $pages )
	{
		echo "<span>" . $pagina_palabra . " " . $paged . " " . $de_palabra . " " . $pages . "</span>";

		if( $paged > 2 && $paged > $range+1 && $showitems < $pages ) echo "<a class='pagination--primero' href='" . get_pagenum_link(1) . "' title=" . $primero . ">&laquo;</a>";

		if( $paged > 1 && $showitems < $pages ) echo "<a class='pagination--atras' title=" . $atras . " href='" . get_pagenum_link( $paged - 1 ) . "'>&lsaquo;</a>";

		for ( $i = 1; $i <= $pages; $i++ )
		{
			if ( 1 != $pages && ( !($i >= $paged + $range + 1 || $i <= $paged - $range - 1) || $pages <= $showitems ) )
			{
				echo ( $paged == $i )? "<span class='current'>" . $i . "</span>":"<a href='".get_pagenum_link($i) . "' class='inactive' title='" . $i . "'>". $i . "</a>";
			}
		}
		if ( $paged < $pages && $showitems < $pages ) echo "<a class='pagination--siguiente' title=" . $siguiente . " href='" . get_pagenum_link( $paged + 1 ) . "'>&rsaquo;</a>";

		if ( $paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) echo "<a class='pagination--ultimo' title=".$ultimo." href='".get_pagenum_link($pages)."'>&raquo;</a>";
	}
};


//Para hacer posible que esta plantilla pueda cambiar de idioma
load_theme_textdomain( 'villabrochero', TEMPLATEPATH . '/language' );
$locale = get_locale();
$locale_file = TEMPLATEPATH . "/language/$locale.php";
if( is_readable( $locale_file ) ) require_once( $locale_file );


//Detén las adivinanzas de URLs de WordPress
add_filter( 'redirect_canonical', 'stop_guessing' );
function stop_guessing( $url )
{
	if( is_404() )
	{
		return false;
	}
	return $url;
}

//Ocultar los errores en la pantalla de Inicio de sesión de WordPress
function no__rrors_please()
{
	return __( '¡Sal de mi jardín! ¡AHORA MISMO!', 'villabrochero' );
};
add_filter( 'login__rrors', 'no__rrors_please' );


//Eliminar palabras cortas de URL
function remove_short_words( $slug )
{
	if ( !is_admin() ) return $slug;
	$slug = explode( '-', $slug );
	foreach  ($slug as $k => $word )
	{
		if ( strlen( $word ) < 3 )
		{
			unset( $slug[$k] );
		}
	}
	return implode( '-', $slug );
};
add_filter( 'sanitize_title', 'remove_short_words' );

/*
// Relativas las url.
function relative_url()
{
	// Don't do anything if:
	// - In feed
	// - In sitemap by WordPress SEO plugin
	if ( is_feed() || get_query_var( 'sitemap' ) )
	return;
	$filters = array(
	'post_link',       // Normal post link
	'post_type_link',  // Custom post type link
	'page_link',       // Page link
	'attachment_link', // Attachment link
	'get_shortlink',   // Shortlink
	'post_type_archive_link',    // Post type archive link
	'get_pagenum_link',          // Paginated link
	'get_comments_pagenum_link', // Paginated comment link
	'term_link',   // Term link, including category, tag
	'search_link', // Search link
	'day_link',   // Date archive link
	'month_link',
	'year_link',

	// site location
	// Los comento porque generan error en el modo Depuración en WordPress

	// 'option_siteurl',
	'option_home', // Puede usarse
	// 'admin_url',
	'home_url', // TAmbien usarse
	// 'site_url',//Hasta acá estaba comentado
	'blog_option_siteurl',
	'includes_url',
	'site_option_siteurl',
	'network_home_url',
	'network_site_url',

	// debug only filters
	'get_the_author_url',
	'get_comment_link',
	'wp_get_attachment_image_src',
	'wp_get_attachment_thumb_url',
	'wp_get_attachment_url',
	'wp_login_url',
	'wp_logout_url',
	'wp_lostpassword_url',
	'get_stylesheet_uri',
	'get_stylesheet_directory_uri',//
	'plugins_url',//
	'plugin_dir_url',//
	'stylesheet_directory_uri',//
	'get_template_directory_uri',//
	'template_directory_uri',//
	'get_locale_stylesheet_uri',
	'script_loader_src', // plugin scripts url
	'style_loader_src', // Este también estaba comentado
	'get_theme_root_uri',
	// Comento para omitir error en Depuración en WordPress
	);
	foreach ( $filters as $filter )
	{
		add_filter( $filter, 'wp_make_link_relative' );
	};
	home_url( $path = '', $scheme = null );
};
add_action( 'template_redirect', 'relative_url', 0 );
*/

// Taxonomías para la inmobiliaria
function taxonomia_operaciones()
{
	$labels = array(
		'name'                       => _x( 'Tipo de Operación', 'Operación de la Propiedad', 'villabrochero' ),
		'singular_name'              => _x( 'Operación', 'Taxonomy Singular Name', 'villabrochero' ),
		'menu_name'                  => __( 'Tipos de Operaciones', 'villabrochero' ),
		'all_items'                  => __( 'Todas las Operaciones', 'villabrochero' ),
		'parent_item'                => __( 'Operación superior', 'villabrochero' ),
		'parent_item_colon'          => __( 'Operación superior:', 'villabrochero' ),
		'new_item_name'              => __( 'Nuevas Operaciones', 'villabrochero' ),
		'add_new_item'               => __( 'Agregar Nuevas Operaciones', 'villabrochero' ),
		'edit_item'                  => __( 'Editar Operación', 'villabrochero' ),
		'update_item'                => __( 'Actualizar Operación', 'villabrochero' ),
		'view_item'                  => __( 'Ver Operación', 'villabrochero' ),
		'separate_items_with_commas' => __( 'Separar Operaciones con comas', 'villabrochero' ),
		'add_or_remove_items'        => __( 'Agregar o remover Operaciones', 'villabrochero' ),
		'choose_from_most_used'      => __( 'Elegir las Operaciones más utilizadas', 'villabrochero' ),
		'popular_items'              => __( 'Operaciones populares', 'villabrochero' ),
		'search_items'               => __( 'Buscar Operaciones', 'villabrochero' ),
		'not_found'                  => __( 'No hay Operaciones', 'villabrochero' ),
		'no_terms'                   => __( 'No hay Operaciones', 'villabrochero' ),
		'items_list'                 => __( 'Listado de Operaciones', 'villabrochero' ),
		'items_list_navigation'      => __( 'Listado de enlaces a Operaciones', 'villabrochero' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => false,
		'show_tagcloud'              => false,
		'rewrite'                    => false,
	);
	register_taxonomy( 'operaciones', array( 'post' ), $args );
}
add_action( 'init', 'taxonomia_operaciones', 0 );


function taxonomia_zonas()
{
	$labels = array(
		'name'                       => _x( 'Localidad', 'Taxonomy General Name', 'villabrochero' ),
		'singular_name'              => _x( 'Localidad', 'Taxonomy Singular Name', 'villabrochero' ),
		'menu_name'                  => __( 'Localidades', 'villabrochero' ),
		'all_items'                  => __( 'Todas las Localidades', 'villabrochero' ),
		'parent_item'                => __( 'Localidad superior', 'villabrochero' ),
		'parent_item_colon'          => __( 'Localidad superior:', 'villabrochero' ),
		'new_item_name'              => __( 'Nuevas Localidades', 'villabrochero' ),
		'add_new_item'               => __( 'Agregar Nuevas Localidades', 'villabrochero' ),
		'edit_item'                  => __( 'Editar Localidad', 'villabrochero' ),
		'update_item'                => __( 'Actualizar Localidad', 'villabrochero' ),
		'view_item'                  => __( 'Ver Localidad', 'villabrochero' ),
		'separate_items_with_commas' => __( 'Separar Localidades con comas', 'villabrochero' ),
		'add_or_remove_items'        => __( 'Agregar o remover Localidades', 'villabrochero' ),
		'choose_from_most_used'      => __( 'Elegir las Localidades más utilizadas', 'villabrochero' ),
		'popular_items'              => __( 'Localidades más populares', 'villabrochero' ),
		'search_items'               => __( 'Buscar Localidades', 'villabrochero' ),
		'not_found'                  => __( 'No hay Localidades', 'villabrochero' ),
		'no_terms'                   => __( 'No hay Localidades', 'villabrochero' ),
		'items_list'                 => __( 'Listado de Localidades', 'villabrochero' ),
		'items_list_navigation'      => __( 'Listado de enlaces a Localidades', 'villabrochero' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => false,
		'show_tagcloud'              => false,
		'rewrite'                    => false,
	);
	register_taxonomy( 'zonas', array( 'post' ), $args );
}
add_action( 'init', 'taxonomia_zonas', 0 );


function taxonomia_precios()
{

	$labels = array(
		'name'                       => _x( 'Precios de la Propiedad', 'Taxonomy General Name', 'villabrochero' ),
		'singular_name'              => _x( 'Precio', 'Taxonomy Singular Name', 'villabrochero' ),
		'menu_name'                  => __( 'Precios de la Propiedad', 'villabrochero' ),
		'all_items'                  => __( 'Todos los Precios', 'villabrochero' ),
		'parent_item'                => __( 'Precio superior', 'villabrochero' ),
		'parent_item_colon'          => __( 'Precio superior:', 'villabrochero' ),
		'new_item_name'              => __( 'Nuevos Precios', 'villabrochero' ),
		'add_new_item'               => __( 'Agregar Nuevos Precios', 'villabrochero' ),
		'edit_item'                  => __( 'Editar Precio', 'villabrochero' ),
		'update_item'                => __( 'Actualizar Precio', 'villabrochero' ),
		'view_item'                  => __( 'Ver Precio', 'villabrochero' ),
		'separate_items_with_commas' => __( 'Separar Precios con comas', 'villabrochero' ),
		'add_or_remove_items'        => __( 'Agregar o remover Precios', 'villabrochero' ),
		'choose_from_most_used'      => __( 'Elegir los Precios más utilizadas', 'villabrochero' ),
		'popular_items'              => __( 'Precios populares', 'villabrochero' ),
		'search_items'               => __( 'Buscar Precios', 'villabrochero' ),
		'not_found'                  => __( 'No hay Precios', 'villabrochero' ),
		'no_terms'                   => __( 'No hay Precios', 'villabrochero' ),
		'items_list'                 => __( 'Listado de Precios', 'villabrochero' ),
		'items_list_navigation'      => __( 'Listado de enlaces a Precios', 'villabrochero' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => false,
		'show_tagcloud'              => false,
		'rewrite'                    => false,
	);
	register_taxonomy( 'precios', array( 'post' ), $args );
}
add_action( 'init', 'taxonomia_precios', 0 );

// Metabox: Calendario de Reservas
function myplugin_add_meta_box2()
{
	$screens = array( 'post' );
	foreach ( $screens as $screen )
	{
		add_meta_box(
			'myplugin_sectionid2',
			__( 'Calendario de Reservas.', 'villabrochero' ),
			'myplugin_meta_box_callback2',
			$screen,
			'side'
		);
	}
}
add_action( 'add_meta_boxes', 'myplugin_add_meta_box2' );

function myplugin_meta_box_callback2( $post )
{
	// Scripts y estilos del multidatepicker
	// Esto lo puso para reducir las peticiones al servidor, a costa de ensuciar el código
	echo '<link rel="stylesheet" href="'.get_stylesheet_directory_uri().'/css/jquery-ui.css" />';
	echo '<link rel="stylesheet" href="'.get_stylesheet_directory_uri().'/css/jquery-ui.structure.css" />';
	echo '<link rel="stylesheet" href="'.get_stylesheet_directory_uri().'/css/jquery-ui.theme.css" />';
	echo '<link rel="stylesheet" href="'.get_stylesheet_directory_uri().'/css/pepper-ginder-custom.css" />';
	// echo '<style type="text/css">';
	// require_once dirname( __FILE__ ) . '/css/jquery-ui.css';
	// require_once dirname( __FILE__ ) . '/css/jquery-ui.structure.css';
	// require_once dirname( __FILE__ ) . '/css/jquery-ui.theme.css';
	// require_once dirname( __FILE__ ) . '/css/pepper-ginder-custom.css';
	// echo '</style>';


	echo '<script type="text/javascript" src="'.get_stylesheet_directory_uri().'/js/jquery-1.11.1.js"></script>';
	echo '<script type="text/javascript" src="'.get_stylesheet_directory_uri().'/js/jquery-ui-1.11.1.js"></script>';
	echo '<script type="text/javascript" src="'.get_stylesheet_directory_uri().'/js/jquery-ui.multidatespicker.js"></script>';

	// Esto lo puso para reducir las peticiones al servidor, a costa de ensuciar el código
	// echo '<script type="text/javascript">';
	// require_once dirname( __FILE__ ) . '/js/jquery-1.11.1.js';
	// require_once dirname( __FILE__ ) . '/js/jquery-ui-1.11.1.js';
	// require_once dirname( __FILE__ ) . '/js/jquery-ui.multidatespicker.js';
	// echo '</script>';
	

	$value = get_post_meta( $post->ID, '_my_meta_value_key2', true );
	wp_nonce_field( 'myplugin_meta_box2', 'myplugin_meta_box_nonce2' );
	echo '<label for="myplugin_new_field2" class="multidatespicker">' . _e("Hacer clic en el campo del formulario y luego clic en las fechas deseadas", "villabrochero") . '</label>';
	echo '<input type="text" class="multidatespicker" id="myplugin_new_field2" name="myplugin_new_field2" value="' . esc_attr( $value ) . '" />';
?>
	<script type="text/javascript">
		$(".multidatespicker").multiDatesPicker(
		{
			dateFormat: '"dd-mm-yy"',
			showButtonPanel : true
		})
	</script>
<?php
}

function myplugin_save_meta_box_data2( $post_id )
{
	if ( ! isset( $_POST['myplugin_meta_box_nonce2'] ) )
	{
		return;
	}
	if ( ! wp_verify_nonce( $_POST['myplugin_meta_box_nonce2'], 'myplugin_meta_box2' ) )
	{
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
	{
		return;
	}
	if ( isset( $_POST['post_type'] ) && 'myplugin_new_field2' == $_POST['post_type'] )
	{
		if ( ! current_user_can( 'edit_page', $post_id ) )
		{
			return;
		}
	}
	else
	{
		if ( ! current_user_can( 'edit_post', $post_id ) )
		{
			return;
		}
	}
	if ( ! isset( $_POST['myplugin_new_field2'] ) )
	{
		return;
	}
	$my_data = sanitize_text_field( $_POST['myplugin_new_field2'] );
	update_post_meta( $post_id, '_my_meta_value_key2', $my_data );
}
add_action( 'save_post', 'myplugin_save_meta_box_data2' );


// Copyright del footer
function display_copyright(
	$iYear = null,
	$szSeparator = " - ",
	$szTail = ". Todos los derechos reservados."
	)
{
	echo display_years( $iYear, $szSeparator, false ) . ' &copy; ' . get_bloginfo('name') . $szTail;
}

function display_years( $iYear = null, $szSeparator = " - ", $bPrint = true )
{
	$iCurrentYear = ( date( "Y" ) );
	if ( is_int( $iYear ) )
	{
		$iYear = ( $iCurrentYear > $iYear ) ? $iYear = $iYear . $szSeparator . $iCurrentYear : $iYear;
	} else {
		$iYear = $iCurrentYear;
	}
	if ( $bPrint == true ) echo $iYear; else return $iYear;
}

// Inclusión de soporte para metaboxes
require_once "includes/meta-box/meta-box.php";
require_once "includes/demo.php";

// Sitemap en xml
add_action("publish_post", "eg_create_sitemap");
add_action("publish_page", "eg_create_sitemap");

function eg_create_sitemap()
{
	$postsForSitemap = get_posts(array(
	'numberposts' => -1,
	'orderby' => 'modified',
	'post_type'  => array('post','page'),
	'order'    => 'DESC'
	));

	$sitemap = '<?xml version="1.0" encoding="UTF-8"?>';
	$sitemap .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

	foreach($postsForSitemap as $post)
	{
		setup_postdata($post);

		$postdate = explode(" ", $post->post_modified);

		$sitemap .= '<url>'.
		'<loc>'. get_permalink($post->ID) .'</loc>'.
		'<lastmod>'. $postdate[0] .'</lastmod>'.
		'<changefreq>monthly</changefreq>'.
		'</url>';
	}

	$sitemap .= '</urlset>';

	$fp = fopen(ABSPATH . "sitemap.xml", 'w');
	fwrite($fp, $sitemap);
	fclose($fp);
}

// Mostrar columna del código del producto
// Add custom column
add_filter('manage_edit-post_columns', 'my_columns_head');
function my_columns_head($defaults)
{
	$defaults['categories'] = 'Tipo';
	$defaults['Codigo_Propiedad'] = 'Referencia';
	$defaults['Descripcion'] = 'Descripción';
	return $defaults;
}

//Add rows data
add_action( 'manage_post_posts_custom_column' , 'my_custom_column', 10, 2 );
function my_custom_column($column, $post_id )
{
	switch ( $column )
	{
		case 'Codigo_Propiedad':
		echo get_post_meta( $post_id , 'villabrochero_codigo' , true );
		break;

		case 'Descripcion':
		$page = get_post($post_id);
		echo wp_trim_words($page->post_content);
		break;
	}
}

// Make these columns sortable
function sortable_columns()
{
	return array(
		'Codigo_Propiedad'	=>	'Codigo_Propiedad'
	);
}
add_filter( "manage_edit-post_sortable_columns", "sortable_columns" );

// Ordenar las propiedades en base al código de la propiedad
function xyz_event_sort_order( $wp_query )
{
	if ( is_admin() )
	{
		$post_type = $wp_query->query['post_type'];
		if ( $post_type == 'post' )
		{
			$wp_query->set( 'meta_key', 'villabrochero_codigo' );
			$wp_query->set( 'orderby', 'villabrochero_codigo' );
			$wp_query->set( 'order', 'ASC' );
		}
	}
}
add_filter( 'pre_get_posts', 'xyz_event_sort_order' );

// Borrar columnas innecesarias: fecha, etiquetas, comentarios, categorías, operaciones y demás...
function my_columns_filter( $columns )
{
	unset($columns['date']);
	unset($columns['tags']);
	unset($columns['comments']);
	unset($columns['author']);
	unset($columns['categories']);
	unset($columns['taxonomy-operaciones']);
	unset($columns['taxonomy-zonas']);
	unset($columns['taxonomy-precios']);
	return $columns;
}
add_filter( 'manage_edit-post_columns', 'my_columns_filter', 10, 1 );


// Cambiar el orden la columna del código del producto
add_filter('manage_posts_columns', 'Referencia_columna');
function Referencia_columna($columns)
{
	$new = array();
	foreach($columns as $key => $title)
	{
		if ($key=='title') // Put the Thumbnail column before the Author column
		$new['Codigo_Propiedad'] = 'Referencia';
		$new[$key] = $title;
	}
	return $new;
}

// Remover los tags y comentarios del sidebar del dashboard de WordPress
add_action('admin_menu', 'my_remove_sub_menus');
function my_remove_sub_menus()
{
	remove_submenu_page('edit.php', 'edit-tags.php?taxonomy=post_tag');
	remove_menu_page( 'edit-comments.php' );
}

// Ordenar las categorías y taxonomías por orden alfabético de la descripción
add_filter( 'get_terms_args', 'my_sort_terms', 10, 2 );
function my_sort_terms( $args, $taxonomies )
{
	$args['orderby'] = 'slug';
	return $args;
}

// Eliminar cajas innecesarias del dashboard

// Quitar cajas del escritorio
function quita_cajas_escritorio()
{
	// if( !current_user_can('manage_options') )
	// {
		remove_meta_box('dashboard_activity', 'dashboard', 'normal' ); // Actividad
		remove_meta_box('dashboard_right_now', 'dashboard', 'normal');   // Ahoramismo
		remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal'); // Comentarios recientes
		remove_meta_box('dashboard_incoming_links', 'dashboard', 'normal');  // Enlaces entrantes
		remove_meta_box('dashboard_plugins', 'dashboard', 'normal');   // Plugins
		remove_meta_box('dashboard_quick_press', 'dashboard', 'side');  // Publicación rápida
		remove_meta_box('dashboard_recent_drafts', 'dashboard', 'side');  // Borradores recientes
		remove_meta_box('dashboard_primary', 'dashboard', 'side');   // Noticas del blog de WordPress
		remove_meta_box('dashboard_secondary', 'dashboard', 'side');   // Otras noticias de WordPress
	// utiliza 'dashboard-network' como segundo parámetro para quitar cajas del escritorio de red.
	// }
}
add_action('wp_dashboard_setup', 'quita_cajas_escritorio' );

// Removiendo el panel de bienvenida del wordpress
remove_action('welcome_panel', 'wp_welcome_panel');


// remove unnecessary page/post meta boxes
function remove_meta_boxes()
{

	// posts
	remove_meta_box('postcustom','post','normal');
	remove_meta_box('trackbacksdiv','post','normal');
	remove_meta_box('commentstatusdiv','post','normal');
	remove_meta_box('commentsdiv','post','normal');
	// remove_meta_box('categorydiv','post','normal');
	// remove_meta_box('tagsdiv-post_tag','post','normal');
	remove_meta_box('slugdiv','post','normal');
	remove_meta_box('authordiv','post','normal');
	remove_meta_box('postexcerpt','post','normal');
	remove_meta_box('revisionsdiv','post','normal');

	// pages
	remove_meta_box('postcustom','page','normal');
	remove_meta_box('commentstatusdiv','page','normal');
	remove_meta_box('trackbacksdiv','page','normal');
	remove_meta_box('commentsdiv','page','normal');
	remove_meta_box('slugdiv','page','normal');
	remove_meta_box('authordiv','page','normal');
	remove_meta_box('revisionsdiv','page','normal');
	remove_meta_box('postexcerpt','page','normal');
}
add_action('admin_init','remove_meta_boxes');


/*
// Disable responsive image support (test!)
// Clean the up the image from wp_get_attachment_image()
add_filter( 'wp_get_attachment_image_attributes', function( $attr )
{
	if( isset( $attr['sizes'] ) )
		unset( $attr['sizes'] );
	if( isset( $attr['srcset'] ) )
		unset( $attr['srcset'] );
	return $attr;
}, PHP_INT_MAX );

// Override the calculated image sizes
add_filter( 'wp_calculate_image_sizes', '__return_false',  PHP_INT_MAX );
// Override the calculated image sources
add_filter( 'wp_calculate_image_srcset', '__return_false', PHP_INT_MAX );
// Remove the reponsive stuff from the content
remove_filter( 'the_content', 'wp_make_content_images_responsive' );
*/

/*
//Función para Minificar el HTML
class WP_HTML_Compression
{
	protected $compress_css = true;
	protected $compress_js = true;
	protected $info_comment = true;
	protected $remove_comments = true;
	protected $html;
	public function __construct($html)
	{
		if (!empty($html))
		{
			$this->parseHTML($html);
		}
	}
	public function __toString()
	{
		return $this->html;
	}
	protected function bottomComment($raw, $compressed)
	{
		$raw = strlen($raw);
		$compressed = strlen($compressed);
		$savings = ($raw-$compressed) / $raw * 100;
		$savings = round($savings, 2);
		return '<!-- HTML Minify | Se ha reducido el tamaño de la web un '.$savings.'% | De '.$raw.' Bytes a '.$compressed.' Bytes -->';
	}
	protected function minifyHTML($html)
	{
		$pattern = '/<(?<script>script).*?<\/script\s*>|<(?<style>style).*?<\/style\s*>|<!(?<comment>--).*?-->|<(?<tag>[\/\w.:-]*)(?:".*?"|\'.*?\'|[^\'">]+)*>|(?<text>((<[^!\/\w.:-])?[^<]*)+)|/si';
		preg_match_all($pattern, $html, $matches, PREG_SET_ORDER);
		$overriding = false;
		$raw_tag = false;
		$html = '';
		foreach ($matches as $token)
		{
			$tag = (isset($token['tag'])) ? strtolower($token['tag']) : null;
			$content = $token[0];
			if (is_null($tag))
			{
				if ( !empty($token['script']) )
				{
					$strip = $this->compress_js;
				}
				else if ( !empty($token['style']) )
				{
					$strip = $this->compress_css;
				}
				else if ($content == '<!--wp-html-compression no compression-->')
				{
					$overriding = !$overriding;
					continue;
				}
				else if ($this->remove_comments)
				{
					if (!$overriding && $raw_tag != 'textarea')
					{
						$content = preg_replace('/<!--(?!\s*(?:\[if [^\]]+]|<!|>))(?:(?!-->).)*-->/s', '', $content);
					}
				}
			}
			else
			{
				if ($tag == 'pre' || $tag == 'textarea')
				{
					$raw_tag = $tag;
				}
				else if ($tag == '/pre' || $tag == '/textarea')
				{
					$raw_tag = false;
				}
				else
				{
					if ($raw_tag || $overriding)
					{
						$strip = false;
					}
					else
					{
						$strip = true;
						$content = preg_replace('/(\s+)(\w++(?<!\baction|\balt|\bcontent|\bsrc)="")/', '$1', $content);
						$content = str_replace(' />', '/>', $content);
					}
				}
			}
			if ($strip)
			{
				$content = $this->removeWhiteSpace($content);
			}
			$html .= $content;
		}
		return $html;
	}
	public function parseHTML($html)
	{
		$this->html = $this->minifyHTML($html);
		if ($this->info_comment)
		{
			$this->html .= "\n" . $this->bottomComment($html, $this->html);
		}
	}
	protected function removeWhiteSpace($str)
	{
		$str = str_replace("\t", ' ', $str);
		$str = str_replace("\n",  '', $str);
		$str = str_replace("\r",  '', $str);
		while (stristr($str, '  '))
		{
			$str = str_replace('  ', ' ', $str);
		}
		return $str;
	}
}
function wp_html_compression_finish($html)
{
	return new WP_HTML_Compression($html);
}
function wp_html_compression_start()
{
	ob_start('wp_html_compression_finish');
}
add_action('get_header', 'wp_html_compression_start', 1);
*/
?>