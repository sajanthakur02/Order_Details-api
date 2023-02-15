<?php
    namespace  Order\Details\Model;    
    
    
    use Order\Details\Api\CustomerOrderInterface;
    use Magento\Sales\Model\Order;
    
    class CustomerOrder implements CustomerOrderInterface
    {
        private $order;
        /**
         * CustomerOrder constructor.
         *
         * @param Order $order
         */
        public function __construct(
            Order $order
        ) {
            $this->order = $order;
        }
    
        /**
         * Returns orders data to user
         *
         * @api
         * @param  string $id customer id.
         * @return return order array collection.
         */
        public function getList($id)
        {
			$currentDate = date("Y-m-d");
			$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
			$connection = $objectManager->create('\Magento\Framework\App\ResourceConnection');
				$conn = $connection->getConnection();
				$select = $conn->select()
					->from(
						['sales_item' => 'sales_order_item'],
						[
							'sales_order.created_at',
							'sales_order.updated_at',
							'sales_order.status',
							'sales_item.price',
							'sales_item.qty_ordered',
							'sales_item.sku'
						]
					)
					->join(
						['sales_order' => 'sales_order'],
						"sales_order.entity_id = sales_item.order_id where sales_order.created_at between '2022-01-01' and '".$currentDate."' and sales_item.sku = '".$id."'"
					);

			$data = $conn->fetchAll($select);
			$datas=[];
			$i=0;
			foreach ($data as $value) {
				if ($value['status'] == "complete") {
					echo "<pre>"; print_r($value);
					$datas[$i]['status'] = $value['status'];
					$datas[$i]['qty'] = $value['qty_ordered'];
					$date = $value['created_at'];
					$datas[$i]['date'] = date( "y/m/d", strtotime($date));
				}
					$i++;
			}
            return count($datas);
        }
    
       
    }