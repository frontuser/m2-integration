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

namespace Frontuser\Integration\Block\Adminhtml\Form\Field;

class Activation extends \Magento\Framework\View\Element\Html\Select
{
	/**
	 * Model Enabledisable
	 *
	 * @var \Magento\Config\Model\Config\Source\Enabledisable
	 */
	public $enableDisable;

	/**
	 * Activation constructor.
	 *
	 * @param \Magento\Framework\View\Element\Context $context
	 * @param \Magento\Config\Model\Config\Source\Enabledisable $enableDisable $enableDisable
	 * @param array $data
	 */
	public function __construct(
		\Magento\Framework\View\Element\Context $context,
		\Magento\Config\Model\Config\Source\Enabledisable $enableDisable,
		array $data = []
	)
	{
		parent::__construct($context, $data);

		$this->enableDisable = $enableDisable;
	}

	/**
	 * @param string $value
	 * @return \Frontuser\Integration\Block\Adminhtml\Form\Field\Activation
	 */
	public function setInputName($value)
	{
		return $this->setName($value);
	}

	/**
	 * Parse to html.
	 *
	 * @return mixed
	 */
	public function _toHtml()
	{
		if (!$this->getOptions()) {
			$attributes = $this->enableDisable->toOptionArray();

			foreach ($attributes as $attribute) {
				$this->addOption($attribute['value'], $attribute['label']);
			}
		}

		return parent::_toHtml();
	}
}
