<?php require VIEWS . 'header.php'; ?>
<div class="container-fluid">
    <div class="row clearfix">
        <div class="col-sm-3">
            <?php require VIEWS . 'sidebar.php'; ?>
        </div>
        <div class="col-sm-9">
            <main>
                <?php require $contentView; ?>
            </main>
        </div>
    </div>
</div>
<?php require VIEWS . 'footer.php';
