{{ extends('layouts.master') }}

#set[content]
<h1>
    Clientes
    <a class="btn btn-success" href="{{url('/clients/form')}}" title="Agregar">
        <span class="glyphicon glyphicon-plus"></span>
    </a>
</h1>
<div id="content-index" class="panel panel-default">
    <div class="panel-body">
        <h3>Lista de clientes</h3>
        {{ component('pagination') }}
        <div class="table-responsive">
            <table id="data-table-list" class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th></th>
                        <th data-column="client_name">Nombre</th>
                        <th data-column="client_identification_document">Documento de identificación</th>
                        <th data-column="client_address">Dirección</th>
                        <th data-column="client_city">Ciudad</th>
                        <th data-column="client_number_receipts">Facturas</th>
                    </tr>
                </thead>
                <tbody id="content-data-list">
                    #foreach($clients as $client)
                    <tr>
                        <td class="btn-actions">
                            <a class="btn btn-primary" href="{{url('/clients/form/')}}{{$client->id}}">
                                <span class="glyphicon glyphicon-pencil"></span>
                            </a>
                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal-delete" data-element-id="{{$client->id}}" data-form-action="{{url('/clients/delete')}}">
                                    <span class="glyphicon glyphicon-remove"></span>
                            </button>
                        </td>
                        <td>{{$client->client_name}}</td>
                        <td>{{$client->client_identification_document}}</td>
                        <td>{{$client->client_address}}</td>
                        <td>{{$client->client_city}}</td>
                        <td>{{$client->client_number_receipts}}</td>
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
<script src="{{ asset('js/script-data-list.js') }}" type="text/javascript"></script>
#end
