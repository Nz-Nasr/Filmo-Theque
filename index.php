<?php get_header(); ?>

<main id="main" class="site-main" class="flex-1">
  <?php
  if (have_posts()) {
    while (have_posts()) {
      the_post();
      echo '<article class="p-4 border-b border-gray-700">';
      the_title('<h2 class="text-xl font-bold mb-2">', '</h2>');
      the_content();
      echo '</article>';
    }
  } else {
    echo '<p class="p-4">هیچ محتوایی پیدا نشد.</p>';
  }
  ?>
</main>

<?php get_footer(); ?>