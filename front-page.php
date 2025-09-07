<?php
get_header();
?>

<main>

    <?php
    // یه آرایه خالی برای ذخیره اطلاعات اسلایدها (تصویر و لینک) درست می‌کنیم
    $slides = [];
    // یه کوئری وردپرس برای گرفتن 5 تا فیلم آخر به ترتیب تاریخ (قدیمی به جدید)
    $films_query = new WP_Query([
        'post_type'      => 'film', // فقط پست‌های نوع film
        'posts_per_page' => 5,
        'orderby'        => 'date',
        'order'          => 'ASC',
    ]);

    // چک می‌کنیم ببینیم کوئری پستی برای نمایش داره یا نه
    if ($films_query->have_posts()) {
        while ($films_query->have_posts()) {
            $films_query->the_post();
            // اطلاعات تصویر و لینک هر پست رو به آرایه اسلایدها اضافه می‌کنیم
            $slides[] = [
                'img'  => has_post_thumbnail()
                    ? get_the_post_thumbnail_url(get_the_ID(), 'full')
                    : get_template_directory_uri() . "/assets/images/films/" . sanitize_title(get_the_title()) . ".jpg",
                'link' => get_permalink()
            ];
        }
        wp_reset_postdata();
        // داده‌های کوئری رو ریست می‌کنیم تا حلقه‌های بعدی به مشکل نخورن
    } else {
        $slides[] = ['img' => get_template_directory_uri() . "/assets/images/films/default.jpg", 'link' => '#'];
        // اگه هیچ پستی نبود، یه اسلاید پیش‌فرض اضافه می‌کنیم
    }

    // متغیرهایی برای مدیریت اسلایدر هیرو: اسلاید فعلی، قبلی و بعدی
    $cur = 0;
    $prev = (count($slides) + $cur - 1) % count($slides);
    $next = ($cur + 1) % count($slides);
    ?>

    <section class="relative w-full max-w-[1440px] mx-auto py-8">
        <!-- کانتینر اسلایدر با ارتفاع‌های مختلف برای موبایل، تبلت و دسکتاپ -->
        <div class="relative mx-auto max-w-[1216px] h-[260px] sm:h-[360px] md:h-[480px] xl:h-[684px] overflow-hidden">

            <!-- اسلاید قبلی (فقط تو دسکتاپ نمایش داده می‌شه) -->
            <a id="heroPrev" href="<?php echo $slides[$prev]['link']; ?>">
                <img src="<?php echo $slides[$prev]['img']; ?>"
                    class="hidden md:block absolute right-0 top-1/2 -translate-y-1/2 w-4/12 h-3/4 object-cover rounded-[40px] opacity-50 translate-x-6 z-[5] pointer-events-none">
            </a>

            <!-- اسلاید فعلی (اصلی) که وسط صفحه نمایش داده می‌شه -->
            <a id="heroCurrent" href="<?php echo $slides[$cur]['link']; ?>">
                <img src="<?php echo $slides[$cur]['img']; ?>"
                    class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 w-full sm:w-10/12 md:w-8/12 lg:w-9/12 h-5/6 object-cover rounded-[50px] shadow-lg z-[10]">
            </a>

            <!-- اسلاید بعدی (فقط تو دسکتاپ نمایش داده می‌شه) -->
            <a id="heroNext" href="<?php echo $slides[$next]['link']; ?>">
                <img src="<?php echo $slides[$next]['img']; ?>"
                    class="hidden md:block absolute left-0 top-1/2 -translate-y-1/2 w-4/12 h-3/4 object-cover rounded-[40px] opacity-50 -translate-x-6 z-[5] pointer-events-none">
            </a>

            <button id="prevSlide" class="absolute left-4 top-1/2 -translate-y-1/2 w-12 h-12 rounded-full 
                bg-[#0D1B2A] text-[#FF8C42] text-4xl flex items-center justify-center">
                ›
            </button>

            <button id="nextSlide" class="absolute right-4 top-1/2 -translate-y-1/2 w-12 h-12 rounded-full 
                bg-[#0D1B2A] text-[#FF8C42] text-2xl flex items-center justify-center">
                ‹
            </button>

            <!-- یه بخش مخفی برای ذخیره تمام تصاویر اسلایدر (برای جاوااسکریپت) -->
            <div id="heroSources" class="hidden">
                <?php foreach ($slides as $s): ?>
                    <img class="hero-src" src="<?php echo $s['img']; ?>" data-link="<?php echo $s['link']; ?>">
                <?php endforeach; ?>
            </div>

        </div>
    </section>

    <section class="max-w-[1216px] mx-auto px-4 py-12">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-[#0D1B2A]">فیلم‌های پیشنهادی</h2>

            <div class="flex gap-2">
                <button
                    class="film-prev w-10 h-10 flex items-center justify-center bg-[#0D1B2A] rounded-full text-[#FF8C42] text-2xl">‹</button>
                <button
                    class="film-next w-10 h-10 flex items-center justify-center bg-[#0D1B2A] rounded-full text-[#FF8C42] text-2xl">›</button>
            </div>

        </div>

        <div class="film-slider flex gap-4 overflow-x-auto overflow-y-hidden scroll-smooth">
            <!-- اسلایدر فیلم‌ها با قابلیت اسکرول افقی -->
            <?php
            // کوئری برای گرفتن 15 فیلم آخر
            $films = new WP_Query([
                'post_type' => 'film',
                'posts_per_page' => 15,
                'orderby' => 'date',
                'order' => 'ASC',
            ]);
            if ($films->have_posts()):
                while ($films->have_posts()): $films->the_post(); ?>
                    <a href="<?php the_permalink(); ?>" class="block w-[180px] shrink-0">
                        <img src="<?php echo get_poster_image(get_the_ID()); ?>"
                            class="w-full h-[260px] object-cover rounded-xl" />
                        <!-- تصویر پوستر فیلم رو با تابع سفارشی get_poster_image می‌گیریم -->
                        <p class="mt-2 text-center text-[#0D1B2A] h-6"><?php the_title(); ?></p>
                    </a>
            <?php endwhile;
                wp_reset_postdata();
            endif; ?>
        </div>

        <div class="flex justify-center mt-6">
            <a href="<?php echo get_post_type_archive_link('film'); ?>"
                class="w-36 h-10 px-4 py-1.5 rounded-3xl outline outline-2 outline-[#0D1B2A] flex justify-center items-center hover:bg-[#EAEAEA] transition">
                <span class="text-[#0D1B2A]">مشاهده همه</span>
            </a>
        </div>

    </section>

    <section class="max-w-[1216px] mx-auto px-4 py-12">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-[#0D1B2A]">سریال‌های پیشنهادی</h2>

            <div class="flex gap-2">
                <button
                    class="series-prev w-10 h-10 flex items-center justify-center bg-[#0D1B2A] rounded-full text-[#FF8C42] text-2xl">‹</button>
                <button
                    class="series-next w-10 h-10 flex items-center justify-center bg-[#0D1B2A] rounded-full text-[#FF8C42] text-2xl">›</button>
            </div>

        </div>

        <div class="series-slider flex gap-4 overflow-x-auto overflow-y-hidden scroll-smooth">
            <?php
            $series = new WP_Query([
                'post_type' => 'series',
                'posts_per_page' => 15,
                'orderby' => 'date',
                'order' => 'ASC',
            ]);
            if ($series->have_posts()):
                while ($series->have_posts()): $series->the_post(); ?>
                    <a href="<?php the_permalink(); ?>" class="block w-[180px] shrink-0">
                        <img src="<?php echo get_poster_image(get_the_ID()); ?>"
                            class="w-full h-[260px] object-cover rounded-xl" />
                        <p class="mt-2 text-center text-[#0D1B2A] h-6"><?php the_title(); ?></p>
                    </a>
            <?php endwhile;
                wp_reset_postdata();
            endif; ?>
        </div>

        <div class="flex justify-center mt-6">
            <a href="<?php echo get_post_type_archive_link('series'); ?>"
                class="w-36 h-10 px-4 py-1.5 rounded-3xl outline outline-2 outline-[#0D1B2A] flex justify-center items-center hover:bg-[#EAEAEA] transition">
                <span class="text-[#0D1B2A]">مشاهده همه</span>
            </a>
        </div>

    </section>

    <section class="max-w-[1216px] mx-auto px-4 pt-12 pb-24">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-[#0D1B2A]">انیمیشن‌های پیشنهادی</h2>

            <div class="flex gap-2">
                <button
                    class="animation-prev w-10 h-10 flex items-center justify-center bg-[#0D1B2A] rounded-full text-[#FF8C42] text-2xl">‹</button>
                <button
                    class="animation-next w-10 h-10 flex items-center justify-center bg-[#0D1B2A] rounded-full text-[#FF8C42] text-2xl">›</button>
            </div>

        </div>

        <div class="animation-slider flex gap-4 overflow-x-auto overflow-y-hidden scroll-smooth">
            <?php
            $animations = new WP_Query([
                'post_type' => 'animation',
                'posts_per_page' => 15,
                'orderby' => 'date',
                'order' => 'ASC',
            ]);
            if ($animations->have_posts()):
                while ($animations->have_posts()): $animations->the_post(); ?>
                    <a href="<?php the_permalink(); ?>" class="block w-[180px] shrink-0">
                        <img src="<?php echo get_poster_image(get_the_ID()); ?>"
                            class="w-full h-[260px] object-cover rounded-xl" />
                        <p class="mt-2 text-center text-[#0D1B2A] h-6"><?php the_title(); ?></p>
                    </a>
            <?php endwhile;
                wp_reset_postdata();
            endif; ?>
        </div>

        <div class="flex justify-center mt-6">
            <a href="<?php echo get_post_type_archive_link('animation'); ?>"
                class="w-36 h-10 px-4 py-1.5 rounded-3xl outline outline-2 outline-[#0D1B2A] flex justify-center items-center hover:bg-[#EAEAEA] transition">
                <span class="text-[#0D1B2A]">مشاهده همه</span>
            </a>
        </div>

    </section>

</main>

<?php get_footer(); ?>