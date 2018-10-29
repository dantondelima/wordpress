<?php 

/*
Template Name: cursos
*/
?>

<?php get_header(); ?> 

   <h1 class="jumbotron text-center" style="font-family:verdana; font-size:50px; border-radius:50px;">Lista de treinamentos</h1>
<?php 

    $args = array('post_type' => 'treinamento');
    $loop = new WP_query($args);
    if($loop->have_posts()) :
        while( $loop->have_posts()) :
            $loop->the_post();
?> 
<div style="margin-left:100px;">
    <div class="col-lg-3">
        <a class="btn btn-primary" role="button" href="<?= the_permalink() ?>">
            <?php the_post_thumbnail('thumbnail'); ?>
            <h2><?php the_title(); ?></h2>
        </a>
    </div>
</div> 
<?php            
        endwhile;
    endif;
?>
    
<?php get_footer(); ?>
