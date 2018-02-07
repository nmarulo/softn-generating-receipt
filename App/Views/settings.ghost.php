{{ extends('layouts.master') }}

#set[content]
<h1>Opciones</h1>
<div>
    <form method="post">
        <div class="panel panel-default">
            <div class="panel-heading">Datos de la factura</div>
            <div class="panel-body form-table">
                <div class="form-group input-group">
                    <span id="span-option-name" class="input-group-addon">Nombre:</span>
                    <input id="option-name" class="form-control" type="text" aria-describedby="span-option-name" name="option_name" value="{{$valueName->option_value}}">
                </div>
                <span class="form-table-cell-hidden"></span>
                <div class="form-group input-group">
                    <span id="span-option-identification-document" class="input-group-addon">Documento de identificación:</span>
                    <input id="option-name" class="form-control" type="text" aria-describedby="span-option-identification-document" name="option_identification_document" value="{{$valueIdentificationDocument->option_value}}">
                </div>
                <span class="form-table-cell-hidden"></span>
                <div class="form-group input-group">
                    <span id="span-option-address" class="input-group-addon">Dirección:</span>
                    <input id="option-address" class="form-control" type="text" aria-describedby="span-option-address" name="option_address" value="{{$valueAddress->option_value}}">
                </div>
                <span class="form-table-cell-hidden"></span>
                <div class="form-group input-group">
                    <span id="span-option-phone-number" class="input-group-addon">Teléfono:</span>
                    <input id="option-phone-number" class="form-control" type="tel" aria-describedby="span-option-phone-number" name="option_phone_number" value="{{$valuePhoneNumber->option_value}}">
                </div>
                <span class="form-table-cell-hidden"></span>
                <div class="form-group input-group">
                    <span id="span-option-web-site" class="input-group-addon">Pagina web:</span>
                    <input id="option-web-site" class="form-control" type="text" aria-describedby="span-option-web-site" name="option_web_site" value="{{$valueWebSite->option_value}}">
                </div>
                <span class="form-table-cell-hidden"></span>
                <div class="form-group input-group">
                    <span id="span-option-iva" class="input-group-addon">I.V.A.:</span>
                    <input id="option-iva" class="form-control" type="number" aria-describedby="span-option-iva" name="option_iva" value="{{$valueIVA->option_value}}">
                </div>
                <span class="form-table-cell-hidden"></span>
                <div class="form-group input-group">
                    <span id="span-setting-pagination-number-row-show" class="input-group-addon">Fondo de la factura:</span>
                    <input id="option-name" class="form-control" type="text" aria-describedby="span-setting-invoice-background-image" name="setting_invoice_background_image" value="{{$valueInvoiceBackgroundImage->option_value}}">
                </div>
                <span class="form-table-cell-hidden"></span>
                <div class="form-table-row">
                    <button class="btn btn-primary btn-block" type="submit">Guardar</button>
                </div>
            </div>
        </div>
    </form>
    <form method="post">
        <div class="panel panel-default">
            <div class="panel-heading">Configuración general</div>
            <div class="panel-body form-table">
                <div class="form-group input-group">
                    <span id="span-setting-date-format" class="input-group-addon">Formato de la fecha:</span>
                    <input id="option-name" class="form-control" type="text" aria-describedby="span-setting-date-format" name="setting_date_format" value="{{$valueDateFormat->option_value}}">
                </div>
                <span class="form-table-cell-hidden"></span>
                <div class="form-group input-group">
                    <span id="span-setting-pagination-number-row-show" class="input-group-addon">Numero de filas a mostrar por pagina:</span>
                    <input id="option-name" class="form-control" type="text" aria-describedby="span-setting-pagination-number-row-show" name="setting_pagination_number_row_show" value="{{$valuePaginationNumberRowShow->option_value}}">
                </div>
                <span class="form-table-cell-hidden"></span>
                <div class="form-table-row">
                    <button class="btn btn-primary btn-block" type="submit">Guardar</button>
                </div>
            </div>
        </div>
    </form>
</div>
#end
