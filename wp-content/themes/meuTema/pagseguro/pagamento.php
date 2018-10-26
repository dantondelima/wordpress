<?php 
/*
Template Name: pagamento
*/

get_header();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js" type="text/javascript"></script>
    <script>
        $(document).ready(function(){  
            var Root = "<?= get_site_url().'/controller' ?>";
            Amount = 500.00;
            //inicia a sessão
            function iniciarSessao()
            {
                $.ajax({
                url: Root,
                    type: 'POST',
                    dataType: 'json',
                    success:function(data){
                        PagSeguroDirectPayment.setSessionId(data.id);
                    },
                    complete: function() {
                        listaMeiosPagamento();
                    }
                });
            }

            //lista os meios de pagamento
            function listaMeiosPagamento()
            {
                PagSeguroDirectPayment.getPaymentMethods({
                    amount: Amount,
                    success: function(data) {
                        $.each(data.paymentMethods.CREDIT_CARD.options, function(i, obj){
                            $('.CartaoCredito').append("<div><img src='https://stc.pagseguro.uol.com.br/"+obj.images.SMALL.path+"'></div>");
                        });
                    },
                    complete: function(data) {
                        getTokenCard();
                    }
                });
            }

            //pegar a bandeirinha do cartão
            $('#numeroCartao').on('keyup', function(){
                var cartao = $(this).val();
                var qnt = cartao.length;
                if(qnt == 6){
                    PagSeguroDirectPayment.getBrand({
                        cardBin: cartao,
                        success: function(data){
                            $("#BandeiraCartao").html("<img src='https:/stc.pagseguro.uol.com.br/public/img/payment-methods-flags/68x30/"+data.brand.name+".png'>");
                            getParcelas(data.brand.name);
                            //$("#Bandeira").val(data.brand.name);
                        },
                        error: function(data)
                        {
                            alert("Cartão não reconhecido");
                            $("#imageBrand").empty();
                        }
                    });
                }
                if(qnt < 6)
                {
                    $("#imageBrand").empty();
                }
            })

            //lista a quantidade de parcelas
            function getParcelas(Bandeira)
            {
                PagSeguroDirectPayment.getInstallments({
                    amount: Amount,
                    maxInstallmentNoInterest: 2,
                    brand: Bandeira,
                    success: function(response)
                    {
                        $.each(response.installments,function(i,obj){
                            $.each(obj,function(i2,obj2){
                                var NumberValue=obj2.installmentAmount;
                                var Number= "R$ "+ NumberValue.toFixed(2).replace(".",",");
                                var NumberParcelas= NumberValue.toFixed(2);
                                $('#QtdParcelas').show().append("<option value='"+obj2.quantity+"'label='"+NumberParcelas+"'>"+obj2.quantity+" parcelas de "+Number+"</option>");
                            });
                        });
                    }
                });
            }

            // obter token do cartão
            function getTokenCard()
            {
                PagSeguroDirectPayment.createCardToken({
                    cardNumber: '4111111111111111',
                    brand: 'visa',
                    cvv: '123',
                    expirationMonth: '12',
                    expirationYear: '2030',
                    success: function(response)
                    {
                    $('#TokenCard').val(response.card.token);
                    }

                });
            }

            $("#BotaoComprar").on('click', function(event){
                PagSeguroDirectPayment.onSenderHashReady(function(response){
                    $("#HashCard").val(response.senderHash);
                });
            });

            $("#QtdParcelas").on('change',function(){
                var ValueSelected=document.getElementById('QtdParcelas');
                $("#ValorParcelas").val(ValueSelected.options[ValueSelected.selectedIndex].label);
            });
        });

</script>
    <script type="text/javascript" src= "https://stc.sandbox.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js"></script>
    
    <title>Integração pagseguro</title>
</head>
<body>

    <form id="Form1" name="Form1" method="post" action= <?= get_site_url().'/pega-dados/'?> class="form center-block">
    <div class="form-group col-sm-8">
        <input class="form-control" type="hidden" id="TokenCard" name="TokenCard">
        <input type="hidden" name="tokenCard" id="Token"/>
        <input type="hidden" name="hashCard" id="Hash"/>
        <input type="hidden" name="nome" id="nome" value="<?= $_POST['nome'] ?>"/>
        <input type="hidden" name="data_nasc" id="data_nasc" value="<?= $_POST['data_nasc'] ?>"/>
        <input type="hidden" name="cpf" id="cpf" value="<?= $_POST['cpf'] ?>"/>
        <input type="hidden" name="email" id="email" value="<?= $_POST['email'] ?>"/>
        <input type="hidden" name="cep" id="cep" value="<?= $_POST['cep'] ?>"/>
        <input type="hidden" name="endereco" id="endereco" value="<?= $_POST['endereco'] ?>"/>
        <input type="hidden" name="numero" id="numero" value="<?= $_POST['numero'] ?>"/>
        <input type="hidden" name="bairro" id="bairro" value="<?= $_POST['bairro'] ?>"/>
        <input type="hidden" name="estado" id="estado" value="<?= $_POST['estado'] ?>"/>
        <input type="hidden" name="cidade" id="cidade" value="<?= $_POST['cidade'] ?>"/>
        <input type="hidden" name="telefone" id="telefone" value="<?= $_POST['telefone'] ?>"/>
        <input type="hidden" name="celular" id="celular" value="<?= $_POST['celular'] ?>"/>
        <input type="hidden" name="preco" id="preco" value="<?= $_POST['preco'] ?>"/>
        <input type="hidden" name="post_id" id="post_id" value="<?= $_POST['post_id'] ?>"/>
    </div>
    <div class="form-group">
        <input class="form-control" type="text" id="NumeroCartao" name="NumeroCartao">
        <div class="BandeiraCartao" id="BandeiraCartao"></div>
    </div>
    <div class="form-group">
        <select class="form-control" name="QtdParcelas" id="QtdParcelas">
            <option value="">Selecione</option>
        </select>
    </div>
    <div class="form-group">
        <input class="form-control" type="text" id="ValorParcelas" name="ValorParcelas">
        <input class="btn btn-primary" id="BotaoComprar" name="BotaoComprar" type="submit" value="Efetuar pagamento">
    </div>
    </form>
        </body> 
</html>

<?php get_footer(); ?>