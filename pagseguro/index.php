<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js" type="text/javascript"></script>

    <title>Integração pagseguro</title>
    <style>
        *{margin: 0; box-sizing: border-box;}
        .CartaoCredito, .Debito , .Boleto{float:left; width: 30%; margin: 30px 1.5%; border-radius: 10px; border: 1px solid #999; font-size: 18px; font-weight: bold;}
        .Titulo{float:left; width: 100%; border-radius: 10px 10px 0 0; font-weight: bold; color: #fff; background: #000; text-align: center;}
    </style>
</head>
<body>

    <form id="Form1" name="Form1" method="post" action="ControllerPedido.php">
        <input type="hidden" id="TokenCard" name="TokenCard">
        <input type="hidden" id="HashCard" name="HashCard">
        <input type="text" id="NumeroCartao" name="NumeroCartao">
        <div class="BandeiraCartao"></div>
        <select name="QtdParcelas" id="QtdParcelas">
            <option value="">Selecione</option>
        </select>
        <input type="text" id="ValorParcelas" name="ValorParcelas">
        <input id="BotaoComprar" name="BotaoComprar" type="submit" value="Comprar">
    </form>
    

    <div class="google-auto-placed" style="text-align: center; width: 100%; height: auto; clear: both;"><ins data-ad-format="auto" class="adsbygoogle adsbygoogle-noablate" data-ad-client="ca-pub-9706216210682263" data-adsbygoogle-status="done" style="display: block; margin: 10px auto 18px; background-color: transparent; height: 90px;"><ins id="aswift_3_expand" style="display:inline-table;border:none;height:90px;margin:0;padding:0;position:relative;visibility:visible;width:1200px;background-color:transparent;"><ins id="aswift_3_anchor" style="display:block;border:none;height:90px;margin:0;padding:0;position:relative;visibility:visible;width:1200px;background-color:transparent;"><iframe width="1200" height="90" frameborder="0" marginwidth="0" marginheight="0" vspace="0" hspace="0" allowtransparency="true" scrolling="no" allowfullscreen="true" onload="var i=this.id,s=window.google_iframe_oncopy,H=s&&s.handlers,h=H&&H[i],w=this.contentWindow,d;try{d=w.document}catch(e){}if(h&&d&&(!d.body||!d.body.firstChild)){if(h.call){setTimeout(h,0)}else if(h.match){try{h=s.upd(h,i)}catch(e){}w.location.replace(h)}}" id="aswift_3" name="aswift_3" style="left:0;position:absolute;top:0;width:1200px;height:90px;"></iframe></ins></ins></ins></div><div class="CartaoCredito"><div class="Titulo">Cartão de Crédito</div></div>
    <div class="Boleto"><div class="Titulo">Boleto</div></div>
    <div class="Debito"><div class="Titulo">Débito Online</div></div>

    <!-- <form name="formPagamento" id="formPagamento" action="https://sandbox.pagseguro.uol.com.br"></form> -->
        <script src="scripts.js"></script>
        <script type="text/javascript" src= "https://stc.sandbox.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js"></script>

    </body>
</html>