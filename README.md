# Trusted URL Params - A TYPO3 extension to generate safe URLs

This TYPO3 extension modifies the generation of links to TYPO3 pages to only include the current query
parameters (`$_GET`) that have been resolved by TYPO3's Routing.

## Background

TYPO3's `typolink` functionality is super-powerful but also drags a lot of history with it. Various issues
have been addressed with TYPO3's Routing, which was introduced in TYPO3 v9.

However, one main issue still resolves: The usage of the option `addQueryString` of `typolink`.
If used, the option adds *any* existing `$_GET` parameter to the generated URL and - in the worst case -
generates a valid cHash for this link.

`addQueryString` allows to define an exclude list of GET parameters, however this issue
can never be solved properly with an exclude list, but rather an allow-list. With TYPO3 v9,
we already have an "allow list" of the current request - all GET parameters or arguments that
have been found in the route path ("route arguments"). This is a much better way to generate
the "addQueryString" logic than using the plain `$_GET` array.

Since TYPO3 v9, this issue has become more visible as the commonly used `seo` extension
uses `addQueryString` to generate the canonical tag, or the language menu.

## How we fixed it

This extension provides an XCLASS (as there is currently no alternative to hook into this place of link generation)
and only takes safe query parameters from the current URL, and only for generated URLs that use the `addQueryString`
flag.

## When to use this extension

We recommend using this extension
* if you have trouble with SEO campaigns and an invalid canonical tag
* or if (valid) bots taking crazy links and fill your cache backends or eat up your server resources
* and if you know you don't misuse "addQueryString" in any other places such as your own TypoScript or third-party extensions

Please read https://typo3.org/security/advisory/typo3-psa-2021-003 for more details.

## TYPO3 v12
TYPO3 v12 finally enforces addQueryString to only allow "trusted" URL Parameters
making this extension obsolete, however the extension continues to be compatible
with TYPO3 v12 when extension use legacy functionality.

See https://review.typo3.org/c/Packages/TYPO3.CMS/+/75864 for the related
core change.

## Installation

Install this extension via `composer req b13/trusted-url-params` or download it from the [TYPO3 Extension Repository](https://extensions.typo3.org/extension/trusted_url_params/) and activate
the extension in the Extension Manager of your TYPO3 installation.

Note: This extension is compatible with TYPO3 v9, v10 and v11.

## Configuration

This extension provides safe URLs by default, and no further configuration is needed. However, custom TypoLink
links can use the `addQueryString.includeUntrusted = 1` property to also include URL parameters that are
added as GET parameters (such as query strings from SolR).

### Possible side effects

As we believe in the concept of an "allow list", we further want to extend this configuration to
allow regular query parameters if configured in e.g. a site configuration to allow proper
pagination links, which might be an issue.

## Inspiration

* TYPO3 Core v9 Routing (Thanks to Oliver Hader and Benni Mack)
* Helmut Hummel (original idea on how to solve it "the core way")
* Extension ["urlguard"](https://github.com/sourcebroker/urlguard) (Thanks to Krystian Szymukowicz from SourceBroker)
* Extension ["urlguard2"](https://github.com/studiomitte/urlguard2) (Thanks to Georg Ringer from Studio Mitte)
* Extension ["seo-canonical-guard"](https://github.com/wazum/seo-canonical-guard)

## Credits

This extension was created by Benni Mack in 2021 for [b13 GmbH, Stuttgart](https://b13.com).

[Find more TYPO3 extensions we have developed](https://b13.com/useful-typo3-extensions-from-b13-to-you) that help us deliver value in client projects. As part of the way we work, we focus on testing and best practices to ensure long-term performance, reliability, and results in all our code.
