				<article class="home--section--article">
					<figure class="home--section--img productos--img">
						<?php if ( has_post_thumbnail() ) {
							the_post_thumbnail('medium');
						}?>
						<figcaption class="mensajes"><?php _e('Vendido', 'villabrochero');?></figcaption>
						<div class="home--section--lista">
							<ul>
								<li><h4><?php the_title();?></h4></li>
								<li><span>Código:</span> A234</li>
								<li><span>Operación:</span> Compra</li>
								<li><a href="<?php the_permalink( ); ?>" class="boton small"><?php _e('Ver Producto', 'villabrochero');?></a></li>
							</ul>
						</div>
					</figure>
				</article>

				<article class="home--section--article">
					<figure class="home--section--img">
						<img src="<?php bloginfo('stylesheet_directory');?>/img/2.jpg" alt="1" />
						<div class="home--section--lista">
							<ul>
								<li><h4>Producto 1</h4></li>
								<li><span>Código:</span> A234</li>
								<li><span>Operación:</span> Compra</li>
								<li><a href="single.html" class="boton small">Ver Producto</a></li>
							</ul>
						</div>
					</figure>
				</article>
				<article class="home--section--article">
					<figure class="home--section--img">
						<img src="<?php bloginfo('stylesheet_directory');?>/img/3.jpg" alt="1" />
						<figcaption class="mensajes">Vendido</figcaption>
						<div class="home--section--lista">
							<ul>
								<li><h4>Producto 1</h4></li>
								<li><span>Código:</span> A234</li>
								<li><span>Operación:</span> Compra</li>
								<li><a href="single.html" class="boton small">Ver Producto</a></li>
							</ul>
						</div>
					</figure>
				</article>
				<article class="home--section--article">
					<figure class="home--section--img">
						<img src="<?php bloginfo('stylesheet_directory');?>/img/4.jpg" alt="1" />
						<div class="home--section--lista">
							<ul>
								<li><h4>Producto 1</h4></li>
								<li><span>Código:</span> A234</li>
								<li><span>Operación:</span> Compra</li>
								<li><a href="single.html" class="boton small">Ver Producto</a></li>
							</ul>
						</div>
					</figure>
				</article>
				<article class="home--section--article">
					<figure class="home--section--img">
						<img src="<?php bloginfo('stylesheet_directory');?>/img/1.jpg" alt="1" />
						<div class="home--section--lista">
							<ul>
								<li><h4>Producto 1</h4></li>
								<li><span>Código:</span> A234</li>
								<li><span>Operación:</span> Compra</li>
								<li><a href="single.html" class="boton small">Ver Producto</a></li>
							</ul>
						</div>
					</figure>
				</article>
				<article class="home--section--article">
					<figure class="home--section--img">
						<img src="<?php bloginfo('stylesheet_directory');?>/img/2.jpg" alt="1" />
						<div class="home--section--lista">
							<ul>
								<li><h4>Producto 1</h4></li>
								<li><span>Código:</span> A234</li>
								<li><span>Operación:</span> Compra</li>
								<li><a href="single.html" class="boton small">Ver Producto</a></li>
							</ul>
						</div>
					</figure>
				</article>