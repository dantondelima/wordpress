<?php 

/* 
Template Name: comprar
*/
?>

<?php get_header();

define("EMAIL_PAGSEGURO", "danton.lima@kbrtec.com.br");
define("TOKEN_PAGSEGURO", "");
define("TOKEN_SANDBOX", "22EA06CA540C4CB1BC92F9084183A2FC");


$TokenCard=$_POST['tokenCard'];
$HashCard=$_POST['hashCard'];
$QtdParcelas=filter_input(INPUT_POST,'QtdParcelas',FILTER_SANITIZE_SPECIAL_CHARS);
$ValorParcelas=filter_input(INPUT_POST,'ValorParcelas',FILTER_SANITIZE_SPECIAL_CHARS);
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
$titulo = $_POST['titulo'];


$preco= number_format($_POST['preco'], 2, '.', '');
//$data = substr($data, 8, 2)."/".substr($data, 5, 2)."/".substr($data, 0, 4);

$Data["email"]=EMAIL_PAGSEGURO;
$Data["token"]=TOKEN_SANDBOX;
$Data["paymentMode"]="default";
$Data["paymentMethod"]="creditCard";
$Data["receiverEmail"]=EMAIL_PAGSEGURO;
$Data["currency"]="BRL";
$Data["itemId1"] = $post;
$Data["itemDescription1"] = $titulo;
$Data["itemAmount1"] = $preco;
$Data["itemQuantity1"] = 1;
$Data["notificationURL="]="https://www.meusite.com.br/notificacao.php";
$Data["reference"]="83783783737";

$Data["senderName"]='Danton de Lima';
$Data["senderCPF"]='49848025880';
$Data["senderAreaCode"]='13';
$Data["senderPhone"]='991678274';
$Data["senderEmail"]="danton.lima@sandbox.pagseguro.com.br";
$Data["senderHash"]=$HashCard;
$Data["shippingType"]="1";
$Data["shippingAddressStreet"]=$endereco;
$Data["shippingAddressNumber"]='800';
$Data["shippingAddressComplement"]='';
$Data["shippingAddressDistrict"]=$bairro;
$Data["shippingAddressPostalCode"]='01452002';
$Data["shippingAddressCity"]=$cidade;
$Data["shippingAddressState"]=$estado;
$Data["shippingAddressCountry"]="BRA";
$Data["shippingCost"]="0.00";
$Data["creditCardToken"]=$TokenCard;
$Data["installmentQuantity"]=$QtdParcelas;
$Data["installmentValue"]=$ValorParcelas;
$Data["noInterestInstallmentQuantity"]=2;
$Data["creditCardHolderName"]=$nome;
$Data["creditCardHolderCPF"]=$cpf;
$Data["creditCardHolderBirthDate"]=$dataNasc;
$Data["creditCardHolderAreaCode"]=substr($telefone, 0, 2);
$Data["creditCardHolderPhone"]=substr($telefone, 2);
$Data["billingAddressStreet"]=$endereco;
$Data["billingAddressNumber"]='800';
$Data["billingAddressComplement"]='';
$Data["billingAddressDistrict"]=$bairro;
$Data["billingAddressPostalCode"]=$cep;
$Data["billingAddressCity"]=$cidade;
$Data["billingAddressState"]=$estado;
$Data["billingAddressCountry"]="BRA";

if(isset($_POST['comprando'])){
    $celular = $_POST['celular'];
    $telefone = $_POST['telefone'];
    $estado = $_POST['estado'];
    $cidade = $_POST['cidade'];
    $bairro = $_POST['bairro'];
    $cep = $_POST['cep'];
    $cpf = $_POST['cpf'];
    $email = $_POST['email'];
    $post = $_POST['post_id'];
    $nome = $_POST['nome'];
    $endereco = $_POST['endereco'];
    $dataNasc = $_POST['data_nasc'];
    $status = 'Aguardando confirmação de pagamento';
    global $wpdb;
    $inscrito_table = $wpdb->prefix.'inscritos';
    if($wpdb->insert(
        $inscrito_table,
        array(
            'inscrito_nome' => $nome,
            'inscrito_data_nasc' => $dataNasc,
            'inscrito_cpf' => $cpf,
            'inscrito_email' => $email,
            'inscrito_cep' => $cep,
            'inscrito_endereco' => $endereco,
            'inscrito_bairro' => $bairro,
            'inscrito_cidade' => $cidade,
            'inscrito_estado' => $estado,
            'inscrito_telefone' => $telefone,
            'inscrito_celular' => $celular,
            'inscrito_status' => $status,
            'pk_post' => $post))) 
    {
        ?>
        <div class="alert alert-success alert-dismissible show">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Inscrição efetuada com sucesso</strong>
        </div>
        <?php
        $BuildQuery=http_build_query($Data);
        $Url="https://ws.sandbox.pagseguro.uol.com.br/v2/transactions";
        $Curl=curl_init($Url);
        curl_setopt($Curl,CURLOPT_HTTPHEADER, array("Content-Type: application/x-www-form-urlencoded; charset=UTF-8"));
        curl_setopt($Curl,CURLOPT_POST,1 );
        curl_setopt($Curl,CURLOPT_SSL_VERIFYPEER,false);
        curl_setopt($Curl,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($Curl,CURLOPT_POSTFIELDS,$BuildQuery);
        $Retorno=curl_exec($Curl);
        curl_close($Curl);
        $Xml=simplexml_load_string($Retorno);
        if(!(substr($Xml, 1, 6) == "errors")) {?>
            <div class="alert alert-success alert-dismissible show">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong><a href="<?= get_site_url().''?>">Transação efetuada(clique para voltar para a página inicial)</a></strong>
            </div>
        <?php } else { ?>
            <div class="alert alert-danger alert-dismissible show">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>erro</strong>
            </div>
    <?php }  }else{ ?> 
            <div class="alert alert-danger alert-dismissible show">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong><?= $wpdb->print_error() ?></strong>
            </div>
     <?php }
    }
    else 
    {?>
        <div class="alert alert-danger alert-dismissible show">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>Nem entrou</strong>
        </div>
    <?php }
    get_footer();