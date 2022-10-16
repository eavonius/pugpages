<?php
declare(strict_types=1);

namespace PugPages;

//use function Env\env;

/**
 * Renders a pug view.
 */
class ViewRenderer
{
    /**
     * Renders a pug template file.
     *
     * @param   string  $template   The pug template to render.
     * @param   array   $variables  Variables to pass to the template.
     * @return  string
     */
    public static function render(string $template, array $variables) : string
    {
        global $pugPagesOptimized;

        $options = self::getOptions($pugPagesOptimized);

        if ($pugPagesOptimized) {
            return \Phug\Optimizer::call('renderFile', [$template . '.pug', $variables], $options);
        } else {
            return \Phug::renderFile($template . '.pug', $variables, $options);
        }
    }

    /**
     * Displays a pug template file.
     *
     * @param string    $template   The pug template to display.
     * @param array     $variables  Variables to pass to the template.
     */
    public static function display(string $template, array $variables)
    {
        global $pugPagesOptimized;

        $options = self::getOptions($pugPagesOptimized);

        if ($pugPagesOptimized) {
            \Phug\Optimizer::call('displayFile', [$template . '.pug', $variables], $options);
        } else {
            \Phug::displayFile($template . '.pug', $variables, $options);
        }
    }

    /**
     * Retrieves an array of options for pug rendering.
     * 
     * @param   bool    $optimized  True if pug templates have been optimized by pre-compiling to cache.
     * @return  array
     */
    private static function getOptions($optimized) : array
    {
        global $pugPagesThemeDir;

        $options = [
            'strict' => true,
            'debug' => true,
            'cache' => false,
            'expressionLanguage' => 'php',
            'paths' => [$pugPagesThemeDir . '/views/', $pugPagesThemeDir . '/pages/'],
        ];
        
        if ($optimized) {
            $options['pretty'] = false;
            $options['debug'] = false;
            //$options['up_to_date_check'] = false;
            $options['cache'] = $pugPagesThemeDir . '/pug_cache/';
        }

        return $options;
    }
}
