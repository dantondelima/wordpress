<?php get_header(); ?>
    
<?php 
    if(have_posts()){
        while(have_posts()) {
            the_post();
?>
    <?php the_post_thumbnail('full') ?>
    <h2><?php the_title() ?></h2>
    <?php the_content() ?>

<?php 
        }
    }
?>
<?php get_footer(); ?>