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
        $receipt->setReceiptType('Factura');
        $receipt->setReceiptNumber(++$lastReceiptNumber);
        $receipt->setReceiptDate($date);
        $object->setReceipt($receipt);
        
        return $object;
    }
    
    /**
     * @param Receipt $receipt
     * @param array   $productsIdAndUnits
     */
    public function generate($receipt, $productsIdAndUnits) {
        $receiptHasProductManager = new ReceiptsHasProductsManager();
        $receiptManager           = new ReceiptsManager();
        $receiptManager->insert($receipt);
        $receiptId = $receiptManager->getLastInsertId();
        
        foreach ($productsIdAndUnits as $productAndUnits) {
            $productId         = $productAndUnits[ProductsManager::ID];
            $productUnits      = $productAndUnits[ReceiptsHasProductsManager::RECEIPT_PRODUCT_UNIT];
            $receiptHasProduct = new ReceiptHasProduct();
            $receiptHasProduct->setReceiptId($receiptId);
            $receiptHasProduct->setProductId($productId);
            $receiptHasProduct->setReceiptProductUnit($productUnits);
            $receiptHasProductManager->insert($receiptHasProduct);
        }
    }
    
}
