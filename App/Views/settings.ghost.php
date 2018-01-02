{{ extends('layouts.master') }}

#set[content]
<h1>Opciones</h1>
<div>
    <form method="get">
        <div class="panel panel-default">
            <div class="panel-heading">Datos de la factura</div>
            <div class="panel-body form-table">
                <div class="form-group input-group">
                    <span id="span-option-name" class="input-group-addon">Nombre:</span>
                    <input id="option-name" class="form-control" type="text" aria-describedby="span-option-name" name="setting_key_name" value="{{$valueName->option_value}}">
                </div>
                <span class="form-table-cell-hidden"></span>
                <div class="form-group input-group">
                    <span id="span-option-identification-document" class="input-group-addon">Documento de identificación:</span>
                    <input id="option-name" class="form-control" type="text" aria-describedby="span-option-identification-document" name="setting_key_identification_document" value="{{$valueIdentificationDocument->option_value}}">
                </div>
                <span class="form-table-cell-hidden"></span>
                <div class="form-group input-group">
                    <span id="span-option-address" class="input-group-addon">Dirección:</span>
                    <input id="option-address" class="form-control" type="text" aria-describedby="span-option-address" name="setting_key_address" value="{{$valueAddress->option_value}}">
                </div>
                <span class="form-table-cell-hidden"></span>
                <div class="form-group input-group">
                    <span id="span-option-phone-number" class="input-group-addon">Teléfono:</span>
                    <input id="option-phone-number" class="form-control" type="tel" aria-describedby="span-option-phone-number" name="setting_key_phone_number" value="{{$valuePhoneNumber->option_value}}">
                </div>
                <span class="form-table-cell-hidden"></span>
                <div class="form-group input-group">
                    <span id="span-option-web-site" class="input-group-addon">Pagina web:</span>
                    <input id="option-web-site" class="form-control" type="text" aria-describedby="span-option-web-site" name="setting_key_web_site" value="{{$valueWebSite->option_value}}">
                </div>
                <span class="form-table-cell-hidden"></span>
                <div class="form-group input-group">
                    <span id="span-option-iva" class="input-group-addon">I.V.A.:</span>
                    <input id="option-iva" class="form-control" type="number" aria-describedby="span-option-iva" name="setting_key_iva" value="{{$valueIVA->option_value}}">
                </div>
                <span class="form-table-cell-hidden"></span>
                <div class="form-table-row">
                    <button class="btn btn-primary btn-block" type="submit">Guardar</button>
                </div>
            </div>
        </div>
        <input type="hidden" name="method" value="update">
    </form>
</div>
#end
