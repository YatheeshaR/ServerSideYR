<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>stackOverflow</title>
    <?= link_tag('https://bootswatch.com/4/yeti/bootstrap.min.css'); ?>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote-bs4.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <a class="navbar-brand" href="#"><strong>stack Overflow</strong></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarColor01">
        <ul class="navbar-nav mr-auto">
        <li class="nav-item">
            <a class="nav-link" href="<?= base_url(); ?>">Home</a>
        </li>
     
        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('users/logout'); ?>" >Logout</a>
        </li>
        <?php  ?>
        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('users/index'); ?>">Login</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('users/register'); ?>">Signup</a>
        </li>
        <?php?>
        </ul>
    </div>
    </nav>
    <div class="container" style="margin-top:40px;">