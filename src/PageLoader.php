<?php
namespace PugPages;

/**
 * Loads pug pages from /pages instead of wordpress templates when they exist.
 */
class PageLoader
{
    /**
     * Hooks pug pages into a theme.
     *
     * @param string $themeDir The root directory of the theme.
     * @param string $optimized True if pug templates have been optimized by pre-compiling to cache.
     */
    public static function hook(string $themeDir, bool $optimized = false)
    {
        global $pugPagesThemeDir;
        global $pugPagesOptimized;

        $pugPagesThemeDir = $themeDir;
        $pugPagesOptimized = $optimized;

        add_filter('sidebar_template', function($template) {
            return self::getPageOrTemplate(
                ['/pages/Sidebar.php'],
                $template
            );
        });

        add_filter('index_template', function ($template) {

            return self::getPageOrTemplate(
                ['/pages/Index.php'],
                $template
            );
        });

        add_filter('archive_template', function ($template) {
            $postType = get_post_type();

            return self::getPageOrTemplate(
                ["/pages/{$postType}/Archive.php"],
                $template
            );
        });

        add_filter('single_template', function ($template) {
            $postType = get_post_type();

            return self::getPageOrTemplate(
                ["/pages/{$postType}/Single.php"],
                $template
            );
        });

        add_filter('page_template', function ($template) {
            $postSlug = get_post_field('post_name');
            $postClass = str_replace("-", "", ucwords($postSlug, "-"));

            $pages = ["/pages/{$postClass}.php"];

            if (is_front_page()) {
                array_unshift($pages, "/pages/FrontPage.php");
            }
            
            return self::getPageOrTemplate(
                $pages,
                $template
            );
        });

        add_filter('search_template', function ($template) {
            return self::getPageOrTemplate(
                ["/pages/Search.php"],
                $template
            );
        });

        add_filter('404_template', function ($template) {
            return self::getPageOrTemplate(
                ["/pages/NotFound.php"],
                $template
            );
        });

        add_filter('tag_template', function ($template) {
            return self::getPageOrTemplate(
                ["/pages/tag/Archive.php"],
                $template
            );
        });

        add_filter('home_template', function ($template) {
            return self::getPageOrTemplate(
                ["/pages/post/Archive.php"],
                $template
            );
        });
    }

    private static function getPageOrTemplate($pages, $template)
    {
        global $pugPagesThemeDir;
        global $pugPageTemplatePath;

        $curDir = dirname(__FILE__, 1);

        foreach ($pages as $page) {
            $pagePath = $pugPagesThemeDir . $page;

            if (file_exists($pagePath)) {
                $pugPageTemplatePath = $page;

                return $curDir . '/PageHandler.php';
            }
        }
        return $template;
    }
}
