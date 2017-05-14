<?php
use Softn\controllers\ViewController;

ViewController::registerScript('jquery-3.2.1');
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Generador de facturas</title>
        <?php
        ViewController::styleView('normalize');
        ViewController::styleRouteView('app/vendor/twbs/bootstrap/dist/css/bootstrap.css');
        ViewController::styleRouteView('app/vendor/fortawesome/font-awesome/css/font-awesome.min.css');
        ViewController::styleView('style');
        ?>
        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
        <header></header>
        <hr/>
