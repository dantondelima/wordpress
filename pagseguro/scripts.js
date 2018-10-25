var Root="http://"+document.location.hostname+"/";
var Amount = 500.00;

//inicia a sessão
function iniciarSessao()
{
    $.ajax({
       url: Root+"pagseguro/ControllerId.php",
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
                $('.CartaoCredito').append("<div><img src='https://stc.pagseguro.uol.com.br/"+obj.images.SMALL.path+"'>"+obj.name+"</div>");
            });

            $('.Boleto').append("<div><img src='https://stc.pagseguro.uol.com.br/"+data.paymentMethods.BOLETO.options.BOLETO.images.SMALL.path+"'>"+data.paymentMethods.BOLETO.name+"</div>");

            $.each(data.paymentMethods.ONLINE_DEBIT.options, function(i, obj){
                $('.Debito').append("<div><img src='https://stc.pagseguro.uol.com.br/"+obj.images.SMALL.path+"'>"+obj.name+"</div>");
            });
        },
        complete: function(data) {
            getTokenCard();
        }
    });
}
 
//pegar a bandeirinha do cartão
$('#NumeroCartao').on('keyup', function(){
    var NumeroCartao=$(this).val();
    var QtdCaracteres=NumeroCartao.length;

    if(QtdCaracteres >= 6){
        PagSeguroDirectPayment.getBrand({
            cardBin: NumeroCartao,
                success: function(response)
                {
                    var BandeiraImg=response.brand.name;
                    $('.BandeiraCartao').html("<img src=https://stc.pagseguro.uol.com.br//public/img/payment-methods-flags/42x20/"+BandeiraImg+".png>");
                    getParcelas(BandeiraImg);
                },
                error: function(response) {
                    alert("Cartão não reconhecido")
                }
        });
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
iniciarSessao();