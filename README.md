# pugpages

Pugpages is a simple framework for using a pattern in wordpress websites similar to ASP.NET [Razor Pages](https://learn.microsoft.com/en-us/aspnet/core/razor-pages/?view=aspnetcore-6.0&tabs=visual-studio), but using open source php technologies.

Models can be any php object, but [Timber](https://upstatement.com/timber/) works especially well.

Views are created using [phug](https://phug-lang.com/) which is a derivative of the [pug](https://pugjs.org/api/getting-started.html) markup language originally created for use with JavaScript - adapted for php.

# Getting Started

Pugpages was used with a wordpress site created with [roots bedrock](https://roots.io/bedrock/), though it may be used in any wordpress website with adaptation.

Your site must be using a custom wordpress theme into which you can add code that works with pugpages.

## Installation

1. Use [composer](https://getcomposer.org/) to install pugpages into your wordpress website:

   ```bash
   composer install pugpages/wordpress
   ```

1. In the root directory of your site's theme, edit your `functions.php` file and add the line:

   ```php
   \PugPages\PageLoader::hook(
       get_stylesheet_directory(),
       in_array(env('WP_ENV'), ['staging', 'production'])
   );
   ```

   > NOTE: This "hooks" pugpages into your theme. The staging and production check turns off [pug optimizations](https://phug-lang.com/#usage) unless you're running in a staging or production environment so things refresh faster during development.

1. Create a `pages` subdirectory of your site's theme. This is where you'll put source code for pug vies and their corresponding page model files.

## Use

TODO
