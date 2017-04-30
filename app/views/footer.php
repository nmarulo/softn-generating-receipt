<?php use Softn\controllers\ViewController; ?>
        <footer>
            <div class="container-fluid">
                <hr/>
                <p class="pull-left">SoftN | Generador de facturas</p>
                <p class="pull-right">Versión <?php echo VERSION; ?></p>
            </div>
        </footer>
        <?php ViewController::scriptView('jquery-3.2.1') ?>
        <?php ViewController::scriptView('jspdf.min') ?>
        <?php ViewController::scriptView('script-generate-pdf') ?>
        <?php ViewController::scriptView('script') ?>
    </body>
</html>
