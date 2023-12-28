<?php

use Illuminate\Support\Facades\Facade;

return [

    /*
    |--------------------------------------------------------------------------
    | Application Name
    |--------------------------------------------------------------------------
    |
    | This value is the name of your application. This value is used when the
    | framework needs to place the application's name in a notification or
    | any other location as required by the application or its packages.
    |
    */

    'name' => env('APP_NAME', 'SL-Projects'),

    /*
    |--------------------------------------------------------------------------
    | Application Environment
    |--------------------------------------------------------------------------
    |
    | This value determines the "environment" your application is currently
    | running in. This may determine how you prefer to configure various
    | services the application utilizes. Set this in your ".env" file.
    |
    */

    'env' => env('APP_ENV', 'production'),

    /*
    |--------------------------------------------------------------------------
    | Application Debug Mode
    |--------------------------------------------------------------------------
    |
    | When your application is in debug mode, detailed error messages with
    | stack traces will be shown on every error that occurs within your
    | application. If disabled, a simple generic error page is shown.
    |
    */

    'debug' => (bool)env('APP_DEBUG', false),

    /*
    |--------------------------------------------------------------------------
    | Application URL
    |--------------------------------------------------------------------------
    |
    | This URL is used by the console to properly generate URLs when using
    | the Artisan command line tool. You should set this to the root of
    | your application so that it is used when running Artisan tasks.
    |
    */

    'http_protocol' => env('HTTP_PROTOCOL', 'https'),
    'domain' => [
        'showcase' => env('SHOWCASE_DOMAIN', 'sl-projects.com'),
        'api' => env('API_DOMAIN', 'api.sl-projects.com'),
        'blog' => env('BLOG_DOMAIN', 'blog.sl-projects.com'),
        'dashboard' => env('DASHBOARD_DOMAIN', 'dashboard.sl-projects.com'),
        'auth' => env('AUTH_DOMAIN', 'auth.sl-projects.com'),
        'sofianelasri' => env('SOFIANELASRI_DOMAIN', 'sofianelasri.fr'),
    ],

    'url' => env('APP_URL', 'https://sl-projects.com'), // Only used by Ziggy to force it to use https
    'asset_url' => env('ASSET_URL'),

    /*
    |--------------------------------------------------------------------------
    | Application Timezone
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default timezone for your application, which
    | will be used by the PHP date and date-time functions. We have gone
    | ahead and set this to a sensible default for you out of the box.
    |
    */

    'timezone' => 'UTC',

    /*
    |--------------------------------------------------------------------------
    | Application Locale Configuration
    |--------------------------------------------------------------------------
    |
    | The application locale determines the default locale that will be used
    | by the translation service provider. You are free to set this value
    | to any of the locales which will be supported by the application.
    |
    */

    'locale' => 'fr',

    /*
    |--------------------------------------------------------------------------
    | Application Fallback Locale
    |--------------------------------------------------------------------------
    |
    | The fallback locale determines the locale to use when the current one
    | is not available. You may change the value to correspond to any of
    | the language folders that are provided through your application.
    |
    */

    'fallback_locale' => 'en-US',

    /*
    |--------------------------------------------------------------------------
    | Faker Locale
    |--------------------------------------------------------------------------
    |
    | This locale will be used by the Faker PHP library when generating fake
    | data for your database seeds. For example, this will be used to get
    | localized telephone numbers, street address information and more.
    |
    */

    'faker_locale' => 'fr_FR',

    /*
    |--------------------------------------------------------------------------
    | Encryption Key
    |--------------------------------------------------------------------------
    |
    | This key is used by the Illuminate encrypter service and should be set
    | to a random, 32 character string, otherwise these encrypted strings
    | will not be safe. Please do this before deploying an application!
    |
    */

    'key' => env('APP_KEY'),

    'cipher' => 'AES-256-CBC',

    /*
    |--------------------------------------------------------------------------
    | Maintenance Mode Driver
    |--------------------------------------------------------------------------
    |
    | These configuration options determine the driver used to determine and
    | manage Laravel's "maintenance mode" status. The "cache" driver will
    | allow maintenance mode to be controlled across multiple machines.
    |
    | Supported drivers: "file", "cache"
    |
    */

    'maintenance' => [
        'driver' => 'file',
        // 'store'  => 'redis',
    ],

    /*
    |--------------------------------------------------------------------------
    | Autoloaded Service Providers
    |--------------------------------------------------------------------------
    |
    | The service providers listed here will be automatically loaded on the
    | request to your application. Feel free to add your own services to
    | this array to grant expanded functionality to your applications.
    |
    */

    'providers' => [

        /*
         * Laravel Framework Service Providers...
         */
        Illuminate\Auth\AuthServiceProvider::class,
        Illuminate\Broadcasting\BroadcastServiceProvider::class,
        Illuminate\Bus\BusServiceProvider::class,
        Illuminate\Cache\CacheServiceProvider::class,
        Illuminate\Foundation\Providers\ConsoleSupportServiceProvider::class,
        Illuminate\Cookie\CookieServiceProvider::class,
        Illuminate\Database\DatabaseServiceProvider::class,
        Illuminate\Encryption\EncryptionServiceProvider::class,
        Illuminate\Filesystem\FilesystemServiceProvider::class,
        Illuminate\Foundation\Providers\FoundationServiceProvider::class,
        Illuminate\Hashing\HashServiceProvider::class,
        Illuminate\Mail\MailServiceProvider::class,
        Illuminate\Notifications\NotificationServiceProvider::class,
        Illuminate\Pagination\PaginationServiceProvider::class,
        Illuminate\Pipeline\PipelineServiceProvider::class,
        Illuminate\Queue\QueueServiceProvider::class,
        Illuminate\Redis\RedisServiceProvider::class,
        Illuminate\Auth\Passwords\PasswordResetServiceProvider::class,
        Illuminate\Session\SessionServiceProvider::class,
        Illuminate\Translation\TranslationServiceProvider::class,
        Illuminate\Validation\ValidationServiceProvider::class,
        Illuminate\View\ViewServiceProvider::class,

        /*
         * Package Service Providers...
         */

        /*
         * Application Service Providers...
         */
        App\Providers\AppServiceProvider::class,
        App\Providers\AuthServiceProvider::class,
        // App\Providers\BroadcastServiceProvider::class,
        App\Providers\EventServiceProvider::class,
        App\Providers\RouteServiceProvider::class,
        App\Providers\FortifyServiceProvider::class,
        \Intervention\Image\ImageServiceProvider::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Class Aliases
    |--------------------------------------------------------------------------
    |
    | This array of class aliases will be registered when this application
    | is started. However, feel free to register as many as you wish as
    | the aliases are "lazy" loaded so they don't hinder performance.
    |
    */

    'aliases' => Facade::defaultAliases()->merge([
        'Image' => \Intervention\Image\Facades\Image::class,
    ])->toArray(),

    /*
    |--------------------------------------------------------------------------
    | Steam API Key
    |--------------------------------------------------------------------------
    |
    | La clé Steam API Key permet d'accéder aux api web de Steam.
    |
    */

    'steam_api_key' => env('STEAM_API_KEY', '19861735D9918C1C70EF003D732EEC79'),

    /*
    |--------------------------------------------------------------------------
    | SteamID64
    |--------------------------------------------------------------------------
    |
    | Le Steam ID permet d'identifier le compte qui sera utilisé pour la
    | vitrine des projets.
    |
    */

    'steam_profile_id64' => env('STEAM_PROFILE_ID64', '76561198148455403'),
    'steam_profile_avatar_hash' => env('STEAM_PROFILE_AVATAR_HASH', 'ee6f9c9ffd6bb2fd2114a378f3f03d997f79e4b9'),

    /*
    |--------------------------------------------------------------------------
    | FileUpload Images
    |--------------------------------------------------------------------------
    |
    | Définition des différentes tailles d'images.
    |
    */

    'fileupload' => [
        'images' => [
            'thumbnail' => [
                'width' => 256,
                'height' => 256,
                'quality' => 75,
                'format' => 'webp',
            ],
            'small' => [
                'width' => 512,
                'height' => 512,
                'quality' => 80,
                'format' => 'webp',
            ],
            'medium' => [
                'width' => 1024,
                'height' => 1024,
                'quality' => 80,
                'format' => 'webp',
            ],
            'large' => [
                'width' => 1920,
                'height' => 1920,
                'quality' => 90,
                'format' => 'webp',
            ],
            'original' => [
                'width' => null,
                'height' => null,
                'quality' => 99,
                'format' => 'webp',
            ],
        ],
        'excluded_image_types' => [
            'image/gif',
            'image/svg+xml',
            'image/vnd.adobe.photoshop'
        ],
        'max_size' => 50, // In MB
        'folder_cache_key' => 'fileupload_folders.',
        'cache_max_age' => 60 * 60 * 24 * 365, // 1 year
    ],

    /*
    |--------------------------------------------------------------------------
    | Legacy Browser Support
    |--------------------------------------------------------------------------
    |
    | Définition des différentes versions de navigateurs supportées.
    | Modern est basé sur le support de la propriété CSS 'aspect-ratio' et des images avif.
    | Legacy est basé sur le support officiel de la propriété CSS 'flex'.
    | 'others' est au format 'dd/mm/yyyy' et représente une date safe pour le support
    |
    */

    'browser_support' => [
        'legacy' => [
            'chrome' => 21,
            'edge' => 12,
            'firefox' => 28,
            'ie' => null,
            'opera' => 12.1,
            'safari' => 6.1,
            'others' => '01/04/2014',
        ],
        'modern' => [
            'chrome' => 88,
            'edge' => 88,
            'firefox' => 93,
            'ie' => null,
            'opera' => 74,
            'safari' => 17,
            'others' => '01/10/2021',
        ],
    ]

];
