<!DOCTYPE html>
<html>
<head>
    <title>Importar archivo CSV a PostgreSQL</title>
</head>
<body>
    <h2>Importar archivo CSV</h2>
    <form action="importar.php" method="post" enctype="multipart/form-data">
        <input type="file" name="archivo" id="archivo">
        <br>
        <br>
        <input type="submit" value="Importar">
    </form>
</body>
</html>

<?php

// Verificar si se ha seleccionado un archivo
if(isset($_FILES['archivo']) && $_FILES['archivo']['name'] != '') {
    // Verificar si el archivo es un archivo CSV válido
    $extension = pathinfo($_FILES['archivo']['name'], PATHINFO_EXTENSION);
    if($extension == 'csv') {
        // Leer el contenido del archivo CSV y convertirlo en un arreglo
        $contenido = file_get_contents($_FILES['archivo']['tmp_name']);
        $filas = explode("\n", $contenido);
        $datos = array();
        foreach($filas as $fila) {
            $columnas = explode(",", $fila);
            $datos[] = $columnas;
        }
        
        // Conectar a la base de datos PostgreSQL
        $conn = pg_connect("");
        if(!$conn) {
            die("Error de conexión: " . pg_last_error());
        }
        
        // Insertar los datos del archivo CSV en la tabla correspondiente
        $tabla = "eisa.empresasaux";
        foreach($datos as $fila) {
            $sql = "INSERT INTO $tabla (idempresaaux, idorganizacion, idlinea, idempresa, clabe, idbanco, idresponsable, responsable, correo_responsable, comision_eisa, spei, autorizado, fecha_solicitud, fecha_autorizado, socio, comision_recarga, tipo_comeisa, tipo_comrec, gasto_corriente, eisa_nrtec, socio_nrtec, cobros_diversos, concepto_aux2, concepto_aux3, monto_gasto_corriente, monto_nrtec_eisa, monto_socio_nrtec, monto_cobros_diversos, monto_concepto_aux2, monto_concepto_aux3, generalayout, comision_nosocio) VALUES ('$fila[0]', '$fila[1]', '$fila[2]', '$fila[3]', '$fila[4]', '$fila[5]', '$fila[6]', '$fila[7]', '$fila[8]', '$fila[9]', '$fila[10]', '$fila[11]', '$fila[12]', '$fila[13]', '$fila[14]', '$fila[15]', '$fila[16]', '$fila[17]', '$fila[18]', '$fila[19]', '$fila[20]', '$fila[21]', '$fila[22]', '$fila[23]', '$fila[24]', '$fila[25]', '$fila[26]', '$fila[27]', '$fila[28]', '$fila[29]', '$fila[30]', '$fila[31]')";
            $resultado = pg_query($conn, $sql);
            if(!$resultado) {
                echo ' <td  align="left">
                     <p><span style="color: green;">La importación ha sido exitosa</span>.</p>
                 </td> ';
            }
        }
    } else {
        echo ' <td  align="left">
            <p><span style="color: red;">El archivo debe ser formato CSV</span>.</p>
        </td> ';
    }
} 

?>

<html>
<body>
    <p><span style="color: black;">¿Deseas Regresar a la Página Principal?</span>.</p>
    <a href="http://187.160.239.50/monterrey/cambiosfide_pba/cambiosfide.php">
        <button>Aceptar</button>
    </a>
</body>
</html>



