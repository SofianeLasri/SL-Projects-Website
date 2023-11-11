<?php

namespace App\Services;

use Carbon\Carbon;
use hisorange\BrowserDetect\Parser as Browser;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class BrowserSupport
{
    protected static int $cacheTime = 86400;

    /**
     * Get the browser support status based on official flexbox support (legacy) and aspect-ratio support (modern).
     * @return string modern|legacy|antique
     */
    public static function getStatus(): string
    {
        $cacheKey = 'browser_support' . Str::slug(Browser::browserFamily() . Browser::browserVersionMajor());
        return Cache::remember($cacheKey, self::$cacheTime, function () {
            return self::search();
        });
    }

    /**
     * @return string modern|legacy|antique
     */
    private static function search(): string
    {
        $browser = Browser::browserFamily();
        $version = Browser::browserVersionMajor();

        if (Browser::isBot() || Browser::isIE() || in_array($browser, ['Nokia Browser', 'NetFront'])) {
            return 'antique';
        }

        $browserSupport = config('app.browser_support');

        $isAntique = function ($browserKey) use ($browser, $version, $browserSupport) {
            $legacyVersion = intval($browserSupport['legacy'][$browserKey]);
            $modernVersion = intval($browserSupport['modern'][$browserKey]);

            if ($version < $legacyVersion) {
                return 'antique';
            } elseif ($version < $modernVersion) {
                return 'legacy';
            }

            return 'modern';
        };

        if (Browser::isChrome()) {
            return $isAntique('chrome');
        }

        if (Browser::isFirefox()) {
            return $isAntique('firefox');
        }

        if (Browser::isSafari()) {
            return $isAntique('safari');
        }

        if (Browser::isOpera()) {
            if (Str::contains($browser, 'Opera Mini') && $version >= 4) {
                return 'legacy';
            }
            return $isAntique('opera');
        }

        if (Browser::isEdge()) {
            return $isAntique('edge');
        }

        $cacheKey = 'browsers-versions.agents.' . Str::slug($browser);
        if (!Cache::has($cacheKey)) {
            $browserListIndex = Str::lower($browser);
            if (empty(config('browsers-versions.agents.' . Str::lower($browser)))) {
                $browserListIndex = self::searchBrowserLongName($browser);

                if (empty($browserListIndex)) {
                    return 'modern';
                }
            }

            Cache::put($cacheKey, $browserListIndex, self::$cacheTime);
        } else {
            $browserListIndex = Cache::get($cacheKey);
        }

        $savedBrowserVersionInfos = self::searchBrowserVersion($browserListIndex, $version);

        if ($savedBrowserVersionInfos['release_date'] > Carbon::createFromFormat('d/m/Y', $browserSupport['modern']['release_date'])) {
            return 'modern';
        } elseif ($savedBrowserVersionInfos['release_date'] > Carbon::createFromFormat('d/m/Y', $browserSupport['legacy']['release_date'])) {
            return 'legacy';
        }

        return 'antique';
    }

    /**
     * Search the browser long name in the config file.
     * @param string $browserLongName The browser long name.
     * @return bool|string The browser index in the config file.
     */
    private static function searchBrowserLongName(string $browserLongName): bool|string
    {
        foreach (config('browsers-versions.agents') as $browserIndex => $browser) {
            if (Str::contains(Str::lower($browserLongName), Str::lower($browser['long_name']))) {
                return $browserIndex;
            }
        }
        return "";
    }

    /**
     * Search the browser version in the config file.
     * @param string $browserIndex The browser index in the config file.
     * @param string $version The browser version.
     * @return array The browser version infos.
     */
    private static function searchBrowserVersion(string $browserIndex, string $version): array
    {
        foreach (config('browsers-versions.agents.' . $browserIndex . '.versions') as $browserVersion) {
            if (Str::contains(Str::lower($version), Str::lower($browserVersion))) {
                return $browserVersion;
            }
        }
        return [];
    }
}
