<!--------- ALTERAR --------->
<div class="modal fade bd-example-modal-lg" id="alterarFornecedorModal" tabindex="-1" aria-labelledby="alterarFornecedorModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Alterar Fornecedor</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                
                    </div>
                    <div class="modal-body">
                        <form method="post" id="form-alterarFornecedor">
                            <div class="row">
                                <div class="col-md">
                                    <label class="form-label ts-label">Cnpj</label>
                                    <input type="text" class="form-control ts-input" name="Cnpj" id="Cnpj" disabled>
                                </div>
                                <div class="col-md">
                                    <label class="form-label ts-label">Fornecedor</label>
                                    <input type="text" class="form-control ts-input" name="nomePessoa" id="nomePessoa" disabled>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-2">
                                    <label class="form-label ts-label">IdGeralProduto</label>
                                    <input type="text" class="form-control ts-input" name="idGeralProduto" id="idGeralProdutoFOR" disabled>
                                    <input type="hidden" class="form-control ts-input" name="idFornecimento" id="idFornecimento">
                                </div>
                                <div class="col-md">
                                    <label class="form-label ts-label">Produto</label>
                                    <input type="text" class="form-control ts-input" name="nomeProduto" id="nomeProdutoFOR" disabled>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md">
                                    <label class="form-label ts-label">refProduto</label>
                                    <input type="text" class="form-control ts-input" name="refProduto" id="refProdutoFOR">
                                </div>
                                <div class="col-md">
                                    <label class="form-label ts-label">eanProduto</label>
                                    <input type="text" class="form-control ts-input" name="eanProduto" id="eanProdutoFOR" disabled>
                                </div>
                                <div class="col-md">
                                    <label class="form-label ts-label">valorCompra</label>
                                    <input type="text" class="form-control ts-input" name="valorCompra" id="valorCompra">
                                </div>
                                <div class="col-md">
                                    <label class="form-label ts-label">Att Trib.</label>
                                    <input type="text" class="form-control ts-input" name="dataAtualizacaoTributaria" id="dataAtualizacaoTributaria" readonly>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md">
                                    <label class="form-label ts-label">Origem</label>
                                    <select class="form-select ts-input" name="origem" id="origem">
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
                                    <input type="text" class="form-control ts-input" name="cfop" id="cfop">
                                </div>
                            </div>
                    </div><!--body-->
                    <div class="modal-footer">
                        <div class="col align-self-start pl-0">
                            <button type='button' class='btn btn-warning' data-bs-toggle='modal' data-bs-target='#atualizaFornecedorModal' data-id="idFornecedorAtualiza">Atualizar Produto</button>
                        </div>
                        <button type="submit" class="btn btn-success">Salvar</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>