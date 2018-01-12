<?php

/**
 * Frontuser Integration
 * Copyright © 2017 Frontuser. All rights reserved.
 *
 * @category    Frontuser
 * @package     Frontuser_Integration
 * @author      Frontuser Team <support@frontuser.com>
 * @copyright   Frontuser (https://frontuser.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

namespace Frontuser\Integration\Block\Adminhtml;


class Customermap extends \Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray
{
	/**
	 * @var \Magento\Framework\Data\Form\Element\Factory
	 */
	public $elementFactory;

	/**
	 * @var $_attributesRenderer \Frontuser\Integration\Block\Adminhtml\Form\Field\Activation
	 */
	public $activation;

	/**
	 * @var \Magento\Customer\Model\Customer
	 */
	public $customerModel;

	/**
	 * @param \Magento\Backend\Block\Template\Context $context
	 * @param \Magento\Framework\Data\Form\Element\Factory $elementFactory
	 * @param array $data
	 */
	public function __construct(
		\Magento\Backend\Block\Template\Context $context,
		\Magento\Framework\Data\Form\Element\Factory $elementFactory,
		\Magento\Customer\Model\Customer $customerModel,
		array $data = [])
	{
		$this->elementFactory  = $elementFactory;
		$this->customerModel = $customerModel;
		parent::__construct($context,$data);
	}

	/**
	 * Get activation options.
	 *
	 * @return \Frontuser\Integration\Block\Adminhtml\Form\Field\Activation
	 */
	public function _getActivationRenderer()
	{
		if (!$this->activation) {
			$this->activation = $this->getLayout()->createBlock(
				'\Frontuser\Integration\Block\Adminhtml\Form\Field\Activation',
				'',
				['data' => ['is_render_to_js_template' => true]]
			);

			$attributes = $this->customerModel->getAttributes();
			$attributesArrays = array();
			foreach ($attributes as $attribute) {
				$attributesArrays[] = array(
					'label' => $attribute->getName(),
					'value' => $attribute->getName()
				);
			}

			$this->activation->setOptions($attributesArrays);
		}

		return $this->activation;
	}

	/**
	 * Prepare to render.
	 *
	 * @return void
	 */
	public function _prepareToRender()
	{
		$this->addColumn('field', ['label' => __('Custom Field')]);

		$this->addColumn('value', [
			'label' => __('Magento Field'),
			'renderer' => $this->_getActivationRenderer()
		]);

		$this->_addAfter = false;
		$this->_addButtonLabel = __('Add');
	}

	/**
	 * Prepare existing row data object.
	 *
	 * @param \Magento\Framework\DataObject $row
	 * @return void
	 */
	public function _prepareArrayRow(\Magento\Framework\DataObject $row)
	{
		$options = [];
		$customAttribute = $row->getData('value');

		$key = 'option_' . $this->_getActivationRenderer()->calcOptionHash($customAttribute);
		$options[$key] = 'selected="selected"';
		$row->setData('option_extra_attrs', $options);
	}
}
