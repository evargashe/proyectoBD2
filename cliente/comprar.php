<?php

    if (isset($_GET['cod_producto'])){
        $id_producto=$_GET['cod_producto'];
    } else {
        header("location: ./indexcliente.php");
    }
    $id_producto=  $_REQUEST['cod_producto'];
    echo $id_producto;

?>
