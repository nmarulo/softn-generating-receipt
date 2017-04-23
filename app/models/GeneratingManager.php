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
    
    const RECEIPT_PRODUCTS  = 'receipt_products';
    
    const RECEIPT_CLIENT_ID = 'receipt_client_id';
    
    public function defaultData(){
        $date = date('d/m/Y', time());
        $receiptManager = new ReceiptsManager();
        $object = new Generating();
        $lastReceipt = $receiptManager->getLast();
        $lastReceiptNumber = $lastReceipt->getReceiptNumber();
        $receipt = $object->getReceipt();
        $receipt->setReceiptNumber(++$lastReceiptNumber);
        $receipt->setReceiptDate($date);
        $object->setReceipt($receipt);
        
        return $object;
    }
    
}
