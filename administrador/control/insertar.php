<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
.prevPhoto label{
	cursor: pointer;
	width: 100%;
	height: 100%;
	position: absolute;
	top: 0;
	left: 0;
	z-index: 2;
}
.prevPhoto img{
	width: 100%;
	height: 100%;
}
.upimg, .notBlock{
	display: none !important;
}
.errorArchivo{
	font-size: 16px;
	font-family: arial;
	color: #cc0000;
	text-align: center;
	font-weight: bold; 
	margin-top: 10px;
}
.delPhoto{
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
#tbl_list_productos img{
	width: 50px;
}
.imgProductoDelete{
	width: 175px;
}

h1{
	text-align: center;
}


</style>
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

	if(!empty($_POST)){


		if(empty($_POST['codigo_producto']) || empty($_POST['nombre']) || empty($_POST['precio']) || empty($_POST['stock']) ||
		empty($_POST['dni_empleado_administrador']) || empty($_POST['num_factura']))
		{
			$message="todos los campos son obligatorios";
			$class="alert alert-danger";
			echo "<meta http-equiv='refresh' content='2;url=./adminindex.php'/>";
		}
		else{
			
				$codigo_producto= $_POST['codigo_producto'];
				$nombre= $_POST['nombre'];
				$precio= $_POST['precio'];
				$stock= $_POST['stock'];
				$dni_empleado_administrador= $_POST['dni_empleado_administrador'];
				$num_factura= $_POST['num_factura'];
				$numsucursal=$_REQUEST['sucursal'];


				$foto= $_FILES['foto'];
				$nombre_foto=$foto['name'];
				$type=$foto['type'];
				$url_temp=$foto['tmp_name'];

				$imgProducto='images.jpg';
				if($nombre_foto != '')
				{
					$destino='../img/uploader/';
					$img_nombre='img_'.md5(date('d-m-Y H:m:s'));
					$imgProducto=$img_nombre.'.jpg';
					$src=$destino.$imgProducto;
				}

				//// insertar 
				if($numsucursal=='100'){

					$serverName = "DESKTOP-UMFMI9C"; //serverName\instanceName

					// Puesto que no se han especificado UID ni PWD en el array  $connectionInfo,
					// La conexión se intentará utilizando la autenticación Windows.
					$connectionInfo = array( "Database"=>"proyectoBD", "UID"=>"sa", "PWD"=>"andre123");
					$conn1 = sqlsrv_connect( $serverName, $connectionInfo);
					
					if( !$conn1 ) {
						echo "Conexión no se pudo establecer.<br />";
						die( print_r( sqlsrv_errors(), true));
					}


					$cons = "insert into producto values('".$codigo_producto."','".$nombre."','".$precio."',
					'".$stock."','".$imgProducto."','".$dni_empleado_administrador."',
					'".$num_factura."')";
					
					$r=sqlsrv_query($conn1,$cons) or die("no se ejecuto la consulta");
					if($r){
						if($nombre_foto != '')
						{
							move_uploaded_file($url_temp,$src);
						}
						$message= "Datos insertados con éxito";
						$class="alert alert-success";
						echo "<meta http-equiv='refresh' content='2;url=./adminindex.php'/>";
					}else{
						$message="No se pudieron insertar los datos";
						$class="alert alert-danger";
						echo "<meta http-equiv='refresh' content='2;url=./adminindex.php'/>";
					} 
				}
				else if($numsucursal=='101')
				{
					$serverName = "DESKTOP-UMFMI9C\MSSQLSERVER01"; //serverName\instanceName

					// Puesto que no se han especificado UID ni PWD en el array  $connectionInfo,
					// La conexión se intentará utilizando la autenticación Windows.
					$connectionInfo = array( "Database"=>"proyectoBD", "UID"=>"", "PWD"=>"");
					$conn2 = sqlsrv_connect( $serverName, $connectionInfo);
					
					if( !$conn2 ) {
						echo "Conexión no se pudo establecer.<br />";
						die( print_r( sqlsrv_errors(), true));
					}


					$cons = "insert into producto values('".$codigo_producto."','".$nombre."','".$precio."',
					'".$stock."','".$imgProducto."','".$dni_empleado_administrador."',
					'".$num_factura."')";
					
					$r=sqlsrv_query($conn2,$cons) or die("no se ejecuto la consulta");
					if($r){
						if($nombre_foto != '')
						{
							move_uploaded_file($url_temp,$src);
						}
						$message= "Datos insertados con éxito";
						$class="alert alert-success";
						echo "<meta http-equiv='refresh' content='2;url=./adminindex.php'/>";
					}else{
						$message="No se pudieron insertar los datos";
						$class="alert alert-danger";
						echo "<meta http-equiv='refresh' content='2;url=./adminindex.php'/>";
					} 
				}
				else{
					$serverName = "DESKTOP-UMFMI9C\MSSQLSERVER03"; //serverName\instanceName

					// Puesto que no se han especificado UID ni PWD en el array  $connectionInfo,
					// La conexión se intentará utilizando la autenticación Windows.
					$connectionInfo = array( "Database"=>"proyectoBD", "UID"=>"", "PWD"=>"");
					$conn2 = sqlsrv_connect( $serverName, $connectionInfo);
					
					if( !$conn2 ) {
						echo "Conexión no se pudo establecer.<br />";
						die( print_r( sqlsrv_errors(), true));
					}


					$cons = "insert into producto values('".$codigo_producto."','".$nombre."','".$precio."',
					'".$stock."','".$imgProducto."','".$dni_empleado_administrador."',
					'".$num_factura."')";
					
					$r=sqlsrv_query($conn2,$cons) or die("no se ejecuto la consulta");
					if($r){
						if($nombre_foto != '')
						{
							move_uploaded_file($url_temp,$src);
						}
						$message= "Datos insertados con éxito";
						$class="alert alert-success";
						echo "<meta http-equiv='refresh' content='2;url=./adminindex.php'/>";
					}else{
						$message="No se pudieron insertar los datos";
						$class="alert alert-danger";
						echo "<meta http-equiv='refresh' content='2;url=./adminindex.php'/>";
					} 
				}
			
		}
		?>
		<div class="<?php echo $class?>">
		<?php echo $message;?>
		</div>	
			<?php
	}
    
?>
<style>
form div.container{
	border: solid 2px;
	border-radius: 10px 10px 10px 10px;
  
}
</style>
<body>
    <h1>Insertar Productos</h1>
    <form action="" method="post" enctype="multipart/form-data" class="insert">
		<div class="container">
			<div>
				<label for="">Codigo Producto</label>
				<input type="number" name="codigo_producto">
			</div>
			<div>
				<label for="">Nombre Producto</label>
				<input type="text" name="nombre">
			</div>
			<div>
				<label for="">Precio</label>
				<input type="number" name="precio">
			</div>
			<div>
				<label for="">Stock</label>
				<input type="number" name="stock">
			</div>
			<div class="col-md-12 pull-right">
					<div class="photo">
						<label for="foto">Foto</label>
							<div class="prevPhoto">
								<span class="delPhoto notBlock">X</span>
								<label for="foto"></label>
							</div>
							<div class="upimg">
								<input type="file" name="foto" id="foto">
							</div>
					<div id="form_alert"></div>
			</div>
					<hr>
			
			<div>
				
				<label for="">Dni administrador</label>
				<select name="dni_empleado_administrador" id="">
					<?php 
					$sql="select dni_empleado_administrador from administrador";
					$query=sqlsrv_query($conn,$sql) or die(" no se ejecuto la consulta");
					while($row=sqlsrv_fetch_array($query))
					{
					?>
					<option value="<?php  echo $row['dni_empleado_administrador'];?>"> <?php  echo $row['dni_empleado_administrador'];?></option>
					<?php 
					}
					?>
				</select>
			</div>
			<div>
				
				<label for="">Numero Factura</label>
				<select name="num_factura" id="">
					<?php 
					$sql="select num_factura from  factura";
					$query=sqlsrv_query($conn,$sql) or die(" no se ejecuto la consulta");
					while($row=sqlsrv_fetch_array($query))
					{
					?>
					<option value="<?php  echo $row['num_factura'];?>"> <?php  echo $row['num_factura'];?></option>
					<?php 
					}
					?>
				</select>
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
			<div>
				<input type="submit" value="Insertar">
			</div>
			
		</div>
    </form>

</body>
<script>
$(document).ready(function(){

//--------------------- SELECCIONAR FOTO PRODUCTO ---------------------
$("#foto").on("change",function(){
	var uploadFoto = document.getElementById("foto").value;
	var foto       = document.getElementById("foto").files;
	var nav = window.URL || window.webkitURL;
	var contactAlert = document.getElementById('form_alert');
	
		if(uploadFoto !='')
		{
			var type = foto[0].type;
			var name = foto[0].name;
			if(type != 'image/jpeg' && type != 'image/jpg' && type != 'image/png')
			{
				contactAlert.innerHTML = '<p class="errorArchivo">El archivo no es válido.</p>';                        
				$("#img").remove();
				$(".delPhoto").addClass('notBlock');
				$('#foto').val('');
				return false;
			}else{  
					contactAlert.innerHTML='';
					$("#img").remove();
					$(".delPhoto").removeClass('notBlock');
					var objeto_url = nav.createObjectURL(this.files[0]);
					$(".prevPhoto").append("<img id='img' src="+objeto_url+">");
					$(".upimg label").remove();
					
				}
		  }else{
			  alert("No selecciono foto");
			$("#img").remove();
		  }              
});

$('.delPhoto').click(function(){
	$('#foto').val('');
	$(".delPhoto").addClass('notBlock');
	$("#img").remove();

});

});

</script>
</html>