<?php

add_theme_support('post-thumbnails');

function cadastrando_post_type_treinamentos(){

    $nomeSingular = 'Treinamento';
    $nomePlural = 'Treinamentos';
    $description = 'Treinamento';

    $labels = array(
        'name' => $nomePlural,
        'name_singular' => $nomeSingular,
        'add_new_item' => 'Adicionar novo '.$nomeSingular,
        'edit_item' => 'Editar'.$nomeSingular
    );

    $supports = array(
        'title',
        'editor',
        'thumbnail'
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'description' => $description,
        'menu_icon' => 'dashicons-hammer',
        'supports' => $supports
    );

    register_post_type('treinamento', $args);

}

add_action('init', 'cadastrando_post_type_treinamentos');

function registrar_menu_navegacao() {
    register_nav_menu('header-meun', 'main-menu');
}

add_action('init', 'registrar_menu_navegacao');