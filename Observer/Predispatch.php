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
namespace Frontuser\Integration\Observer;

use \Psr\Log\LoggerInterface;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class Predispatch implements ObserverInterface
{
	/**
	 * @var \Magento\Framework\Math\Random
	 */
	public $random;

	/**
	 * Predispatch constructor.
	 *
	 * @param LoggerInterface $logger
	 * @param \Magento\Framework\Math\Random $random
	 */
	public function __construct(LoggerInterface $logger, \Magento\Framework\Math\Random $random)
	{
		$this->random = $random;
	}

	/**
	 * @param Observer $observer
	 *
	 * @return mixed
	 */
	public function execute(Observer $observer)
	{
		$quote = $observer->getQuote();
		
		if(!$quote->getFutoken()) {
			$quote->setFutoken($this->random->getRandomString(32));
		}
		
		return $quote;
	}
}