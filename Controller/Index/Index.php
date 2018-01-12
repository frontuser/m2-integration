<?php

namespace Frontuser\Integration\Controller\index;

use Magento\Framework\App\Action\Context;
use Magento\Checkout\Model\Cart as CustomerCart;
use Magento\Framework\Controller\ResultFactory;

class Index extends \Magento\Framework\App\Action\Action
{

	/**
	 * @var \Magento\Checkout\Model\Session
	 */
	protected $checkoutSession;

	/**
	 * @var \Magento\Checkout\Model\Cart
	 */
	protected $cart;

	/**
	 * @param Context $context
	 * @param \Magento\Checkout\Model\Session $checkoutSession
	 * @param CustomerCart $cart
	 */
	public function __construct(
		Context $context,
		\Magento\Checkout\Model\Session $checkoutSession,
		CustomerCart $cart
	) {
		$this->checkoutSession = $checkoutSession;
		$this->cart = $cart;

		parent::__construct($context);
	}

	public function execute()
	{
		$code = $this->_request->getParam('code');

		$quote = $this->_objectManager->create( 'Magento\Quote\Model\Quote' )->getCollection()->addFieldToFilter('futoken', $code)->getFirstItem();
		$resultRedirect = $this->resultFactory->create( ResultFactory::TYPE_REDIRECT );

		if(!empty( $quote )) {

			$this->checkoutSession->setQuoteId( $quote->getId() );
			$this->cart->setQuote( $quote );
			$redirect = 'checkout/cart/';

		} else {
			$redirect = '/';
		}

		$track = $this->getRequest()->getParam('_track');
		$campaign = $this->getRequest()->getParam('_campaign');
		if(!empty($track) && !empty($campaign)) {
			$redirect .= "?_track=$track&_campaign=$campaign";
		}

		$resultRedirect->setPath($redirect);

		return $resultRedirect;
	}
}