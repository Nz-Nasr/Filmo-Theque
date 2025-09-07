<?php get_header() ?>
<div class="mt-10 max-w-5xl mx-auto px-5">

    <div class="text-lg leading-relaxed text-justify space-y-8 text-[#0D1B2A]">
        <?php the_content(); ?>
    </div>

    <h1 class="text-4xl font-bold my-10 text-[#0D1B2A]">
        <?php the_title(); ?>
    </h1>

    <div class="contact-form-wrapper max-w-[900px] mx-auto">
        <?php echo do_shortcode('[contact-form-7 id="9b92da4" title="فرم تماس"]'); ?>
        <!-- کدکوتاه پلاگین Contact Form 7 برای نمایش فرم تماس -->
    </div>

</div>
<?php get_footer() ?>