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
use TYPO3\CMS\Core\Information\Typo3Version;
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
            $allowedQueryArguments = $this->arrayDiffKeyRecursiveWrapper($allowedQueryArguments, $excludedQueryParts);
        }

        return !empty($allowedQueryArguments) ? HttpUtility::buildQueryString($allowedQueryArguments, '&') : '';
    }

    /**
     * Can be replaced by ArrayUtility::arrayDiffKeyRecursive() once we drop v9.5 support.
     * @param array $array1
     * @param array $array2
     * @return array
     */
    private function arrayDiffKeyRecursiveWrapper(array $array1, array $array2): array
    {
        if ((new Typo3Version())->getMajorVersion() < 10) {
            return $this->arrayDiffKeyRecursive($array1, $array2);
        }
        return ArrayUtility::arrayDiffAssocRecursive($array1, $array2);
    }

    /**
     * Can be replaced by ArrayUtility::arrayDiffKeyRecursive() once we drop v9.5 support.
     *
     * Filters keys off from first array that also exist in second array. Comparison is done by keys.
     * This method is a recursive version of php array_diff_key()
     *
     * @param array $array1 Source array
     * @param array $array2 Reduce source array by this array
     * @return array Source array reduced by keys also present in second array
     */
    private function arrayDiffKeyRecursive(array $array1, array $array2): array
    {
        $differenceArray = [];
        foreach ($array1 as $key => $value) {
            if (!array_key_exists($key, $array2)) {
                $differenceArray[$key] = $value;
            } elseif (is_array($value)) {
                if (is_array($array2[$key])) {
                    $recursiveResult = $this->arrayDiffKeyRecursive($value, $array2[$key]);
                    if (!empty($recursiveResult)) {
                        $differenceArray[$key] = $recursiveResult;
                    }
                }
            }
        }
        return $differenceArray;
    }
}
