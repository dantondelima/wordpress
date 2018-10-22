<?php 

/*
Template Name: formulario
*/
get_header(); 

?>
    <script >
        $(document).ready(function(){
            var $cpf = $("#cpf");
            var $cel = $("#celular");
            var $tel = $("#telefone");

            $cpf.mask('000.000.000-00', {reverse: true});
            $cel.mask('(00) 00000-0000');
            $tel.mask('(00) 0000-0000');
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
    <form class="form ">
        <div class="form-group col-7">
            <label for="nome">Nome:</label>
            <input type="text" class="form-control" name="nome" id="nome" placeholder="Digite seu nome">
        </div>
        <div class="form-group col-7">
            <label for="data-nasc">Data de Nascimento:</label>
            <input type="text" class="form-control" name="data-nasc" id="datepicker" placeholder="data de nascimento">
        </div>
        <div class="form-group col-7">
            <label for="cpf">CPF:</label>
            <input type="text" class="form-control" name="cpf" id="cpf" placeholder="Digite seu cpf">
        </div>
        <div class="form-group col-7">
            <label for="email">Email:</label>
            <input type="text" class="form-control" name="email" id="email" placeholder="Digite seu email">
        </div>
        <div class="form-group col-7">
            <label for="cep">CEP:</label>
            <input type="text" class="form-control" name="cep" id="cep" placeholder="Digite seu cep">
        </div>
        <div class="form-group col-7">
            <label for="endereco">Endereço:</label>
            <input type="text" class="form-control" name="endereco" id="endereco" readonly>
        </div>
        <div class="form-group col-7">
            <label for="bairro">Bairro:</label>
            <input type="text" class="form-control" name="bairro" id="bairro" readonly>
        </div>
        <div class="form-group col-7">
            <label for="cidade">Cidade:</label>
            <input type="text" class="form-control" name="cidade" id="cidade" readonly>
        </div>
        <div class="form-group col-7">
            <label for="estado">Estado:</label>
            <input type="text" class="form-control" name="estado" id="estado" readonly>
        </div>
        <div class="form-group col-7">
            <label for="telefone">Telefone:</label>
            <input type="text" class="form-control" name="telefone" id="telefone">
        </div>
        <div class="form-group col-7">
            <label for="celular">Celular:</label>
            <input type="text" class="form-control" name="celular" id="celular">
        </div>
        <input type="hidden" name="post_id" value="<?= $_POST['post_id']?>">
        <button type="submit" style="margin-left:16px; margin-bottom: 30px; width: 895px" class="btn btn-primary btn-block">Inscrever-se</button>
</form>

<?php get_footer(); ?>