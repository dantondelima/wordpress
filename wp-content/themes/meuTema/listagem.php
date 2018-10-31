<?php

function inscricoes_callback(){ ?>
<script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css"> 
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<?php if(isset($_GET['post_id']) && !empty($_GET['post_id']))
{
  $post = $_GET['post_id'];
}
else
{
  $post = "0";
} ?>  
<?php if(isset($_POST['visualizar']))
{
  $teste = $_POST['visualizar'];
}
else
{
  $teste = "0";
} ?>            
<script type="text/javascript"> 
    $(document).ready(function(){
        $('#myTable').DataTable({
           "processing": true,
           "serverSide": true,
           "order": [],
           "dom": '<"top">rt<"bottom"ip><"clear">',
           "ajax": {
               "url": "<?= get_site_url().'/listagem' ?>",
               "type": "POST",
               "data": function(data)
                {
                  data.post = <?= $post ?>;
                }
            },
           "columnDefs": [
                {
                    "targets": [ 0, 1, 2, 3, 4, 5, 6 ], 
                    "orderable":false
                }
           ],
           "language": {
                "zeroRecords": "Nada encontrado - desculpe",
                "info": "Mostrando página _PAGE_ de _PAGES_",
                "infoEmpty": "Nenhum registro disponivel",
                "infoFiltered": "(filtrado do total de _MAX_ registros)",
                "paginate": {
                    "first":      "Primeira",
                    "last":       "Última",
                    "next":       "Próxima",
                    "previous":   "Anterior"
                },
                "search":         "Pesquisar:",
                "loadingRecords": "Carregando...",
                "processing":     "Processando..."
        },
            "lengthChange": false,
            "pageLength": 10
       }); 
       if("<?= $teste ?>" != "0")
        {
          $('#myModal').modal('show');
        }
    });
</script>

<table id="myTable" class="table">
    <thead>
        <tr>
            <th>Curso</th>
            <th>Data de Inscrição</th>
            <th>Nome</th>
            <th>E-mail</th>
            <th>Status</th>
            <th>Visualizar</th>
            <th>Excluir</th>
        </tr>
    </thead>
    <tbody>
        
    </tbody>
</table>
<?php
  if(isset($_POST['deletar']))
  {
    $id = $_POST['inscrito_id'];
    global $wpdb;
    $wpdb->delete('wp_inscritos',array('inscrito_id' => $id));
  }
  if(isset($_POST['visualizar']))
  {
    $id = $_POST['inscrito_id'];
    global $wpdb;
    $dados = $wpdb->get_row('select * from wp_inscritos inner join wp_posts on post_id = id where inscrito_id = '.$id, 'ARRAY_A');
    ?>
    <div class="modal fade" id="myModal" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title"><strong>Dados da Inscrição</strong></h4>
          </div>
          <div class="modal-body">
            <p><strong>Nome:</strong> <?=$dados['inscrito_nome'] ?></p>
            <p><strong>Data de Nascimento:</strong> <?=$dados['inscrito_data_nasc']?></p>
            <p><strong>CPF:</strong> <?=$dados['inscrito_cpf'] ?></p>
            <p><strong>Email:</strong> <?=$dados['inscrito_email'] ?></p>
            <p><strong>CEP:</strong> <?=$dados['inscrito_cep'] ?></p>
            <p><strong>Endereço:</strong> <?=$dados['inscrito_endereco'] ?></p>
            <p><strong>Bairro:</strong> <?=$dados['inscrito_bairro'] ?></p>
            <p><strong>Cidade:</strong> <?=$dados['inscrito_cidade'] ?></p>
            <p><strong>Estado:</strong> <?=$dados['inscrito_estado'] ?></p>
            <p><strong>Telefone:</strong> <?=$dados['inscrito_telefone'] ?></p>
            <p><strong>Celular:</strong> <?=$dados['inscrito_celular'] ?></p>
            <p><strong>Status:</strong> <?=$dados['inscrito_status'] ?></p>
            <p><strong>Curso:</strong> <?=$dados['post_title'] ?></p>
            <p><strong>Data de Inscrição:</strong> <?=(substr($dados['inscrito_data_nasc'], 8, 2)."/".substr($dados['inscrito_data_nasc'], 5, 2)."/".substr($dados['inscrito_data_nasc'], 0, 4)) ?></p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
    <?php
  }
?>
<?php }