<div>
    <h1>
        Clientes
        <a class="btn btn-success" href="clients.php?method=insert" title="Agregar">
            <span class="glyphicon glyphicon-plus"></span>
        </a>
    </h1>
</div>
<div id="content-index">
    <h3>Lista de clientes</h3>
    <ul>
        <?php foreach($viewData['clients'] as $client){ ?>
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
