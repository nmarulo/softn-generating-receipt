<?php
use Softn\controllers\ViewController;

$dataView = ViewController::getViewData('dataView');
?>
<div class="list-group">
<?php foreach ($dataView as $value) { ?>
    <button class="list-group-item" type="button" data-element-id="<?php echo $value['dataId']; ?>"><?php echo $value['showText']; ?></button>
<?php } ?>
</div>
