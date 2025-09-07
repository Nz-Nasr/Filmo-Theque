<?php get_header(); ?>

<main class="max-w-screen-lg mx-auto px-4 py-8">

    <h1 class="text-2xl font-bold mb-10">
        نتایج جستجو برای: "<?php echo get_search_query(); ?>"
    </h1>

    <?php if (have_posts()) : ?>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-6">
            <!-- گرید نتایج جستجو با تعداد ستون‌های متفاوت برای موبایل و دسکتاپ -->
            <?php while (have_posts()) : the_post();
                // حلقه وردپرس برای نمایش تک‌تک نتایج
            ?>
                <?php
                $poster_url = get_poster_image(get_the_ID());
                ?>
                <a href="<?php the_permalink(); ?>" class="block group">
                    <div class="overflow-hidden rounded-2xl shadow-md">
                        <img src="<?php echo esc_url($poster_url); ?>" alt="<?php the_title(); ?>"
                            class="w-full h-64 object-cover group-hover:scale-105 transition-transform duration-300">
                    </div>
                    <h2 class="mt-2 text-center text-base font-medium text-[#0D1B2A] group-hover:text-[#FF8C42]">
                        <?php the_title(); ?>
                    </h2>
                </a>
            <?php endwhile; ?>
        </div>

        <div class="mt-10 mb-6 flex justify-center">
            <?php
            echo paginate_links([
                'mid_size'  => 2,
                'prev_text' => '« قبلی',
                'next_text' => 'بعدی »',
                'before_page_number' => '<span class="px-3 py-1 rounded-md">',
                'after_page_number'  => '</span>',
            ]);
            ?>
        </div>

    <?php else : ?>
        <p>چیزی پیدا نشد!</p>
    <?php endif; ?>

</main>

<style>
    .page-numbers {
        display: inline-block;
        margin: 0 4px;
        padding: 6px 12px;
        border-radius: 8px;
        background: #0D1B2A;
        color: #E0E1DD;
        text-decoration: none;
        font-size: 14px;
    }

    .page-numbers:hover {
        background: #FF8C42;
        color: #E0E1DD;
    }

    .page-numbers.current {
        background: #FF8C42;
        color: #E0E1DD;
        font-weight: bold;
    }
</style>

<?php get_footer(); ?>