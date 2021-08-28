<?php 
    if (isset($_GET['cod_producto'])){
        $serverName = "DESKTOP-UMFMI9C"; //serverName\instanceName

        // Puesto que no se han especificado UID ni PWD en el array  $connectionInfo,
        // La conexión se intentará utilizando la autenticación Windows.
        $connectionInfo = array( "Database"=>"proyectoBD", "UID"=>"sa", "PWD"=>"andre123");
        $conn = sqlsrv_connect( $serverName, $connectionInfo);

        if( $conn ) {
            echo "Conexión establecida.<br />";

        }else{
            echo "Conexión no se pudo establecer.<br />";
            die( print_r( sqlsrv_errors(), true));
        }


        $id=intval($_GET['cod_producto']);
        
        $consulta="delete from producto where cod_producto=$id";
        $res=sqlsrv_query($conn,$consulta);
        if($res){
            header('location: ./adminindex.php');
        }else{
            echo "Error al eliminar el registro";
        }
        /* echo "<br>";
        $con="select color, material from bicicleta where id_producto=$id";
        $r=mysqli_query($conexion,$con);
        while($row=mysqli_fetch_array($r))
        {
            echo $row['color']; echo "<br>";
            echo $row['material'];
                    
        } */
    }
?>