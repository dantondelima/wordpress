<?php

add_theme_support('post-thumbnails');

add_action('admin_menu', 'inscricoes_menu');

include("listagem.php");

function inscricoes_menu() {
	add_menu_page(
		'Incrições',
		'Inscrições',
		'administrator',
		'slug',
		'inscricoes_callback',
		'dashicons-heart',
		26
	);
}

function cadastrando_post_type_treinamentos(){

    $nomeSingular = 'Treinamento';
    $nomePlural = 'Treinamentos';
    $description = 'Treinamento';

    $labels = array(
        'name' => $nomePlural,
        'name_singular' => $nomeSingular,
        'add_new_item' => 'Adicionar novo '.$nomeSingular,
        'edit_item' => 'Editar '.$nomeSingular
    );

    $supports = array(
        'title',
        'editor',
        'thumbnail'
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'description' => $description,
        'menu_icon' => 'dashicons-hammer',
        'supports' => $supports
    );

    register_post_type('treinamento', $args);

}

add_action('init', 'cadastrando_post_type_treinamentos');


function preenche_conteudo_informacoes_treinamento($post) { 
	$curso_meta_data = get_post_meta($post->ID);
	?>

<script>
		function Gratuito(){
			if ($('#Gratuito-input').attr('Checked')) {
				$('#Preco-input').attr('disabled',true);
				$('#Preco-input').attr('value','0,00');
			}
			else{
				$('#Preco-input').attr('disabled',false);	
			}
		}
		$('#Vagas-input').on('keyup', function(){
			$('#Vagas_Restantes-input').attr('value', $('#Vagas-input').attr('value'));
		});
	</script>
<style>
		.metabox {
			display: flex;
			justify-content: space-between;
		}
		.metabox-item {
			flex-basis: 30%;
		}
		.metabox-item label {
			font-weight: 700;
			display: block;
			margin: .5rem 0;
		}
		.input-addon-wrapper {
			height: 30px;
			display: flex;
			align-items: center;
		}
		.input-addon {
			display: block;
			border: 1px solid #000;
			border-bottom-left-radius: 5px;
			border-top-left-radius: 5px;
			height: 100%;
			width: 30px;
			text-align: center;
			line-height: 30px;
			box-sizing: border-box;
			background-color: blue;
			color: #FFF;
		}
		.metabox-input {
			height: 100%;
			border: 1px solid blue;
			border-left: none;
			margin: 0;
		}
	</style>
    <div class="metabox">
        <div class="metabox-item">
			<label for="Gratuito-input">Gratuito</label>
				<input id="Gratuito-input" class="metabox-input" type="checkbox" name="gratuito_id" onclick="Gratuito()" <?php 
					if ($curso_meta_data['gratuito_id'][0]) {
							echo 'Checked';
					} ?>
				>
			</div>

		<div class="metabox-item">
			<label for="Preco-input">Preço:</label>
			<div class="input-addon-wrapper">
				<span class="input-addon">R$</span>
				<input id="Preco-input" class="metabox-input" type="text" name="preco_id"
				value="<?= number_format($curso_meta_data['preco_id'][0], 2, ',', '.'); ?>">
			</div>
		</div>

		<?php if ($curso_meta_data['gratuito_id'][0]) { ?>
			<script>$("#Preco-input").attr("disabled", true);</script>
			<?php
		} ?>
		<div class="metabox-item">
			<label for="Chamada-input">Chamada:</label>
			<input style="height: 35px;" id="Chamada-input" class="metabox-input" type="date" name="chamada_id"
			value="<?= $curso_meta_data['chamada_id'][0]; ?>">
		</div>

		<div class="metabox-item">
			<label for="Vagas-input">Vagas:</label>
			<input id="Vagas-input" class="metabox-input" type="number" name="vagas_id"
			value="<?= $curso_meta_data['vagas_id'][0]; ?>">
			<input type="hidden" id="Vagas_Restantes-input" name="vagasrestantes_id" value="">
		</div>

    </div>
    
<?php } 

function registra_meta_boxes() {
    add_meta_box(
        'informacoes-treinamentos',
        'Informações do treinamento', 
        'preenche_conteudo_informacoes_treinamento',
        'treinamento',
        'normal',
        'high'
    );
}

add_action('add_meta_boxes', 'registra_meta_boxes');

function salva_meta_info($post_id) {
	
	$checked = $_POST['gratuito_id'];
	update_post_meta( $post_id, 'gratuito_id', $checked );
	if ($checked == 1) {
		?>
			<script>$('#Preco-input').attr('disabled',true);</script>
		<?php
	}
	if(isset($_POST['preco_id']))
		update_post_meta($post_id, 'preco_id', sanitize_text_field($_POST['preco_id']));

	if(isset($_POST['chamada_id']))
		update_post_meta($post_id, 'chamada_id', sanitize_text_field($_POST['chamada_id']));
	
	if(isset($_POST['vagas_id'])){
		update_post_meta($post_id, 'vagas_id', sanitize_text_field($_POST['vagas_id']));
		if ($_POST['vagasrestantes_id'] != "") {
			update_post_meta($post_id, 'vagasrestantes_id', sanitize_text_field($_POST['vagasrestantes_id']));
		}
		else{
			update_post_meta($post_id, 'vagasrestantes_id', sanitize_text_field($_POST['vagas_id']));
		}
	}
}
add_action('save_post', 'salva_meta_info');

add_action( 'admin_menu', 'remove_links_menu' );
function remove_links_menu() {
	// remove_menu_page('index.php'); // Painel
	remove_menu_page('edit.php'); // Posts
	remove_menu_page('upload.php'); // Media
	//remove_menu_page('link-manager.php'); // Links
	//remove_menu_page('edit.php?post_type=page'); // Paginas
	remove_menu_page('edit-comments.php'); // Comentários
	//remove_menu_page('themes.php'); // Aparência
	remove_menu_page('plugins.php'); // Plugins
	remove_menu_page('users.php'); // Usuários
	// remove_menu_page('tools.php'); // Ferramentas
	// remove_menu_page('options-general.php'); // Configurações
}