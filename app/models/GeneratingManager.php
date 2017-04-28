<?php
/**
 * GeneratingManager.php
 */

namespace Softn\models;

/**
 * Class GeneratingManager
 * @author Nicolás Marulanda P.
 */
class GeneratingManager {
    
    public function defaultData() {
        $date              = date('d/m/Y', time());
        $receiptManager    = new ReceiptsManager();
        $object            = new Generating();
        $lastReceipt       = $receiptManager->getLast();
        $lastReceiptNumber = $lastReceipt->getReceiptNumber();
        $receipt           = $object->getReceipt();
        $receipt->setReceiptNumber(++$lastReceiptNumber);
        $receipt->setReceiptDate($date);
        $object->setReceipt($receipt);
        
        return $object;
    }
    
    /**
     * @param Receipt $receipt
     * @param array   $products
     */
    public function generate($receipt, $products) {
        $receiptManager           = new ReceiptsManager();
        $receiptHasProductManager = new ReceiptsHasProductsManager();
        $receiptManager->insert($receipt);
        $receiptId = $receiptManager->getLastInsertId();
        
        foreach ($products as $product) {
            $receiptHasProduct = new ReceiptHasProduct();
            $receiptHasProduct->setReceiptId($receiptId);
            $receiptHasProduct->setProductId($product[ProductsManager::ID]);
            $receiptHasProduct->setReceiptProductUnit($product[ReceiptsHasProductsManager::RECEIPT_PRODUCT_UNIT]);
            $receiptHasProductManager->insert($receiptHasProduct);
        }
    }
    
}
