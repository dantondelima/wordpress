<?php
/*
Template Name: listagem
*/
?>
<?php
        $pegadados = CriarDataTable();
        $dados = array();
        foreach ($pegadados as $row) {
            $sub_dados = array();
            $sub_dados[] = $row['post_title'];
            $sub_dados[] = $row['inscrito_data_nasc'];
            $sub_dados[] = $row['inscrito_nome'];
            $sub_dados[] = $row['inscrito_email'];
            $sub_dados[] = $row['inscrito_status'];
            $sub_dados[] = "<a href='' role='button' class='btn btn-primary' data-toggle='tooltip' title='Alterar'><span class='glyphicon glyphicon-edit'></span></a>";
            $sub_dados[] = "<form method='POST' action=''>".""."<button type='submit' role='button' class='btn btn-danger' data-toggle='tooltip' title='Deletar Item'><span class='glyphicon glyphicon-trash'></span></button></form>";
            $dados[] = $sub_dados;
        }
        
        $output = array (
            "draw"  => intval($_POST['draw']),
            "recordsTotal" => TodosRegistros(), 
            "recordsFiltered" => RegistrosFiltrados(),
            "data" => $dados
        );
        echo json_encode($output);
        
    $order = ['post_title','inscrito_data_nasc', 'inscrito_nome','inscrito_email', 'inscrito_status'];
    
    function CriarQuery()
    {
        $query = "select * from wp_inscritos inner join wp_posts on ID = pk_post";
        if(isset($_POST['search']['value']) && !empty($_POST['search']['value']))
        {
            $query = $query." where inscritos_status like ".$_POST['search']['value']."%";         
        }
        if(isset($_POST['order']) && !empty($_POST['order']))
        {
            $query = $query." order by ".$_POST['order']['0']['column']." ".$_POST['order']['0']['dir'];
        }
        else
        {
            $query = $query." order by inscrito_id desc";
        }
        return $query;
    }
    
    function CriarDataTable()
    {
        global $wpdb;
        $query = CriarQuery();
        $formato = "ARRAY_A";
        if($_POST['length'] != -1)
        {
            $query = $query." limit ".$_POST['length']." offset ".$_POST['start'];
        }
        $queryFinal = $wpdb->get_results($query, $formato);
        return $queryFinal;
    }
    
    function RegistrosFiltrados()
    {
        global $wpdb;
        $query = CriarQuery();
        $formato = "ARRAY_A";
        $wpdb->get_results($query, $formato);
        return $wpdb->num_rows;
    }
    
    function TodosRegistros()
    {   
        global $wpdb;
        $query = "select * from wp_inscritos inner join wp_posts on id = pk_post";
        $formato = "ARRAY_A";
        $wpdb->get_results($query, $formato);
        return $wpdb->num_rows;
    }