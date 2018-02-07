{{ extends('layouts.master') }}

#set[content]
<h1>
    {{$actionValue}} producto/servicio
    #if ($isUpdate)
    <a class="btn btn-success" href="{{url('/products/form')}}" title="Agregar">
        <span class="glyphicon glyphicon-plus"></span>
    </a>
    #endif
</h1>
<div class="panel panel-default">
    <div class="panel-body">
        <form class="form-table" method="post">
            <div class="form-group input-group">
                <span id="span-product-name" class="input-group-addon">Nombre</span>
                <input id="product-name" class="form-control" type="text" aria-describedby="span-product-name" name="product_name" value="{{$product->product_name}}">
            </div>
            <span class="form-table-cell-hidden"></span>
            <div class="form-group input-group">
                <span id="span-product-price-unit" class="input-group-addon">Precio unidad</span>
                <input id="product-price-unit" class="form-control" type="text" aria-describedby="span-product-price-unit" name="product_price_unit" value="{{$product->product_price_unit}}">
            </div>
            <span class="form-table-cell-hidden"></span>
            <div class="form-group input-group">
                <span id="span-product-reference" class="input-group-addon">Referencia</span>
                <input id="product-reference" class="form-control" type="text" aria-describedby="span-product-reference" name="product_reference" value="{{$product->product_reference}}">
            </div>
            <span class="form-table-cell-hidden"></span>
            <input type="hidden" value="{{$product->id}}" name="id">
            <input type="hidden" value="update" name="method">
            <div class="form-table-row">
                <button class="btn btn-primary btn-block" type="submit">{{$actionValue}}</button>
            </div>
        </form>
    </div>
</div>
#end
