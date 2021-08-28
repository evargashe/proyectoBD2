

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round|Open+Sans">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <title>Login Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css">

</head>
<style>
    .login-dark {
        height: 760px;
        background: #475d62 url(../../assets/img/star-sky.jpg);
        background-size: cover;
        position: center;
    }
    
    .login-dark form {
        max-width: 320px;
        width: 90%;
        background-color: #1e2833;
        padding: 40px;
        border-radius: 4px;
        transform: translate(-50%, -50%);
        position: absolute;
        top: 50%;
        left: 50%;
        color: #fff;
        box-shadow: 3px 3px 4px rgba(0, 0, 0, 0.2);
    }
    
    .login-dark .illustration {
        text-align: center;
        padding: 15px 0 20px;
        font-size: 100px;
        color: #2980ef;
    }
    
    .login-dark form .form-control {
        background: none;
        border: none;
        border-bottom: 1px solid #434a52;
        border-radius: 0;
        box-shadow: none;
        outline: none;
        color: inherit;
    }
    
    .login-dark form .btn-primary {
        background: #214a80;
        border: none;
        border-radius: 4px;
        padding: 11px;
        box-shadow: none;
        margin-top: 26px;
        text-shadow: none;
        outline: none;
    }
    
    .login-dark form .btn-primary:hover,
    .login-dark form .btn-primary:active {
        background: #214a80;
        outline: none;
    }
    
    .login-dark form .forgot {
        display: block;
        text-align: center;
        font-size: 12px;
        color: #6f7a85;
        opacity: 0.9;
        text-decoration: none;
    }
    
    .login-dark form .forgot:hover,
    .login-dark form .forgot:active {
        opacity: 1;
        text-decoration: none;
    }
    
    .login-dark form .btn-primary:active {
        transform: translateY(1px);
    }
</style>
<?php
    include("../principal.php");
    $message="";
    $class="";
    session_start();

    if(!empty($_SESSION['active']))
    {
        header('location: ./indexadministrador.php');
    }else{
        if(!empty($_POST)){
            if(empty($_POST['correo_electronico']) || empty($_POST['contraseña']))
            {
                $message='ingrese su usuario y su clave';
                $class="alert alert-danger";
                echo "<meta http-equiv='refresh' content='2;url=./indexadministrador.php'/>";

            }
            else{
                $correo_electronico="";
                $contraseña="";
                    $contraseña= $_POST['contraseña'];
                    $correo_electronico= $_POST['correo_electronico'];
                    $consulta= "select p.dni,ce.correo_electronico,p.passW 
                    from persona p
                    inner join correo_electronico ce
                    on p.dni=ce.dni
                    inner join empleado e
                    on e.dni_empleado=p.dni
                    inner join administrador a
                    on a.dni_empleado_administrador=e.dni_empleado
                    where ce.correo_electronico='$correo_electronico' and p.passW='$contraseña';";
                    $resultado = sqlsrv_query($conn,$consulta) or die("no se ejecuto la consulta");
                    //$result= sqlsrv_num_rows($resultado);
                    $es=True;
                    $row=sqlsrv_fetch_array($resultado);
                    if($correo_electronico==$row['correo_electronico'] && $contraseña==$row['passW'])
                    {
                        $row = sqlsrv_fetch_array($resultado);
                        $_SESSION['active']=True;
                        $_SESSION['DNI']=$row['DNI'];
                        $_SESSION['correo_electronico']=$row['correo_electronico'];
                        $_SESSION['contraseña']=$row['contraseña'];
                        header('location: ./control/adminindex.php');
                    }
                    else{
                        $message='Usuario y clase incorrectos';
                        $class="alert alert-danger";
                        echo "<meta http-equiv='refresh' content='2;url=./indexadministrador.php'/>";
                        session_destroy();
                    }

                    /* if($es===True)
                    {
                        $row = sqlsrv_fetch_array($resultado);
                        $_SESSION['active']=True;
                        $_SESSION['DNI']=$row['DNI'];
                        $_SESSION['correo_electronico']=$row['correo_electronico'];
                        $_SESSION['contraseña']=$row['contraseña'];
                        header('location: ./control/adminindex.php');

                    }
                    else{
                        $message='Usuario y clase incorrectos';
                        $class="alert alert-danger";
                        echo "<meta http-equiv='refresh' content='2;url=./indexadministrador.php'/>";
                        session_destroy();
                        
                    }  */ 
            }
        }
    }
    
?>
<body>
            <div class="<?php echo $class?>">
              <?php echo $message;?>
            </div>


    <div class="login-dark">
        
        <a class="button" href="../indexpag.html">Cancelar</a>
        <form method="post">
            <h2 class="sr-only">Login Form</h2>
            <div class="illustration"><i class="icon ion-ios-locked-outline"></i></div>
            <div class="form-group">
                <input class="form-control" type="email" name="correo_electronico" id="correo_electronico"placeholder="correo_electronico">
            </div>
            <div class="form-group">
                <input class="form-control" type="password" name="contraseña" id="contraseña" placeholder="contraseña">
            </div>
            <div class="form-group">
                <button class="btn btn-primary btn-block" type="submit" onclick="location.href='adminindex.php'">Log In</button>
            </div>

            <a href="#" class="forgot">Forgot your email or password?</a></form>

    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/js/bootstrap.bundle.min.js"></script>
</body>

</html>