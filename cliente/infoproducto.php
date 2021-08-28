<?php
	session_start();
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

	$message="";
	$class="";
	if (isset($_GET['cod_producto'])){
		$id_producto=$_GET['cod_producto'];
	} else {
		header("location: ./indexcliente.php");
	}
    $id_producto=  $_REQUEST['cod_producto'];


    $DNI= $_SESSION['DNI'];
    echo $DNI;

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round|Open+Sans">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/custom.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <title>Informacion del Producto</title>
</head>
<style>
p {
    font: oblique bold 120% cursive;
    text-align: center;
}

.prevPhoto {
    text-align: center;
}
.button {
    text-align: center;
}
</style>

<body>
    <h1>Informacion del producto</h1>
    <?php
        $id_producto=  $_REQUEST['cod_producto'];
        if(!is_numeric($id_producto))
		{
			header("location: ./indexcliente.php");
		}
        echo $id_producto;
        $nombre="";
        $query=sqlsrv_query($conn,"select *from producto where cod_producto='$id_producto'") or die(" no se ejecuto la consulta");
        $row=sqlsrv_fetch_array($query);
        if($row['foto']!='images.jpg')
			{
				$classRemove='';
				$foto= '<img id="img" src="../administrador/img/uploader/'.$row['foto'].'" alt="Producto">';
			}
    ?>
    <p class="col-md-12 pull-right"> Nombre :
        <?php 
         echo $row['nombre'];
         ?>
    </p>
    <p class="col-md-12 pull-right"> Precio :
        <?php 
         echo $row['precio'];
         ?>
    </p>
    <p class="col-md-12 pull-right"> Stock :
        <?php 
         echo $row['stock'];
         ?>
    </p>
    <p class="col-md-12 pull-right"> Numero Factura :
        <?php 
         echo $row['num_factura'];
         ?>
    </p>
    <div class="col-md-12 pull-right">
        <div class="photo">
            <p> Foto</p>
            <div class="prevPhoto">
                <span class="delPhoto notBlock"></span>
                <label for="foto"></label>
                <?php echo $foto?>
            </div>
        </div>
    </div>


    <form action="" method="post">
        <div>
            <label for="">DNI cliente</label>
            <input type="number" value="">
        </div>

        <div class="button">
        <a href="./comprar.php?cod_producto=<?php echo $row['cod_producto'];?>">
            <input type="submit" value="comprar">
            </a> 
        </div>
    </form>
    

</body>
<script>
$(document).ready(function() {

            //--------------------- SELECCIONAR FOTO PRODUCTO ---------------------
            $("#foto").on("change", function() {
                    var uploadFoto = document.getElementById("foto").value;
                    var foto = document.getElementById("foto").files;
                    var nav = window.URL || window.webkitURL;
                    var contactAlert = document.getElementById('form_alert');

                    if (uploadFoto != '') {
                        var type = foto[0].type;
                        var name = foto[0].name;
                        if (type != 'image/jpeg' && type != 'image/jpg' && type != 'image/png') {
                            contactAlert.innerHTML = '<p class="errorArchivo">El archivo no es válido.</p>';
                            $("#img").remove();
                            $(".delPhoto").addClass('notBlock');
                            $('#foto').val('');
                            return false;
                        } else {
                            contactAlert.innerHTML = '';
                            $("#img").remove();
                            $(".delPhoto").removeClass('notBlock');
                            var objeto_url = nav.createObjectURL(this.files[0]);
                            $(".prevPhoto").append("<img id='img' src=" + objeto_url + ">");
                            $(".upimg label").remove();

                        }
                        /* } else {
                            alert("No selecciono foto");
                            $("#img").remove();
                        } */
                    });

                /* $('.delPhoto').click(function() {
                    $('#foto').val('');
                    $(".delPhoto").addClass('notBlock');
                    $("#img").remove();

                }); */

            });
</script>

</html>