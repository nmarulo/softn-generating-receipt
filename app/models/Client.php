<?php
/**
 * Client.php
 */

namespace Softn\models;

/**
 * Class Client
 * @author Nicolás Marulanda P.
 */
class Client implements \JsonSerializable {
    
    /** @var int */
    private $id;
    
    /** @var string */
    private $clientName;
    
    /** @var string */
    private $clientAddress;
    
    /** @var string */
    private $clientIdentificationDocument;
    
    /** @var string */
    private $clientCity;
    
    /**
     * Client constructor.
     */
    public function __construct() {
        $this->id                           = 0;
        $this->clientName                   = '';
        $this->clientAddress                = '';
        $this->clientIdentificationDocument = '';
        $this->clientCity                   = '';
    }
    
    public function jsonSerialize() {
        return [
            ClientsManager::ID                             => $this->id,
            ClientsManager::CLIENT_NAME                    => $this->clientName,
            ClientsManager::CLIENT_CITY                    => $this->clientCity,
            ClientsManager::CLIENT_IDENTIFICATION_DOCUMENT => $this->clientIdentificationDocument,
            ClientsManager::CLIENT_ADDRESS                 => $this->clientAddress,
        ];
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
    public function getClientName() {
        return $this->clientName;
    }
    
    /**
     * @param string $clientName
     */
    public function setClientName($clientName) {
        $this->clientName = $clientName;
    }
    
    /**
     * @return string
     */
    public function getClientAddress() {
        return $this->clientAddress;
    }
    
    /**
     * @param string $clientAddress
     */
    public function setClientAddress($clientAddress) {
        $this->clientAddress = $clientAddress;
    }
    
    /**
     * @return string
     */
    public function getClientIdentificationDocument() {
        return $this->clientIdentificationDocument;
    }
    
    /**
     * @param string $clientIdentificationDocument
     */
    public function setClientIdentificationDocument($clientIdentificationDocument) {
        $this->clientIdentificationDocument = $clientIdentificationDocument;
    }
    
    /**
     * @return string
     */
    public function getClientCity() {
        return $this->clientCity;
    }
    
    /**
     * @param string $clientCity
     */
    public function setClientCity($clientCity) {
        $this->clientCity = $clientCity;
    }
    
}
