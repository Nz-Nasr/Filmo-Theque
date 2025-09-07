<?php

function filmotheque_setup()
// تابع برای تنظیمات اولیه قالب
{
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('custom-logo', [
        'height'      => 80,
        'width'       => 80,
        'flex-height' => true,
        'flex-width'  => true,
    ]);

    // ثبت دو منوی ناوبری: منوی اصلی و منوی فوتر
    register_nav_menus([
        'primary' => 'منوی اصلی سایت',
        'footer'  => 'منوی فوتر',
    ]);
}
add_action('after_setup_theme', 'filmotheque_setup');
// این تابع رو به هوک after_setup_theme وصل می‌کنیم تا موقع لود قالب اجرا بشه

function filmotheque_enqueue_assets()
// تابع برای لود استایل‌ها و اسکریپت‌های قالب
{

    // لود فایل استایل اصلی قالب (style.css)
    wp_enqueue_style('filmotheque-style', get_stylesheet_uri());

    // لود Tailwind CSS از CDN (نسخه مرورگر)
    wp_enqueue_script(
        'tailwind',
        'https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4',
        [], // وابستگی نداره
        null, // بدون نسخه خاص
        true // فایل توی فوتر صفحه لود بشه
    );
}
add_action('wp_enqueue_scripts', 'filmotheque_enqueue_assets');
// این تابع رو به هوک wp_enqueue_scripts وصل می‌کنیم تا استایل‌ها و اسکریپت‌ها لود بشن

add_filter('nav_menu_css_class', function ($classes, $item) {
    // به منوهایی که زیرمنو دارن، کلاس‌های اضافی برای استایل می‌ده
    if (in_array('menu-item-has-children', $classes)) {
        $classes[] = 'group relative';
    }
    return $classes;
    // این فیلتر با اولویت ۱۰ اجرا بشه و دو پارامتر بهش داده بشه
}, 10, 2);

add_filter('nav_menu_submenu_css_class', function ($classes) {
    $classes[] = 'absolute hidden group-hover:block right-0 mt-3 p-3 rounded-2xl z-50 bg-[#0D1B2A] shadow-xl min-w-[12rem]';
    return $classes;
}, 10, 3);

// تابع برای اضافه کردن بخش شبکه‌های اجتماعی به Customizer وردپرس
add_action('customize_register', function ($wp_customize) {
    // اضافه کردن یه بخش جدید به اسم شبکه‌های اجتماعی
    $wp_customize->add_section('filmotheque_social', [
        'title'    => 'شبکه‌های اجتماعی',
        'priority' => 160, // اولویت نمایش تو Customizer
    ]);

    // تعریف شبکه‌های اجتماعی
    $socials = [
        'instagram' => 'Instagram',
        'telegram'  => 'Telegram',
        'x'         => 'X (Twitter)',
        'youtube'   => 'YouTube',
        'linkedin'  => 'LinkedIn',
    ];

    // برای هر شبکه اجتماعی یه فیلد تنظیم اضافه کن
    foreach ($socials as $key => $label) {
        $setting_id = 'filmotheque_' . $key;

        // تنظیم برای ذخیره لینک شبکه اجتماعی
        $wp_customize->add_setting($setting_id, [
            'default'           => '',  // مقدار پیش‌فرض خالی
            'sanitize_callback' => 'esc_url_raw', // امن کردن URL وارد شده
        ]);

        // کنترل برای وارد کردن لینک
        $wp_customize->add_control($setting_id, [
            'section' => 'filmotheque_social',
            'label'   => 'لینک ' . $label,
            'type'    => 'url',
        ]);
    }
});

// تابع برای نمایش آیکون‌های شبکه‌های اجتماعی
function filmotheque_social_icons()
{
    $links = [
        // آرایه‌ای از لینک‌های شبکه‌های اجتماعی 
        'instagram' => get_theme_mod('filmotheque_instagram'),
        'telegram'  => get_theme_mod('filmotheque_telegram'),
        'x'         => get_theme_mod('filmotheque_x'),
        'youtube'   => get_theme_mod('filmotheque_youtube'),
        'linkedin'  => get_theme_mod('filmotheque_linkedin'),
    ];

    // برای هر شبکه اجتماعی که لینک داره، یه آیکون نمایش می‌دیم
    foreach ($links as $name => $url) {
        if ($url) {
            echo '<a href="' . esc_url($url) . '" target="_blank" class="text-[#E0E1DD] hover:text-[#FF8C42]">';
            switch ($name) {
                case 'instagram':
                    echo '<svg viewBox="0 0 24 24" class="w-6 h-6" fill="currentColor"><rect x="3" y="3" width="18" height="18" rx="5"></rect><circle cx="12" cy="12" r="4" fill="#0D1B2A"></circle><circle cx="17.5" cy="6.5" r="1.5"></circle></svg>';
                    break;
                case 'telegram':
                    echo '<svg viewBox="0 0 24 24" class="w-6 h-6" fill="currentColor"><path d="M21 6L3 12l5 2 2 5 3-4 5 4 3-13z"></path></svg>';
                    break;
                case 'x':
                    echo '<svg viewBox="0 0 24 24" class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4l16 16M20 4L4 20"></path></svg>';
                    break;
                case 'youtube':
                    echo '<svg viewBox="0 0 24 24" class="w-7 h-7" fill="currentColor"><path d="M21 8c0-2-2-2-2-2H5s-2 0-2 2v8c0 2 2 2 2 2h14s2 0 2-2V8z"></path><path d="M10 9l5 3-5 3z" fill="#0D1B2A"></path></svg>';
                    break;
                case 'linkedin':
                    echo '<svg viewBox="0 0 24 24" class="w-6 h-6" fill="currentColor"><rect x="3" y="3" width="18" height="18" rx="3"></rect><rect x="7" y="10" width="2" height="7" fill="#0D1B2A"></rect><circle cx="8" cy="7" r="1.5" fill="#0D1B2A"></circle><path d="M12 10h2a3 3 0 0 1 3 3v4h-2v-4c0-.6-.4-1-1-1h-2v5h-2v-7h2z" fill="#0D1B2A"></path></svg>';
                    break;
            }
            echo '</a>';
        }
    }
}

function register_film_post_type()
// تابع برای ثبت پست‌تایپ سفارشی فیلم
{
    $labels = array(
        'name' => 'فیلم‌ها',
        'singular_name' => 'فیلم',
        'add_new' => 'افزودن فیلم',
        'add_new_item' => 'افزودن فیلم جدید',
        'edit_item' => 'ویرایش فیلم',
        'new_item' => 'فیلم جدید',
        'view_item' => 'مشاهده فیلم',
        'view_items' => 'مشاهده فیلم‌ها',
        'search_items' => 'جستجوی فیلم‌ها',
        'not_found' => 'هیچ فیلمی یافت نشد',
        'all_items' => 'همه فیلم‌ها',
    );

    // تنظیمات پست‌تایپ فیلم
    $args = array(
        'labels' => $labels,
        'public' => true,
        'has_archive' => true,
        'rewrite' => array('slug' => 'film'),
        'show_in_rest' => true,
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'comments'),
        'show_in_menu' => true,
    );

    // ثبت پست‌تایپ فیلم
    register_post_type('film', $args);
}
add_action('init', 'register_film_post_type');
// این تابع رو به هوک init وصل می‌کنیم تا موقع لود وردپرس اجرا بشه

function register_series_post_type()
{
    $labels = array(
        'name' => 'سریال‌ها',
        'singular_name' => 'سریال',
        'add_new' => 'افزودن سریال',
        'add_new_item' => 'افزودن سریال جدید',
        'edit_item' => 'ویرایش سریال',
        'new_item' => 'سریال جدید',
        'view_item' => 'مشاهده سریال',
        'view_items' => 'مشاهده سریال‌ها',
        'search_items' => 'جستجوی سریال‌ها',
        'not_found' => 'هیچ سریالی یافت نشد',
        'all_items' => 'همه سریال‌ها',
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'has_archive' => true,
        'rewrite' => array('slug' => 'series'),
        'show_in_rest' => true,
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'comments'),
        'show_in_menu' => true,
    );

    register_post_type('series', $args);
}
add_action('init', 'register_series_post_type');

function register_animation_post_type()
{
    $labels = array(
        'name' => 'انیمیشن‌ها',
        'singular_name' => 'انیمیشن',
        'add_new' => 'افزودن انیمیشن',
        'add_new_item' => 'افزودن انیمیشن جدید',
        'edit_item' => 'ویرایش انیمیشن',
        'new_item' => 'انیمیشن جدید',
        'view_item' => 'مشاهده انیمیشن',
        'view_items' => 'مشاهده انیمیشن‌ها',
        'search_items' => 'جستجوی انیمیشن‌ها',
        'not_found' => 'هیچ انیمیشنی یافت نشد',
        'all_items' => 'همه انیمیشن‌ها',
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'has_archive' => true,
        'rewrite' => array('slug' => 'animation'),
        'show_in_rest' => true,
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'comments'),
        'show_in_menu' => true,
    );

    register_post_type('animation', $args);
}
add_action('init', 'register_animation_post_type');

function my_slider_scripts()
// اسکریپت جاوااسکریپت برای اسلایدر هیرو (صفحه اصلی)
{ ?> <script>
        // وقتی صفحه لود شد، این کد اجرا می‌شه
        document.addEventListener("DOMContentLoaded", function() {
            let cur = 0; // متغیر برای نگه داشتن اندیس اسلاید فعلی
            const slides = document.querySelectorAll("#heroSources .hero-src"); // همه تصاویر اسلایدر
            const prevImg = document.querySelector("#heroPrev img");
            const nextImg = document.querySelector("#heroNext img");
            const currImg = document.querySelector("#heroCurrent img");
            const currLink = document.querySelector("#heroCurrent"); // لینک اسلاید فعلی

            // تابع برای نمایش اسلاید با اندیس مشخص
            function show(i) {
                cur = (i + slides.length) % slides.length; // محاسبه اندیس حلقه‌ای
                const prevI = (cur - 1 + slides.length) % slides.length;
                const nextI = (cur + 1) % slides.length;
                currImg.src = slides[cur].src; // تنظیم تصویر فعلی
                prevImg.src = slides[prevI].src;
                nextImg.src = slides[nextI].src;
                currLink.href = slides[cur].dataset.link; // تنظیم لینک اسلاید فعلی
            }
            // کلیک روی دکمه قبلی
            document.getElementById("prevSlide").onclick = e => {
                e.preventDefault(); // جلوگیری از رفتار پیش‌فرض لینک
                show(cur - 1); // نمایش اسلاید قبلی
            };
            // کلیک روی دکمه بعدی
            document.getElementById("nextSlide").onclick = e => {
                e.preventDefault();
                show(cur + 1); // نمایش اسلاید بعدی
            };
            show(cur); // نمایش اسلاید اولیه
            setInterval(() => show(cur + 1), 10000); // تغییر خودکار هر 10 ثانیه
        });
    </script> <?php }
            add_action("wp_footer", "my_slider_scripts");
            // این اسکریپت رو به فوتر وردپرس اضافه می‌کنیم

            // تابع برای گرفتن تصویر پوستر پست
            function get_poster_image($post_id)
            {
                // نوع پست رو می‌گیریم (فیلم، سریال یا انیمیشن)
                $type = get_post_type($post_id);
                // بسته به نوع پست، متای پوستر مربوطه رو می‌گیریم
                if ($type === 'film') {
                    $poster = get_post_meta($post_id, 'poster_image_film', true);
                } elseif ($type === 'series') {
                    $poster = get_post_meta($post_id, 'poster_image_series', true);
                } elseif ($type === 'animation') {
                    $poster = get_post_meta($post_id, 'poster_image_animation', true);
                } else {
                    $poster = '';
                }

                // اگه پوستر وجود داشت، بررسی می‌کنیم که چه نوعیه
                if ($poster) {
                    // اگه پوستر یه لینک مستقیم باشه
                    if (filter_var($poster, FILTER_VALIDATE_URL)) {
                        return esc_url($poster);
                    }
                    if (is_numeric($poster)) {
                        // اگه پوستر یه ID تصویر در وردپرس باشه
                        $url = wp_get_attachment_url($poster);
                        if ($url) return esc_url($url);
                    }
                    if (is_array($poster) && isset($poster['url'])) {
                        // اگه پوستر یه آرایه باشه و کلید 'url' داشته باشه
                        return esc_url($poster['url']);
                    }
                }
                // اگه هیچکدوم نبود، عکس پیش‌فرض نمایش داده میشه
                return get_template_directory_uri() . '/assets/images/placeholder.jpg';
            }

            function my_sections_slider_scripts()
            // اسکریپت جاوااسکریپت برای اسلایدرهای بخش‌های فیلم، سریال و انیمیشن
            { ?>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            // تابع برای تنظیم اسلایدرها
            function setupSlider(containerClass, prevClass, nextClass) {
                const container = document.querySelector(containerClass); // کانتینر اسلایدر
                const prev = document.querySelector(prevClass);
                const next = document.querySelector(nextClass);
                if (!container) return; // اگه کانتینر نبود، خارج می‌شیم

                // رویداد کلیک برای دکمه قبلی
                prev.addEventListener("click", () => {
                    const cardWidth = container.querySelector("a")?.offsetWidth || 200; // عرض کارت
                    container.scrollBy({
                        left: -cardWidth * 5 - 20, // اسکرول به چپ (5 کارت)
                        behavior: "smooth"
                    });
                });
                // رویداد کلیک برای دکمه بعدی
                next.addEventListener("click", () => {
                    const cardWidth = container.querySelector("a")?.offsetWidth || 200;
                    container.scrollBy({
                        left: cardWidth * 5 + 20, // اسکرول به راست (5 کارت)
                        behavior: "smooth"
                    });
                });

            }

            // اسلایدرها رو برای فیلم، سریال و انیمیشن تنظیم می‌کنیم
            setupSlider(".film-slider", ".film-prev", ".film-next");
            setupSlider(".series-slider", ".series-prev", ".series-next");
            setupSlider(".animation-slider", ".animation-prev", ".animation-next");
        });
    </script>

<?php }
            add_action("wp_footer", "my_sections_slider_scripts");
            // این اسکریپت رو به فوتر وردپرس اضافه می‌کنیم

            function filmotheque_hide_section_scrollbars_css()
            // تابع برای مخفی کردن اسکرول‌بارهای اسلایدرها
            {
                $css = <<<CSS
                    .film-slider,
                    .series-slider,
                    .animation-slider {
                    overflow-y: hidden;
                    -ms-overflow-style: none;
                    scrollbar-width: none; /* برای فایرفاکس */
                    }
                    .film-slider::-webkit-scrollbar,
                    .series-slider::-webkit-scrollbar,
                    .animation-slider::-webkit-scrollbar {
                    display: none; /* برای کروم و سافاری */
                    }
                    
                    CSS;
                wp_add_inline_style('filmotheque-style', $css);
                // CSS رو به استایل اصلی قالب اضافه می‌کنیم
            }
            add_action('wp_enqueue_scripts', 'filmotheque_hide_section_scrollbars_css', 20);
            // این تابع رو به هوک wp_enqueue_scripts وصل می‌کنیم

            function register_genres_taxonomies()
            // تابع برای ثبت تکسونومی‌های ژانر
            {
                register_taxonomy(
                    'film_genre',
                    'film',
                    array(
                        'labels' => array(
                            'name'          => 'ژانرهای فیلم',
                            'singular_name' => 'ژانر فیلم',
                        ),
                        'public'        => true, // قابل مشاهده در سایت
                        'hierarchical'  => true, // مثل دسته‌بندی (می‌تونه والد/فرزند داشته باشه)
                        'show_ui'       => true,  // نمایش در داشبورد وردپرس
                        'show_in_rest'  => true, // فعال برای ویرایشگر گوتنبرگ و API
                        'rewrite'       => array('slug' => 'film-genre'), // اسلاگ URL
                    )
                );

                register_taxonomy(
                    'series_genre',
                    'series',
                    array(
                        'labels' => array(
                            'name'          => 'ژانرهای سریال',
                            'singular_name' => 'ژانر سریال',
                        ),
                        'public'        => true,
                        'hierarchical'  => true,
                        'show_ui'       => true,
                        'show_in_rest'  => true,
                        'rewrite'       => array('slug' => 'series-genre'),
                    )
                );

                register_taxonomy(
                    'animation_genre',
                    'animation',
                    array(
                        'labels' => array(
                            'name'          => 'ژانرهای انیمیشن',
                            'singular_name' => 'ژانر انیمیشن',
                        ),
                        'public'        => true,
                        'hierarchical'  => true,
                        'show_ui'       => true,
                        'show_in_rest'  => true,
                        'rewrite'       => array('slug' => 'animation-genre'),
                    )
                );
            }
            add_action('init', 'register_genres_taxonomies');
            // این تابع رو به هوک init وصل می‌کنیم

            function register_year_taxonomy()
            // تابع برای ثبت تکسونومی سال تولید
            {
                register_taxonomy(
                    'animation_year',
                    'animation',
                    array(
                        'labels' => array(
                            'name'          => 'سال تولید',
                            'singular_name' => 'سال تولید',
                        ),
                        'public'        => true,
                        'hierarchical'  => false, // مثل تگ‌ها (بدون سلسله‌مراتب)
                        'show_ui'       => true,
                        'show_in_rest'  => true,
                        'rewrite'       => array('slug' => 'animation-year'),
                    )
                );
                register_taxonomy(
                    'film_year',
                    'film',
                    array(
                        'labels' => array(
                            'name'          => 'سال تولید',
                            'singular_name' => 'سال تولید',
                        ),
                        'public'        => true,
                        'hierarchical'  => false,
                        'show_ui'       => true,
                        'show_in_rest'  => true,
                        'rewrite'       => array('slug' => 'film-year'),
                    )
                );

                register_taxonomy(
                    'series_year',
                    'series',
                    array(
                        'labels' => array(
                            'name'          => 'سال تولید',
                            'singular_name' => 'سال تولید',
                        ),
                        'public'        => true,
                        'hierarchical'  => false,
                        'show_ui'       => true,
                        'show_in_rest'  => true,
                        'rewrite'       => array('slug' => 'series-year'),
                    )
                );
            }
            add_action('init', 'register_year_taxonomy');

            function custom_archive_posts_per_page($query)
            // تابع برای تنظیم تعداد پست‌ها تو صفحات آرشیو
            {
                // فقط تو قسمت کاربری (نه پنل مدیریت) و فقط کوئری اصلی
                if (!is_admin() && $query->is_main_query()) {

                    // برای آرشیو فیلم‌ها، 15 پست در صفحه
                    if (is_post_type_archive('film')) {
                        $query->set('posts_per_page', 15);
                    }

                    if (is_post_type_archive('series')) {
                        $query->set('posts_per_page', 15);
                    }

                    if (is_post_type_archive('animation')) {
                        $query->set('posts_per_page', 15);
                    }
                }
            }
            add_action('pre_get_posts', 'custom_archive_posts_per_page');
            // این تابع رو به هوک pre_get_posts وصل می‌کنیم

            function register_production_country_taxonomy()
            // تابع برای ثبت تکسونومی کشور سازنده
            {
                $labels = array(
                    'name'              => 'محصول کشور',
                    'singular_name'     => 'کشور',
                    'search_items'      => 'جستجوی کشور',
                    'all_items'         => 'همه کشورها',
                    'edit_item'         => 'ویرایش کشور',
                    'update_item'       => 'بروزرسانی کشور',
                    'add_new_item'      => 'افزودن کشور جدید',
                    'new_item_name'     => 'نام کشور جدید',
                    'menu_name'         => 'محصول کشور',
                );

                register_taxonomy(
                    'production_country',
                    array('film', 'series', 'animation'),
                    array(
                        'hierarchical'      => true,
                        'labels'            => $labels, // برچسب‌ها و نام‌ها برای نمایش در داشبورد
                        'show_ui'           => true,
                        'show_in_rest'      => true,
                        'show_admin_column' => true,  // نمایش در ستون مدیریت پست‌ها
                        'public'            => true,
                        'query_var'         => true,  // امکان استفاده در query‌ها
                        'rewrite'           => array('slug' => 'production-country'),
                    )
                );
            }
            add_action('init', 'register_production_country_taxonomy');

            function search_only_custom_post_types($query)
            // تابع برای محدود کردن جستجو به پست‌تایپ‌های سفارشی
            {
                // فقط در قسمت کاربری (نه پنل مدیریت)، فقط کوئری اصلی و فقط وقتی صفحه جستجو هست
                if (!is_admin() && $query->is_main_query() && $query->is_search()) {
                    // جستجو فقط برای فیلم، سریال و انیمیشن
                    $query->set('post_type', array('film', 'series', 'animation'));
                }
            }
            add_action('pre_get_posts', 'search_only_custom_post_types');
            // این تابع رو به هوک pre_get_posts وصل می‌کنیم