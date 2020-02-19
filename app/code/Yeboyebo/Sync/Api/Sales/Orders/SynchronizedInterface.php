<?php
namespace Yeboyebo\Sync\Api\Sales\Orders;

interface SynchronizedInterface {
	/**
	 * Actualiza el campo synchronized del pedido
	 *
	 * @api
	 * @param int $orderId
	 * @return boolean
	 */
	public function setSynchronized($orderId);
}