<?php
include_once("../servidor/conexion.php");
if(!empty($_GET['id'])){
    $clave=$_GET['id'];
    $consulta = mysqli_query($conexion, "DELETE FROM usuarios WHERE idusu=$clave");
    mysqli_close($conexion);
    header("Location: usuarios.php");

}
?>