<div class="text-header bg-primary">Lista de servicios/productos agregados</div>
<ul class="list-group">
    #foreach ($products as $product)
    <li class="list-group-item" data-element-id="{{$product['id']}}">
        <button id="btn-remove-product" class="btn btn-danger btn-action" type="button">
            <span class="glyphicon glyphicon-remove"></span>
        </button>
        <span>{{$product['product_name']}}</span>
        <span class="badge">Unidades: {{$product['receipt_product_unit']}}</span>
        <span class="badge">Precio U.: {{$product['product_price_unit']}} &euro;</span>
    </li>
    #endforeach
</ul>
