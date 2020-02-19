<?php
namespace Yeboyebo\Sync\Model\Sales\Orders;
use Magento\Setup\Exception;
use Magento\TestFramework\Event\Magento;
use Yeboyebo\Sync\Api\Sales\Orders\SynchronizedInterface as ApiInterface;


class Synchronized implements ApiInterface {

	protected $order;
	private $orderFactory;
	protected $log;

	/**
	 * @param \Magento\Quote\Api\SynchronizedInterface $orderId
	 */
	public function __construct(
		\Magento\Sales\Api\Data\OrderInterfaceFactory $orderFactory
	) {
		$this->orderFactory = $orderFactory;
		$writer = new \Zend\Log\Writer\Stream(BP . '/var/log/api.log');
		$logger = new \Zend\Log\Logger();
		$logger->addWriter($writer);
		$this->log = $logger;
	}

	public function setSynchronized($orderId) {

		try{
			//$this->log->info('Entro2');
			$order = $this->orderFactory->create()->loadByIncrementId($orderId);
			$order->setData('synchronized',1);
			$order->save();
			//$this->log->info($order->getId());
			return true;
		}catch(Exception $e){
			return false;
		}

	}
}
