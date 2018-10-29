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
    <script type="text/javascript">
        $(document).ready(function(){
            var Root = "<?= get_site_url().'/dados' ?>";
            var Amount = <?= $_POST['preco'] ?>;
            $("#preco").val(Amount);
            $.ajax({
                url: Root,
                type: 'POST',
                dataType:'json',
                success: function(data)
                {
                    PagSeguroDirectPayment.setSessionId(data.id);
                },
                complete: function()
                {
                    listarMeiosPagamentos();
                }
            });

            function listarMeiosPagamentos()
            {
                PagSeguroDirectPayment.getPaymentMethods({
                    amount: Amount,
                    success: function(data)
                    {
                    
                    },
                    complete: function(data)
                    {
                        
                    }
                });
            }
            
            $("#NumeroCartao").on('keyup', function(){
                var cartao = $(this).val();
                var qtd = cartao.length;
                if(qtd == 6){
                    PagSeguroDirectPayment.getBrand({
                        cardBin: cartao,
                        success: function(data){
                            var BandeiraImg=data.brand.name;
                            $(".BandeiraCartao").html("<img src='https:/stc.pagseguro.uol.com.br/public/img/payment-methods-flags/68x30/"+BandeiraImg+".png'>");
                            $("#Bandeira").val(BandeiraImg);
                            getParcelas(BandeiraImg);
                        },
                        error: function(data)
                        {
                            alert("Cartão não reconhecido");
                            $("#imageBrand").empty();
                        }
                    });
                }
                if(qtd < 6)
                {
                    $("#imageBrand").empty();
                }
            });

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
                    },
                    error: function(response){
                        console.log(response);
                    }
                });
            }
            
            function getTokenCredit(Bandeira)
            {
                PagSeguroDirectPayment.createCardToken({
                    cardNumber: '4111111111111111',
                    brand: Bandeira,
                    cvv: $("#Verification").val(),
                    expirationMonth: $("#Mes").val(),
                    expirationYear: $("#Ano").val(),
                    success: function(data){
                        $("#NumeroCartao").addClass('.is-valid');
                        $("#Verification").addClass('.is-valid');
                        $("#Mes").addClass('.is-valid');
                        $("#Ano").addClass('.is-valid');
                        $("#Token").val(data.card.token);
                        if($("#Token").val() !== '')
                        {
                            $("#comprar").show();
                        }
                    }
                });
            }
            $("#Verification").blur(function (){
                getTokenCredit($("Bandeira").val());
            });
            $("#Mes").blur(function (){
                getTokenCredit($("Bandeira").val());
            });
            $("#Ano").blur(function (){
                getTokenCredit($("Bandeira").val());
            });
            $("#NumeroCartao").blur(function (){
                getTokenCredit($("Bandeira").val());
            });

            $("#comprar").on('click', function(event){
                event.preventDefault();
                PagSeguroDirectPayment.onSenderHashReady(function(response){
                    $("#Hash").val(response.senderHash);
                    if($("#Token").val() !== '' && $("#Hash").val() !== '')
                    {
                        $("#Form1").submit();
                    }
                });
            });
            
            $("#QtdParcelas").on('change',function(){
                var ValueSelected=document.getElementById('QtdParcelas');
                $("#ValorParcelas").val(ValueSelected.options[ValueSelected.selectedIndex].label);
            });
            $.getJSON("https://viacep.com.br/ws/"+ <?= $_POST['cep'] ?> +"/json/?callback=?", function(dados) {
                $("#endereco").val(dados.logradouro);
                $("#bairro").val(dados.bairro);
                $("#cidade").val(dados.localidade);
                $("#estado").val(dados.uf);
            });    
        });
    </script>
    <title>Integração pagseguro</title>
</head>
<body>
<div class="form-group col-sm-6">
    <form id="Form1" name="Form1" method="post" action= <?= get_site_url().'/comprar/'?> class="form center-block">
    <div class="form-group">
        <input class="form-control" type="text" id="NumeroCartao" name="NumeroCartao" required>
        <div class="BandeiraCartao" id="imageBrand"></div>
    </div>
    <div class="form-group">
        <select class="form-control" name="QtdParcelas" id="QtdParcelas">
            <option value="">Selecione</option>
        </select>
    </div>
    
            <div class="form-group col-sm-2" style="width: 33%; margin-left: -15px">
                <input name="verification" class="form-control" id="Verification" placeholder="cvv" required/>
            </div>
            <div class="form-group col-sm-2" style="width: 33.5%; margin-left: -10px">
                <input name="mes" class="form-control" id="Mes" placeholder="Mes de vencimento" required/>
            </div>
            <div class="form-group col-sm-2" style="width: 33%; margin-left: -10px">
                <input name="ano" class="form-control" id="Ano" placeholder="Ano de vencimento" required/>
            </div>
    </div>
    <div class="form-group col-sm-8">
        <input type="hidden" name="tokenCard" id="Token"/>
        <input type="hidden" name="hashCard" id="Hash"/>
        <input type="hidden" name="bandeira" id="Bandeira"/>
        <input type="hidden" name="ValorParcelas" id="ValorParcelas"/>
        <input type="hidden" name="nome" id="nome" value="<?= $_POST['nome'] ?>"/>
        <input type="hidden" name="data_nasc" id="data_nasc" value="<?= $_POST['data_nasc'] ?>"/>
        <input type="hidden" name="cpf" id="cpf" value="<?= $_POST['cpf'] ?>"/>
        <input type="hidden" name="email" id="email" value="<?= $_POST['email'] ?>"/>
        <input type="hidden" name="cep" id="cep" value="<?= $_POST['cep'] ?>"/>
        <input type="hidden" name="endereco" id="endereco" value="<?= $_POST['endereco'] ?>"/>
        <input type="hidden" name="bairro" id="bairro" value="<?= $_POST['bairro'] ?>"/>
        <input type="hidden" name="estado" id="estado" value="<?= $_POST['estado'] ?>"/>
        <input type="hidden" name="cidade" id="cidade" value="<?= $_POST['cidade'] ?>"/>
        <input type="hidden" name="telefone" id="telefone" value="<?= $_POST['telefone'] ?>"/>
        <input type="hidden" name="celular" id="celular" value="<?= $_POST['celular'] ?>"/>
        <input type="hidden" name="preco" id="preco" value="<?= $_POST['preco'] ?>"/>
        <input type="hidden" name="post_id" id="post_id" value="<?= $_POST['post_id'] ?>"/>
        <input type="hidden" name="titulo" value="<?=$_POST['titulo']?>"/>
        <input id="comprar" name="comprando" class="btn btn-primary" role="button" value="Comprar"/>    </div>
    </form>
    <br>
    

    </body> 
</html>

<?php get_footer(); ?>