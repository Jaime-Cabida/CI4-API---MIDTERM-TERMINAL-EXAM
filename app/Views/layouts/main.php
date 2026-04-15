<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Responsive Admin & Dashboard Template based on Bootstrap 5">
    <meta name="author" content="Gilang Heavy">
    <title>CodeIgniter 4 Starter Panel</title>

    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">

    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">

   
    <link href="<?= base_url('assets/css/app.css') ?>" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" rel="stylesheet">

   
    <link rel="stylesheet" href="<?= base_url('css/adminlte.css') ?>" />
    <link href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/styles/overlayscrollbars.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.css" rel="stylesheet">
</head>

<body data-theme="light">
    <div class="wrapper">
        <?= $this->include('layouts/sidebar'); ?>
        <div class="main">
            <?= $this->include('layouts/header'); ?>
            <main class="content">
                <div class="container-fluid p-0">
                    <?= $this->include('components/alerts'); ?>
                    <?= $this->renderSection('content'); ?>
                </div>
            </main>
            <?= $this->include('layouts/footer'); ?>
        </div>
    </div>

    <!-- JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="<?= base_url('assets/js/app.js') ?>"></script>
</body>

</html>