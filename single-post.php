<?php get_header(); ?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-12">

    <?php
    if (have_posts()) {
        while (have_posts()) {
            the_post();
    ?>

            <article class="bg-[#E0E1DD] rounded-[40px] border-2 border-[#FF8C42] overflow-hidden shadow-lg p-6 sm:p-10">

                <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-[#0D1B2A] mb-6 sm:mb-10 text-right">
                    <?php the_title(); ?>
                </h1>

                <?php if (has_post_thumbnail()) { ?>
                    <img src="<?php the_post_thumbnail_url('full'); ?>" alt="<?php the_title(); ?>"
                        class="w-full h-auto object-cover rounded-xl mb-6 sm:mb-10">
                <?php } ?>

                <div class="prose max-w-none text-right text-justify text-[#0D1B2A] leading-relaxed text-lg">
                    <?php
                    the_content();
                    ?>
                </div>

            </article>

        <?php
        }
    } else { ?>
        <p class="text-center text-xl">هیچ محتوایی یافت نشد.</p>
    <?php } ?>

</div>

<?php get_footer(); ?>