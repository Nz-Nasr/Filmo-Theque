<footer class="bg-[#0D1B2A] text-[#E0E1DD] mt-auto rounded-t-[40px] px-4 py-8 md:px-8">

    <div class="max-w-screen-xl mx-auto flex flex-col md:flex-row md:justify-between md:items-start gap-8 md:gap-12">

        <div class="flex flex-col items-center md:items-start gap-4 text-center md:text-right">
            <div class="flex items-center gap-2">
                <?php
                $logo_id = get_theme_mod('custom_logo');
                if ($logo_id) {
                    echo wp_get_attachment_image($logo_id, 'full', false, array(
                        'class' => 'w-10 h-10 object-contain',
                        'alt'   => get_bloginfo('name')
                    ));
                }
                ?>
                <span class="font-semibold text-2xl"><?php bloginfo('name'); ?></span>
            </div>
            <p class="text-sm font-medium leading-relaxed max-w-xs">
                پیشنهاد فیلم و سریال برای همه سبک‌ها.
            </p>
            <div class="flex gap-4 mt-2">
                <!-- آیکون‌های شبکه‌های اجتماعی رو با یه تابع سفارشی نمایش می‌دیم -->
                <?php if (function_exists('filmotheque_social_icons')) filmotheque_social_icons(); ?>
            </div>
        </div>

        <div class="flex-1 flex flex-col items-center md:items-start md:mt-2">
            <h4 class="font-medium text-lg mb-4 text-[#FF8C42]">دسترسی سریع</h4>
            <nav class="flex flex-col sm:flex-row flex-wrap justify-center md:justify-start gap-4 text-lg">
                <?php
                // آرایه‌ای از لینک‌های مهم
                $footer_links = [
                    'صفحه اصلی'    => home_url('/'),
                    'فیلم'         => home_url('/film'),
                    'سریال'        => home_url('/series'),
                    'انیمیشن'      => home_url('/animation'),
                    'بلاگ'         => home_url('/blog'),
                    'ارتباط با ما'  => home_url('/contact'),
                ];
                foreach ($footer_links as $title => $url) {
                    echo '<a href="' . esc_url($url) . '" class="hover:text-[#FF8C42] transition px-2 sm:px-0">' . esc_html($title) . '</a>';
                }
                ?>
            </nav>
        </div>

        <div class="flex-1 mt-4 md:mt-2">
            <h4 class="font-medium text-lg mb-4 text-[#FF8C42]">مقالات منتخب سردبیر</h4>
            <div class="grid grid-cols-1 gap-y-3 text-base leading-snug">
                <!-- لینک‌های مقالات رو تو یه گرید عمودی نشون می‌دیم -->
                <?php
                // اسلاگ‌های مقالات رو به صورت دستی تعریف کردیم
                $jurassic_slug = 'jurassic-world-rebirth';
                $adolescence_slug = 'adolescence';
                $dune_slug = 'dune';
                $robot_slug = 'the-wild-robot';
                ?>
                <a href="<?php echo esc_url(home_url('/' . $jurassic_slug)); ?>"
                    class="text-[#E0E1DD] hover:text-[#FF8C42]">معرفی و نقد فیلم دنیای ژوراسیک: تولد دوباره.</a>
                <a href="<?php echo esc_url(home_url('/' . $adolescence_slug)); ?>"
                    class="text-[#E0E1DD] hover:text-[#FF8C42]">نوجوانی چطور مینی‌سریالی هست؟</a>
                <a href="<?php echo esc_url(home_url('/' . $dune_slug)); ?>"
                    class="text-[#E0E1DD] hover:text-[#FF8C42]">چه تفاوت‌هایی میان فیلم Dune و رمان تل‌ماسه وجود
                    دارد؟</a>
                <a href="<?php echo esc_url(home_url('/' . $robot_slug)); ?>"
                    class="text-[#E0E1DD] hover:text-[#FF8C42]">مهربانی، مهارتی است برای بقا.</a>
            </div>
        </div>

    </div>

    <div class="text-center text-sm mt-8 border-t border-[#1B263B] pt-4">
        <p>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. تمامی حقوق محفوظ است.</p>
    </div>

    <?php wp_footer(); ?>
    <!-- این تابع وردپرس اسکریپت‌ها و استایل‌های مورد نیاز فوتر (مثل پلاگین‌ها) رو لود می‌کنه -->
</footer>