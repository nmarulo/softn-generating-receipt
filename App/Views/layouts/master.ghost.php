<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('css/style.css') }}" rel="stylesheet" type="text/css"/>
    <title>Generador de facturas</title>
</head>
<body>
    <header></header>
    <hr/>
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-sm-2">
            {{ include('includes.navbar') }}
            </div>
            <div class="col-sm-10">
                <main>
                #block(content)
                </main>
            </div>
        </div>
    </div>
    <footer>
        <div class="container-fluid">
            <hr/>
            <p class="pull-left">SoftN | Generador de facturas</p>
            <p class="pull-right">Versión 0.1</p>
        </div>
    </footer>
    <script src="{{ asset('js/jquery-3.2.1.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/bootstrap.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/script-common.js') }}" type="text/javascript"></script>
    #block(scripts)
</body>
</html>
