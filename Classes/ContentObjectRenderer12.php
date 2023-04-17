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

use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;

/**
 * XCLASS for TYPO3 v12.
 */
class ContentObjectRenderer12 extends ContentObjectRenderer
{
    use TrustedUrlParamsTrait;
    public function getQueryArguments($conf)
    {
        return $this->getAllowedQueryArguments($this->getRequest(), $conf ?? []);
    }
}
