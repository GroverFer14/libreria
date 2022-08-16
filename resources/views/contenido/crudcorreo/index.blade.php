<!DOCTYPE html>
<html lang="es" >
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initian-scale=1.0">
		<title>Envíos de Correo</title>
	</head>

	<body>
		<br><center>
		<form action="enviar.php" name="enviar" method="post">
		<fieldset style="width:260px">
			<legend align="center"><h2>FORMULARIO PARA ENVIAR CORREO</h2></legend>
			
			<label><b>Nombre     : </b></label>
			<input type="text" name="nombre" placeholder="Escribe tu nombre">
			<br><br>
			<label><b>Correo de  : </b></label>
			<input type="text" name="correoD" placeholder="Escribe tu correo">
			<br><br>
			<label><b>Correo para: </b></label>
			<input type="text" name="correoP" placeholder="Escribe el correo destinatario">
			<br><br>
			<label><b>Asunto     : </b></label>
			<input type="text" name="asunto" placeholder="Escribe tu asunto">
			<br><br>
			<label><b>Mensaje: </b></label>
			<br><br>
			<textarea name="mensaje" style="width:267px; height:130px;" placeholder="¡Escribe aquí tu mensaje!" ></textarea>
			<br><br>
			<button>ENVIAR</button>
			<br><br>
		</fieldset>
		</form></center>
	</body>
</html>
