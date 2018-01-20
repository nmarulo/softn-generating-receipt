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
        $receipt               = new Receipts();
        $receipt->receipt_date = date('Y-m-d', time());
        $lastReceipt           = Receipts::query()
                                         ->orderBy('receipt_number', 'desc')
                                         ->first();
        
        if ($lastReceipt) {
            $receiptNumber = intval($lastReceipt->receipt_number) + 1;
        } else {
            $receiptNumber = 1;
        }
        
        $receipt->receipt_number = $receiptNumber;
        
        return View::make('generating')
                   ->with('receipt', $receipt);
    }
    
    public function dataPDF(Request $request) {
        $dataJSON = [
            'client'   => NULL,
            'products' => [],
            'receipt'  => NULL,
            'options'  => NULL,
        ];
        
        $receiptId = $request->input('receipt_id', FALSE);
        
        if ($receiptId) {
            $receipt       = Receipts::find($receiptId);
            $client        = Clients::find($receipt->client_id)
                                    ->data();
            $settingsQuery = Settings::query()
                                     ->all();
            $settings      = [];
            array_walk($settingsQuery, function($setting) use (&$settings) {
                $settings[$setting->option_key] = $setting->option_value;
            });
            
            $receiptsProducts = ReceiptsProducts::where('receipt_id', '=', $receipt->id)
                                                ->all();
            $products         = [];
            
            array_walk($receiptsProducts, function($receiptProduct) use (&$products) {
                $products[] = [
                    'product'              => Products::find($receiptProduct->product_id)
                                                      ->data(),
                    'receipt_product_unit' => $receiptProduct->receipt_product_unit,
                ];
            });
            
            $dataJSON = [
                'client'   => $client,
                'products' => $products,
                'receipt'  => $receipt->data(),
                'options'  => $settings,
            ];
        }
        
        return json_encode($dataJSON);
    }
    
    public function generate(Request $request) {
        //[{"id":3,"receipt_product_unit":"1"}]
        $products = (array)json_decode($request->input('receipt_products', []));
        $clientId = $request->input('client_id', FALSE);
        
        if (count($products) == 0 || empty($clientId)) {
            Messages::addDanger('Por favor, seleccione un cliente y mínimo un producto.');
            
            return json_encode(FALSE);
        }
        
        $result = ['receipt_id' => 0];
        
        if ($receipt = $this->insertReceipt($request)) {
            $this->insertProducts($receipt);
            $this->updateClient($receipt->client_id);
            $result['receipt_id'] = $receipt->id;
        }
        
        return json_encode($result);
    }
    
    private function insertReceipt(Request $request) {
        $receipt                        = new Receipts();
        $receipt->receipt_type          = $request->input('receipt_type');
        $receipt->receipt_number        = $request->input('receipt_number');
        $receipt->receipt_date          = $request->input('receipt_date');
        $receipt->receipt_license_plate = $request->input('receipt_license_plate');
        $receipt->client_id             = $request->input('client_id');
        
        if (!$receipt = $receipt->save()) {
            Messages::addDanger('Error al registrar la factura.');
        }
        
        return $receipt;
    }
    
    private function insertProducts(Receipts $receipt) {
        $receiptProduct             = new ReceiptsProducts();
        $receiptProduct->receipt_id = $receipt->id;
        
        array_walk($products, function($product) use ($receiptProduct) {
            $product                              = (array)$product;
            $receiptProduct->product_id           = $product['id'];
            $receiptProduct->receipt_product_unit = $product['receipt_product_unit'];
            Query::insert(ReceiptsProducts::tableName(), $receiptProduct->data())
                 ->execute();
        });
    }
    
    private function updateClient($clientId) {
        $client                         = Clients::find($clientId);
        $client->client_number_receipts = intval($client->client_number_receipts) + 1;
        
        if(!$client->save()){
            Messages::addDanger('Error al actualizar el cliente.');
        }
    }
    
    public function dataModal(Request $request) {
        $objects = [];
        $search  = $request->input('search', '');
        
        switch ($request->input('methodGetData')) {
            case 'clients':
                $objects = $this->clients($search);
                break;
            case 'products':
                $objects = $this->products($search);
                break;
        }
        
        return View::make('generating.datamodal')
                   ->with('objects', $objects)
                   ->with('name', $request->input('methodGetName'));
    }
    
    public function clients($search = '') {
        return Clients::query()
                      ->where('client_name', 'LIKE', "%$search%")
                      ->orderBy('client_name')
                      ->all(NULL, function($row) {
                          return $row->data();
                      });
    }
    
    public function products($search = '') {
        return Products::query()
                       ->where('product_name', 'LIKE', "%$search%")
                       ->orderBy('product_name')
                       ->all(NULL, function($row) {
                           return $row->data();
                       });
    }
    
    public function selectedProducts(Request $request) {
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
