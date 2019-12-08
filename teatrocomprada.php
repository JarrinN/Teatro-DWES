<?php
    session_start();
    //conexion BD
    $conexion = new mysqli('localhost','root','picopalo','teatro');
    $sesion = $_GET['sesion']; //titulo sesion
    $sql = "SELECT disponibilidadSillas FROM sesiones WHERE sesion = '$sesion'"; //consulta sillas
    $consulta = $conexion->query($sql);
    $sillas = $consulta->fetch_assoc();

    $arraySillas = str_split($sillas['disponibilidadSillas']); //array de sillas
    $posicion = $_GET['posicion']; //posiscion en el array de la silla

    $arraySillas[$posicion] = '0'; //cambiamos a 0

    $newSillas = join("",$arraySillas); //juntamos el array

    $update = "UPDATE sesiones SET disponibilidadSillas = '$newSillas' WHERE sesion = '$sesion'";
    $actualizar = $conexion->query($update); //hacemos el update a la BD

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    
    <title>Butaca comprada</title>
</head>
<body>
    <img src="imagenes/logo-teatro.jpg" alt="logo" />
    <h1>¡Enhorabuena!</h1>
    <p>Has adquirido una entrada. Para descargarla, haz click 
    <a href="teatropdfentrada.php?sesion=<?php echo $_GET['sesion']?>&fila=<?php echo $_GET['fila']?>&silla=<?php echo $_GET['silla']?>">AQUÍ.</a></p>
    <br>
    <p>Si rellenas este formulario, te la enviamos por correo:</p>
    <form action="teatropdfentradaemail.php?nombre=<?php echo $_SESSION['user'] ?>&sesion=<?php echo $_GET['sesion']?>&fila=<?php echo $_GET['fila']?>&silla=<?php echo $_GET['silla']?>" method="post">
        <span>Tu E-Mail</span>
        <input type="email" name="email" placeholder="tu email" />
        <?php if(isset($_POST['enviar']) && empty($_POST['email'])) echo "<span style='color:red'>¡Debes introducir un email!</span>";?>
        <br>
        <input type="submit" value="Enviar" name="enviar"/>
    </form>
    <br>
    <br>
    <p><a href="teatropagina.php?sesion=<?php echo $_GET['sesion']?>"><img src="imagenes/comprar-mas.png" alt="comprar"></a></p>
</body>
</html>