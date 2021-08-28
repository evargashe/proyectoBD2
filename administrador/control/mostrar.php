<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
    img{
        height: 200px;
        width: 200px
    }
</style>
<body>
    <?php  require("./insertar.php");?>
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

        <?php 
        $busqueda=$_GET['busqueda'];
        ?>


    <h1>Listado de Productos</h1>

    <form method="get">
                <input type="text" name="busqueda" id="busqueda" placeholder="busque su producto por nombre" value="<?php echo $busqueda;?>">
                <input type="submit" value="Buscar" class="btn btn-search">
            </form>


    <form action="" method="post">
    <?php
            $consulta="SELECT *FROM [DESKTOP-UMFMI9C\MSSQLSERVER01].proyectoBD.dbo.producto
            union select *from [DESKTOP-UMFMI9C].proyectoBD.dbo.producto
            union SELECT *FROM [DESKTOP-UMFMI9C\MSSQLSERVER03].proyectoBD.dbo.producto";
            $r= sqlsrv_query($conn,$consulta) or die("error");

            ?>
            <table class="table table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th>Codigo Producto</th>
                        <th>Nombre</th>
                        <th>Precio</th>
                        <th>Stock</th>
                        <th>Foto</th>
                        <th>Dni empleado administrador</th>
                        <th>Numero factura</th>
                        <th>Acciones</th>
                    </tr>                        
                    <?php
                        while($row=sqlsrv_fetch_array($r))
                        {
                            $cod_producto=$row['cod_producto'];
                            $nombre=$row['nombre'];
                            $precio=$row['precio'];
                            $stock=$row['stock'];
                            $dni_empleado_administrador=$row['dni_empleado_administrador'];
                            $num_factura=$row['num_factura'];
                            if($row['foto']!='images.jpg'){
                                $foto='../img/uploader/'.$row['foto'];
                            }
                            else{
                                $foto='img/'.$row['foto'];
                            }
                        ?>
                    <tr class="table-success">
                        <td> <?php echo $cod_producto; ?></td>
                        <td> <?php echo $nombre; ?></td>
                        <td> <?php echo $precio; ?></td>
                        <td> <?php echo $stock; ?></td>
                        <td><img src="<?php echo $foto;?>" alt="<?php echo $foto;?>"></td>
                        <td> <?php echo $dni_empleado_administrador;?></td>
                        <td> <?php echo $num_factura;?></td>
                        <td>
                        <a href="./editar.php?cod_producto=<?php echo $cod_producto;?>" class="edit" title="Editar" data-toggle="tooltip"><i class="material-icons">&#xE254;</i></a>
                        <a href="./eliminar.php?cod_producto=<?php echo $cod_producto;?>" class="delete" title="Eliminar" data-toggle="tooltip"><i class="material-icons">&#xE872;</i></a>
                        </td>
                    </tr>
                    <?php } ?>
                        
                </thead>

            </table>
    </form>
</body>
</html>