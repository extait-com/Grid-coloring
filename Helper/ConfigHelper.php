<?php
/**
 * NOTICE OF LICENSE
 *
 * This source file is subject to the commercial license
 * that is bundled with this package in the file LICENSE.txt.
 *
 * @category Extait
 * @package Extait_Highlighter
 * @copyright Copyright (c) 2016-2018 Extait, Inc. (http://www.extait.com)
 */

namespace Extait\Highlighter\Helper;

class ConfigHelper
{
    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * ConfigHelper constructor.
     *
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
    ) {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * Get value from store scope config.
     *
     * @param string $path
     * @param int|null $storeId
     *
     * @return mixed
     */
    protected function getConfigValue($path, $storeId = null)
    {
        return $this->scopeConfig->getValue($path, \Magento\Store\Model\ScopeInterface::SCOPE_STORE, $storeId);
    }

    /**
     * Get Module status.
     *
     * @param int|null $storeId
     *
     * @return bool
     */
    public function isModuleEnabled($storeId = null)
    {
        return (bool)$this->getConfigValue('extait_highlighter/general/module_status', $storeId);
    }

    /**
     * @param int|null $storeId
     *
     * @return array
     */
    public function getStatusColors($storeId = null)
    {
        $colors = $this->getConfigValue('extait_highlighter/general/row_colors', $storeId);
        $colors = unserialize($colors);
        if (is_array($colors)) {
            $colors = array_combine(
                array_map(function ($item) {
                    return $item['status'];
                }, $colors),
                $colors
            );
        } else {
            $colors = [];
        }

        return $colors;
    }
}
