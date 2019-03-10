<?php if ( session_id() == '')
{
	// echo 'No hay sesión iniciada';
	session_start();


	/* genero un string largo, y como parametro
	le paso la fecha actual con microsegundos (microtime).
	luego con substr lo acorto a seis caracteres
	*/
	$ranStr = substr( sha1( microtime() ),0,6);

	//Guardo el valor del captcha en una variable de sesion
	$_SESSION['captcha'] = $ranStr;


	// creo la imagen con php...
	// fondo_captcha.jpg debe ser una imagen existente
	$newImage = imagecreatefromjpeg( 'data:image/jpeg;base64,/9j/4AAQSkZJRgABAQEASABIAAD/2wBDAAMCAgMCAgMDAwMEAwMEBQgFBQQEBQoHBwYIDAoMDAsKCwsNDhIQDQ4RDgsLEBYQERMUFRUVDA8XGBYUGBIUFRT/2wBDAQMEBAUEBQkFBQkUDQsNFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBT/wgARCAAeAHMDAREAAhEBAxEB/8QAGwAAAgMBAQEAAAAAAAAAAAAAAwQBAgUGAAj/xAAUAQEAAAAAAAAAAAAAAAAAAAAA/9oADAMBAAIQAxAAAAH6KNIXJGDONEuJDgsSeKnHnVGoCJDAwQyVJBAQ5Y443TSBlSQoMaLCgUMKBzhTTNIgEWKEnhkRHDwQWOQP/8QAJBAAAgEDBAICAwAAAAAAAAAAAQIDAAQSBRETIRQiEDIVM0H/2gAIAQEAAQUCsIYxGtvGV4EFcSrXFGymMZJHGaaGMDijyMMZBhC0bcMFgRKZUZWto97LuFOlL+7uopWBBU5s20gOdMvSmpGNIGY/emAVG+2nn0/kq16gsuJMpWlObDoE7VE/SPl8d5v+tssrDUI+NdRjNPeowju4wX1BAZrxDS3EYP5FMvOjNecsbJfxgHUUFefHTahGIzfRb//EABQRAQAAAAAAAAAAAAAAAAAAAFD/2gAIAQMBAT8Bc//EABQRAQAAAAAAAAAAAAAAAAAAAFD/2gAIAQIBAT8Bc//EACkQAAEDAgQEBwEAAAAAAAAAAAABAhExkRAhMjMDEnGBEyAiI0JRYZL/2gAIAQEABj8Cd7bbG22wkcNLG03l6GXDanYjw22Nts9DbbYlGN/k222Ntq9jQxOxobHQWOElhfQ2w8Q/MZxg+8eVUFFHmRIgkZmnyLjKUFFHZONLijijrCJDhNRK8ykQ4o4+RRxRxRw5IcUcf//EACEQAAIBAwUBAQEAAAAAAAAAAAABESEx0UFRYXGhkYGx/9oACAEBAAE/IXl4xmn5hwCKnVR2zekTCQ6ibSPyJIaU0iMj8Ym3XuhRdXiL1XTopBX+CXZjcBUxY2nInaLE5GlMckS+hQk3PQlQxBbkW9ER0hCnANi/5ILUEyg4hohHY9g21CkvfUFvWridQlsa6lTLxVoTE0bRTIQjYh1dStUCsObUkoyD2YJ4IiStI+lkpngslefBZGaIOmRZ4OUsktifSyLfwlknhXpZZGlXvhZJyFDpZJS5nslk7t2WSNP+SyaYPZZFnXmsn//aAAwDAQACAAMAAAAQkEEkEkkgAkEEAggEkAAEkkkggAEkkg//xAAUEQEAAAAAAAAAAAAAAAAAAABQ/9oACAEDAQE/EHP/xAAUEQEAAAAAAAAAAAAAAAAAAABQ/9oACAECAQE/EHP/xAAjEAEAAwEAAQMEAwAAAAAAAAABABEhMUFRYaFxkdHhwfDx/9oACAEBAAE/EOEh5+iB2zxsfEZxgf0oYKZ3/KCRwovb4nSG4fileoWr8URrAafohETwoV7cggXTXh8Qz0BfB9pdG+mlfaWiMYP4owjaaH8TTXW/vUri+oOAErNg0FnRa+8YULuooyL4PZXk4uaRRWuqbmoXGnzBogjY+kufB5FShHjeeIldA22FV8obsciAMya+oi7qNbZaIwW3xl1VgaOEKMTXsphLNdhiMe52WNeI83NgWxiVhc5I01fJgue35goUBGmWBK8Q0FKcSa0VLii2klrQDkiYDZWQI11iMCKx91C5FwsBlexIPaSjwgqIQqIX3eh2j1eREq6bBVXYeU3snm6K8QwaqhZP/9k=' );
	// $newImage = imagecreatefromjpeg( "img/fondo_captcha.jpg" );

	// la funcion imagecolorallocate ( $imagen , rojo , verde , azul ) genera un color
	$txtColor = imagecolorallocate($newImage, 0, 0, 200);

	/*
	que luego lo usamos para colorear el string
	bool imagestring ( resource $image , int $font , int $x , int $y , string $string , int $color )
	*/
	imagestring($newImage, 5, 30, 8, $ranStr, $txtColor);

	//indico la cabecera
	header( "Content-type: image/jpeg" );

	//creo la imagen
	imagejpeg($newImage);
	$captcha_imagen = imagejpeg($newImage);
} else {
	// echo 'No hay sesión iniciada';
	session_start();


	/* genero un string largo, y como parametro
	le paso la fecha actual con microsegundos (microtime).
	luego con substr lo acorto a seis caracteres
	*/
	$ranStr = substr( sha1( microtime() ),0,6);

	//Guardo el valor del captcha en una variable de sesion
	$_SESSION['captcha'] = $ranStr;


	// creo la imagen con php...
	// fondo_captcha.jpg debe ser una imagen existente
	$newImage = imagecreatefromjpeg( 'data:image/jpeg;base64,/9j/4AAQSkZJRgABAQEASABIAAD/2wBDAAMCAgMCAgMDAwMEAwMEBQgFBQQEBQoHBwYIDAoMDAsKCwsNDhIQDQ4RDgsLEBYQERMUFRUVDA8XGBYUGBIUFRT/2wBDAQMEBAUEBQkFBQkUDQsNFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBT/wgARCAAeAHMDAREAAhEBAxEB/8QAGwAAAgMBAQEAAAAAAAAAAAAAAwQBAgUGAAj/xAAUAQEAAAAAAAAAAAAAAAAAAAAA/9oADAMBAAIQAxAAAAH6KNIXJGDONEuJDgsSeKnHnVGoCJDAwQyVJBAQ5Y443TSBlSQoMaLCgUMKBzhTTNIgEWKEnhkRHDwQWOQP/8QAJBAAAgEDBAICAwAAAAAAAAAAAQIDAAQSBRETIRQiEDIVM0H/2gAIAQEAAQUCsIYxGtvGV4EFcSrXFGymMZJHGaaGMDijyMMZBhC0bcMFgRKZUZWto97LuFOlL+7uopWBBU5s20gOdMvSmpGNIGY/emAVG+2nn0/kq16gsuJMpWlObDoE7VE/SPl8d5v+tssrDUI+NdRjNPeowju4wX1BAZrxDS3EYP5FMvOjNecsbJfxgHUUFefHTahGIzfRb//EABQRAQAAAAAAAAAAAAAAAAAAAFD/2gAIAQMBAT8Bc//EABQRAQAAAAAAAAAAAAAAAAAAAFD/2gAIAQIBAT8Bc//EACkQAAEDAgQEBwEAAAAAAAAAAAABAhExkRAhMjMDEnGBEyAiI0JRYZL/2gAIAQEABj8Cd7bbG22wkcNLG03l6GXDanYjw22Nts9DbbYlGN/k222Ntq9jQxOxobHQWOElhfQ2w8Q/MZxg+8eVUFFHmRIgkZmnyLjKUFFHZONLijijrCJDhNRK8ykQ4o4+RRxRxRw5IcUcf//EACEQAAIBAwUBAQEAAAAAAAAAAAABESEx0UFRYXGhkYGx/9oACAEBAAE/IXl4xmn5hwCKnVR2zekTCQ6ibSPyJIaU0iMj8Ym3XuhRdXiL1XTopBX+CXZjcBUxY2nInaLE5GlMckS+hQk3PQlQxBbkW9ER0hCnANi/5ILUEyg4hohHY9g21CkvfUFvWridQlsa6lTLxVoTE0bRTIQjYh1dStUCsObUkoyD2YJ4IiStI+lkpngslefBZGaIOmRZ4OUsktifSyLfwlknhXpZZGlXvhZJyFDpZJS5nslk7t2WSNP+SyaYPZZFnXmsn//aAAwDAQACAAMAAAAQkEEkEkkgAkEEAggEkAAEkkkggAEkkg//xAAUEQEAAAAAAAAAAAAAAAAAAABQ/9oACAEDAQE/EHP/xAAUEQEAAAAAAAAAAAAAAAAAAABQ/9oACAECAQE/EHP/xAAjEAEAAwEAAQMEAwAAAAAAAAABABEhMUFRYaFxkdHhwfDx/9oACAEBAAE/EOEh5+iB2zxsfEZxgf0oYKZ3/KCRwovb4nSG4fileoWr8URrAafohETwoV7cggXTXh8Qz0BfB9pdG+mlfaWiMYP4owjaaH8TTXW/vUri+oOAErNg0FnRa+8YULuooyL4PZXk4uaRRWuqbmoXGnzBogjY+kufB5FShHjeeIldA22FV8obsciAMya+oi7qNbZaIwW3xl1VgaOEKMTXsphLNdhiMe52WNeI83NgWxiVhc5I01fJgue35goUBGmWBK8Q0FKcSa0VLii2klrQDkiYDZWQI11iMCKx91C5FwsBlexIPaSjwgqIQqIX3eh2j1eREq6bBVXYeU3snm6K8QwaqhZP/9k=' );
	// $newImage = imagecreatefromjpeg( "img/fondo_captcha.jpg" );

	// la funcion imagecolorallocate ( $imagen , rojo , verde , azul ) genera un color
	$txtColor = imagecolorallocate($newImage, 0, 0, 200);

	/*
	que luego lo usamos para colorear el string
	bool imagestring ( resource $image , int $font , int $x , int $y , string $string , int $color )
	*/
	imagestring($newImage, 5, 30, 8, $ranStr, $txtColor);

	//indico la cabecera
	header( "Content-type: image/jpeg" );

	//creo la imagen
	imagejpeg($newImage);
	$captcha_imagen = imagejpeg($newImage);
};?>