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

namespace Extait\Highlighter\Ui\Component\Listing\Columns;

use Extait\Highlighter\Helper\ConfigHelper;

class StatusCode extends \Magento\Ui\Component\Listing\Columns\Column
{
    /**
     * @var ConfigHelper
     */
    private $configHelper;

    /**
     * StatusCode constructor.
     *
     * @param \Magento\Framework\View\Element\UiComponent\ContextInterface $context
     * @param \Magento\Framework\View\Element\UiComponentFactory $uiComponentFactory
     * @param ConfigHelper $configHelper
     * @param array $components
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\UiComponent\ContextInterface $context,
        \Magento\Framework\View\Element\UiComponentFactory $uiComponentFactory,
        ConfigHelper $configHelper,
        array $components = [],
        array $data = []
    ) {
        parent::__construct($context, $uiComponentFactory, $components, $data);
        $this->configHelper = $configHelper;
    }

    /**
     * @param array $dataSource
     *
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if ($this->configHelper->isModuleEnabled()) {
            $colors = $this->configHelper->getStatusColors();
            if (isset($dataSource['data']['items'])) {
                foreach ($dataSource['data']['items'] as &$item) {
                    $item['back_color'] = isset($colors[$item['status']]) ? $colors[$item['status']]['back_color'] : '';
                    $item['text_color'] = isset($colors[$item['status']]) ? $colors[$item['status']]['text_color'] : '';
                }
            }
        }

        return $dataSource;
    }
}
