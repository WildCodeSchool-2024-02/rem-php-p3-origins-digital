<?php

namespace App\Service;

class RoutingUrlService
{
    public function routingUrl(string $url): string
    {
        $url = (trim($url, " "));
        if ($url !== "") {
            $urlParts = parse_url($url);
            if (str_contains($urlParts['host'], "youtube") || str_contains($urlParts['host'], "twitch")) {
                if (str_contains($urlParts['host'], "youtube")) {
                    return "youtube";
                }
                if (str_contains($urlParts['host'], "twitch")) {
                    return "twitch";
                }
            } else {
                return "invalid url";
            }
        }
        return "";
    }
}
