<?php
// Incluir el archivo de conexión
include("../Servidor/conexion.php");


// nombre del archivo y charset
header('Content-Type: text/csv; charset=latin1');
header('Content-Disposition: attachment; filename="ReporteProductos.csv"');

// Salida del archivo
$salida = fopen('php://output', 'w');

// Encabezados del CSV
fputcsv($salida, array('Nombre', 'Descripcion', 'Cantidad', 'Precio', 'Color', utf8_decode('Tamaño'), 'Foto'));

// Consulta para obtener los datos
$reporteCsv = mysqli_query($conexion,'SELECT * FROM productos');

// Verificar si la consulta fue exitosa
if (!$reporteCsv) {
    die("Error en la consulta: " . $mysqli->error);
}

// Escribir los datos en el archivo CSV
while ($filaR = $reporteCsv->fetch_assoc()) { 
    fputcsv($salida, array(
        utf8_decode($filaR ['nombre']),
        utf8_decode($filaR['descripcion']),
        $filaR['cantidad'],
        $filaR['precio'],
        utf8_decode($filaR['color']),
        $filaR['tamaño'],
        $filaR['foto']
    ));
}

// Cerrar la salida
fclose($salida);
?>