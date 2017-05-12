<?php
use Softn\controllers\ViewController;

$clients = ViewController::getViewData('clients');
?>
<div>
    <h1>
        Clientes
        <a class="btn btn-success" href="clients.php?method=insert" title="Agregar">
            <span class="glyphicon glyphicon-plus"></span>
        </a>
    </h1>
</div>
<div id="content-index">
    <form class="form-inline" method="get">
        <div class="form-group">
            <label id="search-data" class="control-label">Buscar</label>
            <input id="search-data" class="form-control" type="text" name="search" placeholder="Buscar...">
        </div>
        <input type="hidden" name="method" value="index">
        <button class="btn btn-primary" type="submit"><span class="glyphicon glyphicon-search"></span></button>
        <a class="btn btn-danger" href="clients.php"><span class="glyphicon glyphicon-remove"></span></a>
    </form>
    <h3>Lista de clientes</h3>
    <ul>
        <?php foreach ($clients as $client) { ?>
            <li>
                <?php echo $client->getClientName(); ?>
                <a href="clients.php?method=update&update=<?php echo $client->getId(); ?>">
                    <span class="glyphicon glyphicon-pencil"></span>
                </a>
                <a href="clients.php?method=delete&delete=<?php echo $client->getId(); ?>">
                    <span class="glyphicon glyphicon-remove"></span>
                </a>
            </li>
        <?php } ?>
    </ul>
</div>
