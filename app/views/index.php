<?php
use Softn\controllers\ViewController;

ViewController::header();
?>
    <div class="container-fluid">
    <div class="row clearfix">
        <div class="col-sm-2">
            <?php ViewController::sidebar(); ?>
        </div>
        <div class="col-sm-10">
            <main>
                <?php ViewController::content(); ?>
            </main>
        </div>
    </div>
</div>
<?php ViewController::footer();
