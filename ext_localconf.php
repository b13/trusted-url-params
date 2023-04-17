<?php

defined('TYPO3_MODE') || defined('TYPO3') || die('Access denied.');

call_user_func(static function () {
    switch ((new \TYPO3\CMS\Core\Information\Typo3Version())->getMajorVersion()) {
        case 9:
            $GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects'][\TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer::class] = [
                'className' => \B13\TrustedUrlParams\ContentObjectRenderer9::class
            ];
            break;
        case 10:
            $GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects'][\TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer::class] = [
                'className' => \B13\TrustedUrlParams\ContentObjectRenderer10::class
            ];
            break;
        case 11:
            $GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects'][\TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer::class] = [
                'className' => \B13\TrustedUrlParams\ContentObjectRenderer11::class
            ];
            break;
        case 12:
            $GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects'][\TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer::class] = [
                'className' => \B13\TrustedUrlParams\ContentObjectRenderer12::class
            ];
            break;
    }
});
