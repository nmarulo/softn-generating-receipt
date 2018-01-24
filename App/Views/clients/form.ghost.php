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
#end
