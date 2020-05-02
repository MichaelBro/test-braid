<?php

use Bitrix\Catalog\StoreTable;
use Bitrix\Main\ArgumentException;
use Bitrix\Main\EventManager;
use Bitrix\Main\Event;
use Bitrix\Main\ObjectPropertyException;
use Bitrix\Main\SystemException;
use Bitrix\Sale\Order;

$eventManager = EventManager::getInstance();
$eventManager->addEventHandler('sale', 'OnSaleOrderSaved', 'SaleHandler::$userId');
$eventManager->addEventHandler('main', 'OnBeforeEventAdd', 'SaleHandler::changeMailTemplate');

class SaleHandler
{
    /**
     * Id способа доставки 'Самовывоз'
     * @var int
     */
    private static $pickupOfGoodsId = 3;

    /**
     * F - финальный статус (название по умолчанию - Выполнен), в котором заказ считается выполненным.
     * @var string
     */
    private static $finalStatus = 'F';

    public static function removeMailingAddress(Event $event): void
    {
        $order = $event->getParameter('ENTITY');

        $deliveryId = $order->getField('DELIVERY_ID');
        $status = $order->getField('STATUS_ID');

        if ((int)$deliveryId === self::$pickupOfGoodsId && $status === self::$finalStatus) {
            $userId = $order->getUserId();
            $user = new CUser;

            $fields = [
                'PERSONAL_STREET' => '',
                'PERSONAL_MAILBOX' => '',
                'PERSONAL_CITY' => '',
                'PERSONAL_STATE' => '',
                'PERSONAL_ZIP' => '',
                'PERSONAL_COUNTRY' => '',
                'PERSONAL_NOTES' => '',
            ];
            $user->Update($userId, $fields);
        }
    }

    /**
     * @param $event
     * @param $lid
     * @param $arFields
     * @param $messageId
     * @throws ArgumentException
     * @throws ObjectPropertyException
     * @throws SystemException
     */
    public static function changeMailTemplate(&$event, &$lid, &$arFields, &$messageId): void
    {
        $order = Order::load($arFields['ORDER_ID']);
        $deliveryId = $order->getField('DELIVERY_ID');

        if ((int)$deliveryId === self::$pickupOfGoodsId && $event === 'SALE_NEW_ORDER') {
            $collection = $order->getShipmentCollection();

            $store = self::getStoreInfo($collection);

            $arFields['ADDRESS'] = $store['ADDRESS'];
            $arFields['SCHEDULE'] = $store['SCHEDULE'];

            $event = 'SALE_NEW_ORDER_SELF_DELIVERY';
        }
    }

    /**
     * @param $collection
     * @return array
     * @throws ArgumentException
     * @throws ObjectPropertyException
     * @throws SystemException
     */
    private static function getStoreInfo($collection): array
    {
        $storeId = 0;
        foreach ($collection as $shipment) {
            if (!$shipment->isSystem()) {
                $storeId = $shipment->getStoreId();
            }
        }

        return StoreTable::getList([
            'select' => ['ADDRESS', 'SCHEDULE'],
            'filter' => ['ID' => $storeId]
        ])->fetch();
    }
}