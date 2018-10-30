<?php

get_header();
/*
Template Name: realizado
*/

    require_once('wp-load.php');
    if(isset($_POST['enviando'])){
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $dataNasc = $_POST['data_nasc'];
        $cpf = $_POST['cpf'];
        $cep = $_POST['cep'];
        $endereco = $_POST['endereco'];
        $bairro = $_POST['bairro'];
        $cidade = $_POST['cidade'];
        $estado = $_POST['estado'];
        $telefone = $_POST['telefone'];
        $celular = $_POST['celular'];
        $post = $_POST['post_id'];
        $status = "Finalizada";

        global $wpdb;
        $tabela = $wpdb->prefix . 'inscritos';
            if(!$wpdb->insert($tabela, 
            array(
                'inscrito_nome' => $nome,
                'inscrito_email' => $email,
                'inscrito_data_nasc' => $dataNasc,
                'inscrito_cpf' => $cpf, 
                'inscrito_cep' => $cep,
                'inscrito_endereco' => $endereco,
                'inscrito_bairro' => $bairro,
                'inscrito_cidade' => $cidade,
                'inscrito_estado' => $estado,
                'inscrito_telefone' => $telefone,
                'inscrito_celular' => $celular,
                'inscrito_status' => $status,
                'post_id' => $post
            )
            )){
                echo $wpdb->last_error;
            }
            else{
                ?> <h1>Inscrição realizada com sucesso</h1>
        <?php    }
        }


get_footer(); ?>