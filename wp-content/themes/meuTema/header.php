<!DOCTYPE html>
<html>
    <head>
        <?php $raiz = get_template_directory_uri(); ?>
        <link rel="stylesheet" href="<?= $raiz?>/reset.css">
        <link rel="stylesheet" href="<?= $raiz?>/style.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="http://code.jquery.com/ui/1.9.0/themes/base/jquery-ui.css" />
        <script src="http://code.jquery.com/ui/1.9.0/jquery-ui.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.min.js"></script>
        <?php wp_head(); ?>
    </head>
    <body>
        
    <header>
        <a href="<?= get_site_url()?>">Início</a>
    </header>

