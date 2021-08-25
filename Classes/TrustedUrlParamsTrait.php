<?php
declare(strict_types=1);

namespace B13\TrustedUrlParams;

/*
 * This file is part of TYPO3 CMS-based extension "trusted_url_params" by b13.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 */

use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Routing\PageArguments;
use TYPO3\CMS\Core\Utility\ArrayUtility;
use TYPO3\CMS\Core\Utility\HttpUtility;

trait TrustedUrlParamsTrait
{
    protected function getAllowedQueryArguments($request, array $conf): string
    {
        if (!$request instanceof ServerRequestInterface) {
            return '';
        }
        $pageArguments = $request->getAttribute('routing');
        if (!$pageArguments instanceof PageArguments) {
            return '';
        }
        $allowedQueryArguments = $pageArguments->getRouteArguments();
        if ($conf['includeUntrusted'] ?? false) {
            $allowedQueryArguments = array_replace_recursive($pageArguments->getQueryArguments(), $allowedQueryArguments);
        }

        // Exclude parameters given in a list
        if (!empty($conf['exclude'] ?? false)) {
            $excludeString = str_replace(',', '&', $conf['exclude']);
            $excludedQueryParts = [];
            parse_str($excludeString, $excludedQueryParts);
            $allowedQueryArguments = ArrayUtility::arrayDiffKeyRecursive($allowedQueryArguments, $excludedQueryParts);
        }

        return !empty($allowedQueryArguments) ? HttpUtility::buildQueryString($allowedQueryArguments, '&') : '';
    }
}
