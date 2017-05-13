<?php
use Softn\controllers\ViewController;

$dataList = ViewController::getViewData('dataList');
?>
<div class="list-group">
<?php foreach ($dataList as $value) { ?>
    <button class="list-group-item" type="button" data-element-id="<?php echo $value['dataId']; ?>"><?php echo $value['showText']; ?></button>
<?php } ?>
</div>
