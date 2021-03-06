<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\Cms;

use Spryker\Shared\Cms\CmsConstants;
use Spryker\Zed\Kernel\AbstractBundleConfig;

class CmsConfig extends AbstractBundleConfig
{
    protected const CMS_TWIG_TEMPLATE_PREFIX = '@Cms';
    protected const CMS_PLACEHOLDER_PATTERN = '/<!-- CMS_PLACEHOLDER : "[a-zA-Z0-9._-]*" -->/';
    protected const CMS_PLACEHOLDER_VALUE_PATTERN = '/"([^"]+)"/';

    /**
     * @return string
     */
    public function getPlaceholderPattern(): string
    {
        return static::CMS_PLACEHOLDER_PATTERN;
    }

    /**
     * @return string
     */
    public function getPlaceholderValuePattern(): string
    {
        return static::CMS_PLACEHOLDER_VALUE_PATTERN;
    }

    /**
     * @deprecated Use getTemplateRealPaths() instead.
     *
     * @param string $templateRelativePath
     *
     * @return string
     */
    public function getTemplateRealPath($templateRelativePath)
    {
        return $this->getAbsolutePath($templateRelativePath, 'Yves');
    }

    /**
     * @param string $templateRelativePath
     *
     * @return array
     */
    public function getTemplateRealPaths(string $templateRelativePath): array
    {
        return [
            $this->getAbsolutePath($templateRelativePath, 'Yves'),
            $this->getAbsolutePath($templateRelativePath, 'Shared'),
        ];
    }

    /**
     * @return bool
     */
    public function appendPrefixToCmsPageUrl(): bool
    {
        return false;
    }

    /**
     * @param string $templateRelativePath
     * @param string $twigLayer
     *
     * @return string
     */
    protected function getAbsolutePath(string $templateRelativePath, string $twigLayer): string
    {
        $templateRelativePath = str_replace(static::CMS_TWIG_TEMPLATE_PREFIX, '', $templateRelativePath);

        return sprintf(
            '%s/%s/%s/Cms/Theme/%s%s',
            APPLICATION_SOURCE_DIR,
            $this->get(CmsConstants::PROJECT_NAMESPACE),
            $twigLayer,
            $this->get(CmsConstants::YVES_THEME),
            $templateRelativePath
        );
    }
}
