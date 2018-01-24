<?php

namespace App\Controllers;

use App\Facades\Messages;
use App\Models\Clients;
use App\Models\Products;
use App\Models\Receipts;
use App\Models\ReceiptsProducts;
use App\Models\Settings;
use Silver\Core\Controller;
use Silver\Database\Query;
use Silver\Http\Request;
use Silver\Http\View;

/**
 * generating controller
 */
class GeneratingController extends Controller {
    
    public function index() {
        return View::make('generating')
                   ->with('receiptNumber', $this->getLastReceiptNumber())
                   ->with('receiptDate', date('Y-m-d', time()));
    }
    
    private function getLastReceiptNumber() {
        $lastReceipt = Receipts::query()
                               ->orderBy('receipt_number', 'desc')
                               ->first();
        
        if ($lastReceipt) {
            return intval($lastReceipt->receipt_number) + 1;
        }
        
        return 1;
    }
    
    public function dataPDF(Request $request) {
        if (!$request->ajax()) {
            //TODO: mensaje de error.
            return "";
        }
        
        $dataJSON = [
            'client'   => NULL,
            'products' => [],
            'receipt'  => NULL,
            'options'  => NULL,
        ];
        
        $receiptId = $request->input('receipt_id', FALSE);
        
        if ($receiptId && $receipt = Receipts::find($receiptId)) {
            $client = Clients::find($receipt->client_id)
                             ->data();
            
            $dataJSON = [
                'client'   => $client,
                'products' => $this->getDataPDFProducts($receiptId),
                'receipt'  => $receipt->data(),
                'options'  => $this->getDataPDFSettings(),
            ];
        }
        
        return json_encode($dataJSON);
    }
    
    private function getDataPDFProducts($receiptId) {
        $receiptsProducts = ReceiptsProducts::where('receipt_id', '=', $receiptId)
                                            ->all();
        $products         = [];
        
        array_walk($receiptsProducts, function($receiptProduct) use (&$products) {
            $products[] = [
                'product'              => Products::find($receiptProduct->product_id)
                                                  ->data(),
                'receipt_product_unit' => $receiptProduct->receipt_product_unit,
            ];
        });
        
        return $products;
    }
    
    private function getDataPDFSettings() {
        $settingsQuery = Settings::query()
                                 ->all();
        $settings      = [];
        array_walk($settingsQuery, function($setting) use (&$settings) {
            $settings[$setting->option_key] = $setting->option_value;
        });
        
        return $settings;
    }
    
    public function generate(Request $request) {
        if (!$request->ajax()) {
            //TODO: mensaje de error.
            return "";
        }
        
        //[{"id":3,"receipt_product_unit":"1"}]
        $products = (array)json_decode($request->input('receipt_products', []));
        $clientId = $request->input('client_id', FALSE);
        
        if (count($products) == 0 || empty($clientId)) {
            Messages::addDanger('Por favor, seleccione un cliente y mínimo un producto.');
            
            return json_encode(FALSE);
        }
        
        if ($receipt = $this->insertReceipt($request, $products)) {
            Messages::addSuccess('Factura creada correctamente.');
            
            return json_encode(['receipt_id' => $receipt->id]);
        }
        
        return json_encode(FALSE);
    }
    
    private function insertReceipt(Request $request, $products) {
        $receipt                        = new Receipts();
        $receipt->receipt_type          = $request->input('receipt_type');
        $receipt->receipt_number        = $request->input('receipt_number');
        $receipt->receipt_date          = $request->input('receipt_date');
        $receipt->receipt_license_plate = $request->input('receipt_license_plate');
        $receipt->client_id             = $request->input('client_id');
        
        try {
            if (!($receipt = $receipt->save()) || !$this->productsClients($products, $receipt)) {
                $receipt->delete();
                $receipt = FALSE;
                Messages::addDanger('Error al registrar la factura.');
            }
        } catch (\Exception $ex) {
            $receipt = FALSE;
            //TODO: log
            Messages::addDanger('* Error al registrar la factura.');
        }
        
        return $receipt;
    }
    
    private function productsClients($products, Receipts $receipt) {
        $result = $this->insertProducts($products, $receipt);
        
        if ($result && !$this->updateClient($receipt->client_id)) {
            $result = FALSE;
            $this->deleteReceiptsProducts($products, $receipt->id, count($products));
        }
        
        return $result;
    }
    
    private function insertProducts($products, Receipts $receipt) {
        $error                      = FALSE;
        $len                        = count($products);
        $receiptProduct             = new ReceiptsProducts();
        $receiptProduct->receipt_id = $receipt->id;
        $maxI                       = 0;
        
        try {
            for ($i = 0; $i < $len && !$error; ++$i) {
                $maxI                                 = $i;
                $product                              = (array)$products[$i];
                $receiptProduct->product_id           = $product['id'];
                $receiptProduct->receipt_product_unit = $product['receipt_product_unit'];
                $error                                = !Query::insert(ReceiptsProducts::tableName(), $receiptProduct->data())
                                                              ->execute();
            }
        } catch (\Exception $ex) {
            //TODO: log
            $error = TRUE;
            $this->deleteReceiptsProducts($products, $receipt->id, $maxI);
        }
        
        if ($error) {
            Messages::addDanger('Error al vincular los productos.');
        }
        
        return !$error;
    }
    
    private function deleteReceiptsProducts($products, $receiptId, $maxI) {
        try {
            for ($i = 0; $i < $maxI; ++$i) {
                $product = (array)$products[$i];
                Query::delete()
                     ->from(ReceiptsProducts::tableName())
                     ->where('product_id', $product['id'])
                     ->where('receipt_id', $receiptId)
                     ->execute();
            }
        } catch (\Exception $exception) {
            //TODO: log.
            Messages::addDanger('Error al borrar los productos vinculados.');
        }
    }
    
    private function updateClient($clientId) {
        $client                         = Clients::find($clientId);
        $client->client_number_receipts = intval($client->client_number_receipts) + 1;
        
        if (!$client->save()) {
            //TODO: log
            Messages::addDanger('Error al actualizar el cliente.');
            
            return FALSE;
        }
        
        return TRUE;
    }
    
    public function dataModal(Request $request) {
        if (!$request->ajax()) {
            //TODO: mensaje de error.
            return "";
        }
        
        $objects = [];
        $search  = $request->input('search', '');
        
        switch ($request->input('methodGetData')) {
            case 'clients':
                $objects = $this->searchClients($search);
                break;
            case 'products':
                $objects = $this->searchProducts($search);
                break;
        }
        
        return View::make('generating.datamodal')
                   ->with('objects', $objects)
                   ->with('name', $request->input('methodGetName'));
    }
    
    private function searchClients($search = '') {
        return Clients::query()
                      ->where('client_name', 'LIKE', "%$search%")
                      ->orderBy('client_name')
                      ->all(NULL, function($row) {
                          return $row->data();
                      });
    }
    
    private function searchProducts($search = '') {
        return Products::query()
                       ->where('product_name', 'LIKE', "%$search%")
                       ->orderBy('product_name')
                       ->all(NULL, function($row) {
                           return $row->data();
                       });
    }
    
    public function selectedProducts(Request $request) {
        if (!$request->ajax()) {
            //TODO: mensaje de error.
            return "";
        }
        
        $productsIdAndUnits = $request->input('productsIdAndUnits', []);
        $products           = [];
        
        array_walk($productsIdAndUnits, function($product) use (&$products) {
            $productFind                         = Products::find($product['id'])
                                                           ->data();
            $productFind['receipt_product_unit'] = $product['receipt_product_unit'];
            $products[]                          = $productFind;
        });
        
        return View::make('generating.selectedproducts')
                   ->with('products', $products);
    }
}
