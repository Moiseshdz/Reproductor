<?php
include "consultas/sesion.php";
include "consultas/unidad.php";
include "consultas/jefes.php" ;
include "consultas/unidad.php";
include "consultas/chofer.php";
include "consultas/personal.php";
include "consultas/folio-contador.php";
include "acciones/perfil.php";
date_default_timezone_set('America/Mexico_City');
?>
    <!DOCTYPE html>
    <html lang="es">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="stylesheet" href="../css/reporte.css">
        <title>Reporte de Salida</title>

    </head>

    <body>

  <!-- Menú desplegable -->
  <div id="mySidenav" class="sidenav">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <a href="#" id="openPopup">PERFIL</a>
        <a href="acciones/personal.php">PERSONAL</a>
        <a href="acciones/unidades.php">UNIDADES</a>
          <a href="acciones/chofer.php">CHOFERES</a>
        <a href="acciones/jefe.php">JEFE DE DEP</a>
        <a href="acciones/pdfs.php">PASES PDF</a>
        <a href="#" onclick="salir()">SALIR</a>
        
       
    </div>
<!-- Contenido del popup -->
<div class="popup" id="profilePopup" >
    <h3>Perfil de Usuario</h3>
    <h4>Actualizar Datos</h4>
    <div style="overflow-y: auto; height: 400px;" >
   
    <form action="#" method="post">
        <div class="profile-info">
            <img src="<?=$img?>" alt="" style="border-radius:10px; width: 180px;" />

            
            <div class="input-container">
            <input id="num" style="width: 230px;" type="text" name="ficha" value="<?=$_COOKIE['ficha_cookie']?>" hidden>
                <label for="nombre">Nombre:</label>
                <input id="nombre" style="width: 250px;" type="text" name="nombre" value="<?=$nombre_sesion?>">
            </div>
            <div class="input-container">
                <label for="apellido">Apellido:</label>
                <input id="apellido" style="width: 250px;" type="text" name="apellido" value="<?=$apellido_sesion?>">
            </div>
            <div class="input-container">
                <label for="email">Correo:</label>
                <input id="email" style="width: 250px;" type="text" name="email" value="<?=$email?>">
            </div>
            <div class="input-container">
                <label for="num">Teléfono:</label>
                <input id="num" style="width: 250px;" type="text" name="num" value="<?=$num?>">
            </div>

           
           </div>

        <br>
        <center>
            <button type="submit" name="btnE">Aceptar</button>
            <button id="closePopup" style="background-color: #E74C3C;">Cerrar</button>
        </center>
    </form>
    <form action="#" method="post" enctype="multipart/form-data">
    <input id="num" style="width: 230px;" type="text" name="ficha" value="<?=$_COOKIE['ficha_cookie']?>" hidden>
    <label for="imagen">Foto:</label>
    <input id="imagen" style="width: 230px;" type="file" name="img" required>
    <button type="submit" name="btnImg">Aceptar</button>
    </form>

    </div>
</div>

<!-- Fondo oscuro detrás del popup -->
<div class="overlay" id="overlay"></div>




        <form action="pdf.php" method="post">
    <!-- Botón para abrir el menú -->
        <span class="menu" style="font-size:30px;cursor:pointer;" onclick="openNav()">&#9776; Menú</span>
        <img src="../logo/logo.jpg" alt="">
        <br><br><br>
            
            <input type="text" name="num" value="<?=$contador?>" hidden>
            <input type="text" name="folio" value="<?=$folio?>" hidden>
            <input type="text" name="fecha" value="<?=date(" d/m/y ");?>" hidden>
            <input type="text" name="hora" value="<?=date(" g:i a ");?>" hidden>

            <strong>MOTIVO DE LA SALIDA:</strong>
            <p class="token">
                <?=$token?>
            </p>
            <br>
            <br> FECHA:
            <input type="text" name="fecha" value="<?=date(" d/m/y ");?>" readonly>
            <br>
            <br>

            <label for="">VEHÍCULO/No. INVENTARIO:</label>
            <br>
            <input type="text" name="tipo_vehiculo" placeholder="Tipo" onclick="mostrarPopup()" readonly />

            <input type="text" name="no_inventario" placeholder="000000" required />
            <input type="text" name="no_inventario_2" placeholder="000000" readonly hidden/> Placa:
            <input type="text" name="placa" placeholder="000000" required />
            <br>
            <br>

            <label for="">POR ORDEN DE:</label>
            <br>
            <input type="text" name="orden_de" onclick="mostrarPopupJefe()" style="width: 310px;" required readonly /> /
            <input type="text" name="orden_de_2" style="width: 200px;" required /> 
            H.Salida:

            <input type="time" name="hora_salida" style="width: 150px;"  required />
            <br>
            <br>

            <label for="">DESCRIPCIÓN DE LOS BIENES:</label>
            <br>
            <textarea style="width: 80%;" name="descripcion" id="" cols="70" rows="6" required></textarea>
            <br>
            <br>

            <label for="">DESTINO:</label>
            <br>
            <input type="text" name="destino" style="width: 60%;" required>
            <br>
            <br>

            <label for="">MOTIVO DE LA SALIDA:</label>
            <br>
            <input type="text" name="motivo" style="width: 60%;" required>
            <br>
            <br>

<hr>
            <label for="">COORDINADOR EN TURNO</label>
            <br>
            <br> NOMBRE:
            <input type="text" name="coordinador_nombre" style="width: 300px;" value="<?=$nombre_sesion.' '. $apellido_sesion?>" readonly>
            <br> FICHA:
            <input type="text" name="coordinador_ficha" value="<?=$ficha_session?>" readonly>
            <br>


            <hr>

            <label for="">RESPONSABLE DE LA UNIDAD</label>
            <br>
            <br> NOMBRE:
            <input type="text" name="responsable_nombre" onclick="mostrarPopupChefer()" required readonly>
            <br> FICHA:
            <input type="text" name="responsable_ficha" required>
            <br> NO. LICENCIA:
            <input type="text" name="responsable_licencia" required>
            <br>


            <hr>

            <label for="">VIGILANTE EN TURNO</label>
            <br>
            <br> NOMBRE:
            <input type="text" name="vigilante_nombre">
            <br> FICHA:
            <input type="text" name="vigilante_ficha">
            <br>

            <hr>

            <label for="">PERSONAL AUXILIAR</label>

            <p class="elegir" onclick="mostrarPopupPersonal()">Elegir</p>

        <!--select id="numero" onclick="mostrarPopupPersonal()" style="width: 60px;">
            <option value="0">0</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
        </!--select-->
    
        

        <div id="inputs"></div>
            <br>

            <hr>
            <center>
            <input type="submit" value="GENERAR">
            </center>


        </form>

<center><i style="color:black; font-size:14px;">Todos los derechos reservados © Moisés de Jesús García Hernández copyright 2024. </i></center>
<p></p>
        <script src="../js/reportee.js"></script>
    </body>
    </html>
