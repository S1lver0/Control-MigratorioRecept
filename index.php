<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="style-2.css">
    <link rel="shortcut icon" href="sopas.png">
    <!--script src="https://kit.fontawesome.com/c4691aa0a3.js" crossorigin="anonymous"></script-->
    <script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
    <title>CONTROL MIGRATORIO</title>
    <!--LIBRERIAS AÑADIDAS PARA LAS ALERTAS-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.20/dist/sweetalert2.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.20/dist/sweetalert2.all.min.js"></script>
</head>

<body>
    <header>
        <div class="container">
            <nav class=" navbar-light">
                <a class="navbar-brand" href="#">
                    <div class="fotos">
                        <img src="img/escudo.png" width="80" height="90" class="d-inline-block align-top escudo"
                            alt="">
                        <img src="img/rayo.png" width="125" height="90" class="d-inline-block align-top rayo" alt="">
                    </div>

                </a>
                <h1 class="align-middle">RELACIÓN DE PASAJEROS</h1>
            </nav>
        </div>
    </header>


    <?php
    ///variables cabecera
    $fecha = "";
    $destino = "";
    $procedencia = "";
    $poliza = "";
    //variables vehiculo
    $tipo = "";
    $modelo = "";
    $motor = "";
    $placa = "";
    $marca = "";
    $año = "";
    $chasis = "";
    $pais = "";

    //variables conductor
    $diCon = "";
    $nombreCon = "";
    $domicilio = "";
    $profesion = "";
    $nacionalidad = "";
    $brevete = "";
    $fechaNa = "";
    $scpp = "";

    //pasajeros 
    $pass = false;
    //consultas sql
    
    if (isset($_GET['codigoqr'])) {
        $pass = true;
        include("conectarbd.php");
        $codigo = $_GET['codigoqr'];

        $sql = "SELECT pasajeros.*,detalle.* from pasajeros JOIN detalle ON detalle.pasajeros=pasajeros.DI_Numero WHERE detalle.registro = '$codigo'";

        $pasajeros = $conex->query($sql);

        //para cabecera
    
        $sql = "SELECT * FROM registro WHERE registro.codigo='$codigo'";
        $result = $conex->query($sql);
        $result = $result->fetch_assoc();

        $fecha = $result['fecha'];
        $procedencia = $result['procedencia'];
        $destino = $result['destino'];
        $poliza = $result['poliza'];

        //para vehiculo
        $sql = "SELECT vehiculo.*,modelo.Id,modelo.Nombre AS modelo_nombre,marca.Id,marca.Nombre AS marca_nombre,motor.Id,motor.Nombre AS motor_nombre,chasis.Id,chasis.Nombre AS chasis_nombre ,tipo_ve.Id,tipo_ve.Nombre AS tipo_ve_nombre,pais.id,pais.Nombre AS pais_nombre,registro.* FROM vehiculo 
        JOIN modelo ON vehiculo.Modelo=modelo.Id
        JOIN marca ON vehiculo.Marca=marca.Id
        JOIN motor ON vehiculo.Motor=motor.Id
        JOIN chasis ON vehiculo.Chasis=chasis.Id
        JOIN tipo_ve ON vehiculo.Tipo_ve=tipo_ve.Id
        JOIN pais ON vehiculo.Pais = pais.id
        JOIN registro ON vehiculo.Placa=registro.vehiculo
        WHERE registro.codigo = '$codigo'";

        $result = $conex->query($sql);
        $result = $result->fetch_assoc();

        //variables vehiculo
        $tipo = $result['tipo_ve_nombre'];
        $modelo = $result['modelo_nombre'];
        $motor = $result['motor_nombre'];
        $placa = $result['Placa'];
        $marca = $result['marca_nombre'];
        $año = $result['Anio'];
        $chasis = $result['chasis_nombre'];
        $pais = $result['pais_nombre'];

        //variables para conductor
        $sql = "SELECT conductor.*,registro.*,pais.Id,pais.Nombre AS nombre_pais,profesion.Id,profesion.Nombre AS nombre_profesion FROM conductor 
        JOIN pais ON conductor.pais=pais.id
        JOIN profesion ON conductor.profesion_Id=profesion.Id
        JOIN registro ON conductor.Di_conductor=registro.conductor
        WHERE registro.codigo = '$codigo'";

        $result = $conex->query($sql);
        $result = $result->fetch_assoc();

        //variables conductor
        $diCon = $result['Di_conductor'];
        $nombreCon = $result['Nombre'];
        $domicilio = $result['domicilio'];
        $profesion = $result['nombre_profesion'];
        $nacionalidad = $result['nombre_pais'];
        $brevete = $result['Brevete'];
        $fechaNa = $result['FNam'];
        $scpp = $result['scpp'];

    }
    ////////////////////////////////////////////////////////////////////////////////////////
    
    if (isset($_GET['guardar'])) {
        include("conectarbd.php");
        include("conectarbd2.php");
        $codigo = $_GET['guardar'];

        $sql = "SELECT pasajeros.*,detalle.* from pasajeros JOIN detalle ON detalle.pasajeros=pasajeros.DI_Numero WHERE detalle.registro = '$codigo'";

        $pasajeros = $conex->query($sql);

        //para cabecera
    
        $sql = "SELECT * FROM registro WHERE registro.codigo='$codigo'";
        $result = $conex->query($sql);
        $result = $result->fetch_assoc();

        $fecha = $result['fecha'];
        $procedencia = $result['procedencia'];
        $destino = $result['destino'];
        $poliza = $result['poliza'];

        //para vehiculo
        $sql = "SELECT vehiculo.*,modelo.Id,modelo.Nombre AS modelo_nombre,marca.Id,marca.Nombre AS marca_nombre,motor.Id,motor.Nombre AS motor_nombre,chasis.Id,chasis.Nombre AS chasis_nombre ,tipo_ve.Id AS id_tipo,tipo_ve.Nombre AS tipo_ve_nombre,pais.id AS id_pais,pais.Nombre AS pais_nombre,registro.* FROM vehiculo 
        JOIN modelo ON vehiculo.Modelo=modelo.Id
        JOIN marca ON vehiculo.Marca=marca.Id
        JOIN motor ON vehiculo.Motor=motor.Id
        JOIN chasis ON vehiculo.Chasis=chasis.Id
        JOIN tipo_ve ON vehiculo.Tipo_ve=tipo_ve.Id
        JOIN pais ON vehiculo.Pais = pais.id
        JOIN registro ON vehiculo.Placa=registro.vehiculo
        WHERE registro.codigo = '$codigo'";

        $result = $conex->query($sql);
        $result = $result->fetch_assoc();

        //variables vehiculo
        $tipo = $result['tipo_ve_nombre'];
        $modelo = $result['modelo_nombre'];
        $motor = $result['motor_nombre'];
        $placa = $result['Placa'];
        $marca = $result['marca_nombre'];
        $año = $result['Anio'];
        $chasis = $result['chasis_nombre'];
        $pais = $result['pais_nombre'];

        //vehiculo base de datos 2
    
        $chasis_d = uniqid();
        $marca_d = uniqid();
        $modelo_d = uniqid();
        $motor_d = uniqid();


        $pais = $result['id_pais'];
        $tipo = $result['id_tipo'];




        //variables para conductor
        $sql = "SELECT conductor.*,registro.*,pais.Id AS id_pais,pais.Nombre AS nombre_pais,profesion.Id AS id_profesion,profesion.Nombre AS nombre_profesion FROM conductor 
        JOIN pais ON conductor.pais=pais.id
        JOIN profesion ON conductor.profesion_Id=profesion.Id
        JOIN registro ON conductor.Di_conductor=registro.conductor
        WHERE registro.codigo = '$codigo'";

        $result = $conex->query($sql);
        $result = $result->fetch_assoc();

        //variables conductor
        $diCon = $result['Di_conductor'];
        $nombreCon = $result['Nombre'];
        $domicilio = $result['domicilio'];
        $profesion = $result['nombre_profesion'];
        $nacionalidad = $result['nombre_pais'];
        $brevete = $result['Brevete'];
        $fechaNa = $result['FNam'];
        $scpp = $result['scpp'];

        ///base de datos 2
        $Di_con = $diCon;
        $fecha_na = $fechaNa;
        $nacionalidad_conduc = $result['id_pais'];
        $nombre_conduc = $nombreCon;
        $profesion_conduc = $result['id_profesion'];

        //llenamos la tabla di 
        $tipo_di = "1";
        $sql = "INSERT INTO di (Numero,Tipo) VALUES ('$Di_con','$tipo_di')";

        if (mysqli_query($conex2, $sql)) {
            //echo "Datos insertados correctamente.";
        } else {
            //echo "Error al insertar datos: " . mysqli_error($conex);
        }

        /////////////////////////////////////////////////////////////////
    
        $sql = "INSERT INTO conductor (Di_conductor, Nombre, FNam, domicilio, pais, profesion_Id, scpp, Brevete) VALUES ('$Di_con','$nombre_conduc','$fecha_na','$domicilio','$nacionalidad_conduc','$profesion_conduc','$scpp','$brevete')";


        if (mysqli_query($conex2, $sql)) {
            //echo "Datos insertados correctamente.";
        } else {
            //echo "Error al insertar datos: " . mysqli_error($conex);
        }

        //tabla modelo
        $sql = "INSERT INTO modelo (Id,Nombre) VALUES ('$modelo_d','$modelo')";
        if (mysqli_query($conex2, $sql)) {
            //echo "Datos insertados correctamente.";
        } else {
            //echo "Error al insertar datos: " . mysqli_error($conex);
        }
        //motor
    
        $sql = "INSERT INTO motor (Id,Nombre) VALUES ('$motor_d','$motor')";
        if (mysqli_query($conex2, $sql)) {
            //echo "Datos insertados correctamente.";
        } else {
            //echo "Error al insertar datos: " . mysqli_error($conex);
        }

        //tabla marca
        $sql = "INSERT INTO marca (Id,Nombre) VALUES ('$marca_d','$marca')";
        if (mysqli_query($conex2, $sql)) {
            //echo "Datos insertados correctamente.";
        } else {
            //echo "Error al insertar datos: " . mysqli_error($conex);
        }
        //tabla Chasis
        $sql = "INSERT INTO chasis (Id,Nombre) VALUES ('$chasis_d','$chasis')";
        if (mysqli_query($conex2, $sql)) {
            //echo "Datos insertados correctamente.";
        } else {
            //echo "Error al insertar datos: " . mysqli_error($conex);
        }

        $sql = "INSERT INTO vehiculo (Placa, Anio, Modelo, Motor, Marca, Chasis, Tipo_Ve, Pais) VALUES ('$placa','$año','$modelo_d','$motor_d','$marca_d','$chasis_d','$tipo','$pais')";


        if (mysqli_query($conex2, $sql)) {
            //echo "Datos insertados correctamente.";
        } else {
            //echo "Error al insertar datos: " . mysqli_error($conex);
        }
        //llenado de tabla registro 
        $sql = "INSERT INTO registro (codigo, fecha, procedencia, destino, vehiculo, poliza, conductor) VALUES ('$codigo','$fecha','$procedencia','$destino','$placa','$poliza','$Di_con')";
        // Ejecutar la sentencia INSERT
        if (mysqli_query($conex2, $sql)) {
            //echo "Datos insertados correctamente.";
        } else {
            //echo "Error al insertar datos: " . mysqli_error($conex);
        }



        while ($fila = $pasajeros->fetch_assoc()) {
            $Passname = $fila['Nombre'];
            //////pais
            $aux = $fila['pais'];
            $pa_nacionalidad = $fila['pais'];
            $sql = "SELECT * FROM pais WHERE id=$aux";
            $aux = $conex->query($sql);
            $aux = $aux->fetch_assoc();
            $Passnacionalidad = $aux['Nombre'];
            ///
            //profesion
            $aux = $fila['profesion_Id'];
            $pa_profesion = $fila['profesion_Id'];
            $sql = "SELECT * FROM profesion WHERE id=$aux";
            $aux = $conex->query($sql);
            $aux = $aux->fetch_assoc();
            $Passprofesion = $aux['Nombre'];
            //estado_c
            $aux = $fila['estado_c'];
            $sql = "SELECT * FROM estado_c WHERE id=$aux";
            $aux = $conex->query($sql);
            $aux = $aux->fetch_assoc();
            $Passestado = $aux['Tipo'];
            //fecha
            //estado_c
            $aux = $fila['DI_Numero'];
            $sql = "SELECT * FROM di WHERE Numero=$aux";
            $aux = $conex->query($sql);
            $aux = $aux->fetch_assoc();
            $Tipe = $aux['Tipo'];
            
    
            $PassFecha = $fila['FNam'];
            //DI
            $PassDi = $fila['DI_Numero'];


            //llenamos la tabla pasajero
            $DI_Numero = $PassDi;
            $pa_estado = $fila['estado_c'];
            $pa_fecha = $PassFecha;
            $pa_nombre = $Passname;
            //llenamos la tabla di 
            $tipo_di = $Tipe;
            $sql = "INSERT INTO di (Numero,Tipo) VALUES ('$DI_Numero','$tipo_di')";

            if (mysqli_query($conex2, $sql)) {
                //echo "Datos insertados correctamente.";
            } else {
                //echo "Error al insertar datos: " . mysqli_error($conex);
            }


            $sql = "INSERT INTO pasajeros (DI_Numero, Nombre, FNam, estado_c, pais, profesion_Id) VALUES ('$DI_Numero','$pa_nombre','$pa_fecha','$pa_estado','$pa_nacionalidad','$pa_profesion')";


            if (mysqli_query($conex2, $sql)) {
                //echo "Datos insertados correctamente.";
            } else {
                //echo "Error al insertar datos: " . mysqli_error($conex);
            }

            //llenamos la tabla detalle
            $id_detalle = uniqid();
            $sql = "INSERT INTO detalle (id,registro,pasajeros) VALUES ('$id_detalle','$codigo','$DI_Numero')";

            if (mysqli_query($conex2, $sql)) {
                //echo "Datos insertados correctamente.";
            } else {
                //echo "Error al insertar datos: " . mysqli_error($conex);
            }

        }
        //registro completado
        $conex->close();
        $conex2->close();
        header("Location: index.php");
        exit();
    }

    ?>







    <form class="container caja-datos sombra">
        <h2>Escanear QR</h2>
        <div class="caja-escanear">
            <div class="video-container">
                <video id="QR">
                    <!-- Aquí puedes agregar las fuentes de video o dejarlo vacío -->
                </video>
                <img src="img/marcoqr.png" alt="Imagen superpuesta" class="overlay-image">
            </div>
            <div class="container-mensaje">
                <form method="POST" action="index.php">
                    <input name="codigoqr" type="text" id="codigoqr" class="mostrar-codigo" placeholder="Aquí el código"
                        style="display: none;">
                    <button id="botonqr" disabled class="btn btn-success" type="submit" onclick="mostrarDatos()">Obtener
                        datos del código QR</button>
                </form>
            </div>
        </div>
    </form>
    <br>
    <br>

    <form>
        <div class="container caja-datos sombra">
            <div class="row">
                <div class=" col-md-6 col-sm-12">
                    <label for="inputEmail4 col-sm-12">Fecha</label>
                    <input class="form-control" id="inputEmail4" placeholder="" value="<?php echo $fecha ?>" disabled>
                </div>
                <div class=" col-md-6">
                    <label for="inputPassword4">Destino</label>
                    <input type="text" class="form-control" id="inputPassword4" placeholder=""
                        value="<?php echo $destino ?>" disabled>
                </div>
            </div>

            <div class="row">
                <div class=" col-md-6 col-sm-12">
                    <label for="inputEmail4 col-sm-12">Procedencia</label>
                    <input type="text" class="form-control" id="inputEmail4" placeholder=""
                        value="<?php echo $procedencia ?>" disabled>
                </div>
                <div class=" col-md-6">
                    <label for="inputPassword4">Polizá</label>
                    <input type="text" class="form-control" id="inputPassword4" placeholder=""
                        value="<?php echo $poliza ?>" disabled>
                </div>
            </div>
        </div>

        <br>


        <br>

    </form>

    <br>
    <br>

    <div class="container  ordenar-grid sombra-grid">
        <div class="container fila-doble item1">
            <h2>Vehiculo</h2>
            <div class="row">
                <div class="row col-md-6">
                    <label for="inputPassword" class="col-sm-3 col-form-label">Tipo</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="inputPassword4d" placeholder=""
                            value="<?php echo $tipo ?>" disabled>
                    </div>
                </div>
                <div class="row col-md-6">
                    <label for="inputPassword" class="col-sm-3 col-form-label">Marca</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control input-vehiculo" id="inputPassword" placeholder=""
                            required value="<?php echo $marca ?>" disabled>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="row col-md-6">
                    <label for="inputPassword" class="col-sm-3 col-form-label">Modelo</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control input-vehiculo" id="inputPassword" placeholder=""
                            required value="<?php echo $modelo ?>" disabled>
                    </div>
                </div>
                <div class="row col-md-6">
                    <label for="inputPassword" class="col-sm-3 col-form-label">Año</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control input-vehiculo" id="inputPassword" placeholder=""
                            required value="<?php echo $año ?>" disabled>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="row col-md-6">
                    <label for="inputPassword" class="col-sm-3 col-form-label">Motor</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control input-vehiculo" id="inputPassword" placeholder=""
                            required value="<?php echo $motor ?>" disabled>
                    </div>
                </div>
                <div class="row col-md-6">
                    <label for="inputPassword" class="col-sm-3 col-form-label">Chasis</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control input-vehiculo " id="inputPassword" placeholder=""
                            required value="<?php echo $chasis ?>" disabled>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="row col-md-6">
                    <label for="inputPassword" class="col-sm-3 col-form-label">Placa</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control input-vehiculo" id="inputPassword" placeholder=""
                            required value="<?php echo $chasis ?>" disabled>
                    </div>
                </div>
                <div class="row col-md-6">
                    <label for="inputPassword" class="col-sm-3 col-form-label">Pais</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control input-vehiculo" id="inputPasswordsdsd" placeholder=""
                            required value="<?php echo $pais ?>" disabled>
                    </div>
                </div>
            </div>

        </div>


        <div class="container div-vehiculo item3">
            <h2>Conductor</h2>
            <div class="col">
                <div class="row col-md-12">
                    <label for="inputPassword" class="col-sm-2 col-form-label">Nombre</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control input-conductor" id="inputPassword" placeholder=""
                            required value="<?php echo $nombreCon ?>" disabled>
                    </div>
                </div>

                <div class="row col-md-12">
                    <label for="inputPassword" class="col-sm-2 col-form-label">Domicilio</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control input-conductor" id="inputPassword" placeholder=""
                            required value="<?php echo $domicilio ?>" disabled>
                    </div>
                </div>

                <div class="row col-md-12">
                    <label for="inputPassword" class="col-sm-2 col-form-label">Profesion</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control input-conductor" id="inputPasswordsdd" placeholder=""
                            required value="<?php echo $profesion ?>" disabled>
                    </div>
                </div>

                <div class="row col-md-12">
                    <label for="inputPassword" class="col-sm-2 col-form-label">Di</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control input-conductor" id="inputPasswordsddss" placeholder=""
                            required value="<?php echo $diCon ?>" disabled>
                    </div>
                </div>

                <div class="row col-md-12">
                    <label for="inputPassword" class="col-sm-2 col-form-label">Pais</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control input-conductor" id="inputPasswordsdddd" placeholder=""
                            required value="<?php echo $nacionalidad ?>" disabled>
                    </div>
                </div>

                <div class="row">
                    <div class="row col-md-4">
                        <label for="inputPassword" class="col-sm-3 col-form-label lbl-conductor">Brevete</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control input-conductor" id="inputPassword" placeholder=""
                                required value="<?php echo $brevete ?>" disabled>
                        </div>
                    </div>
                    <div class="row col-md-4">
                        <label for="inputPassword" class="col-sm-3 col-form-label lbl-conductor"">Fecha Nac</label>
                            <div class=" col-sm-9">
                            <input type="text" class="form-control input-conductor" id="inputPassword" placeholder=""
                                required value="<?php echo $fechaNa ?>" disabled>
                    </div>
                </div>

                <div class="row col-md-4">
                    <label for="inputPassword" class="col-sm-3 col-form-label lbl-conductor"">SC/PP</label>
                            <div class=" col-sm-9">
                        <input type="text" class="form-control input-conductor" id="inputPassword" placeholder=""
                            required value="<?php echo $scpp ?>" disabled>
                </div>
            </div>
        </div>
    </div>

    </div>

    </div>
    </form>

    <br>
    <br>

    <div class="container table-resp">
        <table class="table table-striped ">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nombres y apellidos</th>
                    <th scope="col">Nacionalidad</th>
                    <th scope="col">Estado Civil</th>
                    <th scope="col">Profesion</th>
                    <th scope="col">F. Nacimiento</th>
                    <th scope="col">DI</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($pass) {
                    $cant = 1;
                    while ($fila = $pasajeros->fetch_assoc()) {
                        $Passname = $fila['Nombre'];
                        //////pais
                        $aux = $fila['pais'];
                        $sql = "SELECT * FROM pais WHERE id=$aux";
                        $aux = $conex->query($sql);
                        $aux = $aux->fetch_assoc();
                        $Passnacionalidad = $aux['Nombre'];
                        ///
                        //profesion
                        $aux = $fila['profesion_Id'];
                        $sql = "SELECT * FROM profesion WHERE id=$aux";
                        $aux = $conex->query($sql);
                        $aux = $aux->fetch_assoc();
                        $Passprofesion = $aux['Nombre'];
                        //estado_c
                        $aux = $fila['estado_c'];
                        $sql = "SELECT * FROM estado_c WHERE id=$aux";
                        $aux = $conex->query($sql);
                        $aux = $aux->fetch_assoc();
                        $Passestado = $aux['Tipo'];
                        //fecha
                
                        $PassFecha = $fila['FNam'];
                        //DI
                        $PassDi = $fila['DI_Numero'];


                        echo (
                            "<tr>
                            <th scope='row'>$cant</th>
                            <td>$Passname</td>
                            <td>$Passnacionalidad</td>
                            <td>$Passestado</td>
                            <td>$Passprofesion</td>
                            <td>$PassFecha</td>
                            <td>$PassDi</td>
                        </tr>"
                        );
                        $cant++;
                    }
                    $conex->close();
                }


                ?>



            </tbody>
        </table>
    </div>

    <div class="boton boton-fin">
        <form method="GET" action="index.php">
            <input name="guardar" type="text" id="guardar" class="mostrar-codigo" placeholder="Aquí el código"
                value='<?php if ($pass == true) {
                    echo $codigo;
                } ?>' style="display: none;">
            <button type="submit" <?php if ($pass != true) {
                echo "disabled";
            } ?> id="bt-guardar"
                class="btn btn-warning btn-final-2">Guardar</button>
        </form>
    </div>
    <div style="height:100px"></div>
</body>
<script src="scanQR.js"></script>

</html>