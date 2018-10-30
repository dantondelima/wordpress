<?php 

/*
Template Name: formulario
*/
get_header(); 
require_once('wp-load.php');
?>
    <script >
        $(document).ready(function(){

            $( "#datepicker" ).datepicker({
                dateFormat: "dd/mm/yy",
                changeMonth: true,
                changeYear: true,
                dayNames: ['Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sábado','Domingo'],
                dayNamesMin: ['D','S','T','Q','Q','S','S','D'],
                dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sáb','Dom'],
                monthNames: ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
                monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez']
            });

        $(document).ready(function() {
            function limpa_formulário_cep() {
                $("#endereco").val("");
                $("#bairro").val("");
                $("#cidade").val("");
                $("#estado").val("");
            }
            
            $("#cep").blur(function() {
                var cep = $(this).val().replace(/\D/g, '');
                if (cep != "") {
                    var validacep = /^[0-9]{8}$/;
                    if(validacep.test(cep)) {
                        $("#endereco").val("...");
                        $("#bairro").val("...");
                        $("#cidade").val("...");
                        $("#estado").val("...");
                        $.getJSON("https://viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {
                            if (!("erro" in dados)) {
                                var estado = {
                                    SP:"São Paulo",
                                    RJ:"Rio de Janeiro",
                                    RS:"Rio Grande do Sul",
                                    PR:"Paraná",
                                    PB:"Paraíba",
                                    BA:"Bahia",
                                    ES:"Espírito Santo",
                                    MT:"Mato Grosso",
                                    MS:"Mato Grosso do Sul",
                                    MG:"Minas Gerais",
                                    RO:"Rondônia",
                                    AM:"Amazonas",
                                    AP:"Amapá",
                                    RR:"Roraima",
                                    SC:"Santa Catarina",
                                    SE:"Sergipe",
                                    CE:"Ceará",
                                    AL:"Alagoas",
                                    AC:"Acre",
                                    GO:"Goiás",
                                    PA:"Pará",
                                    PE:"Pernambuco",
                                    RN:"Rio Grande do Norte",
                                    MA:"Maranhão",
                                    DF:"Distrito Federal",
                                    PI:"Piauí",
                                    TO:"Tocantins"
                                };
                                $("#endereco").val(dados.logradouro);
                                $("#bairro").val(dados.bairro);
                                $("#cidade").val(dados.localidade);
                                $("#estado").val(estado[dados.uf]);
                            }
                            else {
                                limpa_formulário_cep();
                                alert("CEP não encontrado.");
                            }
                        });
                    } 
                    else {
                        limpa_formulário_cep();
                        alert("Formato de CEP inválido.");
                    }
                } 
                else {
                    limpa_formulário_cep();
                }
            });
        });
    });

</script>
    <form class="form center-block" method="POST" action="<?= ((!empty($_POST['gratuito']) || (intval($_POST['gratuito']) == 1) ) ? get_site_url().'/realizado/' : get_site_url().'/pagamento/')?>" id="formInscricao">
    <div>
        <div class="form-group col-sm-8">
            <label for="nome">Nome:</label>
            <input type="text" class="form-control" name="nome" id="nome" placeholder="Digite seu nome" required>
        </div>
        <div class="form-group col-sm-5">
            <label for="data-nasc">Data de Nascimento:</label>
            <input type="text" class="form-control" name="data_nasc" id="datepicker" placeholder="data de nascimento" required>
        </div>
        <div class="form-group col-sm-3">
            <label for="cpf">CPF:</label>
            <input type="text" class="form-control" name="cpf" id="cpf" placeholder="Digite seu cpf" required>
        </div>
        <div class="form-group col-sm-8">
            <label for="email">Email:</label>
            <input type="text" class="form-control" name="email" id="email" placeholder="Digite seu email" required>
        </div>
        <div class="form-group col-sm-8">
            <label for="cep">CEP:</label>
            <input type="text" class="form-control" name="cep" id="cep" placeholder="Digite seu cep" required>
        </div>
        <div class="form-group col-sm-5">
            <label for="endereco">Endereço:</label>
            <input type="text" class="form-control" name="endereco" id="endereco" readonly>
        </div>
        <div class="form-group col-sm-3">
            <label for="bairro">Bairro:</label>
            <input type="text" class="form-control" name="bairro" id="bairro" readonly>
        </div>
        <div class="form-group col-sm-5">
            <label for="cidade">Cidade:</label>
            <input type="text" class="form-control" name="cidade" id="cidade" readonly>
        </div>
        <div class="form-group col-sm-3">
            <label for="estado">Estado:</label>
            <input type="text" class="form-control" name="estado" id="estado" readonly>
        </div>
        <div class="form-group col-sm-5">
            <label for="telefone">Telefone:</label>
            <input type="text" class="form-control" name="telefone" id="telefone" placeholder="Digite seu telefone" required>
        </div>
        <div class="form-group col-sm-3">
            <label for="celular">Celular:</label>
            <input type="text" class="form-control" name="celular" id="celular" placeholder="Digite seu celular" required>
        </div>
        <input type="hidden" name="post_id" value="<?= $_POST['post_id']?>">
        <input type="hidden" name="gratuito" value="<?= $_POST['gratuito']?>">
        <input type="hidden" name="titulo" value="<?=the_title()?>"/>
        <input type="hidden" name="preco" value="<?= (double) str_replace(',', '.', $_POST['preco'])?>">
        <div class="form-group col-sm-8">
            <input class="btn btn-primary" name="enviando" value="<?= ($_POST['gratuito']) ? 'Inscrever-se' : 'Inscrever-se'?>" type="submit"/>
        </div>
    </div>
</form>

</body>
</html>
<?php get_footer(); ?>