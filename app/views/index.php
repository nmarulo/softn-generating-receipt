<?php
use Softn\controllers\ViewController;

$message = ViewController::getViewData('message');
$type    = ViewController::getViewData('type');

ViewController::header();
if ($message !== FALSE) { ?>
    <div id="messages">
        <div id="messages-content" class="modal-dialog">
            <div class="alert alert-<?php echo $type; ?> alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <?php echo $message; ?>
            </div>
            <script>
                if (timeout != undefined) {
					clearTimeout(timeout);
				}
				var timeout = setTimeout(function () {
					$("#messages").remove();
				}, 5000);
            </script>
        </div>
    </div>
<?php } ?>
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
