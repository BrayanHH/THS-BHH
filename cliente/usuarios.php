<?php
include_once("../servidor/conexion.php");
if (!empty($_POST)) {
  $alert = "";
  if (empty($_POST['cam1']) || empty($_POST['cam2']) || empty($_POST['cam3']) || empty($_POST['cam4']) || empty($_POST['cam5']) || empty($_POST['cam7'])) {
    $alert = '<div class="alert alert-danger d-flex align-items-center" role="alert">
            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Warning:"><use xlink:href="#exclamation-triangle-fill"/></svg>
                <div>
                     Todos los campos son obligatorios
                </div>
            </div>';
  } else {
    $c1 = $_POST['cam1'];
    $c2 = $_POST['cam2'];
    $c3 = $_POST['cam3'];
    $c4 = $_POST['cam4'];
    $c5 = $_POST['cam5'];
    $c6 = $_POST['cam6'];
    $c7 = $_POST['cam7'];
    $c8 = md5($_POST['cam5']);
    $query = mysqli_query($conexion, "SELECT * FROM usuarios where correo = '$c4'");
    $result = mysqli_fetch_array($query);
    if ($result > 0) {
      $alert = '<div class="alert alert-danger d-flex align-items-center" role="alert">
            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Warning:"><use xlink:href="#exclamation-triangle-fill"/></svg>
                <div>
                    El correo ya existe
                </div>
            </div>';
    } else {
      $consulta = mysqli_query($conexion, "INSERT INTO usurios(nomusu, apausu, amausu, correo, contra, telefono, idtipo) values ('$c1','$c2','$c3','$c4','$c5',$c6, $c7)");
      if ($consulta) {
        $alert = '<div class="alert alert-success d-flex align-items-center" role="alert">
        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Warning:"><use xlink:href="#exclamation-triangle-fill"/></svg>
            <div>
                Datos guardados
            </div>
        </div>';
        $c1 = "";
        $c2 = "";
        $c3 = "";
        $c4 = "";
        $c5 = "";
        $c6 = "";
        $c7 = "";
        $c8 = "";
      } else {
        $alert = '<div class="alert alert-danger d-flex align-items-center" role="alert">
        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Warning:"><use xlink:href="#exclamation-triangle-fill"/></svg>
            <div>
                Error al guardar
            </div>
        </div>';
      }
    }
  }
}
?>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.5.1/uicons-regular-rounded/css/uicons-regular-rounded.css'>
  <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.5.1/uicons-bold-straight/css/uicons-bold-straight.css'>
  <title>Hello, world!</title>
</head>

<body>
  <header>
    <?php
    include_once("include/encabezado.php");
    ?>
  </header>
  <div class="container" style="text-align: center;">
    <h2>ADMINISTRACIÓN DE USUARIOS</h2>
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
      Agregar Nuevo Usuario
    </button>
    <table class="table">
      <thead>
        <tr>
        <th scope="col">ID</th>
          <th scope="col">Nombre</th>
          <th scope="col">Apellido Paterno</th>
          <th scope="col">Apellido Materno</th>
          <?php if ($_SESSION['rol'] == 1) {
          ?>


            <th scope="col">Correo</th>
            <th scope="col">Teléfono</th>
            <th scope="col">Tipo Usuario</th>
            <th scope="col">Acciones</th>
          <?php
          }
          ?>
        </tr>
      </thead>
      <tbody>
        <?php
        include_once("../servidor/conexion.php");
        $con = mysqli_query($conexion, "SELECT u.idusu, u.nomusu, u.apausu, u.amausu, u.correo, u.telefono, t.tipousu
                                 FROM usuarios u INNER JOIN tipousuarios t ON u.idtipo=t.idtipo;");
        $res = mysqli_num_rows($con);
        while ($datos = mysqli_fetch_assoc($con)) {
        ?>
          <tr>
          <td><?php echo $datos['idusu'] ?></td>
            <td><?php echo $datos['nomusu'] ?></td>
            <td><?php echo $datos['apausu'] ?></td>
            <td><?php echo $datos['amausu'] ?></td>
            <?php if ($_SESSION['rol'] == 1) {
            ?>
              <td><?php echo $datos['correo'] ?></td>
              <td><?php echo $datos['telefono'] ?></td>
              <td><?php echo $datos['tipousu'] ?></td>
            <?php }
            ?>
            <?php
            if ($_SESSION['rol'] == 1) {
            ?>
              <td><a href="editar_usuario.php?id=<?php echo $datos['idusu']; ?>">
                <button type="button" class="btn btn-primary"><i class="fi fi-bs-user-add"></i></button></a>
                  </td>

              <td><a href="borrar_usuario.php?id=<?php echo $datos['idusu']; ?>">
                <button type="button" class="btn btn-danger"><i class="fi fi-rr-trash"></i></button></a>
              </td>
            <?php
            }
            ?>
          </tr>
        <?php
        }
        ?>
      </tbody>
    </table>

  </div>

  <!-- inicia Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Registros de usuarios</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form style="padding: 30px;" method="POST">
            <div>
              <?php echo isset($alert) ? $alert : "" ?>
            </div>
            <div class="mb-3">
              <label for="exampleInputEmail1" class="form-label" style="color:aqua;">Nombre(s)</label>
              <input id="cam1" type="name" class="form-control" aria-describedby="emailHelp" style="width:300px; margin-left:140px;" name="cam1">
              <label for="exampleInputEmail1" class="form-label" style="color:aqua;">Apellido Paterno</label>
              <input id="cam2" type="name" class="form-control"  aria-describedby="emailHelp" style="width:300px; margin-left:140px;" name="cam2">
              <label for="exampleInputEmail1" class="form-label" style="color:aqua;">Apellido Materno</label>
              <input id="cam3" type="name" class="form-control"  aria-describedby="emailHelp" style="width:300px; margin-left:140px;" name="cam3">
              <label for="exampleInputEmail1" class="form-label" style="color:aqua;">Correo</label>
              <input id="cam4" type="email" class="form-control"  aria-describedby="emailHelp" style="width:300px; margin-left:140px;" name="cam4">
              <label for="exampleInputPassword1" class="form-label" style="color:aqua;">Contraseña</label>
              <input id="cam5" type="password" class="form-control" id="contra" style="width:300px; margin-left:140px" name="cam5">
              <label for="exampleInputEmail1" class="form-label" style="color:aqua;">Teléfono</label>
              <input id="cam6" type="name" class="form-control"  aria-describedby="emailHelp" style="width:300px; margin-left:140px;" name="cam6">
              <select id="cam7" class="form-select" aria-label="Default select example" name="cam7">
                <option selected>Tipo de Usuario</option>
                <?php
                include_once("../servidor/conexion.php");
                $cone = mysqli_query($conexion, "SELECT * FROM tipousuarios ORDER BY tipousuarios.tipousu ASC");
                $resu = mysqli_num_rows($cone);
                while ($dat = mysqli_fetch_assoc($cone)) {
                ?>

                  <option value="<?php echo $dat['idtipo'] ?>"><?php echo $dat['tipousu'] ?></option>

                <?php
                }
                ?>
              </select>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
              <button type="submit" class="btn btn-primary">Guardar Información</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!--termina modal-->
  <footer>
    <?php
    include_once("include/pie.php");
    ?>
  </footer>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>


</body>

</html>