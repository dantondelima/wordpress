<!DOCTYPE html>
<html>
    <head>
        <?php $raiz = get_template_directory_uri(); ?>
        <link rel="stylesheet" href="<?= $raiz?>/reset.css">
        <link rel="stylesheet" href="<?= $raiz?>/style.css">
        <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <link rel="stylesheet" href="http://code.jquery.com/ui/1.9.0/themes/base/jquery-ui.css" />
        <script src="http://code.jquery.com/jquery-1.8.2.js"></script>
        <script src="http://code.jquery.com/ui/1.9.0/jquery-ui.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.min.js"></script>
        <?php wp_head(); ?>
    </head>
    <body>
        
    <header>
        <a href="<?= get_site_url()?>">Início</a>
        <?php 
        $args = array(
            'theme_location' => 'header-menu'
        );
            wp_nav_menu($args);
        ?>
    </header>

