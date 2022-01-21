<!doctype html>
<html lang="en">
    <head>
    <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- <link href="<?= getRelativePath('alertify.css') ?>" rel="stylesheet">
        <link href="<?= getRelativePath('Fomantic-UI/dist/semantic.min.css') ?>" rel="stylesheet">
        <link href="<?= $page_stylesheet ?>" rel="stylesheet"> -->

        <link href="<?= getRelativePath('alertify.min.css') ?>" rel="stylesheet">
        <link href="<?= getRelativePath('Fomantic-UI/semantic.min.css') ?>" rel="stylesheet">
        <link href="<?= $page_stylesheet ?>" rel="stylesheet">

        <!-- <script type="text/javascript" src="<?= getRelativePath('jquery-3.4.1.js') ?>" defer></script>
        <script type="text/javascript" src="<?= getRelativePath('popper.js') ?>" defer></script>
        <script type="text/javascript" src="<?= getRelativePath('alertify.js') ?>" defer></script>
        <script type="text/javascript" src="<?= getRelativePath('tablesort.js') ?>" defer></script>
        <script type="text/javascript" src="<?= getRelativePath('Fomantic-UI/dist/semantic.min.js') ?>" defer></script>
        <script type="text/javascript" src="<?= $page_script ?>" defer></script> -->

        <script type="text/javascript" src="<?= getRelativePath('jquery-3.4.1.min.js') ?>" defer></script>
        <script type="text/javascript" src="<?= getRelativePath('popper.min.js') ?>" defer></script>
        <script type="text/javascript" src="<?= getRelativePath('alertify.min.js') ?>" defer></script>
        <script type="text/javascript" src="<?= getRelativePath('tablesort.js') ?>" defer></script>
        <script type="text/javascript" src="<?= getRelativePath('Fomantic-UI/semantic.min.js') ?>" defer></script>

        <?php 
            $rel_path = getRelativePath("api.php");
            $rel_path_param = $rel_path. "?query={query}&fetch={fetch}";
        ?>

        <script id="main-script" data-api-path="<?= $rel_path_param ?>" data-api-path-gen="<?= $rel_path ?>" type="text/javascript" src="<?= $page_script ?>" defer></script>

        <title><?= $page_title ?></title>
    </head>
    <body>
        <div id="page-loader" class="ui dimmer">
            <div class="ui medium text green elastic loader">Please wait in a moment...</div>
        </div>

