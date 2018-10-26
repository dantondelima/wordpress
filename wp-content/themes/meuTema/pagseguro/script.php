<?php

/*
    Template Name: sessao
*/ 
?>
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
                    $("#imageBrand").html("<img src='https:/stc.pagseguro.uol.com.br/public/img/payment-methods-flags/68x30/"+data.brand.name+".png'>");
                    getParcelas(data.brand.name);
                    $("#Bandeira").val(data.brand.name);
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
