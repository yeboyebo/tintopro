<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Yeboyebo\Sync\Model\Sales\Orders;



class ListOrders{

	protected $_orderCollectionFactory;
	protected $serializer;
	protected $resultJsonFactory;


	public function __construct(
		\Magento\Sales\Model\ResourceModel\Order\CollectionFactory $orderCollectionFactory,
		\Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory
	) {
		$this->_orderCollectionFactory = $orderCollectionFactory;
		$this->resultJsonFactory = $resultJsonFactory;
	}



	public function getList(){
		$collection = $this->_orderCollectionFactory->create()
                        ->addAttributeToSelect('*')
                        ->addFieldToFilter('synchronized', array('eq', false))
						->addAttributeToSort('entity_id','asc');
		$json = array();
		foreach ($collection as $order){
			array_push($json,$this->serializeOrder($order));
		}

		return $json;
	}

	protected function serializeOrder($order){

		//$addressSerializer = new AddressSerializer();
		$shipping = floatval($order->getBaseShippingInclTax());
		$surcharge = floatval($order->getBaseFoomanSurchargeAmount());
		$gastos = $shipping + $surcharge;
		$data = [
			'entity_id' => (int) $order['entity_id'],
			'increment_id' =>  $order['increment_id'],
			'created_at' => $order->getData('created_at'),
			'payment_method' => $order->getPayment()->getMethod(),
			'email' => $order['customer_email'],
			'cif' => trim($order->getBillingAddress()->getData('vat_id') !== null ? $order->getBillingAddress()->getData('vat_id') : $order->getCustomerTaxvat()),
			'customer_id' => $order->getCustomerId(),
			'billing_address' => $this->serializeAddress($order->getBillingAddress()),
			'shipping_address' => $this->serializeAddress($order->getShippingAddress()),
			'shipping_method' => $order->getShippingMethod(),
			'shipping_description' => $order->getShippingDescription(),
			'shipping_price' =>  $gastos,
			'weight' => (float) $order['weight'],
			'units' => $order->getTotalItemCount(),
			'currency' => $order->getOrderCurrencyCode(),
			'subtotal' => (float) $order['base_subtotal'],
			'tax_amount' => (float) $order['base_tax_amount'],
			'discount_amount' => (float) $order['base_discount_amount'],
			'grand_total' => (float) $order['base_grand_total']
		];


		foreach($order->getAllVisibleItems() as $item)
		{
			$data['items'][] = $this->serializeOrderItem($item);
		}

		return $data;
	}

	protected function serializeOrderItem($item){
		return [
			'sku' => $item->getSku(),
			'cantidad' => (int) $item->getQtyOrdered(),
			'iva' => (float) $item->getTaxPercent(),
			'pvptotaliva' => (float) $item->getBaseRowTotalInclTax(),
			'ivaincluido' => (float) $item->getBasePriceInclTax(),
			'pvpunitarioiva' => (float) $item->getBasePriceInclTax(),
			'pvpsindtoiva' => (float)($item->getBasePriceInclTax() * $item->getQtyOrdered())
		];
	}

	protected function serializeAddress($address){
		return [
			'type' => $address->getData('address_type'),
			'firstname' => $address->getData('firstname'),
			'middlename' => $address->getData('middlename'),
			'lastname' => $address->getData('lastname'),
			'email' => $address->getData('email'),
			'telephone' => $address->getData('telephone'),
			'street'=>	$address->getData('street'),
			'region'=> $address->getData('region'),
			'region_id'=> $address->getData('region_id'),
			'postcode' => $address->getData('postcode'),
			'city'=> $address->getData('city'),
			'country_id'=> $address->getData('country_id'),
			'company' => $address->getData('company')
		];
	}
}
