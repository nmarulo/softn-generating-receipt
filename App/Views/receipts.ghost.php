{{ extends('layouts.master') }}

#set[content]
<h1>
    Facturas
    <a class="btn btn-success" href="{{ url('/generating') }}" title="Agregar">
        <span class="glyphicon glyphicon-plus"></span>
    </a>
</h1>
<div id="content-index" class="panel panel-default">
    <div class="panel-body">
        <h3>Lista de facturas</h3>
        {{ component('pagination') }}
        <div class="table-responsive">
            <table id="data-table-list" class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th></th>
                        <th data-column="receipt_number">Numero</th>
                        <th data-column="receipt_type">Tipo</th>
                        <th data-column="receipt_date">Fecha</th>
                        <th data-column="client_id">Cliente</th>
                    </tr>
                </thead>
                <tbody id="content-data-list">
                    #foreach($receipts as $receipt)
                    <tr>
                        <td class="btn-actions">
                            <a class="btn btn-warning btn-generate-pdf" data-receipt-id="{{$receipt->id}}" href="{{ url('/generating/datapdf') }}">
                                <span class="glyphicon glyphicon-save-file"></span>
                            </a>
                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal-delete" data-element-id="{{$receipt->id}}" data-form-action="{{ url('/receipts/delete') }}">
                                    <span class="glyphicon glyphicon-remove"></span>
                            </button>
                        </td>
                        <td>{{$receipt->receipt_number}}</td>
                        <td>{{$receipt->receipt_type}}</td>
                        <td>{{$receipt->receipt_date}}</td>
                        <td>
                            <a href="{{ url('/clients/form/'.$receipt->client_id) }}">
                                <span class="glyphicon glyphicon-link"></span>
                                {{$receipt->client->client_name}}
                            </a>
                        </td>
                    </tr>
                    #endforeach
                </tbody>
            </table>
        </div>
        {{ component('pagination') }}
    </div>
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
