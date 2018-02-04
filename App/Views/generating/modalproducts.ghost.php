<div id="modal-products" class="modal fade content-autocomplete-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Lista de productos/servicios</h4>
            </div>
            <div class="modal-body">
                <form class="modal-form-search">
                    <input type="hidden" name="search-data-model" value="products"/>
                    <div class="row">
                        <div class="col-sm-7">
                            <div class="form-group input-group">
                                <span id="span-search-data" class="input-group-addon">Buscar</span>
                                <input id="search-data" class="form-control search-data" type="text" name="search-data-value" aria-describedby="span-search-data">
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <div class="form-group">
                                <label class="radio-inline">
                                    <input type="radio" name="search-data-column" value="product_name" checked> Nombre
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="search-data-column" value="product_reference"> Referencia
                                </label>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="content-autocomplete-data-list">
                    <div class="list-group">
                        No existen productos registrados.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
