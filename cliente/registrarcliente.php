<html>

<head>
    <meta charset="UTF-8">
    <title>Registration Form</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round|Open+Sans">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<style>
    /*-----Background-----*/

body{
	 background-image:url(https://s3.envato.com/files/243754334/primag.jpg);
	 background-repeat:no-repeat;
	 background-size:cover;
	 width:100%;
	 height:100vh;
	 overflow:auto;
	 
}

/*-----for border----*/
.container{
	font-family:Roboto,sans-serif;
	  background-image:url(https://image.freepik.com/free-vector/dark-blue-blurred-background_1034-589.jpg) ;
    
     border-style: 1px solid gray;
     margin: 0 auto;
     text-align: center;
     opacity: 0.8;
     margin-top: 67px;
     max-width: 500px;
     padding-top: 10px;
     height: 363px;
     margin-top: 166px;
}
label{
    color: white;
}
	  

/*---for heading-----*/
.heading{
	 text-decoration:bold;
	 text-align : center;
	 font-size:30px;
	 color:#F96;
	 padding-top:10px;
}

     /*---------- for Input type--------*/
.col-xs-4.male{
	 color: white;
     font-size: 13px;
     margin-top: 9px;
     padding-bottom: 16px;
}
.col-xs-4.female {
     color: white;
     font-size: 13px;
     margin-top: 9px;
     padding-bottom: 16px;
	 padding-right: 95px;
}	
/*------------For submit button---------*/
.sbutton{
	 color: white;
     font-size: 20px;
     border: 1px solid white;
     background-color: #080808;
     width: 32%;
     margin-left: 41%;
     margin-top: 16px;
	 box-shadow: 0px 2px 2px 0px white;
  	   
   }
.btn.btn-warning:hover {
    box-shadow: 2px 1px 2px 3px #99ccff;
	background:#5900a6;
	color:#fff;
	transition: background-color 1.15s ease-in-out,border-color 1.15s ease-in-out,box-shadow 1.15s ease-in-out;
	
}	 
	  
</style>
<body>
<?php $message=""; $class=""; ?>
<?php 
    $serverName = "DESKTOP-UMFMI9C"; //serverName\instanceName

    // Puesto que no se han especificado UID ni PWD en el array  $connectionInfo,
    // La conexión se intentará utilizando la autenticación Windows.
    $connectionInfo = array( "Database"=>"proyectoBD", "UID"=>"sa", "PWD"=>"andre123");
    $conn = sqlsrv_connect( $serverName, $connectionInfo);
    
    if( !$conn ) {
        echo "Conexión no se pudo establecer.<br />";
        die( print_r( sqlsrv_errors(), true));
    }

    if(isset($_POST['registrar'])) { 

        if($_POST['dni'] == '' or $_POST['nombre'] == '' or $_POST['primer_apellido'] == '' or $_POST['passW']=='' or 
        $_POST['correo_electronico']=='' or$_POST['credito']=='' or$_POST['id_sucursal']=='') { 
            $message="Por favor llene todos los campos."; 
            $class="alert alert-danger";
            echo "<meta http-equiv='refresh' content='2;url=./registrarcliente.php'/>";
        }
        else{
            $dni= $_POST['dni'];
            $nombre= $_POST['nombre'];
            $primer_apellido= $_POST['primer_apellido'];
            $passW= $_POST['passW'];
            $correo_electronico= $_POST['correo_electronico'];
            $credito= $_POST['credito'];
            $id_sucursal=$_REQUEST['id_sucursal'];


            if($id_sucursal=='100'){

                $serverName = "DESKTOP-UMFMI9C"; //serverName\instanceName

                // Puesto que no se han especificado UID ni PWD en el array  $connectionInfo,
                // La conexión se intentará utilizando la autenticación Windows.
                $connectionInfo = array( "Database"=>"proyectoBD", "UID"=>"sa", "PWD"=>"andre123");
                $conn = sqlsrv_connect( $serverName, $connectionInfo);
                
                if( !$conn ) {
                    echo "Conexión no se pudo establecer.<br />";
                    die( print_r( sqlsrv_errors(), true));
                }
                $consulta= "exec Registrar_Cliente '$dni','$nombre','$primer_apellido','$passW','$correo_electronico','$credito','$id_sucursal';";
                $resultado = sqlsrv_query($conn,$consulta) or die("no se ejecuto la consulta 1");
                if($resultado)
                {
                    $message= "Datos insertados con éxito";
                    $class="alert alert-success";
                    echo "<meta http-equiv='refresh' content='2;url=./indexcliente.php'/>";
                }else{
                    $message="No se pudieron insertar los datos";
                    $class="alert alert-danger";
                    echo "<meta http-equiv='refresh' content='2;url=./registrarcliente.php'/>";
                }
            }
            else if($id_sucursal=='101')
            {
                $serverName1 = "DESKTOP-UMFMI9C\MSSQLSERVER01"; //serverName\instanceName

                // Puesto que no se han especificado UID ni PWD en el array  $connectionInfo,
                // La conexión se intentará utilizando la autenticación Windows.
                $connectionInfo1 = array( "Database"=>"proyectoBD", "UID"=>"", "PWD"=>"");
                $conn1 = sqlsrv_connect( $serverName1, $connectionInfo1);
                
                if( !$conn1 ) {
                    echo "Conexión no se pudo establecer.<br />";
                    die( print_r( sqlsrv_errors(), true));
                }
                $consulta1 = "exec Registrar_Cliente1 '$dni','$nombre','$primer_apellido','$passW','$correo_electronico','$credito','$id_sucursal';";
                $resultado = sqlsrv_query($conn1,$consulta1) or die("no se ejecuto la consulta 2");
                if($resultado)
                {
                    $message= "Datos insertados con éxito";
                    $class="alert alert-success";
                    echo "<meta http-equiv='refresh' content='2;url=./indexcliente.php'/>";
                }else{
                    $message="No se pudieron insertar los datos";
                    $class="alert alert-danger";
                    echo "<meta http-equiv='refresh' content='2;url=./registrarcliente.php'/>";
                }
            }
            else{
                $serverName2 = "DESKTOP-UMFMI9C\MSSQLSERVER03"; //serverName\instanceName

                // Puesto que no se han especificado UID ni PWD en el array  $connectionInfo,
                // La conexión se intentará utilizando la autenticación Windows.
                $connectionInfo2 = array( "Database"=>"proyectoBD", "UID"=>"", "PWD"=>"");
                $conn2 = sqlsrv_connect( $serverName2, $connectionInfo2);
                
                if( !$conn2 ) {
                    echo "Conexión no se pudo establecer.<br />";
                    die( print_r( sqlsrv_errors(), true));
                }
                $consulta2= "exec Registrar_Cliente2 '$dni','$nombre','$primer_apellido','$passW','$correo_electronico','$credito','$id_sucursal';";
                $resultado = sqlsrv_query($conn2,$consulta2) or die("no se ejecuto la consulta 3");
                if($resultado)
                {
                    $message= "Datos insertados con éxito";
                    $class="alert alert-success";
                    echo "<meta http-equiv='refresh' content='2;url=./indexcliente.php'/>";
                }else{
                    $message="No se pudieron insertar los datos";
                    $class="alert alert-danger";
                    echo "<meta http-equiv='refresh' content='2;url=./registrarcliente.php'/>";
                }
            }
        }
            
    }

?>
<div class="<?php echo $class?>">
              <?php echo $message;?>
            </div>	
<a href="./indexcliente.php" class="btn float-right login_btn">Cancelar</a>

    <div class="container">
        <header class="heading"> Registration-Form</header>
        <form method="POST">
            <div class="col-sm-12">
                <div class="row">
                    <div class="col-xs-4">
                        <label class="dni">DNI :</label>
                    </div>
                    <div class="col-xs-8">
                        <input type="number" name="dni" id="dni" placeholder="Ingrese su DNI"
                            class="form-control ">
                    </div>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="row">
                    <div class="col-xs-4">
                        <label class="nombre">Nombre :</label>
                    </div>
                    <div class="col-xs-8">
                        <input type="text" name="nombre" id="nombre" placeholder="Ingrese su nombre"
                            class="form-control ">
                    </div>
                </div>
            </div>


            <div class="col-sm-12">
                <div class="row">
                    <div class="col-xs-4">
                        <label class="papellido">Primer apellido:</label>
                    </div>
                    <div class="col-xs-8">
                        <input type="text" name="primer_apellido" id="primer_apellido" placeholder="Ingrese su primer apellido"
                            class="form-control last">
                    </div>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="row">
                    <div class="col-xs-4">
                        <label class="email">Correo Electronico :</label>
                    </div>
                    <div class="col-xs-8">
                        <input type="email" name="correo_electronico" id="correo_electronico" placeholder="Ingrese su correo electronico" class="form-control">
                    </div>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="row">
                    <div class="col-xs-4">
                        <label class="pass">Contraseña :</label>
                    </div>
                    <div class="col-xs-8">
                        <input type="password" name="passW" id="passW" placeholder="Ingrese su password"
                            class="form-control">
                    </div>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="row">
                    <div class="col-xs-4">
                        <label class="pass">Credito :</label>
                    </div>
                    <div class="col-xs-8">
                        <input type="number" name="credito" id="credito" placeholder="Ingrese su credito"
                            class="form-control">
                    </div>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="row">
                    <div class="col-xs-4">
                        <label class="pass">Seleccion el Id sucursal :</label>
                    </div>
                    <select class="col-xs-8" id="id_sucursal" name="id_sucursal">
                    <?php 
                        $serverName = "DESKTOP-UMFMI9C"; //serverName\instanceName

                        // Puesto que no se han especificado UID ni PWD en el array  $connectionInfo,
                        // La conexión se intentará utilizando la autenticación Windows.
                        $connectionInfo = array( "Database"=>"proyectoBD", "UID"=>"sa", "PWD"=>"andre123");
                        $conn = sqlsrv_connect( $serverName, $connectionInfo);
                        
                        if( !$conn ) {
                            echo "Conexión no se pudo establecer.<br />";
                            die( print_r( sqlsrv_errors(), true));
                        }
                        $sql="select id_sucursal from sucursal";
                        $query=sqlsrv_query($conn,$sql) or die(" no se ejecuto la consulta");
                        while($row=sqlsrv_fetch_array($query))
                        {
                        ?>
                        <option value="<?php  echo $row['id_sucursal'];?>"> <?php  echo $row['id_sucursal'];?></option>
                        <?php 
                        }
                        ?>
			        </select>
                </div>
            </div>

            <div class="col-sm-12">
                <div class="col-sm-12">
                    <input type="submit"class="btn btn-warning" name="registrar">Submit</input>
                </div>
            </div>
        </form>


    </div>

</body>

</html>