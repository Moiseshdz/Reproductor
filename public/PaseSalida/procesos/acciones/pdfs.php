<?php
include "../../conn/conn.php";
// Consulta inicial de datos
$ficha_session = isset($_COOKIE['ficha_cookie']) ? $_COOKIE['ficha_cookie'] : '';
date_default_timezone_set('America/Mexico_City');
$sql = "SELECT * FROM pdf ORDER BY id DESC";
$result = $conn->query($sql);
if ($result->num_rows <= 0) {
    $error = "<br>NO HAY RESULTADOS";
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../../css/personal.css">
    <title>Reporte de Salida</title>
</head>
<body>
    <div class="caja">
        <img src="../../logo/logo.jpg" style="width: 130px;">
        <a href="../reporte.php?ficha_sesion=<?=$ficha_session?>"> <span class="menu" style="font-size:30px;cursor:pointer; color:black;">&#9776; Inicio</span></a>
        <br><br>

        <br>
        <center style="font-weight: bold;">PDFS DE PASES DE SALIDAS</center>
        <br>
        <input type="text" id="searchInput" placeholder="Buscar...">
        <br><br>
        <div style="overflow-x:auto; overflow-y:auto; height: 380px;">
            <table id="pdfTable">
                <tr>
                    <th>#</th>
                    <th>DESTINO</th>
                    <th>MOTIVO</th>
                    <th>FOLIO</th>
                    <th>FECHA</th>
                    <th>HORA</th>
                    <th>VER</th>
                </tr>
                <?php $count = 0; ?>
                <?php while($row = $result->fetch_assoc()) { ?>
                <tr>
                <td><?php echo ++$count; ?></td>
                   <td><?=$row['destino']?></td>
                   <td><?=$row['motivo']?></td>
                   <td><?=$row['folio']?></td>
                   <td><?=$row['fecha']?></td>
                   <td><?=$row['hora']?></td>
                   <td><a href="../<?=$row['ruta']?>"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></a></td>
                </tr>
                <?php } ?>
            </table>
        </div>
    </div>
</body>
</html>

<script>
    document.getElementById("searchInput").addEventListener("keyup", function() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("searchInput");
        filter = input.value.toUpperCase();
        table = document.getElementById("pdfTable");
        tr = table.getElementsByTagName("tr");
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td");
            for (var j = 0; j < td.length; j++) {
                if (td[j]) {
                    txtValue = td[j].textContent || td[j].innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                        break;
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }
    });
</script>

<style>
    a{
        color:red;
    }
    a:hover{
      color:#45a049;
    }
    td{
        text-transform: uppercase;
    }
</style>
