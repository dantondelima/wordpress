<?php get_header(); ?>
    
<?php 
    if(have_posts()){
        while(have_posts()) {
            the_post();
?>
    <?php the_post_thumbnail('full') ?>
    <h2><?php the_title() ?></h2>
    <?php the_content() ?>
    <?php $curso_meta_data = get_post_meta($post->ID); ?>
    <style>
        .single-curso-info{
            margin-left:50px;
        }
    </style>
    <dl class="single-curso-info">
        
        <dt>Gratuito:</dt>
        <dd>
            <?php if ($curso_meta_data['gratuito_id'][0]) {
                echo 'Sim.';
            } else{
                echo 'Não.';
            } ?>
        </dd>    
        <?php if (!($curso_meta_data['gratuito_id'][0])): ?>
        <dt>Preço: </dt>
                <dd>R$ <?= $curso_meta_data['preco_id'][0] ?></dd>
            <?php endif ?>
        <dt>Chamada:</dt>
        <dd><?= $curso_meta_data['chamada_id'][0] ?></dd>
        <dt>Vagas:</dt>
        <dd><?= $curso_meta_data['vagas_id'][0] ?></dd>
        <dd>Vagas restantes: <?= $curso_meta_data['vagasrestantes_id'][0] ?></dd>
    </dl>
    <form method="POST" action="<?= get_site_url().'/formulario-de-inscricao/'?>">
        <input type="hidden" name="post_id" value="<?=$post->ID?>"/>
        <input type="hidden" name="preço" value="<?= $curso_meta_data['preco_id'][0] ?>"/>
        <input type="hidden" name="gratuito" value="<?= $curso_meta_data['gratuito_id'][0] ?>"/>
        <input type="submit" class="btn btn-primary" <?= (!$curso_meta_data['vagasrestantes_id'][0] < 0) ? 'disabled' : '' ?> value="Inscrição"/>
    </form>

<?php 
        }
    }
?>
<?php get_footer(); ?>