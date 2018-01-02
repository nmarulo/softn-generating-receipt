{{ extends('layouts.master') }}

#set[content]
<h1>
    Facturas
    <a class="btn btn-success" href="#" title="Agregar">
        <span class="glyphicon glyphicon-plus"></span>
    </a>
</h1>
<div id="content-index">
    <h3>Lista de facturas</h3>
    <table class="table table-hover table-striped">
        <thead>
            <tr>
                <th></th>
                <th>Numero</th>
                <th>Tipo</th>
                <th>Fecha</th>
                <th>Cliente</th>
            </tr>
        </thead>
        <tbody id="content-data-list">
            #foreach($receipts as $receipt)
            <tr>
                <td class="btn-actions">
                    <a class="btn btn-warning btn-generate-pdf" data-receipt-id="" href="#">
                        <span class="glyphicon glyphicon-open-file"></span>
                    </a>
                    <a class="btn btn-danger" href="">
                        <span class="glyphicon glyphicon-remove"></span>
                    </a>
                </td>
                <td>{{$receipt->receipt_number}}</td>
                <td>{{$receipt->receipt_type}}</td>
                <td>{{$receipt->receipt_date}}</td>
                <td>{{$receipt->client_id}}</td>
            </tr>
            #endforeach
        </tbody>
    </table>
</div>
#end
