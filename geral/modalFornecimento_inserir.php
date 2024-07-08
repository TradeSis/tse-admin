<!--------- INSERIR --------->
<div class="modal fade bd-example-modal-lg" id="inserirFornecedorModal" tabindex="-1" aria-labelledby="inserirFornecedorModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Inserir Fornecedor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" id="form-inserirFornecedor">
                    <div class="row">
                        <div class="col-md">
                            <label class="form-label ts-label">Cnpj</label>
                            <input type="text" class="form-control ts-input" name="Cnpj">
                        </div>
                        <div class="col-md">
                            <label class="form-label ts-label">refProduto</label>
                            <input type="text" class="form-control ts-input" name="refProduto">
                        </div>
                        <div class="col-md-5">
                            <label class="form-label ts-label">idGeralProduto</label>
                            <input type="text" class="form-control ts-input" name="idGeralProduto" id="fornecimento_idGeralProduto">
                        </div>
                        <div class="col-md">
                            <label class="form-label ts-label">valorCompra</label>
                            <input type="text" class="form-control ts-input" name="valorCompra">
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md">
                            <label class="form-label ts-label">Origem</label>
                            <select class="form-select ts-input" name="origem">
                                <option value="0">0 - Nacional, exceto as indicadas nos códigos 3 a 5</option>
                                <option value="1">1 - Estrangeira - Importação direta, exceto a indicada no código 6</option>
                                <option value="2">2- Estrangeira - Adquirida no mercado interno, exceto a indicada no código 7</option>
                                <option value="3" title="mercadoria ou bem com Conteúdo de Importação superior a 40%">3 - Nacional, superior a 40%..</option>
                                <option value="4" title="cuja produção tenha sido feita em conformidade com os processos produtivos básicos de que tratam o
Decreto-Lei no 288/1967 , e as Leis nos 8.248/1991, 8.387/1991, 10.176/2001 e 11.484/2007">4 - Nacional, processos produtivos</option>
                                <option value="5" title="mercadoria ou bem com Conteúdo de Importação inferior ou igual a 40%">5 - Nacional, inferior ou igual a 40%</option>
                                <option value="6" title="Importação direta, sem similar nacional, constante em lista de Resolução Camex e gás natural">6- Estrangeira - Importação direta</option>
                                <option value="7" title="Adquirida no mercado interno, sem similar nacional, constante em lista de Resolução Camex
e gás natural">7 - Estrangeira - Adquirida no mercado interno</option>
                                <option value="8" title="mercadoria ou bem com Conteúdo de Importação superior a 70% (setenta por cento)">8 - Nacional, superior a 70% (setenta por cento)</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label ts-label">cfop</label>
                            <input type="text" class="form-control ts-input" name="cfop">
                        </div>
                    </div>
            </div><!--body-->
            <div class="modal-footer">
                <button type="submit" class="btn btn-success">Cadastrar</button>
            </div>
            </form>
        </div>
    </div>
</div>