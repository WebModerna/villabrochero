<?php
	$dest		=	$email_contact;			// Email de destino
	$nombre		=	$_POST['nomape'];		// Nombre de quien envia
	$email		=	$_POST['ema'];			// Email de quien envia
	$telefono	=	$_POST['tel'];			// Teléfono de quién envía
	$asunto		=	__('Consulta de Propiedad vía Web', 'villabrochero');
	$cuerpo		=	'
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.or=
	g/TR/xhtml1/DTD/xhtml1-strict.dtd">
	<html xmlns=3D"http://www.w3.org/1999/xhtml" lang="es">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.5, user-scalable=yes" />
		<title>Consulta de Propiedad</title>
		<link rel="shortcut icon" type="image/x-icon" href="data:image/jpeg;base64,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+UT6+/lE+vv6RPr7+kP5+vlE+vv6RPr7+kT6+/pE+fv6RPr7+kT6+/pE+vv6Q/r7+kP6+/pD+vr4Pvz9/Cz+/v4S/v7+AwAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAD6+vgA/f39A/j49Qrx8esQ8fLsEvLy7BLy8+wS8/PtE/Lz7RPx8uwS8vPtE/Lz7BLy8+0S8vPtE/Ly7BLy8uwS8vPtE/Lz7BLy8+0T8vPtEvLy7BLy8+wS8vPtE/Lz7RPy8+0T8vPtEvLz7RLy8uwS8vPtE/Lz7RPy8+0T8vPtE/Lz7RPy8+0T8vLsEvLy7BLy8+wS8PHrEPf49Ar+/v0D+vr4AAAAAAAAAAAAAAAAAAAAAAD///Af////////wAf///////+AA////////gAA///////4AAA///////AAAB//////wAAAB/////+AAAAD/////gAAAAD////8AAAAAH////wAAAAAf///+AAAAAA////wAAAAAB////AAAAAAH///8AAAAAAf///gAAAAAA///+AAAAAAD///4AAAAAAP///gAAAAAA///+AAAAAAD///4AAAAAAP///gAAAAAA///+AAAAAAD///4AAAAAAP///gAAAAAA///+AAAAAAD///4AAAAAAP///gAAAAAA///+AAAAAAD///4AAAAAAP///gAAAAAA///+AAAAAAD///4AAAAAAP///gAAAAAA///+AAAAAAD///4AAAAAAP///gAAAAAA///+AAAAAAD///4AAAAAAP///gAAAAAA///+AAAAAAD///4AAAAAAP///gAAAAAA///+AAAAAAD///4AAAAAAP///gAAAAAA///+AAAAAAD///8AAAAAAf//8=" />
		<style type="text/css">
			*
			{
				border: none;
				color: #555;
				font-family: "Bookman Old Style", Garamond, Georgia, serif;
				font-size: 18px;
				margin: 0;
				padding: 0;
			}
			a, p
			{
				line-height: 20px;
			}
			a
			{
				color: #E0BF12 !important;
				border: none !important;
			}
			a:hover
			{
				color: #e74c3c !important;
			}
			body
			{
				background: #ccc;
			}
			h1, h2, h3, h4, h5
			{
				font-family: "Trebuchet MS", "Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif;
				font-size: 22px;
				font-weight: lighter;
				text-transform: uppercase;
			}
			h1
			{
				color: #eeeeee;
			}
			p
			{
				margin-bottom: 8px;
				margin-top: 8px;
			}
			table
			{
				border-collapse: collapse;
			}
			td
			{
				padding-bottom: 16px;
				padding-left: 8px;
				padding-right: 8px;
				padding-top: 16px;
			}
			#footer *
			{
				color: #eeeeee;
			}
			.contenido
			{
				border-color: #006553;
				border-style: solid;
				border-width: 1px;
				box-shadow: 3px 3px 8px #000000;
				-o-box-shadow: 3px 3px 8px #000000;
				-ms-box-shadow: 3px 3px 8px #000000;
				-moz-box-shadow: 3px 3px 8px #000000;
				-webkit-box-shadow: 3px 3px 8px #000000;
				margin-left: auto;
				margin-right: auto;
				max-width: 800px;
			}
		</style>
	</head>
	<body>
		<table width="100%" align="center">
			<tbody>
				<tr>
					<td align="center">
						<table style="max-width:800px;" class="contenido" align="center" bgcolor="#ffffff">
							<tbody>
								<tr>
									<td bgcolor="#006553" align="left">
										<a href="http://www.villabrochero.com.ar"><img alt="logo_small2.png" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAGQAAAB3CAMAAADCfhVTAAAAA3NCSVQICAjb4U/gAAADAFBMVEX///8+cmM9aF4yZ0YbU0oyZ0Yba1soZVkeYUobV1EbU0oOUEIJUEISRTMAPy0oZVkeYlMaWUkbU0obU0QOUEIoZVkeYlMaWUkbV1EIWksbU0ooZVkeYlMeYUobV1EaWUkbV1EbU0obU0QoZVkQWEoQWEobU0oQWEoQZ1EaWUkQWEoJYkoQWEobV1EQWEoJWUQJYkoJWlEQWEoIWksJYkoaWUkJWlEIWkv///////f3//7s//3/9/7x9fnl9vXY9/Ps7O3c7u3b6OjG5+XP4N7E396+3NrJ1ta21tGl09H/zADmzxPwzRLyzAna0giszMTezxTpySTlyCvvxwDuxhLeySrvxQnmxhfMzDPlxwfbyCGkyMGvxMPlxgDYyBXlwxDexQDdxBjdxAfKyBXwvQD3vADewQ7hvwHmvgDmvQngvwmSxL7tuRPNwCnVvxrKwCOgurm8wSTEvTPIvRWQvbe9uTbItxfFtiGcvVq2tCaMtKyrtDSssyeltCm2rSqPq6ajrzaZtCawrRl6raaXrjWVrDx6qp6Cp52dqwqepSaWpCuhnzRyo5eYoiSCoVqTnzdzm5WMnDCMmj9inZNmmZmHmyaXmQ59mzRhnFh+lylYlo9jkolSloRZk4FvlDdwkkZulClxin55iztFkX9PjH5ihnxxiSFtiSdxhjNkhkNUikZkhj1ghyhjhDFYhTNMgHRXhClRhDZffzo7hlI7gHNBgUMxgXNMeURaeCUvfGw7eGxVeRhQdTVGdjVLdyg4eSQ+cmM+ckYvcl02dDcad2A9aF4kcTo2bCIgbUtJZiEyZ0Yba1slaUEoZVkMbVs3ZTMoaS8Aa1IAa1oQZ1EAaWUeYlMAa0oeYUoAZmYJZ0AZYjoHZFIAY1oJYkoIZSsAY1IIYFoAZUIFZDodXDwcYCEAYkoaWUkQXjwbV1EeWTEJWlERWy8IWksQWEoAW1sJWUQEWzoBWGMbU0oAWkEAWVIbU0QAWEoAWjIKUzMOUEIJUEIAUUIAUTYASjISRTMAPy3uA2TeAAABAHRSTlMAERERESIiIiIiIiIiIiIzMzMzMzNERERERERVVVVVZmZmZnd3iIiZqqqqu7vMzMzd3d3d7u7u7v//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////SKZ7/wAAAAlwSFlzAAALEgAACxIB0t1+/AAAABx0RVh0U29mdHdhcmUAQWRvYmUgRmlyZXdvcmtzIENTNXG14zYAAAAWdEVYdENyZWF0aW9uIFRpbWUAMDIvMjkvMTZ+8n7XAAAW0klEQVRogb2aC1wTV7rAc3fv3ve9ex97H3u7713b7W4fe7u73TAEKoqChmcTEgMOhDghkygCauUivoq2XR+0IqUsIta2VqtVwbdY8QGuWkBlAoTITJwEO6AhL5wYHoF6z5mZhASBqru93w9mkpk55z/f+b7zne+cE9Gw084JM4144QNOpyNM3M57dnr6cna7y2V3Ou6JHDRF0ZSZoqcWqgM8QTGW8KsMaaUJarpysFqKJsleEUPT7K1+j9sxtbh7bt2yET6/L0zcDNVzq79nuoI9/f23bEa6V0TS7gPrN23eXLp5KgF3St844HkzOVzmnXS/v2nLlKVgwdItWzaecAGIg+7bnqqQyxVTC7j5auWX88QTpGaoOGHJdOUUiiXytDqv9T7QpK9Mjqk1uinFoMO1ysovk8MREgBZI9Oqwe0pRY1pk+oGqNtAE0+ZClfrcBTV6fU4juFqNc4L/yQO7uDSqlEOgiAIfwCnnZ7VMjzw7KQCbqbUebnmYstU8G1BVXq9GsVwTYo8K0mlAl/UAgVXK6r8AkQsjohAOF12Dq6V6fRT6wGLqpV1zDhEDdVA1QY9mv7O54cq91a8ls3Vr9dD9XQBSKg8CkQ3AbJkCa5O3/jZwbdbfV7fhRvvJQHNOKUNoRCJOBIBhyeEGPS4Ou+TZp+VGbR1UJeOvZGp0i/R8aYJQGD1kbXrnlgTnR7DM/cO2+1WS9NlC8FYm08XSDXZBmgQVIBEQIvkj/XGQNyTQPQ4piq6QnUYKcsfTvTBeDG0Ky9zZbY+RBMOUsOyGbxOoRA8UCseDplgeBxT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" width="50" /></a>
									</td>
									<td bgcolor="#006553" align="right" color="#eeeeee">
										<h1>';
										$cuerpo .= $nombre_sitio;
										$cuerpo .= '</h1>
									</td>
								</tr>
								<tr>
									<td colspan="2" align="center">
										<h2>Consulta vía Web</h2>
									</td>
								</tr>
								<tr>
									<td colspan="2" bgcolor="#eeeeee" align="left">
										<strong>Nombre y Apellido: </strong>';
										$cuerpo .= $_POST['nomape'];
										$cuerpo .= '
									</td>
								</tr>
								<tr>
									<td colspan="2" align="left">
										<strong>Correo Electrónico: </strong>
										<a href="mailto:';
										$cuerpo .= $_POST['ema'];
										$cuerpo .= '">';
										$cuerpo .= $_POST['ema'];
										$cuerpo .= '</a>
									</td>
								</tr>
								<tr>
									<td colspan="2" bgcolor="#eeeeee" align="left">
										<strong>Propiedad: </strong><a target="_blank" href="';
										$cuerpo .= $_POST['hidden-producto-url'];
										$cuerpo .= '">';
										$cuerpo .= $_POST['hidden-producto'];
										$cuerpo .= '</a>
									</td>
								</tr>
								<tr>
									<td colspan="2" align="left">
										<strong>Teléfono: </strong>';
										$cuerpo .= $_POST['tel'];
										$cuerpo .= '
									</td>
								</tr>
								<tr>
									<td colspan="2" bgcolor="#eeeeee" align="left">
										<strong>Mensaje: </strong>';
										$cuerpo .= $_POST['oii'];
										$cuerpo .= '
									</td>
								</tr>
								<tr>
									<td colspan="2" bgcolor="#006553" align="center" id="footer">
										<p>
											<a href="mailto:';
											$cuerpo .= $email_contact;
											$cuerpo .= '">';
											$cuerpo .= $email_contact;
											$cuerpo .= '</a> - <a href="mailto:';
											$cuerpo .= $email_contact_ventas;
											$cuerpo .= '">';
											$cuerpo .= $email_contact_ventas;
											$cuerpo .= '</a>
										</p>
										<p>Tel: ';
										$cuerpo .= $telefono_fijo;
										$cuerpo .= ' / ';
										$cuerpo .= $telefono_celular;
										$cuerpo .= '</p><p>';
										$cuerpo .= $direccion_web;
										$cuerpo .= '</p><p>';
										$cuerpo .= $horario;
										$cuerpo .= '</p>
										<p>Seguinos en: <a href="http://';
										$cuerpo .= $facebook_contact;
										$cuerpo .= '" target="_blank" title="Facebook"><img alt="Facebook" src="data:image/png;base64,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" /></a></p>
									</td>
								</tr>
							</tbody>
						</table>
					</td>
				</tr>
			</tbody>
		</table>
	</body>
	</html>';