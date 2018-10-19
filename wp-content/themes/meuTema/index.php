<?php get_header(); ?> 
        
<?php 

    $args = array('post_type' => 'treinamento');
    $loop = new WP_query($args);
    if($loop->have_posts()) :
        while( $loop->have_posts()) :
            $loop->the_post();
?> 
<div style="border: 1px solid black">
    <a href="<?= the_permalink() ?>">
    <?php the_post_thumbnail('thumbnail'); ?>
    <h2><?php the_title(); ?></h2>
    </a>
</div> 
<?php            
        endwhile;
    endif;
?>
    
<?php get_footer(); ?>
