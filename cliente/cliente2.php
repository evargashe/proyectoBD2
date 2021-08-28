
<?php 
session_start();
if(empty($_SESSION['active']))
{
    header('location: ./indexcliente.php');
}
require_once('../principal.php');
$DNI=$_SESSION['DNI'];
echo $DNI;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round|Open+Sans">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <title>Sucursal 3</title>
</head>
<style>
    body{
        background-color: #887221;
    }
    .nav{
        color: red;
    }
</style>
<body>
    <nav id="nav"class="navbar navbar-default" role="navigation">
        <!-- El logotipo y el icono que despliega el menú se agrupan
       para mostrarlos mejor en los dispositivos móviles -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                <span class="sr-only">Bienvenido a la sucursal 3</span>
            </button>
            <a class="navbar-brand" href="#">Bienvenido a la sucursal 3</a>
        </div>


            <ul class="nav navbar-nav navbar-left">
                <li class="nav-item">
                    <a class="nav-link" href="./salircliente.php">Salir</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <?php require ("./mostrar2.php"); 
            $DNI= $_SESSION['DNI'];
            echo $DNI;
        ?>
    </div>
    

</body>

</html>