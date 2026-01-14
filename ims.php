<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<link rel="stylesheet" href="estilos.css">
<title>Índice de Masa Corporal (IMC)</title>
</head>
<body>
<center><h2>Registro de Índice de Masa Corporal (IMC)</h2></center>
<form method="post">
    CURP del Joven: <input type="text" name="CURP" maxlength="18" required><br><br>
    Peso (kg): <input type="number" step="0.01" name="Peso" required><br><br>
    Altura (m): <input type="number" step="0.01" name="Altura" required><br><br>
    <input type="submit" name="guardar" value="Guardar">
</form>

<?php
include("conexion.php");

if(isset($_POST['guardar'])){
    $curp = $_POST['CURP'];
    $peso = $_POST['Peso'];
    $altura = $_POST['Altura'];

    // Calcular IMC
    $imc = $peso / ($altura * $altura);
    $imc = round($imc, 2);

    // Clasificación y mensajes
    if($imc < 18.5){
        $clas = "Bajo peso";
        $mensaje = "<p style='color:blue;'>⚠️ Estás por debajo de tu peso ideal. 
        Come más alimentos ricos en proteínas, frutas, verduras y carbohidratos saludables. 
        Dormir bien y hacer ejercicios de fuerza te ayudarán a ganar masa muscular 💪.</p>";
    } elseif($imc < 25){
        $clas = "Normal";
        $mensaje = "<p style='color:green;'>🎉 ¡Felicidades! Tu peso es ideal. 
        Sigue manteniendo una alimentación balanceada, haz ejercicio regularmente y mantente hidratado 🥗🏃‍♂️.</p>";
    } elseif($imc < 30){
        $clas = "Sobrepeso";
        $mensaje = "<p style='color:orange;'>⚠️ Tienes un poco de sobrepeso. 
        Intenta reducir el consumo de azúcares y harinas, come más frutas y verduras, 
        y realiza al menos 30 minutos de actividad física diaria 🏋️‍♀️.</p>";
    } else {
        $clas = "Obesidad";
        $mensaje = "<p style='color:red;'>🚨 Tu IMC indica obesidad. 
        Es importante cuidar tu salud: consulta a un médico o nutriólogo, 
        haz caminatas diarias, evita bebidas azucaradas y come porciones más pequeñas 🥦🚶‍♂️.</p>";
    }

    // Insertar en la base de datos
    $sql = "INSERT INTO indice_masa_corporal (CURP, Peso, Altura, IMC, Clasificacion, Fecha_Registro)
            VALUES ('$curp', '$peso', '$altura', '$imc', '$clas', NOW())";

    if(mysqli_query($conexion, $sql)){
        echo "<h3>✅ Tu IMC es: $imc ($clas)</h3>";
        echo $mensaje;
    } else {
        echo "<h3 style='color:red;'>Error al guardar: " . mysqli_error($conexion) . "</h3>";
    }
}
?>

<br><br>
<table border="1" cellpadding="5" cellspacing="0">
<tr>
<th>ID</th>
<th>CURP</th>
<th>Peso</th>
<th>Altura</th>
<th>IMC</th>
<th>Clasificación</th>
<th>Fecha</th>
</tr>

<?php
$cons = mysqli_query($conexion, "SELECT * FROM indice_masa_corporal");
while($f = mysqli_fetch_assoc($cons)){
    echo "<tr>
        <td>".$f['ID_IMC']."</td>
        <td>".$f['CURP']."</td>
        <td>".$f['Peso']."</td>
        <td>".$f['Altura']."</td>
        <td>".$f['IMC']."</td>
        <td>".$f['Clasificacion']."</td>
        <td>".$f['Fecha_Registro']."</td>
    </tr>";
}
?>
</table>
<a href="administradores.php">Regresar a administradores</a>
<a href="jovenes.php" class="regresar">TABLA DE JOVENES</a>

</body>
</html>
