<?php 
include("config.php");

/* 
Template Name: dados
*/

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

$preco= /*number_format(*/$_POST['preco']/*, 2, '.', '')*/;
//$data = substr($data, 8, 2)."/".substr($data, 5, 2)."/".substr($data, 0, 4);

$Data["email"]=EMAIL_PAGSEGURO;
$Data["token"]=TOKEN_SANDBOX;
$Data["paymentMode"]="default";
$Data["paymentMethod"]="creditCard";
$Data["receiverEmail"]=EMAIL_PAGSEGURO;
$Data["currency"]="BRL";
$Data["itemId1"] = 1;
$Data["itemDescription1"] = 'Website';
$Data["itemAmount1"] = $preco;
$Data["itemQuantity1"] = 1;
$Data["notificationURL="]="https://www.meusite.com.br/notificacao.php";
$Data["reference"]="83783783737";
$Data["senderName"]='José Comprador';
$Data["senderCPF"]='22111944785';
$Data["senderAreaCode"]='37';
$Data["senderPhone"]='99999999';
$Data["senderEmail"]="danton.lima@sandbox.pagseguro.com.br";
$Data["senderHash"]=$HashCard;
$Data["shippingType"]="1";
$Data["shippingAddressStreet"]='Av. Brig. Faria Lima';
$Data["shippingAddressNumber"]='1384';
$Data["shippingAddressComplement"]='5 Andar';
$Data["shippingAddressDistrict"]='Jardim Paulistano';
$Data["shippingAddressPostalCode"]='01452002';
$Data["shippingAddressCity"]='Sao Paulo';
$Data["shippingAddressState"]='SP';
$Data["shippingAddressCountry"]="BRA";
$Data["shippingType"]="1";
$Data["shippingCost"]="0.00";
$Data["creditCardToken"]=$TokenCard;
$Data["installmentQuantity"]=$QtdParcelas;
$Data["installmentValue"]=$ValorParcelas;
$Data["noInterestInstallmentQuantity"]=2;
$Data["creditCardHolderName"]=$nome;
$Data["creditCardHolderCPF"]=$cpf;
$Data["creditCardHolderBirthDate"]=$dataNasc;
$Data["creditCardHolderAreaCode"]='13';
$Data["creditCardHolderPhone"]=$celular;
$Data["billingAddressStreet"]=$endereco;
$Data["billingAddressNumber"]='1384';
$Data["billingAddressComplement"]='5 Andar';
$Data["billingAddressDistrict"]=$bairro;
$Data["billingAddressPostalCode"]='01452002';
$Data["billingAddressCity"]=$cidade;
$Data["billingAddressState"]=$estado;
$Data["billingAddressCountry"]="BRA";


$BuildQuery=http_build_query($Data);
$Url="https://ws.sandbox.pagseguro.uol.com.br/v2/transactions";

$Curl=curl_init($Url);
curl_setopt($Curl,CURLOPT_HTTPHEADER,Array("Content-Type: application/x-www-form-urlencoded; charset=UTF-8"));
curl_setopt($Curl,CURLOPT_POST,true);
curl_setopt($Curl,CURLOPT_SSL_VERIFYPEER,false);
curl_setopt($Curl,CURLOPT_RETURNTRANSFER,true);
curl_setopt($Curl,CURLOPT_POSTFIELDS,$BuildQuery);
$Retorno=curl_exec($Curl);
curl_close($Curl);
$Xml=simplexml_load_string($Retorno);