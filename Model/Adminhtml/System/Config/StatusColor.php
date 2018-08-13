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

namespace Extait\Highlighter\Model\Adminhtml\System\Config;

use Magento\Framework\App\Config\Value;

class StatusColor extends Value
{
    /**
     * @var \Magento\Sales\Model\ResourceModel\Order\Status\CollectionFactory
     */
    private $statusCollectionFactory;

    /**
     * StatusColor constructor.
     *
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $config
     * @param \Magento\Framework\App\Cache\TypeListInterface $cacheTypeList
     * @param \Magento\Framework\Model\ResourceModel\AbstractResource|null $resource
     * @param \Magento\Framework\Data\Collection\AbstractDb|null $resourceCollection
     * @param \Magento\Sales\Model\ResourceModel\Order\Status\CollectionFactory $statusCollectionFactory
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\App\Config\ScopeConfigInterface $config,
        \Magento\Framework\App\Cache\TypeListInterface $cacheTypeList,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        \Magento\Sales\Model\ResourceModel\Order\Status\CollectionFactory $statusCollectionFactory,
        array $data = []
    ) {
        $this->statusCollectionFactory = $statusCollectionFactory;
        parent::__construct($context, $registry, $config, $cacheTypeList, $resource, $resourceCollection, $data);
    }

    /**
     * Prepare data before save
     *
     * @return $this
     */
    public function beforeSave()
    {
        $result = [];
        foreach ($this->getValue() as $data) {
            if (is_array($data)) {
                $result[] = $data;
            }
        }
        $this->setValue(serialize($result));

        return $this;
    }

    /**
     * Process data after load
     *
     * @return $this
     */
    public function afterLoad()
    {
        $values = unserialize($this->getValue());

        $options = $this->statusCollectionFactory->create()->toOptionArray();

        $statuses = [];
        foreach ($options as $option) {
            $statuses[$option['value']] = [
                'status' => $option['value'],
                'back_color' => '#ffffff',
                'text_color' => '#000000',
            ];
        }

        if (is_array($values)) {
            foreach ($values as $value) {
                if (isset($statuses[$value['status']])) {
                    $statuses[$value['status']]['back_color'] = $value['back_color'];
                    $statuses[$value['status']]['text_color'] = $value['text_color'];
                }
            }
        }

        array_values($statuses);
        $this->setValue($statuses);

        return $this;
    }
}
