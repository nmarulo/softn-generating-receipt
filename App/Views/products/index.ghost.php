{{ extends('layouts.master') }}

#set[content]
<h1>
    Productos/Servicios
    <a class="btn btn-success" href="{{ url('/products/form') }}" title="Agregar">
        <span class="glyphicon glyphicon-plus"></span>
    </a>
</h1>
<div id="content-index" class="panel panel-default">
    <div class="panel-body">
        <h3>Lista de productos/servicios</h3>
        <div class="row">
            <div class="col-md-6">
                {{ component('pagination') }}
            </div>
            <div class="col-md-6">
                <form class="form-data-table-list">
                    <div class="form-group input-group">
                        <span id="span-search-data" class="input-group-addon">Buscar</span>
                        <input class="form-control search-data" type="text" name="search-data-value" aria-describedby="span-search-data">
                        <span class="input-group-addon">
                            <input type="radio" name="search-data-column" value="product_name" checked> Nombre
                        </span>
                        <span class="input-group-addon">
                            <input type="radio" name="search-data-column" value="product_reference"> Referencia
                        </span>
                    </div>
                </form>
            </div>
        </div>
        <div class="table-responsive">
            <table id="data-table-list" class="table table-hover table-striped">
                <thead>
                <tr>
                    <th></th>
                    <th data-column="product_reference">Referencia</th>
                    <th data-column="product_name">Nombre</th>
                    <th data-column="product_price_unit">Precio unidad</th>
                </tr>
                </thead>
                <tbody id="content-data-list">
                    #foreach($products as $product)
                    <tr>
                        <td class="btn-actions">
                            <a class="btn btn-primary" href="{{ url('/products/form/') }}{{$product->id}}">
                                <span class="glyphicon glyphicon-pencil"></span>
                            </a>
                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal-delete" data-element-id="{{$product->id}}" data-form-action="{{ url('/products/delete') }}">
                                    <span class="glyphicon glyphicon-remove"></span>
                            </button>
                        </td>
                        <td>{{$product->product_reference}}</td>
                        <td>{{$product->product_name}}</td>
                        <td class="text-right">{{$product->product_price_unit}} &euro;</td>
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
