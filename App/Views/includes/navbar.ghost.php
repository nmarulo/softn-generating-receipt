<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#menu-navbar-collapse" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">SoftN GI</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="menu-navbar-collapse">
            <ul class="nav navbar-nav side-nav">
                <li>
                    <a href="{{ url('/') }}">
                        <i class="fa fa-home" aria-hidden="true"></i> Inicio
                    </a>
                </li>
                <li><a href="{{ url('/generating') }}">Generar</a></li>
                <li><a href="{{ url('/clients') }}">Clientes</a></li>
                <li><a href="{{ url('/products') }}">Productos / Servicios</a></li>
                <li><a href="{{ url('/receipts') }}">Facturas</a></li>
                <li><a href="{{ url('/settings') }}">Opciones</a></li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>

