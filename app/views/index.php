<?php
use Softn\controllers\ViewController;

ViewController::header();
?>
    <div class="container-fluid">
    <div class="row clearfix">
        <div class="col-sm-3">
            <?php ViewController::sidebar(); ?>
        </div>
        <div class="col-sm-9">
            <main>
                <?php ViewController::content(); ?>
            </main>
        </div>
    </div>
</div>
<?php ViewController::footer();
