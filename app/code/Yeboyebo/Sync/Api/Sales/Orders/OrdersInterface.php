<?php
namespace Yeboyebo\Sync\Api\Sales\Orders;

interface OrdersInterface {
	/**
	 * Devuelve el listado de pedidos sin sincronizar
	 *
	 * @api
	 * @return object
	 */
	public function getList();
}