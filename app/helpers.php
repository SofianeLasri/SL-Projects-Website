<?php

if (!function_exists('getWebsiteUrl')) {
    /**
     * Get the url of a website
     * @param string $websiteName
     * @return string
     */
    function getWebsiteUrl(string $websiteName): string
    {
        return config('app.http_protocol') . "://" . config('app.domain.' . $websiteName);
    }
}
