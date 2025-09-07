<form role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>" class="relative w-full md:w-auto">
    <input type="search" name="s" value="<?php echo get_search_query(); ?>" placeholder="دنبال چی می‌گردی؟"
        class="header-search w-full md:w-80 pr-10 pl-3 py-2 rounded-full bg-[#FF8C42] text-[#E0E1DD] text-sm focus:outline-none placeholder-[#E0E1DD]" />
    <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2" aria-label="جستجو">
        <!-- آیکون ذره‌بین برای دکمه جستجو -->
        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 md:w-5 md:h-5 text-[#E0E1DD]" fill="currentColor"
            viewBox="0 0 24 24">
            <path
                d="M10 2a8 8 0 105.293 14.293l4.707 4.707 1.414-1.414-4.707-4.707A8 8 0 0010 2zm0 2a6 6 0 110 12A6 6 0 0110 4z" />
        </svg>
    </button>
</form>