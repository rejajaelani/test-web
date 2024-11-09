<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title><?= $title; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= publicUrl('assets/css/style.css') ?>">
</head>

<body>

    <?php
    if ($pageActive != 'login') :
    ?>
        <section class="container-fluid" style="background-color: #E8F0FE;">
            <div class="container">
                <div class="row">
                    <div class="col-3" style="display: flex; justify-content: center; align-items: center; height: 100vh;">
                        <?php include 'side-bar.php'; ?>
                    </div>
                    <div class="col-9" style="display: flex; justify-content: center; align-items: center; height: 100vh;">
                    <?php endif; ?>