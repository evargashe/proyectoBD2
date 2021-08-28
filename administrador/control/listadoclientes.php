<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de clientes</title>
    <script src="https://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round|Open+Sans">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/custom.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<style>
    .th,.td{
        font-size: 10px;
    }
    img{
        height: 200px;
        width: 200px
    }
    h1{
        text-align:center;
        font-size: 50px;
    }
    .container{
	border: solid 2px;
	border-radius: 10px 10px 10px 10px;
  
    }
</style>
<body>
    <?php
        $message="";
        $class="";
        $serverName = "DESKTOP-UMFMI9C\MSSQLSERVER01"; //serverName\instanceName
    
        // Puesto que no se han especificado UID ni PWD en el array  $connectionInfo,
        // La conexión se intentará utilizando la autenticación Windows.
        $connectionInfo = array( "Database"=>"proyectoBD", "UID"=>"", "PWD"=>"andre123");
        $conn = sqlsrv_connect( $serverName, $connectionInfo);
        
        if( !$conn ) {
            echo "Conexión no se pudo establecer.<br />";
            die( print_r( sqlsrv_errors(), true));
        }
    ?>
        <div>
            <a href="./adminindex.php"><button class="btn btn-primary">Regresar</button></a>
        </div>
    <h1>Listado de Clientes</h1>

    <?php
            $consulta="select *
            from [DESKTOP-UMFMI9C].proyectoBD.dbo.persona p
            inner join [DESKTOP-UMFMI9C].proyectoBD.dbo.cliente c
            on p.dni=c.dni_cliente
            inner join [DESKTOP-UMFMI9C].proyectoBD.dbo.correo_electronico correo
            on p.dni=correo.dni
            union 
            select *
            from [DESKTOP-UMFMI9C\MSSQLSERVER01].proyectoBD.dbo.persona p
            inner join [DESKTOP-UMFMI9C\MSSQLSERVER01].proyectoBD.dbo.cliente c
            on p.dni=c.dni_cliente
            inner join [DESKTOP-UMFMI9C\MSSQLSERVER01].proyectoBD.dbo.correo_electronico correo
            on p.dni=correo.dni
            union
            select *
            from [DESKTOP-UMFMI9C\MSSQLSERVER03].proyectoBD.dbo.persona p
            inner join [DESKTOP-UMFMI9C\MSSQLSERVER03].proyectoBD.dbo.cliente c
            on p.dni=c.dni_cliente
            inner join [DESKTOP-UMFMI9C\MSSQLSERVER03].proyectoBD.dbo.correo_electronico correo
            on p.dni=correo.dni
            
            ";
            $r= sqlsrv_query($conn,$consulta) or die("error");

            ?>
            <div class="container">
            <table class="table table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th>DNI</th>
                        <th>Nombre</th>
                        <th>Primer Apellido</th>
                        <th>Contraseña</th>
                        <th>Credito</th>
                        <th>id Sucursal</th>
                        <th>Correo Electronico</th>
                    </tr>                        
                    <?php

                        while($row=sqlsrv_fetch_array($r))
                        {
                            $dni=$row['dni'];
                            $nombre=$row['nombre'];
                            $primer_apellido=$row['primer_apellido'];
                            $passW=$row['passW'];
                            $credito=$row['credito'];
                            $id_sucursal=$row['id_sucursal'];
                            $corre_electronico=$row['correo_electronico'];

                        ?>
                    <tr class="table-success">
                        <td> <?php echo $dni; ?></td>
                        <td> <?php echo $nombre; ?></td>
                        <td> <?php echo $primer_apellido; ?></td>
                        <td> <?php echo $passW; ?></td>
                        <td><?php echo $credito;?></td>
                        <td> <?php echo $id_sucursal;?></td>
                        <td> <?php echo $corre_electronico;;?></td>

                    </tr>
                    <?php } ?>
                        
                </thead>

            </table>
            </div>
    </form>
</body>
</html>