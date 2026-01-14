<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Gestión de Jóvenes</title>

<style>
body { font-family: Arial; background:#f4f8ff; padding:20px; }
input { padding:6px; margin:4px; width:230px; }
button { padding:6px 10px; cursor:pointer; }
table { border-collapse:collapse; width:100%; margin-top:20px; background:#fff; }
th,td { border:1px solid #ccc; padding:8px; text-align:center; }
th { background:#cfe2ff; }
.msg { padding:10px; margin:10px auto; width:60%; border-radius:5px; }
.ok { background:#e6ffed; color:#0a7a2d; }
.err { background:#ffeaea; color:#a10000; }
</style>

</head>
<body>

<h2 align="center">Gestión de Jóvenes</h2>

<?php
include("conexion.php");

$curp = $nombre = $apellido = $fecha = $direccion = "";
$mensaje = "";

/* ===== GUARDAR ===== */
if (isset($_POST['guardar'])) {
    $curp = $_POST['CURP'];
    $nombre = $_POST['Nombre'];
    $apellido = $_POST['Apellido'];
    $fecha = $_POST['Fecha_Nacimiento'];
    $direccion = $_POST['Direccion'];

    $sql = "INSERT INTO jovenes VALUES ('$curp','$nombre','$apellido','$fecha','$direccion')";
    if (mysqli_query($conexion,$sql)) {
        $mensaje = "<div class='msg ok'>✅ Registro guardado correctamente</div>";
        // LIMPIAR CAMPOS
        $curp = $nombre = $apellido = $fecha = $direccion = "";
    } else {
        $mensaje = "<div class='msg err'>❌ Error: ".mysqli_error($conexion)."</div>";
    }
}

/* ===== CARGAR PARA EDITAR ===== */
if (isset($_POST['editar'])) {
    $curp = $_POST['CURP'];
    $q = mysqli_query($conexion,"SELECT * FROM jovenes WHERE CURP='$curp'");
    if ($row = mysqli_fetch_assoc($q)) {
        $nombre = $row['Nombre'];
        $apellido = $row['Apellido'];
        $fecha = $row['Fecha_Nacimiento'];
        $direccion = $row['Direccion'];
    }
}

/* ===== ACTUALIZAR ===== */
if (isset($_POST['actualizar'])) {
    $curp = $_POST['CURP'];
    $nombre = $_POST['Nombre'];
    $apellido = $_POST['Apellido'];
    $fecha = $_POST['Fecha_Nacimiento'];
    $direccion = $_POST['Direccion'];

    $sql = "UPDATE jovenes SET 
            Nombre='$nombre',
            Apellido='$apellido',
            Fecha_Nacimiento='$fecha',
            Direccion='$direccion'
            WHERE CURP='$curp'";
    if (mysqli_query($conexion,$sql)) {
        $mensaje = "<div class='msg ok'>✏️ Registro actualizado</div>";
        $curp = $nombre = $apellido = $fecha = $direccion = "";
    }
}

/* ===== ELIMINAR ===== */
if (isset($_POST['eliminar'])) {
    $curp = $_POST['CURP'];
    mysqli_query($conexion,"DELETE FROM jovenes WHERE CURP='$curp'");
    $mensaje = "<div class='msg ok'>🗑️ Registro eliminado</div>";
}
?>

<?= $mensaje ?>

<!-- FORMULARIO -->
<form method="post">
CURP:<br>
<input type="text" name="CURP" value="<?= $curp ?>" required><br>
Nombre:<br>
<input type="text" name="Nombre" value="<?= $nombre ?>"><br>
Apellido:<br>
<input type="text" name="Apellido" value="<?= $apellido ?>"><br>
Fecha Nacimiento:<br>
<input type="date" name="Fecha_Nacimiento" value="<?= $fecha ?>"><br>
Dirección:<br>
<input type="text" name="Direccion" value="<?= $direccion ?>"><br><br>

<button name="guardar">Guardar</button>
<button name="actualizar">Actualizar</button>
</form>

<!-- TABLA -->
<table>
<tr>
<th>CURP</th>
<th>Nombre</th>
<th>Apellido</th>
<th>Fecha</th>
<th>Dirección</th>
<th>Acciones</th>
</tr>

<?php
$res = mysqli_query($conexion,"SELECT * FROM jovenes");
while($f=mysqli_fetch_assoc($res)){
?>
<tr>
<td><?= $f['CURP'] ?></td>
<td><?= $f['Nombre'] ?></td>
<td><?= $f['Apellido'] ?></td>
<td><?= $f['Fecha_Nacimiento'] ?></td>
<td><?= $f['Direccion'] ?></td>
<td>
<form method="post" style="display:inline">
<input type="hidden" name="CURP" value="<?= $f['CURP'] ?>">
<button name="editar">Modificar</button>
<button name="eliminar" onclick="return confirm('¿Eliminar registro?')">Eliminar</button>
</form>
</td>
</tr>
<?php } ?>
</table>

<br>
<a href="ims.php">IR A IDMC DEL PACIENTE</a>

</body>
</html>
