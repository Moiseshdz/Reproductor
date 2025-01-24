
<?php
// Set the number of seconds before the refresh
$seconds = 15;

// Construct the Refresh header
$refreshHeader = "Refresh: $seconds; URL=reporte.php";

// Send the Refresh header
header($refreshHeader);


require_once 'dompdf/autoload.inc.php';
include "../conn/conn.php";

use Dompdf\Dompdf;
use Dompdf\Options;

$options = new Options();
$options->set('isHtml5ParserEnabled', true);
$options->set('isPhpEnabled', true);
$options->set('defaultFont', 'Arial');

$dompdf = new Dompdf($options);

date_default_timezone_set('America/Mexico_City');

// Función para detectar si el usuario está accediendo desde un dispositivo móvil
function isMobileDevice() {
    return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|midp|netfront|opera m(ob|in)i|palm( os)?|phone|pie|up\.browser|up\.link|webos|wos)/i", $_SERVER['HTTP_USER_AGENT']);
}

// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recoger los datos del formulario
    $destino = $_POST['destino'];
    $motivo = $_POST['motivo'];

    $folio = $_POST['folio'];
    $fecha = $_POST['fecha'];
    $hora  = $_POST['hora'];

   
    $ruta_pdf = 'pdfs/Reporte_de_salida_Folio_' . $folio . '.pdf';
    // Sentencia SQL para insertar los valores en la tabla "pdf"
    $insertToken = "INSERT INTO pdf (destino,motivo,folio, fecha, hora, ruta) 
                    VALUES ('$destino','$motivo','$folio', '$fecha', '$hora','$ruta_pdf')";

    // Ejecutar la consulta
    if ($conn->query($insertToken) === TRUE) {
        // Definir la ruta donde deseas guardar el PDF
       

        // Recoger los demás datos del formulario
        $tipo_vehiculo = $_POST['tipo_vehiculo'];
        $no_inventario = $_POST['no_inventario'];
        $placa = $_POST['placa'];
        $orden_de = $_POST['orden_de'];
        $orden_de_2 = $_POST['orden_de_2'];
        $hora_salida = $_POST['hora_salida'];
        $descripcion = $_POST['descripcion'];
        $destino = $_POST['destino'];
        $motivo = $_POST['motivo'];
        $coordinador_nombre = $_POST['coordinador_nombre'];
        $coordinador_ficha = $_POST['coordinador_ficha'];
        $responsable_nombre = $_POST['responsable_nombre'];
        $responsable_ficha = $_POST['responsable_ficha'];
        $responsable_licencia = $_POST['responsable_licencia'];
        $vigilante_nombre = $_POST['vigilante_nombre'];
        $vigilante_ficha = $_POST['vigilante_ficha'];

        // Cargar HTML desde rep.php
        ob_start(); // Iniciar el almacenamiento en búfer de salida
        include 'rep.php'; // Incluir el archivo rep.php que contiene el HTML
        $html = ob_get_clean(); // Obtener el contenido del búfer de salida y limpiarlo

        // Renderizar PDF
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->getOptions()->set('isRemoteEnabled', true);
        $dompdf->render();

        // Guardar el PDF en la ruta especificada
        file_put_contents($ruta_pdf, $dompdf->output());

        // Verificar si es un dispositivo móvil
        if (isMobileDevice()) {
            // Descargar el PDF al navegador y abrirlo automáticamente
            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment; filename="Reporte_de_salida ('.$folio.').pdf"');
            echo $dompdf->output();
        } else {
            // Salida del PDF al navegador para visualización directa (solo en dispositivos no móviles)
            $dompdf->stream('Reporte_de_salida ('.$folio.').pdf', array('Attachment' => 0));
        }

        echo "PDF guardado en: $ruta_pdf";
    } else {
        echo "Error al insertar el registro: " . $conn->error;
    }

    // Cerrar la conexión a la base de datos
    $conn->close();
} else {
    echo "Error: No se han recibido datos del formulario.";
}
?>

