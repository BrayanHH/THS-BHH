<?php
include_once("../servidor/conexion.php");
if(!empty($_GET['id'])){
    $clave=$_GET['id'];
    $consulta = mysqli_query($conexion, "DELETE FROM productos WHERE idprod=$clave");
    mysqli_close($conexion);
    header("Location: productos.php");

}
?>