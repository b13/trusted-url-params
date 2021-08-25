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
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;

/**
 * XCLASS for TYPO3 v10.
 */
class ContentObjectRenderer10 extends ContentObjectRenderer
{
    use TrustedUrlParamsTrait;

    /**
     * @var null|ServerRequestInterface
     */
    protected $request = null;

    public function getQueryArguments($conf, $overruleQueryArguments = [], $forceOverruleArguments = false)
    {
        return $this->getAllowedQueryArguments($this->getRequest(), $conf ?? []);
    }

    /**
     * Shim for support < TYPO3 v11.
     *
     * @return null|ServerRequestInterface
     */
    public function getRequest(): ?ServerRequestInterface
    {
        if ($this->request instanceof ServerRequestInterface) {
            return $this->request;
        }
        if (isset($GLOBALS['TYPO3_REQUEST']) && $GLOBALS['TYPO3_REQUEST'] instanceof ServerRequestInterface) {
            return $GLOBALS['TYPO3_REQUEST'];
        }
    }
}
