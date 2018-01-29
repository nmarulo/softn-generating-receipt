{{ extends('layouts.master') }}

#set[content]
<h1>Generar factura</h1>
<div id="content-index">
    <form id="form-generate-receipt" method="post">
        <div class="row clearfix">
            <div class="col-sm-6">
                <div class="panel panel-default">
                    <div class="panel-body form-table">
                        <div class="form-group input-group">
                            <span id="span-receipt-type" class="input-group-addon">Tipo</span>
                            <select id="receipt-type" class="form-control" aria-describedby="span-receipt-type" name="receipt_type">
                              <option>Factura</option>
                              <option>Presupuesto</option>
                            </select>
                        </div>
                        <span class="form-table-cell-hidden"></span>
                        <div class="form-group input-group">
                            <span id="span-receipt-number" class="input-group-addon">Número</span>
                            <input id="receipt-number" class="form-control" type="number" aria-describedby="span-receipt-number" name="receipt_number" value="{{$receiptNumber}}">
                        </div>
                        <span class="form-table-cell-hidden"></span>
                        <div class="form-group input-group">
                            <span id="span-receipt-date" class="input-group-addon">Fecha</span>
                            <input id="receipt-date" class="form-control" type="text" aria-describedby="span-receipt-date" name="receipt_date" value="{{$receiptDate}}">
                        </div>
                        <span class="form-table-cell-hidden"></span>
                        <div class="form-group input-group">
                            <span id="span-receipt-license-plate" class="input-group-addon">Matrícula</span>
                            <input id="receipt-license-plate" class="form-control" type="text" aria-describedby="span-receipt-license-plate" name="receipt_license_plate">
                        </div>
                        <span class="form-table-cell-hidden"></span>
                        <div class="input-group form-table-row">
                            <span id="span-receipt-client" class="input-group-addon">Cliente</span>
                            <input id="receipt-client" class="form-control" type="text" aria-describedby="span-receipt-client">
                            {{ include('generating.modalclients') }}
                        </div>
                    </div>
                </div>
                <input id="receipt-products" type="hidden" name="receipt_products">
                <input id="receipt-client-id" type="hidden" name="client_id">
            </div>
            <div class="col-sm-6">
                <div class="panel panel-primary">
                    <div class="panel-heading">Agregar producto/servicio</div>
                    <div class="panel-body form-table">
                        <div class="form-group input-group">
                            <span id="span-receipt-product" class="input-group-addon">Producto/Servicio</span>
                            <input id="receipt-product" class="form-control" type="text" aria-describedby="span-receipt-product">
                            {{ include('generating.modalproducts') }}
                        </div>
                        <span class="form-table-cell-hidden"></span>
                        <div class="form-group input-group">
                            <span id="span-receipt-product-unit" class="input-group-addon">Unidades</span>
                            <input id="receipt-product-unit" class="form-control" type="number" aria-describedby="span-receipt-product-unit" value="1">
                        </div>
                        <span class="form-table-cell-hidden"></span>
                        <div class="form-table-row">
                            <button id="btn-add-product" class="btn btn-primary" type="button" disabled="disabled">Agregar producto</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <button id="btn-generate-receipt" class="btn btn-success" type="submit">Generar</button>
        </div>
    </form>
    <div id="btn-group-actions-generate" class="hidden">
        <button id="btn-generate-pdf" class="btn btn-success" type="button">Generar PDF</button>
        <a class="btn btn-primary" href="{{url('/receipts')}}">Ver lista de facturas</a>
        <a class="btn btn-warning" href="{{url('/generating')}}">Nueva factura</a>
    </div>
    <div id="list-selected-products" class="form-group">
        No hay productos seleccionados
    </div>
</div>
#end
#set[scripts]
<script src="{{ asset('js/jspdf.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/script-generate-pdf.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/script-generating.js') }}" type="text/javascript"></script>
#end

