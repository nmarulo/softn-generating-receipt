<aside>
    <nav class="navbar navbar-custom">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#menu-sidebar-collapse" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">SoftN</a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="menu-sidebar-collapse">
            <div class="list-group">
                <a class="list-group-item" href="{{ url('/') }}">
                    <i class="fa fa-home" aria-hidden="true"></i> Inicio</a>
                <a class="list-group-item" href="{{ url('/generating') }}">Generar</a>
                <a class="list-group-item" href="{{ url('/clients') }}">Clientes</a>
                <a class="list-group-item" href="{{ url('/products') }}">Productos / Servicios</a>
                <a class="list-group-item" href="{{ url('/receipts') }}">Facturas</a>
                <a class="list-group-item" href="{{ url('/settings') }}">Opciones</a>
            </div>
        </div><!-- /.navbar-collapse -->
    </nav>
</aside>
