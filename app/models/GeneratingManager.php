<?php
/**
 * GeneratingManager.php
 */

namespace Softn\models;

use Softn\util\Arrays;

/**
 * Class GeneratingManager
 * @author Nicolás Marulanda P.
 */
class GeneratingManager {
    
    private $receiptId;
    
    /**
     * GeneratingManager constructor.
     */
    public function __construct() {
        $this->receiptId = 0;
    }
    
    public function defaultData() {
        $date              = date('Y-m-d', time());
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
     * @param Generating $generating
     *
     * @return bool
     */
    public function generate($generating) {
        if (!$this->insertReceipt($generating->getReceipt())) {
            return FALSE;
        }
        
        if (!$this->updateClient($generating->getReceipt()
                                            ->getClientId())
        ) {
            return FALSE;
        }
        
        return $this->insertReceiptsHasProducts($this->receiptId, $generating->getReceiptsHasProducts());
    }
    
    /**
     * @param Receipt $receipt
     *
     * @return bool
     */
    private function insertReceipt($receipt) {
        $receiptManager = new ReceiptsManager();
        
        if ($receiptManager->insert($receipt)) {
            $this->receiptId = $receiptManager->getLastInsertId();
            
            return TRUE;
        }
        
        return FALSE;
    }
    
    /**
     * @param int $idClient
     *
     * @return bool
     */
    private function updateClient($idClient) {
        $clientsManager = new ClientsManager();
        
        return $clientsManager->updateNumberReceipts($idClient);
    }
    
    /**
     * @param int   $receiptId
     * @param array $productsIdAndUnits
     *
     * @return bool
     */
    private function insertReceiptsHasProducts($receiptId, $productsIdAndUnits) {
        if ($receiptId == 0) {
            return FALSE;
        }
        
        $receiptHasProductManager = new ReceiptsHasProductsManager();
        $notError                 = TRUE;
        $count                    = count($productsIdAndUnits);
        
        for ($i = 0; $i < $count && $notError; ++$i) {
            $value             = Arrays::get($productsIdAndUnits, $i);
            $receiptHasProduct = new ReceiptHasProduct();
            
            $receiptHasProduct->setReceiptId($receiptId);
            $receiptHasProduct->setProductId($value->getProductId());
            $receiptHasProduct->setReceiptProductUnit($value->getReceiptProductUnit());
            
            if (!$receiptHasProductManager->insert($receiptHasProduct)) {
                $notError = FALSE;
            }
        }
        
        return $notError;
    }
    
}
