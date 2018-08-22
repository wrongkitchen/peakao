<?php

class Mycart_Payease_RedirectController extends Mage_Core_Controller_Front_Action
{
    /**
     * Order instance
     */
    protected $_order;

    /**
     *  Get order
     *
     *  @return  Mage_Sales_Model_Order
     */
    public function getOrder()
    {
        if ($this->_order == null) {
        }
        return $this->_order;
    }

    /**
     * Send expire header to ajax response
     *
     */
    protected function _expireAjax()
    {
        if (!Mage::getSingleton('checkout/session')->getQuote()->hasItems()) {
            $this->getResponse()->setHeader('HTTP/1.1','403 Session Expired');
            exit;
        }
    }

    /**
     * Get singleton with paypal strandard order transaction information
     *
     * @return Mage_Paypal_Model_Standard
     */
    public function getStandard()
    {
        return Mage::getSingleton('paypal/standard');
    }

    /**
     * When a customer chooses Paypal on Checkout/Payment page
     *
     */
    public function indexAction()
    {
        $session = Mage::getSingleton('checkout/session');
        $session->setPayeaseQuoteId($session->getQuoteId());
        $this->getResponse()->setBody($this->getLayout()->createBlock('mycart_payease/redirect')->toHtml());
        $session->unsQuoteId();
        $session->unsRedirectUrl();
    }

    /**
     * When a customer cancel payment from paypal.
     */
    public function cancelAction()
    {
        $session = Mage::getSingleton('checkout/session');
   
        $session->setQuoteId($session->getPayeaseQuoteId(true));
        if ($session->getLastRealOrderId()) {
            $order = Mage::getModel('sales/order')->loadByIncrementId($session->getLastRealOrderId());
            if ($order->getId()) {
                $order->cancel()->save();
            }
            Mage::helper('paypal/checkout')->restoreQuote();
        }
				$session->addError($this->__('Payment Error , Please check your payment info!')); 
        $this->_redirect('checkout/cart');
    }
 public function callbackAction()
    { 
	 $session = Mage::getSingleton('checkout/session');
   
     $session->setQuoteId($session->getPayeaseQuoteId(true));

     $order = Mage::getModel('sales/order')->loadByIncrementId($session->getLastRealOrderId());
		 
	 $payment = Mage::getSingleton("payesase/payment");
	 $status = $this->getrequest()->getparam("v_pstatus");
	 $v_md5money = $this->getrequest()->getparam("v_md5money");
     $amount = number_format($order->getGrandTotal(),2,".","");
	switch($order->getOrderCurrencyCode()){
		case "HKD" :
		   $currency = 9;
		    break;
		case "CNY" :
		   $currency = 0;
		   break;
		case "USD" :
		    $currency =1;
		   break;
	}
	$hashdata =$amount.$currency;
	$md5money = hash_hmac("md5",$hashdata,$hashkey);
	if($v_md5money!=$md5money){
		 $order->setStatus("fraud")->save();
		$session->addError($this->__('Payment Fraud Detect , Please Waitting Our Inspection!')); 
        $this->_redirect('checkout/cart');
	}
	  if($status==20){
	     
	        $order->setState(Mage_Sales_Model_Order::STATE_PROCESSING, true)->save();
			 $this->_redirect('*/*/success');
	  }
	  else if($status==30){
		     $order->setStatus("failed")->save();
			 $this->_redirect('*/*/cancel');
	  }
	  else if($status==1){
	
		$session->addsuccess($this->__('Your Order Is Submit, Please Waitting for the payment in Bank!')); 
		$this->_redirect('*/*/cancel');
	  }
	  else {
		$session->addError($this->__('Payment Pendding , Please check your payment info!')); 
        $this->_redirect('checkout/cart');
	  }
     // var_dump($this->getrequest()->getparams());  
       // $this->_redirect('*/*/success');
    }
    /**
     * when paypal returns
     * The order information at this point is in POST
     * variables.  However, you don't want to "process" the order until you
     * get validation from the IPN.
     */
    public function  successAction()
    {
    
        $session = Mage::getSingleton('checkout/session');
        $session->setQuoteId($session->getPayeaseQuoteId(true));
        Mage::getSingleton('checkout/session')->getQuote()->setIsActive(false)->save();
        $this->_redirect('checkout/onepage/success', array('_secure'=>true));
    }
}
