<?php

if (! function_exists('getWebsiteUrl')) {
    /**
     * Get the url of a website
     */
    function getWebsiteUrl(string $websiteName): string
    {
        return config('app.http_protocol').'://'.config('app.domain.'.$websiteName);
    }
}
