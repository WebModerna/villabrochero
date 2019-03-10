<!doctype html>
<html <?php language_attributes();?>>
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=<?php bloginfo('charset');?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.5, user-scalable=yes" />
<?php
// Variables
$meta_keywords2 = of_get_option('meta_keywords2', '');
$villabrochero_meta_keywords = rwmb_meta('villabrochero_meta_keywords', '');
$villabrochero_meta_descripcion = rwmb_meta('villabrochero_meta_descripcion', '');
$meta_paginas_meta_descripcion = rwmb_meta('meta_paginas_meta_descripcion', '');
$meta_paginas_meta_keywords = rwmb_meta('meta_paginas_meta_keywords', '');

if ( is_home() || is_search() || is_category() || is_tag() ) { ?>

	<title><?php bloginfo('name');?></title>
	<?php if( $meta_keywords2 ) { echo '<meta name="keywords" content="' . $meta_keywords2 . '" />'; };?>
	<meta name="description" content="<?php bloginfo('description');?>" />

<?php } elseif ( is_404() ) { ?>

	<title><?php _e('Error 404', 'villabrochero');?> | <?php bloginfo('name');?></title>
	<?php if( $meta_keywords2 ) { echo '<meta name="keywords" content="' . $meta_keywords2 . '" />'; };?>
	<meta name="description" content="<?php bloginfo('description');?>" />

<?php } elseif ( is_single() ) { ?>

	<title><?php the_title();?> | <?php bloginfo('name');?></title>
	<?php
		if ( $villabrochero_meta_descripcion ) {
			echo '<meta name="description" content="' . $villabrochero_meta_descripcion . '" />';
		} else { ?>
			<meta name="description" content="<?php bloginfo('description');?>" />
		<?php }
		if ( $villabrochero_meta_keywords ) {
			echo '<meta name="keywords" content="' . $villabrochero_meta_keywords . '" />';
		}
	?>

<?php } elseif ( is_page() ) { ?>

	<title><?php the_title();?> | <?php bloginfo('name');?></title>
	<?php
		if ( $meta_paginas_meta_descripcion ) {
			echo '<meta name="description" content="' . $meta_paginas_meta_descripcion . '" />';
		} else { ?>
			<meta name="description" content="<?php bloginfo('description');?>" />
		<?php }
		if ( $meta_paginas_meta_keywords ) {
			echo '<meta name="keywords" content="' . $meta_paginas_meta_keywords . '" />';
		}
	?>

<?php } else { ?>

	<title><?php the_title();?> | <?php bloginfo('name');?></title>
	<meta name="description" content="<?php bloginfo('description');?>" />
	<?php if( $meta_keywords2 ) { echo '<meta name="keywords" content="' . $meta_keywords2 . '" />'; };?>

<?php };?>

	<meta name="author" content="<?php _e('WebModerna | el futuro de la web', 'villabrochero') ?>" />
<?php if( wpmd_is_ios() ) { ?>
	<link rel="apple-touch-icon-precomposed" sizes="57x57" href="<?php bloginfo('stylesheet_directory');?>/img/apple-touch-icon-57x57.png" />
	<link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php bloginfo('stylesheet_directory');?>/img/apple-touch-icon-114x114.png" />
	<link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php bloginfo('stylesheet_directory');?>/img/apple-touch-icon-72x72.png" />
	<link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php bloginfo('stylesheet_directory');?>/img/apple-touch-icon-144x144.png" />
	<link rel="apple-touch-icon-precomposed" sizes="60x60" href="<?php bloginfo('stylesheet_directory');?>/img/apple-touch-icon-60x60.png" />
	<link rel="apple-touch-icon-precomposed" sizes="120x120" href="<?php bloginfo('stylesheet_directory');?>/img/apple-touch-icon-120x120.png" />
	<link rel="apple-touch-icon-precomposed" sizes="76x76" href="<?php bloginfo('stylesheet_directory');?>/img/apple-touch-icon-76x76.png" />
	<link rel="apple-touch-icon-precomposed" sizes="152x152" href="<?php bloginfo('stylesheet_directory');?>/img/apple-touch-icon-152x152.png" />
<?php };?>
	<link rel="icon" type="image/png" href="<?php bloginfo('stylesheet_directory');?>/img/favicon-196x196.png" sizes="196x196" />
	<link rel="icon" type="image/png" href="<?php bloginfo('stylesheet_directory');?>/img/favicon-96x96.png" sizes="96x96" />
	<link rel="icon" type="image/png" href="<?php bloginfo('stylesheet_directory');?>/img/favicon-32x32.png" sizes="32x32" />
	<link rel="icon" type="image/png" href="<?php bloginfo('stylesheet_directory');?>/img/favicon-16x16.png" sizes="16x16" />
	<link rel="icon" type="image/png" href="<?php bloginfo('stylesheet_directory');?>/img/favicon-128.png" sizes="128x128" />
	<link rel="shortcut icon" type="image/x-icon" href="<?php bloginfo('stylesheet_directory');?>/img/favicon.ico" />

	<link rel="stylesheet" href="<?php bloginfo('stylesheet_directory');?>/css/style.min.css" />

<?php if( wpmd_is_notdevice() ) { ?>
<!--[if lt IE 9]>
	<script type="text/javascript">
		document.createElement("nav");
		document.createElement("header");
		document.createElement("footer");
		document.createElement("section");
		document.createElement("article");
		document.createElement("aside");
		document.createElement("main");
	</script>
<![endif]-->

<!--[if IE 8]>
	<script type="text/javascript" defer src="<?php bloginfo('stylesheet_directory');?>/js/html5-3.6-respond-1.4.2.min.js"></script>
	<script type="text/javascript" defer src="<?php bloginfo('stylesheet_directory');?>/js/selectivizr-min.js"></script>
	<script type="text/javascript" defer src="<?php bloginfo('stylesheet_directory');?>/js/css3-mediaqueries.js"></script>
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_directory');?>/css/styleIE8.css" />
<![endif]-->

<!--[if gte IE 9]><style type="text/css">.gradient { filter: none !important; }</style><![endif]-->
<?php
};
// Layout de la web
$ancho_de_la_web = of_get_option('ancho_de_la_web', '');
if( $ancho_de_la_web )
{
	echo '<style type="text/css">@media screen and ( min-width: 980px ) { div.wrapper {';
			if ( $ancho_de_la_web == 'angosto' )
			{
				echo "max-width: 1100px;";
			}
			else if ( $ancho_de_la_web == 'ancho_total' )
			{
				echo "max-width: 99%;";
			}
			echo '} }</style>';
}

// Background de la web
$color_de_la_web = of_get_option('color_de_la_web', '');
if ( $color_de_la_web )
{
	echo '<style type="text/css" media="screen">@media screen and (min-width:980px) { body, .header, .sidebar { background: ' . $color_de_la_web . '; } }</style>';
};
wp_head();
?>
</head>
<body>
<?php if( wpmd_is_notdevice() ) { ?>
<!--[if lt IE 8]>
	<p class="browserupgrade">Estás usando un <strong>navegador viejo</strong>. Por favor <a target="_blank" href="http://browsehappy.com/">actualizá tu navegador</a> para mejorar tu experiencia en la web.</p>
	<hr />
	<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
<![endif]-->
<?php };?>
<div class="wrapper">
	<header class="header">
		<div class="logotipo gradient">
		<?php $logotipo_de_la_web = of_get_option('logo_uploader', '');
		if ( is_page() || is_single() ) { ?>
			<h2 class="logotipo--header">
				<?php if( $logotipo_de_la_web ) { ?>
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
					<img src="<?php echo $logotipo_de_la_web;?>" alt="<?php bloginfo('name');?>" />
				</a>
				<?php } ?>
				<span><?php bloginfo('name');?></span>
			</h2>
		<?php } else { ?>
			<h1 class="logotipo--header">
				<?php if( $logotipo_de_la_web ) { ?>
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
					<img src="<?php echo $logotipo_de_la_web;?>" alt="<?php bloginfo('name');?>" />
				</a>
				<?php } ?>
				<span><?php bloginfo('name');?></span>
			</h1>
		<?php };?>
		</div>

		<div class="boton_menu">
			<div class="menu_barritas">
				<a href="#" id="menu">
					<span></span>
					<span></span>
					<span></span>
				</a>
			</div>
		</div>
		<div class="clearfix"></div>

		<nav class="navegacion">
			<?php
			// Barra de navegación principal: solo categorías
			$default = array(
				'container'			=>			false,
				'depth'				=>				0,
				'menu'				=>	'header_nav',
				'theme_location'	=>	'header_nav',
				'items_wrap'		=>	'<ul id="header_nav" class="navegacion--listado navegacion--listado-cerrar">%3$s</ul>'
			);
			wp_nav_menu($default);

			// Barra secundaria: solo páginas
			$default = array(
				'container'			=>			false,
				'depth'				=>				0,
				'menu'				=>	'second_nav',
				'theme_location'	=>	'second_nav',
				'items_wrap'		=>	'<ul class="second_nav navegacion--listado navegacion--listado-cerrar">%3$s</ul>'
			);
			wp_nav_menu($default);?>
		</nav>
	</header>