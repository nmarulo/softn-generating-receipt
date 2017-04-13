<?php require VIEWS . 'header.php'; ?>
<div class="row clearfix">
    <div class="col-sm-3">
        <?php require VIEWS . 'sidebar.php'; ?>
    </div>
    <div class="col-sm-9">
        <main>
            <div class="container-fluid">
                <?php require $contentView; ?>
            </div>
        </main>
    </div>
</div>
<?php require VIEWS . 'footer.php';
