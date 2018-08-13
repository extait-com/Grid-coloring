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

namespace Extait\Highlighter\Block\Adminhtml\System\Config\Form\Field;

use Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray;
use Magento\Framework\DataObject;

class StatusColor extends AbstractFieldArray
{
    /**
     * @var \Magento\Sales\Model\ResourceModel\Order\Status\CollectionFactory
     */
    private $statusCollectionFactory;

    /**
     * StatusColor constructor.
     *
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Sales\Model\ResourceModel\Order\Status\CollectionFactory $statusCollectionFactory
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Sales\Model\ResourceModel\Order\Status\CollectionFactory $statusCollectionFactory,
        array $data = []
    ) {
        $this->statusCollectionFactory = $statusCollectionFactory;
        parent::__construct($context, $data);
    }

    /**
     * @var string
     */
    protected $_template = 'Extait_Highlighter::system/config/form/field/array.phtml';

    /**
     * Prepare to render
     * @return void
     */
    protected function _prepareToRender()
    {
        $this->addColumn('status', [
            'label' => __('Status'),
            'size' => '50',
        ]);
        $this->addColumn('back_color', [
            'label' => __('Background'),
            'size' => '16',
        ]);
        $this->addColumn('text_color', [
            'label' => __('Text'),
            'size' => '16',
        ]);
    }

    /**
     * @return array
     */
    public function getArrayRows()
    {
        $rows = parent::getArrayRows();
        if (empty($rows)) {
            $options = $this->statusCollectionFactory->create()->toOptionArray();

            $rows = [];
            foreach ($options as $option) {
                $data = new DataObject();
                $data->setData([
                    'status' => $option['value'],
                    'back_color' => '#ffffff',
                    'text_color' => '#000000',
                    '_id' => $option['value'],
                    'column_values' => [
                        $option['value'] . '_status' => $option['value'],
                        $option['value'] . '_back_color' => '#ffffff',
                        $option['value'] . '_text_color' => '#000000',
                    ]
                ]);
                $rows[$option['value']] = $data;
            }
        }

        return $rows;
    }
}
