<?php
get_header();

if (have_posts()) : while (have_posts()) : the_post();

        $post_id = get_the_ID();

        $featured = has_post_thumbnail($post_id) ? get_the_post_thumbnail_url($post_id, 'full') : get_template_directory_uri() . '/assets/images/placeholder.jpg';
        $poster_url = function_exists('get_poster_image') ? get_poster_image($post_id) : $featured;

        $duration = get_post_meta($post_id, 'duration', true);
        $imdb     = get_post_meta($post_id, 'imdb_rating', true);
        $director = get_post_meta($post_id, 'director', true);
        $writer   = get_post_meta($post_id, 'writer', true);
        $creator  = get_post_meta($post_id, 'creator', true);
        $actors   = get_post_meta($post_id, 'stars', true);

        $years      = get_the_terms($post_id, 'series_year');
        $genres     = get_the_terms($post_id, 'series_genre');
        $countries  = get_the_terms($post_id, 'production_country');
        $year_text      = $years ? join('، ', wp_list_pluck($years, 'name')) : '';
        $genres_text    = $genres ? join('، ', wp_list_pluck($genres, 'name')) : '';
        $countries_text = $countries ? join('، ', wp_list_pluck($countries, 'name')) : '';

        $summary = get_post_meta($post_id, 'summary', true);
        if (empty($summary)) $summary = get_the_excerpt();
?>

        <section class="relative w-full max-w-[1440px] mx-auto my-16 py-8 px-4 sm:px-6">

            <div class="absolute inset-0 z-0 overflow-hidden">
                <div class="w-full h-full bg-cover bg-center rounded-[20px]"
                    style="background-image: url('<?php echo esc_url($featured); ?>'); filter: blur(4px); opacity:0.5;">
                </div>
            </div>

            <div class="relative z-10 grid lg:grid-cols-12 gap-8 items-start">

                <div class="lg:col-span-4 flex flex-col items-center mt-6 lg:mt-12 mb-8 lg:mb-20">
                    <h1 class="text-[#0D1B2A] text-xl sm:text-2xl font-bold mb-4 text-center lg:hidden"><?php the_title(); ?>
                    </h1>

                    <div
                        class="rounded-[40px] overflow-hidden shadow-lg mb-6 w-3/4 sm:w-2/3 lg:w-full max-w-[380px] max-h-[620px]">
                        <img src="<?php echo esc_url($poster_url); ?>" class="w-full h-auto object-cover max-h-[620px]"
                            alt="<?php the_title_attribute(); ?>">
                    </div>

                    <?php if ($imdb):
                        $imdb_url = get_post_meta($post_id, 'imdb_url', true);
                    ?>

                        <div class="text-[#0D1B2A] text-center max-w-xs">
                            <div class="flex justify-center items-baseline gap-1">
                                <span class="text-3xl font-bold"><?php echo esc_html($imdb); ?></span>
                                <span class="text-lg">/10</span>
                            </div>

                            <?php if ($imdb_url): ?>
                                <a href="<?php echo esc_url($imdb_url); ?>" target="_blank" rel="noopener">
                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo/IMDB.png"
                                        class="w-16 h-auto mx-auto mt-2">
                                </a>

                            <?php else: ?>
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo/IMDB.png"
                                    class="w-16 h-auto mx-auto mt-2">
                            <?php endif; ?>

                        </div>
                    <?php endif; ?>

                </div>

                <div class="lg:col-span-8 text-[#0D1B2A] text-right text-base sm:text-lg space-y-4 lg:mt-16">
                    <h1 class="hidden lg:block text-4xl font-bold mb-6"><?php the_title(); ?></h1>

                    <?php if ($year_text): ?>
                        <div><span class="font-bold">سال تولید:</span> <?php echo esc_html($year_text); ?></div>
                    <?php endif; ?>

                    <?php if ($genres_text): ?>
                        <div><span class="font-bold">ژانر:</span> <?php echo esc_html($genres_text); ?></div>
                    <?php endif; ?>

                    <?php if ($duration): ?>
                        <div><span class="font-bold">زمان:</span> <?php echo esc_html($duration); ?> دقیقه</div>
                    <?php endif; ?>

                    <?php if ($countries_text): ?>
                        <div><span class="font-bold">محصول کشور:</span> <?php echo esc_html($countries_text); ?></div>
                    <?php endif; ?>

                    <?php if ($director): ?>
                        <div><span class="font-bold">کارگردان:</span> <?php echo esc_html($director); ?></div>
                    <?php endif; ?>

                    <?php if ($creator): ?>
                        <div><span class="font-bold">سازنده:</span> <?php echo esc_html($creator); ?></div>
                    <?php endif; ?>

                    <?php if ($writer): ?>
                        <div><span class="font-bold">نویسنده:</span> <?php echo esc_html($writer); ?></div>
                    <?php endif; ?>

                    <?php if ($actors): ?>
                        <div><span class="font-bold">ستارگان:</span> <?php echo esc_html($actors); ?></div>
                    <?php endif; ?>

                    <?php if ($summary): ?>
                        <div class="mt-20 text-justify text-base sm:text-lg">
                            <?php echo wp_kses_post($summary); ?>
                        </div>
                    <?php endif; ?>

                </div>
            </div>

        </section>

<?php
    endwhile;
endif;
?>

<?php
$seasons_raw = get_post_meta($post_id, 'seasons_raw', true);

if (!empty($seasons_raw)) :
    $lines = preg_split("/\r\n|\n|\r/", $seasons_raw);
    // جدا کردن هر خط از متن فصل‌ها
?>
    <section class="w-full max-w-[1440px] mx-auto my-8 px-6">
        <h2 class="text-[#0D1B2A] text-3xl font-bold mb-6 text-right">فصل‌ها و تعداد قسمت‌ها</h2>

        <div class="space-y-4">
            <?php foreach ($lines as $line): ?>
                <?php if ($line !== ''): ?>
                    <div class="w-full rounded-[25px] bg-[#778DA9] text-lg text-[#E0E1DD] p-3 text-right">
                        <?php echo esc_html($line); ?>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>

    </section>

<?php endif; ?>

<section class="w-full max-w-[1440px] mx-auto my-8 px-6">
    <h2 class="text-[#0D1B2A] text-3xl font-bold mb-6 text-right">ثبت نظر</h2>

    <form method="post" class="space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <input type="text" name="comment_name" placeholder="اسم شما:"
                class="w-full rounded-[25px] bg-[#415A77] text-lg text-[#E0E1DD] p-3 text-right placeholder:text-[#E0E1DD] focus:outline-none focus:ring-2 focus:ring-[#0D1B2A]"
                required>
            <input type="email" name="comment_email" placeholder="ایمیل شما:"
                class="w-full rounded-[25px] bg-[#415A77] text-lg text-[#E0E1DD] p-3 text-right placeholder:text-[#E0E1DD] focus:outline-none focus:ring-2 focus:ring-[#0D1B2A]"
                required>
        </div>
        <textarea name="comment_content" placeholder="نظر شما:"
            class="w-full rounded-[25px] bg-[#415A77] text-lg text-[#E0E1DD] p-3 h-32 text-right placeholder:text-[#E0E1DD] focus:outline-none focus:ring-2 focus:ring-[#0D1B2A]"
            required></textarea>

        <button type="submit" class="bg-[#0D1B2A] text-lg text-[#E0E1DD] px-6 py-3 rounded-[25px]">ارسال نظر</button>
    </form>

</section>

<section class="w-full max-w-[1440px] mx-auto my-16 px-6">
    <h2 class="text-[#0D1B2A] text-3xl font-bold mb-6 text-right">نظرات کاربران</h2>

    <div class="space-y-6">
        <?php
        if (
            $_SERVER['REQUEST_METHOD'] === 'POST'
            && !empty($_POST['comment_name'])
            && !empty($_POST['comment_email'])
            && !empty($_POST['comment_content'])
        ) {
            $new_comment = array(
                'comment_post_ID'      => $post_id,
                'comment_author'       => sanitize_text_field($_POST['comment_name']),
                'comment_author_email' => sanitize_email($_POST['comment_email']),
                'comment_content'      => sanitize_textarea_field($_POST['comment_content']),
                'comment_approved'     => 1,
            );
            wp_insert_comment($new_comment);
            echo '<p class="text-green-600 font-semibold">نظر شما با موفقیت ثبت شد.</p>';
        }

        $comments = get_comments(array(
            'post_id' => $post_id,
            'status'  => 'approve'
        ));

        if ($comments) :
            foreach ($comments as $comment) :
        ?>
                <div class="bg-[#778DA9] rounded-[25px] p-4 text-lg text-right">
                    <p class="font-bold text-[#0D1B2A]"><?php echo esc_html($comment->comment_author); ?>:</p>
                    <p class="text-[#0D1B2A] mt-2"><?php echo esc_html($comment->comment_content); ?></p>
                </div>

        <?php
            endforeach;
        else :
            echo '<p class="text-gray-600">هنوز نظری ثبت نشده است.</p>';
        endif;
        ?>

    </div>
</section>

<?php get_footer(); ?>