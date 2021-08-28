<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
img {
    width: 200px;
    height: 200px;
    align: center;
}


/* Create four equal columns that floats next to each other */
.column {
    display: inline-block;
    padding: 10px 10px;
    border: 4px dotted BLACK;
    background-color: green; 
    float: left;
    width: 25%;
    padding: 20px;   
}

/* Clear floats after the columns */
.row:after {
    content: "";
    display: table;
    clear: both;
    padding: 10px 10px;
}

/* On screens that are 992px wide or less, go from four columns to two columns */
@media screen and (max-width: 992px) {
    .column {
        width: 50%;
    }
}

/* On screens that are 600px wide or less, make the columns stack on top of each other instead of next to each other */
@media screen and (max-width: 600px) {
    .column {
        width: 100%;
    }
}
</style>

<body>

<?php  

?>
 
<form method="GET" action="" onSubmit="return validarForm(this)">
 
    <input type="text" placeholder="Buscar usuario" name="palabra">

    <input type="submit" value="Buscar" name="buscar" id="buscar">

</form>
    <?php
        $message="";
        $class="";
        $serverName = "DESKTOP-UMFMI9C"; //serverName\instanceName

        // Puesto que no se han especificado UID ni PWD en el array  $connectionInfo,
        // La conexión se intentará utilizando la autenticación Windows.
        $connectionInfo = array( "Database"=>"proyectoBD", "UID"=>"sa", "PWD"=>"andre123");
        $conn = sqlsrv_connect( $serverName, $connectionInfo);
        
        if( !$conn ) {
            echo "Conexión no se pudo establecer.<br />";
            die( print_r( sqlsrv_errors(), true));
        }
    ?>
    <h1>Listado de Productos</h1>
    <form action="" method="post">

        <div class="row">


            <?php 
                $buscar="";
                if(isset($_GET["submit"]) && !empty($_GET["submit"])){
                    $buscar=$_GET['buscar'];
                }
                $consulta="select *from producto where nombre like '$buscar%' or nombre like '%$buscar' or cod_producto like '$buscar%'";
                $r= sqlsrv_query($conn,$consulta) or die("error");
                     while($row=sqlsrv_fetch_array($r))
                     {
                        $cod_producto=$row['cod_producto'];

                        if($row['foto']!='images.jpg'){
                            $foto='../administrador/img/uploader/'.$row['foto'];
                        }
                        else{
                            $foto='../administrador/img/'.$row['foto'];
                        }
                ?>
            <div class="column" align="center">
                <a href="./infoproducto.php?cod_producto=<?php echo $cod_producto;?>"">
                    <img class="imgcard" src="<?php echo $foto;?>" alt="<?php echo $foto;?>">
                </a>
                <div>
                    <input type="submit" value="Comprar">
                </div>
            </div>

            <?php } ?>

        </div>
    </form>
</body>

     
<script type="text/javascript">
    function validarForm(formulario) 
    {
        if(formulario.palabra.value.length==0) 
        { //¿Tiene 0 caracteres?
            formulario.palabra.focus();  // Damos el foco al control
            alert('Debes rellenar este campo'); //Mostramos el mensaje
            return false; 
         } //devolvemos el foco  
         return true; //Si ha llegado hasta aquí, es que todo es correcto 
     }   
</script>
</html>