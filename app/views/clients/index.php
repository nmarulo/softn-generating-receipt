<div>
    <h1>
        Clientes
        <a class="btn btn-success" href="#" title="Agregar">
            <span class="glyphicon glyphicon-plus"></span>
        </a>
    </h1>
</div>
<div id="content-index">
    <h3>Lista de clientes</h3>
    <ul>
        <?php foreach($viewData['clients'] as $client){ ?>
            <li><?php echo $client; ?></li>
        <?php } ?>
    </ul>
</div>
