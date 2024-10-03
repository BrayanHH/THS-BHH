<?php
include_once("../servidor/conexion.php");

// Actualizar usuario
if (!empty($_POST)) {
  $alert = "";
  
  // Validación de campos vacíos
  if (empty($_POST['nomusu']) || empty($_POST['apausu']) || empty($_POST['amausu']) || empty($_POST['correo']) || empty($_POST['contra']) || empty($_POST['telefono']) || empty($_POST['ruta']) || empty($_POST['idtipo'])) {
    $alert = '<div class="alert alert-danger" role="alert">Todos los campos son requeridos</div>';
  } else {
    // Recogiendo datos del formulario
    $idusu   = intval($_GET['id']);
    $nombre = $_POST['nomusu'];
    $apausu = $_POST['apausu'];
    $amausu = $_POST['amausu'];
    $correo = $_POST['correo'];
    $contra = $_POST['contra'];
    $telefono = $_POST['telefono'];
    $ruta = $_POST['ruta'];
    $idtipo = $_POST['idtipo'];

    // Query para actualizar datos del usuario
    $sql_update = mysqli_query($conexion, "UPDATE usuarios SET nomusu='$nombre', apausu='$apausu', amausu='$amausu', correo='$correo', contra='$contra', telefono='$telefono', ruta='$ruta', idtipo='$idtipo' WHERE idusu=$idusu");
    
    if ($sql_update) {
      // Redirigir con parámetro de éxito
      header("Location: usuarios.php?update=success");
      exit();
    } else {
      $alert = '<div class="alert alert-danger" role="alert">Error al actualizar el usuario</div>';
    }
  }
}

// Mostrar datos del usuario
if (empty($_REQUEST['id'])) {
  header("Location: usuarios.php");
  exit();
}

$idusu = intval($_REQUEST['id']);

$stmt = $conexion->prepare("SELECT * FROM usuarios WHERE idusu = ?");
$stmt->bind_param("i", $idusu);
$stmt->execute();
$result = $stmt->get_result();
$result_sql = $result->num_rows;

if ($result_sql == 0) {
  header("Location: usuarios.php");
  exit();
} else {
  $data = $result->fetch_assoc();
  $nombre = $data['nomusu'];
  $apausu = $data['apausu'];
  $amausu = $data['amausu'];
  $correo = $data['correo'];
  $contra = $data['contra'];
  $telefono = $data['telefono'];
  $ruta = $data['ruta'];
  $idtipo = $data['idtipo'];
}
?>

<?php include_once "include/encabezado.php"; ?>

<!-- Begin Page Content -->
<div class="container-fluid">
  <div class="row">
    <div class="col-lg-6 m-auto">
      <form action="" method="post">
        <?php echo isset($alert) ? $alert : ''; ?>
        <input type="hidden" name="id" value="<?php echo $idusu; ?>">
        <div class="form-group">
          <label for="nombre">Nombre</label>
          <input type="text" placeholder="Ingrese nombre" class="form-control" name="nomusu" id="nombre" value="<?php echo $nombre; ?>">
        </div>
        <div class="form-group">
          <label for="correo">Correo</label>
          <input type="email" placeholder="Ingrese correo" class="form-control" name="correo" id="correo" value="<?php echo $correo; ?>">
        </div>
        <div class="form-group">
          <label for="ApaUsu">Apellido Paterno</label>
          <input type="text" placeholder="Ingrese apellido paterno" class="form-control" name="apausu" id="apausu" value="<?php echo $apausu; ?>">
        </div>
        <div class="form-group">
          <label for="AmaUsu">Apellido Materno</label>
          <input type="text" placeholder="Ingrese apellido materno" class="form-control" name="amausu" id="amausu" value="<?php echo $amausu; ?>">
        </div>
        <div class="form-group">
          <label for="incrip">Contraseña</label>
          <input type="text" class="form-control" name="contra" id="contra" value="<?php echo $contra; ?>">
        </div>
        <div class="form-group">
          <label for="telefono">Teléfono</label>
          <input type="text" placeholder="Ingrese teléfono" class="form-control" name="telefono" id="telefono" value="<?php echo $telefono; ?>">
        </div>
        <div class="form-group">
          <label for="ruta">Ruta</label>
          <input type="text" placeholder="Ingrese ruta" class="form-control" name="ruta" id="ruta" value="<?php echo $ruta; ?>">
        </div>
        <div class="form-group">
          <label for="rol">Rol</label>
          <select name="idtipo" id="rol" class="form-control">
            <option value="1" <?php if ($idtipo == 1) echo "selected"; ?>>Administrador</option>
            <option value="2" <?php if ($idtipo == 2) echo "selected"; ?>>Gerente</option>
            <option value="3" <?php if ($idtipo == 3) echo "selected"; ?>>Empleado</option>
            <option value="4" <?php if ($idtipo == 4) echo "selected"; ?>>Cliente</option>
          </select>
        </div>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="window.location.href='../Cliente/usuarios.php'">Cancelar</button>

        <button type="submit" class="btn btn-primary"><i class="fas fa-user-edit"></i> Editar Usuario</button>
     
      </form>
    </div>
  </div>
</div>
<!-- End of Main Content -->
<?php include_once "include/pie.php"; ?>