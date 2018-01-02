{{ extends('layouts.master') }}

#set[content]
<h1>
    Productos/Servicios
    <a class="btn btn-success" href="{{url('/products/form')}}" title="Agregar">
        <span class="glyphicon glyphicon-plus"></span>
    </a>
</h1>
<div id="content-index" class="panel panel-default">
    <div class="panel-body">
        <h3>Lista de productos/servicios</h3>
        <table class="table table-hover table-striped">
        <thead>
            <tr>
                <th></th>
                <th>Referencia</th>
                <th>Nombre</th>
                <th>Precio unidad</th>
            </tr>
        </thead>
        <tbody id="content-data-list">
            #foreach($products as $product)
            <tr>
                <td class="btn-actions">
                    <a class="btn btn-primary" href="{{url('/products/form/')}}{{$product->id}}">
                        <span class="glyphicon glyphicon-pencil"></span>
                    </a>
                    <form method="post" action="{{url('/products/delete')}}">
                        <input type="hidden" name="id" value="{{$product->id}}"/>
                        <button type="submit" class="btn btn-danger">
                            <span class="glyphicon glyphicon-remove"></span>
                        </button>
                    </form>
                </td>
                <td>{{$product->product_reference}}</td>
                <td>{{$product->product_name}}</td>
                <td class="text-right">{{$product->product_price_unit}} &euro;</td>
            </tr>
            #endforeach
        </tbody>
    </table>
    </div>
</div>
#end
