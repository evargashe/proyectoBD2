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
		header("location: ./adminindex.php");
	}

	if(!empty($_POST))
	{
            $cod_producto= $_POST['codigo_producto'];
            $nombre= $_POST['nombre'];
            $precio= $_POST['precio'];
            $stock= $_POST['stock'];
            $dni_empleado_administrador= $_POST['dni_empleado_administrador'];
            $num_factura= $_POST['num_factura'];

            echo $num_factura;

			$foto= $_FILES['foto'];
			$nombre_foto= $foto['name'];
			$type= $foto['type'];
			$url_temp= $foto['tmp_name'];

			$upd= '';
            $imgProducto='';
			if($nombre_foto != '')
			{
				$destino= '../img/uploader/';
				$img_nombre= 'img_'.md5(date('d-m-Y H:m:s'));
				$imgProducto= $img_nombre.'.jpg';
				$src= $destino.$imgProducto;
			}else{
				if($_POST['foto_actual'] != $_POST['foto_remove '])
				{
					$imgProducto= '../img/images.jpg';
				}
			}

			$query="update producto set cod_producto='$cod_producto',nombre='$nombre',precio='$precio',
            stock='$stock', dni_empleado_administrador='$dni_empleado_administrador',num_factura='$num_factura',
            foto='$imgProducto' where cod_producto='$id_producto'";
			$query_update= sqlsrv_query($conn,$query) or die ("error");
			if($query_update){

				if($nombre_foto != '' && ($_POST['foto_actual']!='images.jpg') || ($_POST['foto_actual'] != $_POST['foto_remove']))
				{
					unlink("../img/uploader/".$_POST['foto_actual']);
				}
				if($nombre_foto != '')
				{
					move_uploaded_file($url_temp,$src);
				}
				$message="Producto actualizado";
				$class="alert alert-success";
				echo "<meta http-equiv='refresh' content='4;url=./adminindex.php'/>";
			
			}
			else{
				$message="Error al actualizar producto";
				$class="alert alert-danger";
				echo "<meta http-equiv='refresh' content='4;url=./editar.php'/>";

			}
		
	}


	//
	if(empty($_REQUEST['cod_producto']))
	{
		header("location: ./adminindex.php");
	} 
    
	else{
		$id_producto=  $_REQUEST['cod_producto'];
		if(!is_numeric($id_producto))
		{
			header("location: ./adminindex.php");
		}
		echo $id_producto;
		$query=sqlsrv_query($conn,"select *from producto where cod_producto='$id_producto'") or die(" no se ejecuto la consulta");
		$result_producto=sqlsrv_num_rows($query);

		$foto='';
		$classRemove='notBlock';

		/* if($result_producto>0)
		{ */
			$data_producto=sqlsrv_fetch_array($query);
			if($data_producto['foto']!='images.jpg')
			{
				$classRemove='';
				$foto= '<img id="img" src="../img/uploader/'.$data_producto['foto'].'" alt="Producto">';
			}
		/* } */
		/* else{
			header("location: ./adminindex.php");
		} */
		
		
	}
	
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
    <title>Editar Producto</title>
</head>
<style>
.prevPhoto {
    display: flex;
    justify-content: space-between;
    width: 160px;
    height: 150px;
    border: 1px solid #CCC;
    position: relative;
    cursor: pointer;
    background-repeat: no-repeat;
    background-size: cover;
    background-position: center center;
    margin: auto;
}

.prevPhoto label {
    cursor: pointer;
    width: 100%;
    height: 100%;
    position: absolute;
    top: 0;
    left: 0;
    z-index: 2;
}

.prevPhoto img {
    width: 100%;
    height: 100%;
}

.upimg,
.notBlock {
    display: none !important;
}

.errorArchivo {
    font-size: 16px;
    font-family: arial;
    color: #cc0000;
    text-align: center;
    font-weight: bold;
    margin-top: 10px;
}

.delPhoto {
    color: #FFF;
    display: -webkit-flex;
    display: -moz-flex;
    display: -ms-flex;
    display: -o-flex;
    display: flex;
    justify-content: center;
    align-items: center;
    border-radius: 50%;
    width: 25px;
    height: 25px;
    background: red;
    position: absolute;
    right: -10px;
    top: -10px;
    z-index: 10;
}

#tbl_list_productos img {
    width: 50px;
}

.imgProductoDelete {
    width: 175px;
}
</style>

<body>
    <div class="<?php echo $class?>">
        <?php echo $message;?>
    </div>
    <div class="container">
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div class="col-sm-8">
                        <h2>Editar <b>Producto</b></h2>
                    </div>
                    <!-- <div class="col-sm-4">
                        <a href="index.php" class="btn btn-info add-new"><i class="fa fa-arrow-left"></i> Regresar</a>
                    </div> -->
                </div>
            </div>

            <div class="row">
                <form action="" method="post" enctype="multipart/form-data">
                <input type="hidden" name="foto_actual" id="foto_actual" value="<?php echo $data_producto['foto'];?>">
				<input type="hidden" name="foto_remove" id="foto_remove" value="<?php echo $data_producto['foto'];?>">
                    <div>
                        <label for="">Codigo Producto</label>
                        <input type="number" name="codigo_producto" value="<?php echo $data_producto['cod_producto']?>">
                    </div>
                    <div>
                        <label for="">Nombre Producto</label>
                        <input type="text" name="nombre" value="<?php echo $data_producto['nombre']?>">
                    </div>
                    <div>
                        <label for="">Precio</label>
                        <input type="number" name="precio" value="<?php echo $data_producto['precio']?>">
                    </div>
                    <div>
                        <label for="">Stock</label>
                        <input type="number" name="stock" value="<?php echo $data_producto['stock']?>">
                    </div>
                    <div class="col-md-12 pull-right">
                        <div class="photo">
                            <label for="foto">Foto</label>
                            <div class="prevPhoto">
                                <span class="delPhoto notBlock">X</span>
                                <label for="foto"></label>
                                <?php echo $foto?>
                            </div>
                            <div class="upimg">
                                <input type="file" name="foto" id="foto" >
                            </div>
                            <div id="form_alert"></div>
                        </div>
                        <hr>

                        <div>

                            <label for="">Dni administrador</label>
                            <select name="dni_empleado_administrador" id="">
                                <option value="<?php echo $data_producto['dni_empleado_administrador'];?>"selected>
                                    <?php  echo $data_producto['dni_empleado_administrador'];?>
                                </option>
                                <?php 
				$sql="select dni_empleado_administrador from administrador";
				$query=sqlsrv_query($conn,$sql) or die(" no se ejecuto la consulta");
				while($row=sqlsrv_fetch_array($query))
				{
				?>

                <?php 
                if($row['dni_empleado_administrador']!=$data_producto['dni_empleado_administrador']){?>
                                <option value="<?php echo $row['dni_empleado_administrador'];?>"> 
                                    <?php  echo $row['dni_empleado_administrador'];?>
                                </option>
                                <?php 
                }
				}
				?>
                            </select>
                        </div>
                        <div>

                            <label for="">Numero Factura</label>
                            <select name="num_factura" id="">
                                <option value="<?php echo $data_producto['num_factura'];?>"selected>
                                    <?php  echo $data_producto['num_factura'];?>
                                </option>
                                <?php 
				$sql="select num_factura from  factura";
				$query=sqlsrv_query($conn,$sql) or die(" no se ejecuto la consulta");
				while($row=sqlsrv_fetch_array($query))
				{
				?>

                <?php 
                if($row['num_factura']!=$data_producto['num_factura']){?>
                                <option value="<?php echo $row['num_factura'];?>"> 
                                    <?php  echo $row['num_factura'];?>
                                </option>
                                <?php 
                }
				}
				?>
                            </select>
                        </div>

                        <div>
                            <input type="submit" value="Actualizar Producto">
                        </div>
                </form>
                <div>
                            <a href="./adminindex.php">Cancelar</a>
                        </div>
            </div>
        </div>
    </div>
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
        } else {
            alert("No selecciono foto");
            $("#img").remove();
        }
    });

    $('.delPhoto').click(function() {
        $('#foto').val('');
        $(".delPhoto").addClass('notBlock');
        $("#img").remove();

    });

});
</script>

</html>