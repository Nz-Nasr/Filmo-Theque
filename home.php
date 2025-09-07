<?php get_header(); ?>

<main class="max-w-screen-xl mx-auto px-4 py-8">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

        <?php
        // کوئری وردپرس برای گرفتن 6 پست آخر به ترتیب قدیمی به جدید
        $blog_query = new WP_Query([
            'post_type'      => 'post', // فقط پست‌های استاندارد وردپرس
            'posts_per_page' => 6,
            'order'          => 'ASC',
        ]);

        // چک می‌کنیم ببینیم کوئری پستی برای نمایش داره یا نه
        if ($blog_query->have_posts()) {
            // حلقه برای پردازش هر پست
            foreach ($blog_query->posts as $post) {
                setup_postdata($post); ?>

                <a href="<?php the_permalink(); ?>" class="block group">
                    <div class="bg-[#E0E1DD] rounded-[40px] border-2 border-[#FF8C42] overflow-hidden shadow-md transition-transform duration-300 group-hover:scale-105">

                        <?php if (has_post_thumbnail()) {
                            // اگه پست تصویر شاخص داشت، نمایشش می‌دیم
                        ?>
                            <img src="<?php the_post_thumbnail_url('medium_large'); ?>" alt="<?php the_title(); ?>"
                                class="w-full h-56 sm:h-80 object-cover rounded-t-[40px] border-b-2 border-[#FF8C42]">
                        <?php } else { ?>
                            <img src="https://placehold.co/600x400" alt="no-image"
                                class="w-full h-56 sm:h-80 object-cover rounded-t-[40px] border-b-2 border-[#FF8C42]">
                        <?php } ?>

                        <div class="p-6 text-right">
                            <h2 class="text-2xl font-bold text-[#0D1B2A] mb-4"><?php the_title(); ?></h2>
                            <p class="text-lg text-[#0D1B2A] leading-relaxed">
                                <!-- چکیده پست (20 کلمه) -->
                                <?php echo wp_trim_words(get_the_excerpt(), 20, '...'); ?>
                            </p>
                        </div>

                    </div>
                </a>

            <?php }
            wp_reset_postdata();
        } else { ?>
            <p class="text-center text-xl">هیچ پستی پیدا نشد.</p>
        <?php } ?>

    </div>
</main>

<?php get_footer(); ?>