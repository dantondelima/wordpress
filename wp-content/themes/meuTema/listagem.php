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
<?php }