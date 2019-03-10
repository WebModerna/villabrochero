// Botón abridor del formulario del producto
(function()
{
	$(document).on("ready", formulario_propiedad);
	function formulario_propiedad()
	{
		$("#label-check").on("click", abridor);
		function abridor(ev)
		{
			ev.preventDefault();
			$(".formulario--producto").slideToggle("fast");
		}
	}
}());