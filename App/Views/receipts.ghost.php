{{ extends('layouts.master') }}

#set[content]
<h1>
    Facturas
    <a class="btn btn-success" href="#" title="Agregar">
        <span class="glyphicon glyphicon-plus"></span>
    </a>
</h1>
<div id="content-index" class="panel panel-default">
    <div class="panel-body">
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
                    <a class="btn btn-warning btn-generate-pdf" data-receipt-id="{{$receipt->id}}" href="#">
                        <span class="glyphicon glyphicon-open-file"></span>
                    </a>
                    <form method="post" action="{{url('/receipts/delete')}}">
                        <input type="hidden" name="id" value="{{$receipt->id}}"/>
                        <button type="submit" class="btn btn-danger">
                            <span class="glyphicon glyphicon-remove"></span>
                        </button>
                    </form>
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
</div>
#end
#set[scripts]
<script src="{{ asset('js/jspdf.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/script-generate-pdf.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/script-receipts.js') }}" type="text/javascript"></script>
#end
