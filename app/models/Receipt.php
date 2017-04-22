<?php
/**
 * Receipt.php
 */

namespace Softn\models;

/**
 * Class Receipt
 * @author Nicolás Marulanda P.
 */
class Receipt {
    
    /** @var int */
    private $id;
    
    /** @var string */
    private $receiptType;
    
    /** @var int */
    private $receiptNumber;
    
    /** @var string */
    private $receiptDate;
    
    /** @var int */
    private $clientId;
    
    /**
     * Receipt constructor.
     */
    public function __construct() {
        $this->id            = 0;
        $this->receiptType   = '';
        $this->receiptNumber = '';
        $this->receiptDate   = '';
    }
    
    /**
     * @return int
     */
    public function getClientId() {
        return $this->clientId;
    }
    
    /**
     * @param int $clientId
     */
    public function setClientId($clientId) {
        $this->clientId = $clientId;
    }
    
    /**
     * @return int
     */
    public function getId() {
        return $this->id;
    }
    
    /**
     * @param int $id
     */
    public function setId($id) {
        $this->id = $id;
    }
    
    /**
     * @return string
     */
    public function getReceiptType() {
        return $this->receiptType;
    }
    
    /**
     * @param string $receiptType
     */
    public function setReceiptType($receiptType) {
        $this->receiptType = $receiptType;
    }
    
    /**
     * @return int
     */
    public function getReceiptNumber() {
        return $this->receiptNumber;
    }
    
    /**
     * @param int $receiptNumber
     */
    public function setReceiptNumber($receiptNumber) {
        $this->receiptNumber = $receiptNumber;
    }
    
    /**
     * @return string
     */
    public function getReceiptDate() {
        return $this->receiptDate;
    }
    
    /**
     * @param string $receiptDate
     */
    public function setReceiptDate($receiptDate) {
        $this->receiptDate = $receiptDate;
    }
    
}
