<?php

function url_reformat($url)
{
    $domain = parse_url($url, PHP_URL_HOST);

    $domainParts = explode('.', $domain);

    if (count($domainParts) == 3 and $domainParts[0] != 'www') {
        // With Subdomain (if not www)
        $domain = $domainParts[0] . '.' .
            $domainParts[count($domainParts) - 2] . '.' . $domainParts[count($domainParts) - 1];
    } else if (count($domainParts) >= 2) {
        // Without Subdomain
        $domain = $domainParts[count($domainParts) - 2] . '.' . $domainParts[count($domainParts) - 1];
    } else {
        // Without http(s)
        $domain = $url;
    }
}
