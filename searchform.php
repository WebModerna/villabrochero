<?php
/*
* searchform.php
* @package WordPress
* @subpackage villabrochero
* @since villabrochero 1.0
* Text Domain: villabrochero
*/
?>
<form action="<?php echo home_url( '/' );?>" method="get" role="search">

	<label for="operaciones"><?php _e('Operación:', 'villabrochero');?></label>
	<select name="operaciones" id="operaciones">
		<option value="" selected="selected"><?php _e('Seleccionar', 'villabrochero');?></option>
		<?php $operaciones = get_terms('operaciones');
		if ( !empty( $operaciones ) && !is_wp_error( $operaciones ) )
		{
			foreach ( $operaciones as $operacion )
			{
				echo  '<option value="' . $operacion->slug . '">' . $operacion->name . '</option>';
			}
		};?>
	</select>
	<input type="hidden" name="post_type" value="operaciones" />

	<label for="category_name"><?php _e('Propiedad:', 'villabrochero');?></label>
	<select name="category_name" id="category_name">
		<option value="" selected="selected"><?php _e('Seleccionar', 'villabrochero');?></option>
		<?php
			$categories = get_categories();
			foreach ($categories as $cat)
			{
				echo  '<option value="' . $cat->slug . '" >' . $cat->cat_name . '</option>';
			};?>
	</select>
	<input type="hidden" name="post_type" value="category_name" />

	<label for="zonas"><?php _e('Zona:', 'villabrochero');?></label>
	<select name="zonas" id="zonas">
		<option value="" selected="selected"><?php _e('Seleccionar', 'villabrochero');?></option>
		<?php $zonas = get_terms('zonas');
		if ( !empty( $zonas ) && !is_wp_error( $zonas ) )
		{
			foreach ( $zonas as $zona )
			{
				echo  '<option value="' . $zona->slug . '">' . $zona->name . '</option>';
			}
		};?>
	</select>
	<input type="hidden" name="post_type" value="zonas" />

	<label for="precios"><?php _e('Precio:', 'villabrochero');?></label>
	<select name="precios" id="precios">
		<option value="" selected="selected"><?php _e('Seleccionar', 'villabrochero');?></option>
		<?php $precios = get_terms('precios');
		if ( !empty( $precios ) && !is_wp_error( $precios ) )
		{
			foreach ( $precios as $precio )
			{
				echo  '<option value="' . $precio->slug . '">' . $precio->name . '</option>';
			}
		};?>
	</select>
	<input type="hidden" name="post_type" value="precios" />
	<input type="hidden" name="s" id="s" />
	<div class="clearfix"></div>

	<div class="aligncenter">
		<button class="boton-rojo" type="submit" id="searchsubmit">
			<?php _e('Buscar', 'villabrochero');?><span class="icono-search icono-left"></span>
		</button>
	</div>
</form>
<hr>
<form id="form1" name="form1"  action="<?php echo home_url( '/' );?>custom-search" method="get">
	<div class="relativo">
		<label for="codigo_producto"><?php _e('Por código:', 'villabrochero');?></label>
		<div class="relativo busqueda_codigo">
			<input type="search" name="codigo_producto" id="codigo_producto" maxlength="5" placeholder="A301" value="<?php echo $_GET['codigo_producto'];?>" />
			<button class="boton-rojo" type="submit" id="searchsubmit2" title="<?php _e('Buscar por código', 'villabrochero');?>">
				<img alt="Buscar" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAFAAAABQAgMAAADzfxo+AAAAA3NCSVQICAjb4U/gAAAACVBMVEX///8AAAD///9+749PAAAAA3RSTlP//wDXyg1BAAAACXBIWXMAAArDAAAKwwE0KSSrAAAAHHRFWHRTb2Z0d2FyZQBBZG9iZSBGaXJld29ya3MgQ1M1cbXjNgAAAKVJREFUOI3t0jESxCAIBVCGkqN4So9CsYXjKXdFJfmEOtkiFhZvRESgnix68XlU4isSUYmoP+SIRH7UsRkKohoyYjWkiDyuQLQkK9PGeahGZMsmiOK7oy5kxHnbX2HyzrSitPae/1Lynzr6o+HnZ4ewcS1DXShnXAYTgtELR3SJUzdw1+hY98Cc8bgOUSK2Iwdij/jJsGEex3LBjtH78ZJgWC/egF80SaSWjA3OaQAAAABJRU5ErkJggg==" />
			</button>
		</div>
	</div>
	<div class="clearfix"></div>
</form>