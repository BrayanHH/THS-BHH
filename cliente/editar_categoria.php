<?php

include_once("../Servidor/conexion.php");

// Actualizar categoría
if (!empty($_POST)) {

    $alert = "";

    if (empty($_POST['categoria'])) {
        $alert = '<div class="alert alert-danger" role="alert">Todos los campos son requeridos</div>';
    } else {
            $idcat = intval($_GET['id']);

            $categoria = $_POST['categoria'];

            $sql_update = mysqli_query($conexion, "UPDATE categorias SET categoria='$categoria' WHERE idcat=$idcat" );

            if($sql_update){
                header("Location: productos.php?update=success");
                exit();
            }else{
                $alert = '<div class="alert alert-danger" role="alert">Error al actualizar categoria</div>';
            }
        }   

}

    // Validación de campos vacíos
   /* if (empty($_POST['cam1'])) {
        $alert = '<div class="alert alert-danger" role="alert">Todos los campos son requeridos</div>';
    } else {
        // Recogiendo datos del formulario

        $nombre = mysqli_real_escape_string($conexion, $_POST['categoria']);

        // Query para actualizar datos de la categoría
        $sql_update = mysqli_query($conexion, "UPDATE categorias SET categoria='$nombre' WHERE idcat='$idcat'");

        if ($sql_update) {
            // Redirigir con parámetro de éxito
            header("Location: categoria.php?update=success");
            exit();
        } else {
            $alert = '<div class="alert alert-danger" role="alert">Error al actualizar la categoría</div>';
        }
    }*/


// Mostrar datos de la categoría
if (empty($_REQUEST['id'])) {
    header("Location: categoria.php");
    exit();
}

$idcat = intval($_REQUEST['id']);

$stmt = $conexion->prepare("SELECT * FROM categorias WHERE idcat = ?");
$stmt->bind_param("i", $idcat);
$stmt->execute();
$result = $stmt->get_result();
$result_sql = $result->num_rows;

if ($result_sql == 0) {
    header("Location: categoria.php");
    exit();
} else {
    $data = $result->fetch_assoc();
    $categoria = $data['categoria'];
}
?>
<?php include_once "include/encabezado.php"; ?>

<!-- Begin Page Content -->
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-6 m-auto">
            <form action="" method="post">
                <?php echo isset($alert) ? $alert : ''; ?>
                <input type="hidden" name="id" value="<?php echo $idcat; ?>">
                <div class="form-group">
                    <label for="categoria">Nombre</label>
                    <input type="text" placeholder="Ingrese nombre" class="form-control" name="categoria" id="categoria" value="<?php echo $categoria; ?>">
                </div>

                <button type="button" class="btn btn-secondary" onclick="window.location.href='categoria.php'">Cancelar</button>
                <button type="submit" class="btn btn-primary"><i class="fas fa-user-edit"></i> Editar Categoría</button>
            </form>
        </div>
    </div>
</div>
<!-- End of Main Content -->
<?php include_once "include/pie.php"; ?>