<?php
   $fecha = $_POST['fecha'];
   
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

   ?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>PDF</title>
   </head>
   <body>
      <!-- Tu HTML aquí -->
      <div class="container">
         <div class="head">
            <div class="heading-text">
               PEMEX PERFORACION Y SERVICIOS
            </div>
         </div>
         <div class="logos">
            <img class="iqz" src="https://midycode.com/PaseSalida/logo/Imagen1.jpg" alt="">
            <img class="der" src="https://midycode.com/PaseSalida/logo/Imagen2.jpg" alt="">
         </div>
         <div class="center">
            <div class="center-text">
               <p>UNIDAD DE SERVICIOS A POZOS, SUR.</p>
               <p>DEPARTAMENTO DE CEMENTACIONES</p>
            </div>
         </div>
         <div class="footer">
            <div class="footer-text">
               PASE PARA SALIDA DE VEHICULOS, MATERIALES Y/O PERSONAL
            </div>
         </div>
         <div class="body" style="display: inline-block;">
            <div class="body-text">
               <!-- Contenido del cuerpo -->
               <div class="fecha">
                  FECHA: 
                  <div class="textfecha"><?php echo $fecha;?></div>
               </div>
               <p style="font-weight: bold;">AL DEPARTAMENTO DE VIGILANCIA:</p>
               <p class="title">VEHÍCULO/No. INVENTARIO:</p>
               <div style="width: 10px; text-decoration: underline; display: inline-block;"></div>
               <div class="line" style="width: 140px;"><?php echo $tipo_vehiculo;?></div>
               <div style="width: 10px; text-decoration: underline; display: inline-block;"></div>
               <div class="line" style="width: 140px;"><?php echo $no_inventario;?></div>
               <div class="line" style="float: right; margin-left: 5px; width: 120px;"><?php echo $placa;?></div>
               <div class="title" style="float: right;">PLACAS:</div>
               <br><br>
               <div class="title">POR ORDEN DE:</div>
               <div class="space-x" style="width: 10px;"></div>
               <div class="line" style="width: 370px; background-color: #CCD1D1;"><?php echo $orden_de?> / <?php echo $orden_de_2?></div>
               <div class="line" style="float: right; margin-left: 5px; width: 60px;"><?php echo $hora_salida?></div>
               <div class="title" style="float: right;">HORA DE SALIDA:</div>
               <br><br>
               <div class="title">DESCRIPCIÓN DE LOS BIENES:</div>
               <div class="space-x"></div>
               <div class="line" style="width: 460px;"><?php echo $descripcion?></div>
               <br><br>
               <div class="title">DESTINO:</div>
               <div class="space-x" style="width: 34px;"></div>
               <div class="line" style="width: 550px;"><?php echo $destino?></div>
               <br><br>
               <div class="title">MOTIVO DE LA SALIDA:</div>
               <div class="space-x" style="width: 23.5px;"></div>
               <div class="line" style="width: 500px;"><?php echo $motivo?></div>
            </div>
         </div>
         <div class="aling">
            <div class="space-x" style="width: 25px;"></div>
            <div class="coord">
               <div class="coord-text">
                  COORDINADOR EN TURNO
               </div>
               <div class="turno-text">
                  <p class="turno-p"><span class="turno-titulo">NOMBRE:</span> <?php echo $coordinador_nombre?></p>
                  <p class="turno-p"><span class="turno-titulo">FICHA:</span> <?php echo $coordinador_ficha?></p>
                  <p class="turno-p"><span class="turno-titulo">FIRMA:</span>
                     _______________________________________________
                  </p>
               </div>
            </div>
            <div class="space-x" style="width: 25px;"></div>
            <div class="resp-unidad">
               <div class="resp-text">
                  RESPONSABLE DE LA UNIDAD
               </div>
               <div class="resp-unidad-p">
                  <span><?php echo $responsable_nombre?></span>
                  <div class="space-x" style="width: 20px;"></div>
                  FICHA: <?php echo $responsable_ficha?> <br>
                  <span class="licencia">NO. LICENCIA: <?php echo $responsable_licencia?></span>
                  <span class="firma">FIRMA: _______________</span>
               </div>
            </div>
            <div class="vigilancia">
               <div class="vigilancia-text-title">VIGILANTE EN TURNO</div>
            </div>
            <div class="vig-text">
               <p class="turno-p"><span class="turno-titulo">NOMBRE:</span> <?php echo $vigilante_nombre?></p>
               <p class="turno-p"><span class="turno-titulo">FICHA:</span> <?php echo $vigilante_ficha?></p>
               <p class="turno-p"><span class="turno-titulo">FIRMA:</span>
                  _______________________________________________
               </p>
            </div>
            <div class="space-x" style="width: 25px;"></div>
            <div class="personal">
               <div class="personal-text-title">PERSONAL AUXILIAR</div>
               <?php 
                  foreach ($_POST as $nombre_campo => $valor_campo) {
                     if (substr($nombre_campo, 0, 7) == 'nombre_') {
                         $indice = substr($nombre_campo, 7); 
                         $nombre = $_POST['nombre_' . $indice];
                         $ficha = $_POST['ficha_' . $indice];
                         #echo "Nombre: $nombre, Ficha: $ficha<br>";
                  ?>
               <p id="index-up" class="turno-p" style="text-decoration: underline;">
                  <?php echo $nombre?>  <span class="ficha">FICHA: <?php echo $ficha?></span> 
               </p>
               <?php } } ?>
               <div class="uno">
                  CONTENIDO CHECADO DE CONFORMIDAD A LA HORA DE SALIDA       <br>   
                  DEPTO. SOLICITANTE.   <br>
                  PATRIMONIAL.   
               </div>
               <div class="tres" >
                  ORIGINAL VIGILANCIA.  <br>
                  C.C.P.  SERVICIOS GENERALES Y ADMÓN.. 
               </div>
               <div class="dos">
                  TELEFENOS: DEPARTAMENTO DE CEMETACIONES	<br>	
                  933 334 0033 EXT.: 34 199, 34 697				
               </div>
            </div>
            <div  class="pie">
               NOTA: ESTE DOCUMENTO NO TENDRÁ VALIDEZ SI PRESENTA ALTERACIONES Y FECHA ATRASADA
            </div>
         </div>
      </div>


      <div style="height: 33px;"></div>

      
      <!-- Tu HTML2 aquí -->
        <div class="container">
         <div class="head">
            <div class="heading-text">
               PEMEX PERFORACION Y SERVICIOS
            </div>
         </div>
         <div class="logos">
            <img class="iqz" src="https://midycode.com/PaseSalida/logo/Imagen1.jpg" alt="">
            <img class="der" src="https://midycode.com/PaseSalida/logo/Imagen2.jpg" alt="">
         </div>
         <div class="center">
            <div class="center-text">
               <p>UNIDAD DE SERVICIOS A POZOS, SUR.</p>
               <p>DEPARTAMENTO DE CEMENTACIONES</p>
            </div>
         </div>
         <div class="footer">
            <div class="footer-text">
               PASE PARA SALIDA DE VEHICULOS, MATERIALES Y/O PERSONAL
            </div>
         </div>
         <div class="body" style="display: inline-block;">
            <div class="body-text">
               <!-- Contenido del cuerpo -->
               <div class="fecha">
                  FECHA: 
                  <div class="textfecha"><?php echo $fecha;?></div>
               </div>
               <p style="font-weight: bold;">AL DEPARTAMENTO DE VIGILANCIA:</p>
               <p class="title">VEHÍCULO/No. INVENTARIO:</p>
               <div style="width: 10px; text-decoration: underline; display: inline-block;"></div>
               <div class="line" style="width: 140px;"><?php echo $tipo_vehiculo;?></div>
               <div style="width: 10px; text-decoration: underline; display: inline-block;"></div>
               <div class="line" style="width: 140px;"><?php echo $no_inventario;?></div>
               <div class="line" style="float: right; margin-left: 5px; width: 120px;"><?php echo $placa;?></div>
               <div class="title" style="float: right;">PLACAS:</div>
               <br><br>
               <div class="title">POR ORDEN DE:</div>
               <div class="space-x" style="width: 10px;"></div>
               <div class="line" style="width: 370px; background-color: #CCD1D1;"><?php echo $orden_de?> / <?php echo $orden_de_2?></div>
               <div class="line" style="float: right; margin-left: 5px; width: 60px;"><?php echo $hora_salida?></div>
               <div class="title" style="float: right;">HORA DE SALIDA:</div>
               <br><br>
               <div class="title">DESCRIPCIÓN DE LOS BIENES:</div>
               <div class="space-x"></div>
               <div class="line" style="width: 460px;"><?php echo $descripcion?></div>
               <br><br>
               <div class="title">DESTINO:</div>
               <div class="space-x" style="width: 34px;"></div>
               <div class="line" style="width: 550px;"><?php echo $destino?></div>
               <br><br>
               <div class="title">MOTIVO DE LA SALIDA:</div>
               <div class="space-x" style="width: 23.5px;"></div>
               <div class="line" style="width: 500px;"><?php echo $motivo?></div>
            </div>
         </div>
         <div class="aling">
            <div class="space-x" style="width: 25px;"></div>
            <div class="coord">
               <div class="coord-text">
                  COORDINADOR EN TURNO
               </div>
               <div class="turno-text">
                  <p class="turno-p"><span class="turno-titulo">NOMBRE:</span> <?php echo $coordinador_nombre?></p>
                  <p class="turno-p"><span class="turno-titulo">FICHA:</span> <?php echo $coordinador_ficha?></p>
                  <p class="turno-p"><span class="turno-titulo">FIRMA:</span>
                     _______________________________________________
                  </p>
               </div>
            </div>
            <div class="space-x" style="width: 25px;"></div>
            <div class="resp-unidad">
               <div class="resp-text">
                  RESPONSABLE DE LA UNIDAD
               </div>
               <div class="resp-unidad-p">
                  <span><?php echo $responsable_nombre?></span>
                  <div class="space-x" style="width: 20px;"></div>
                  FICHA: <?php echo $responsable_ficha?> <br>
                  <span class="licencia">NO. LICENCIA: <?php echo $responsable_licencia?></span>
                  <span class="firma">FIRMA: _______________</span>
               </div>
            </div>
            <div class="vigilancia">
               <div class="vigilancia-text-title">VIGILANTE EN TURNO</div>
            </div>
            <div class="vig-text">
               <p class="turno-p"><span class="turno-titulo">NOMBRE:</span> <?php echo $vigilante_nombre?></p>
               <p class="turno-p"><span class="turno-titulo">FICHA:</span> <?php echo $vigilante_ficha?></p>
               <p class="turno-p"><span class="turno-titulo">FIRMA:</span>
                  _______________________________________________
               </p>
            </div>
            <div class="space-x" style="width: 25px;"></div>
            <div class="personal">
               <div class="personal-text-title">PERSONAL AUXILIAR</div>
               <?php 
                  foreach ($_POST as $nombre_campo => $valor_campo) {
                     if (substr($nombre_campo, 0, 7) == 'nombre_') {
                         $indice = substr($nombre_campo, 7); 
                         $nombre = $_POST['nombre_' . $indice];
                         $ficha = $_POST['ficha_' . $indice];
                         #echo "Nombre: $nombre, Ficha: $ficha<br>";
                  ?>
               <p id="index-up" class="turno-p" style="text-decoration: underline;">
                  <?php echo $nombre?>  <span class="ficha">FICHA: <?php echo $ficha?></span> 
               </p>
               <?php } } ?>
               <div class="uno">
                  CONTENIDO CHECADO DE CONFORMIDAD A LA HORA DE SALIDA       <br>   
                  DEPTO. SOLICITANTE.   <br>
                  PATRIMONIAL.   
               </div>
               <div class="tres" >
                  ORIGINAL VIGILANCIA.  <br>
                  C.C.P.  SERVICIOS GENERALES Y ADMÓN.. 
               </div>
               <div class="dos">
                  TELEFENOS: DEPARTAMENTO DE CEMETACIONES	<br>	
                  933 334 0033 EXT.: 34 199, 34 697				
               </div>
            </div>
            <div  class="pie">
               NOTA: ESTE DOCUMENTO NO TENDRÁ VALIDEZ SI PRESENTA ALTERACIONES Y FECHA ATRASADA
            </div>
         </div>
      </div>
   </body>
</html>

     <style>
         body {
         font-family: Arial, Helvetica, sans-serif;
         font-weight: bold;
         text-transform: uppercase;
         }
         .licencia {
         position: relative;
         right: 10px;
         top: 10px;
         }
         .firma {
         position: relative;
         right: -30px;
         top: 10px;
         }
         .resp-unidad {
         font-size: 10px;
         width: 300px;
         height: 13px;
         display: inline-block;
         border: solid 1px black;
         background-color: #EAEDED;
         }
         .resp-text {
         padding-top: 0.7px;
         text-align: center;
         float: right;
         padding-right: 70px;
         }
         .resp-unidad-p {
         font-size: 10px;
         padding-top: 0.7px;
         text-align: center;
         float: right;
         position: relative;
         top: 20px;
         width: 300px;
         height: 10px;
         word-wrap: break-word;
         }
         .coord {
         font-size: 10px;
         width: 300px;
         height: 13px;
         display: inline-block;
         border: solid 1px black;
         background-color: #EAEDED;
         }
         .coord-text {
         padding-top: 0.7px;
         text-align: center;
         }
         .turno-text {
         float: left;
         }
         .turno-p {
         margin-bottom: -6px;
         }
         .container {
         width: 100%;
         height: 490px;
         border: solid 1.5px black;
         word-wrap: break-word;
         overflow-y: auto;
         text-align: justify;
         position: relative;
         top: -30px;
         }
         .head, .footer {
         width: 95%;
         margin: 10px auto;
         border: solid 1px black;
         background-color: #EAEDED;
         font-weight: bold;
         text-align: center;
         }
         .body {
         margin-left: 33px;
         width: 90%;
         text-align: justify;
         font-size: 9px;
         display: inline-block;
         text-align: left;
         position: relative;
         top: -30px;
         }
         .logos {
         width: 95%;
         margin: 10px auto;
         }
         .iqz {
         width: 100px;
         float: left;
         }
         .der {
         width: 100px;
         float: right;
         }
         .footer {
         position: relative;
         top: -20px;
         margin-top: 10px;
         }
         .line {
         display: inline-block;
         margin: 0;
         font-size: 9px;
         font-weight: bold;
         background-color: #F9E79F;
         height: 13px;
         text-align: center;
         border-bottom: solid 1px black;
         }
         .space-x {
         width: 30px;
         display: inline-block;
         }
         .space-y {
         height: -5px;
         }
         .title {
         display: inline-block;
         margin: 0;
         font-size: 9px;
         }
         .center-text {
         position: relative;
         top: -15px;
         font-size: 13px;
         font-weight: bold;
         text-align: center;
         }
         .footer-text, .heading-text {
         font-size: 12px;
         }
         .vigilancia{
         width: 300px;
         height: 13px;
         background-color: #EAEDED;
         position: relative;
         top: 60px;
         left: 30px;
         border: solid 1px;
         }
         .vigilancia-text-title{
         position: relative;
         top: -48.5px;
         font-size: 10px;;
         text-align: center;
         }
         .vig-text{
         position: relative;
         font-size: 10px;
         top: 60px;
         left: 31px;
         }
         .personal{
         width: 300px;
         height: 13px;
         background-color: #EAEDED;
         position: relative;
         top: -35px;
         left: 370px;
         border: solid 1px;
         font-size: 10px;
         }
         .personal-text-title{
         text-align: center;
         }
         .ficha{
         position: relative;
         top: 0px;
         float: right;
         }
         .pie{
         position: relative;
         top:80px;
         width: 100%;
         height: 10px;
         background-color: gray;
         font-size: 9px;
         text-align: center;
         height: 13px;
         border-radius: 3px;
         color: #F2F3F4;
         }
         .aling{
         position: relative;
         top:-15px;
         }
         .uno{
            position: absolute;
            top: 100px;
            width: auto;
            font-size: 5px;
            left: -340px;
            z-index: 99999;
         }
         .dos{
            position: absolute;
            top: 108px;
            width: 200px;
            font-size: 6px;
            right: 100px;
            z-index: 99999;
         }
         .tres{
            position: absolute;
            top: 100px;
            width: auto;
            font-size: 5px;
            left: -160px; 
            z-index: 99999;
         }
         .fecha{
            width:auto;
            font-size: 10px;
            position: relative;
            top: 10px;
            left: 545px;
            display: inline-block;
          
         }
         .textfecha{
            display: inline-block; 
            width: 45px; 
            height: 13px; 
            background-color: #F9E79F; 
            position: relative;
            top: 4px;
            text-align: center;
            border-bottom: solid 1px;
         }
               
      </style>
      
 