<!DOCTYPE html>
<html>
    <head>
        <?php $raiz = get_template_directory_uri(); ?>
        <link rel="stylesheet" href="<?= $raiz?>/reset.css">
        <link rel="stylesheet" href="<?= $raiz?>/style.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
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

