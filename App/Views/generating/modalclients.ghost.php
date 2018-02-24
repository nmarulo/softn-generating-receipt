<div id="modal-clients" class="modal fade content-autocomplete-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Lista de clientes</h4>
            </div>
            <div class="modal-body">
                <form class="modal-form-search">
                    <input type="hidden" name="search-data-model" value="clients"/>
                    <div class="row">
                        <div class="col-sm-8">
                            <div class="form-group input-group">
                                <span id="span-search-data" class="input-group-addon">Buscar</span>
                                <input class="form-control search-data" type="text" name="search-data-value" aria-describedby="span-search-data">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="radio-inline">
                                    <input type="radio" name="search-data-column" value="client_name" checked> Nombre
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="search-data-column" value="client_identification_document"> DNI
                                </label>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="content-autocomplete-data-list">
                    No existen clientes registrados.
                </div>
            </div>
        </div>
    </div>
</div>
