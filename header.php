<!DOCTYPE html>
<html <?php language_attributes(); ?> dir="rtl">

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <!-- تنظیم کاراکترست سایت که مطمئن بشیم حروف فارسی درست نشون داده می‌شن -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- ریسپانسیو بودن سایت تو دستگاه‌های مختلف (موبایل، تبلت، دسکتاپ) -->
    <link href="https://cdn.jsdelivr.net/gh/rastikerdar/vazir-font@30.1.0/dist/font-face.css" rel="stylesheet"
        type="text/css" />
    <!-- CDN فونت وزیر -->
    <?php wp_head(); ?>
    <!-- تابع وردپرس که چیزای ضروری مثل مثل استایل‌ها، اسکریپت‌ها و متا تگ‌های قالب رو تو هدر لود می‌کنه -->
</head>

<body class="flex flex-col min-h-screen bg-[#E0E1DD]">
    <?php wp_body_open(); ?>
    <!-- تابع وردپرس برای اضافه کردن کدهای خاص در ابتدای تگ body -->

    <header class="py-4">
        <div class="max-w-screen-xl mx-auto px-4 flex items-center gap-3">

            <a href="<?php echo esc_url(home_url('/')); ?>"
                class="flex items-center gap-2 bg-[#0D1B2A] text-[#E0E1DD] rounded-full pr-4 pl-3 py-2 shadow-md">
                <?php
                $logo_id = get_theme_mod('custom_logo');
                // چک می‌کنیم ببینیم لوگو تو تنظیمات قالب انتخاب شده یا نه
                if ($logo_id) {
                    // اگه لوگو داشتیم، با تابع وردپرس نشونش می‌دیم
                    echo wp_get_attachment_image($logo_id, 'full', false, array(
                        // false بدون آیتم پیش‌فرض
                        'class' => 'w-8 h-8 object-contain',
                        'alt'   => get_bloginfo('name')
                    ));
                }
                ?>
                <span class="font-medium text-base whitespace-nowrap"><?php bloginfo('name'); ?></span>
            </a>

            <div class="flex-1 hidden md:flex items-center gap-4 bg-[#0D1B2A] rounded-full py-2 pr-4 pl-2 shadow-md">
                <!-- این بخش منوی اصلی و فرم جستجو رو برای دسکتاپ نشون می‌ده (تو موبایل مخفیه) -->
                <nav class="flex-1">
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'primary',
                        // نمایش منوی اصلی که تو وردپرس تنظیم شده
                        'container'      => false,
                        // هیچ <div> اضافی دور منو ایجاد نشه
                        'menu_class'     => 'header-nav flex flex-wrap gap-6',
                    ));
                    ?>
                </nav>
                <div class="shrink-0">
                    <?php get_search_form(); ?>
                </div>
            </div>

            <div class="flex-1 flex items-center justify-end gap-2 md:hidden">
                <!-- بخش موبایل‌‌ها که شامل فرم جستجو و دکمه منوی همبرگری هست -->
                <div class="flex-1">
                    <?php get_search_form(); ?>
                </div>
                <button id="mobile-menu-button"
                    class="p-2 rounded-full bg-[#0D1B2A] text-[#E0E1DD] shadow-md transition-all duration-300">
                    <!-- دکمه منوی همبرگری برای باز کردن منوی موبایل -->
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <!-- آیکون همبرگر برای منوی موبایل -->
                        <path fill-rule="evenodd"
                            d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                            clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>

            <div id="mobile-menu"
                class="fixed top-0 right-0 w-40 h-full bg-[#0D1B2A] p-4 pt-16 transform translate-x-full transition-transform duration-300 md:hidden z-50">
                <!-- منوی کشویی موبایل که به صورت پیش‌فرض مخفیه -->
                <button id="mobile-menu-close" class="absolute top-4 right-4 text-[#E0E1DD] p-2 rounded-full">
                    <!-- دکمه بستن منوی موبایل -->
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                            clip-rule="evenodd"></path>
                    </svg>
                </button>
                <nav class="flex-1">
                    <!-- منوی ناوبری برای موبایل (با آیتم‌های عمودی) -->
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'primary',
                        'container'      => false,
                        'menu_class'     => 'header-nav flex flex-col gap-2',
                    ));
                    ?>
                </nav>
            </div>

        </div>
    </header>

    <style>
        body {
            font-family: 'Vazir', sans-serif;
        }

        .header-nav>li>a {
            padding: 8px 12px;
            border-radius: 999px;
            color: #E0E1DD;
            font-size: 16px;
            text-decoration: none;
        }

        .header-nav>li>a:hover {
            color: #FF8C42;
        }

        .header-nav li.menu-item-has-children>a::after {
            content: "▾";
            font-size: 14px;
            margin-inline-start: 6px;
            color: #FF8C42;
        }

        .header-nav ul.sub-menu li a {
            display: block;
            padding: 8px 12px;
            border-radius: 8px;
            color: #E0E1DD;
            font-size: 14px;
        }

        .header-nav ul.sub-menu li a:hover {
            background: #1B263B;
        }

        .header-search::placeholder {
            color: #E0E1DD;
        }
    </style>

    <script>
        // اسکریپت جاوااسکریپت برای مدیریت منوی موبایل
        document.addEventListener('DOMContentLoaded', () => {
            // منتظر می‌مونیم تا صفحه کامل لود بشه
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');
            // دکمه منوی موبایل و خود منوی موبایل رو انتخاب می‌کنیم

            mobileMenuButton.addEventListener('click', () => {
                // وقتی روی دکمه منوی موبایل کلیک می‌کنیم، منو باز یا بسته می‌شه
                if (mobileMenu.classList.contains('translate-x-full')) {
                    const closeButton = document.getElementById('mobile-menu-close');
                    if (closeButton) {
                        closeButton.style.display = 'none';
                    }
                    mobileMenu.classList.remove('translate-x-full');
                    // اگه منو بسته باشه، دکمه بستن رو مخفی می‌کنیم و منو رو باز می‌کنیم
                } else {
                    mobileMenu.classList.add('translate-x-full');
                    // اگه منو باز باشه، می‌بندیمش
                }
            });
        });
    </script>