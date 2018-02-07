{{ extends('layouts.master') }}

#set[content]
<h1>
    {{$actionValue}} cliente
    #if ($isUpdate)
        <a class="btn btn-success" href="{{url('/clients/form')}}" title="Agregar">
            <span class="glyphicon glyphicon-plus"></span>
        </a>
    #endif
</h1>
<div id="content-index" class="row">
    <div class="col-sm-6">
        <div class="panel panel-default">
            <div class="panel-body">
                <form class="form-table" method="post">
                    <div class="form-group input-group">
                        <span id="span-client-name" class="input-group-addon">Nombre</span>
                        <input id="client-name" class="form-control" type="text" aria-describedby="span-client-name" name="client_name" value="{{$client->client_name}}">
                    </div>
                    <span class="form-table-cell-hidden"></span>
                    <div class="form-group input-group">
                        <span id="span-client-address" class="input-group-addon">Dirección</span>
                        <input id="client-address" class="form-control" type="text" aria-describedby="span-client-address" name="client_address" value="{{$client->client_address}}">
                    </div>
                    <span class="form-table-cell-hidden"></span>
                    <div class="form-group input-group">
                        <span id="span-client-identification-document" class="input-group-addon">Documento de identificación</span>
                        <input id="client-identification-document" class="form-control" aria-describedby="span-client-identification-document" type="text" name="client_identification_document" value="{{$client->client_identification_document}}">
                    </div>
                    <span class="form-table-cell-hidden"></span>
                    <div class="form-group input-group">
                        <span id="span-client-city" class="input-group-addon">Ciudad</span>
                        <input id="client-city" class="form-control" type="text" aria-describedby="span-client-city" name="client_city" value="{{$client->client_city}}">
                    </div>
                    <span class="form-table-cell-hidden"></span>
                    <input type="hidden" value="{{$client->id}}" name="id">
                    <input type="hidden" value="update" name="method">
                    <div class="form-table-row">
                        <button class="btn btn-primary btn-block" type="submit">{{$actionValue}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    #if($isUpdate)
    <div class="col-sm-6">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Facturas</h3>
            </div>
            <div class="panel-body">
                #if(count($receipts) > 0)
                {{ component('pagination') }}
                <div class="table-responsive">
                    <table id="data-table-list" class="table table-hover table-striped">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Numero</th>
                                <th>Tipo</th>
                                <th>Fecha</th>
                            </tr>
                        </thead>
                        <tbody id="content-data-list">
                            #foreach($receipts as $receipt)
                            <tr>
                                <td class="btn-actions">
                                    <a class="btn btn-warning btn-generate-pdf" data-receipt-id="{{$receipt->id}}" href="{{url('/generating/datapdf')}}">
                                        <span class="glyphicon glyphicon-open-file"></span>
                                    </a>
                                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal-delete" data-element-id="{{$receipt->id}}" data-form-action="{{url('/receipts/delete')}}" data-update="#data-table-list">
                                            <span class="glyphicon glyphicon-remove"></span>
                                    </button>
                                </td>
                                <td>{{$receipt->receipt_number}}</td>
                                <td>{{$receipt->receipt_type}}</td>
                                <td>{{$receipt->receipt_date}}</td>
                            </tr>
                            #endforeach
                        </tbody>
                    </table>
                </div>
                #else
                <p>Sin resultados.</p>
                #endif
            </div>
        </div>
    </div>
    #endif
</div>
{{ include('includes.modaldelete') }}
#end
#set[scripts]
<script src="{{ asset('js/script-modal-delete.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/jspdf.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/script-generate-pdf.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/script-receipts.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/script-data-list.js') }}" type="text/javascript"></script>
#end
