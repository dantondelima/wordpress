<?php

add_theme_support('post-thumbnails');

function cadastrando_post_type_treinamentos(){

    $nomeSingular = 'Treinamento';
    $nomePlural = 'Treinamentos';
    $description = 'Treinamento';

    $labels = array(
        'name' => $nomePlural,
        'name_singular' => $nomeSingular,
        'add_new_item' => 'Adicionar novo '.$nomeSingular,
        'edit_item' => 'Editar'.$nomeSingular
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

function registrar_menu_navegacao() {
    register_nav_menu('header-meun', 'main-menu');
}

add_action('init', 'registrar_menu_navegacao');

function preenche_conteudo_informacoes_treinamento() { ?>
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

/*<div class="metabox">
		<div class="metabox-item">
			<label for="Gratuito-input">Gratuito</label>
				<input id="Gratuito-input" class="metabox-input" type="checkbox" name="gratuito_id" onclick="Gratuito()" <?php 
					if ($curso_meta_data['gratuito_id'][0]) {
							echo 'Checked';
					} ?>
				>
			</div>
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
			<input id="Chamada-input" class="metabox-input" type="date" name="chamada_id"
			value="<?= $curso_meta_data['chamada_id'][0]; ?>">
		</div>

		<div class="metabox-item">
			<label for="Vagas-input">Vagas:</label>
			<input id="Vagas-input" class="metabox-input" type="number" name="vagas_id"
			value="<?= $curso_meta_data['vagas_id'][0]; ?>">
			<input type="hidden" id="Vagas_Restantes-input" name="vagasrestantes_id" value="">
		</div>
    </div>
    
    */