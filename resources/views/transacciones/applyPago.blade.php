
<?php
use Carbon\Carbon;

$today = now()->format('Y-m-d');
?>
<div class="modal fade" id="applyModal" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-{{-- xl --}}md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-4">
                    <h3 class="role-title">Aplicar Pago</h3>
                </div>
                <div class="text-center">
                    <p>Monto de Pago</p>
                    <div class="d-flex justify-content-center align-items-center">
                        <sup class="h6 pricing-currency mt-3 mb-0 me-1" style="color: #697A8D">$</sup>
                        <h1 class="amount mb-0 text-primary" id="pago_semanal"></h1>
                    </div>
                    <div
                        class="col-{{-- 3 --}}6 mx-auto d-flex justify-content-between align-items-center bg-lighter p-2 mb-2 mt-4">
                        <p class="mb-0 fw-semibold" style="font-size: 12px">ID SOLICITUD:</p>
                        <p class="fw-bold mb-0 d-block text-truncate text-third" id="idSolicitudView"></p>
                    </div>
                </div>
                <form action="{{ route('admin.transacciones.store') }}" method="POST" class="mx-auto">
                    @csrf
                    <input type="hidden" name="idSolicitud" id="idSolicitud">
                   <div class="row">
                        <div class="col-5 mx-auto mt-2">
                            <label class="form-label" for="fecha_pago">Fecha de Pago</label>
                            <input type="date" name="fecha_pago" class="form-control" value="{{ $today }}">
                        </div>
                        <div class="col-5 mx-auto mt-2">
                            <label class="form-label">Monto de Transacción</label>
                            <div class="input-group input-group-merge">
                                <span class="input-group-text">$</span>
                                <input type="number" class="form-control" step="0.01" id="monto_pago" name="monto_pago" placeholder="00" required>
                                <span class="input-group-text">.00</span>
                            </div>
                        </div>
                   </div>
                    <div class="row">
                        <div class="col-5 mx-auto mt-2">
                            <label class="form-label" for="basic-icon-default-phone">Tipo de Cobro</label>
                            <select class="form-select item-details mb-2" id="tipo_pago" name="tipo_pago" required onchange="cuentaTipoPago()">
                                <option>-- Selecciona --</option>
                                <option value="Transferencia">Transferencia</option>
                                <option value="Efectivo">Efectivo</option>
                                <option value="Cheque">Cheque</option>
                                <option value="Especie">Especie</option>
                            </select>
                        </div>
                        <div class="col-5 mx-auto mt-2">
                            <label class="form-label" for="basic-default-message">Observaciones</label>
                            <input type="text" class="form-control text-uppercase invoice-item-price mb-2" id="observaciones" name="observaciones" placeholder="">
                        </div>
                    </div>
                    <div class="row">
                        <div id="cuentaTransferencia" style="display: none">
                            <div class="col-7 mx-auto mt-2">
                                <div class="form-group">
                                    <label class="form-label" for="basic-icon-default-phone">Cuenta Transferencia</label>
                                    <select class="form-select item-details mb-2" id="cuenta_transferencia" name="cuenta_transferencia">
                                        <option>-- Selecciona --</option>
                                        @foreach($bancos as $banco)
                                            <option {{ old('cuenta_transferencia') == $banco->id ? 'selected' : '' }} value="{{$banco->id}}">{{$banco->nombre_cuenta}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div id="cuentaEfectivo" style="display: none">
                            <div class="col-7 mx-auto mt-2">
                                <div class="form-group">                                            
                                    <label class="form-label" for="basic-icon-default-phone">Cuenta Efectivo</label>
                                    <select class="form-select item-details mb-2" id="cuenta_efectivo" name="cuenta_efectivo">
                                        <option>-- Selecciona --</option>
                                        @foreach($cuentasCaja as $cuentaC)
                                            <option {{ old('cuenta_efectivo') == $cuentaC->id ? 'selected' : '' }} value="{{$cuentaC->cuentas_id}}">{{$cuentaC->nombre_caja}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div id="cuentaCheque" style="display: none">
                            <div class="col-7 mx-auto mt-2">
                                <div class="form-group">
                                    <label class="form-label" for="basic-icon-default-phone">Cuenta Cheque</label>
                                    <select class="form-select item-details mb-2" id="cuenta_cheque" name="cuenta_cheque">
                                        <option>-- Selecciona --</option>
                                        @foreach($bancos as $banco)
                                            <option {{ old('cuenta_cheque') == $banco->id ? 'selected' : '' }} value="{{$banco->id}}">{{$banco->nombre_cuenta}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div id="cuentaEspecie" style="display: none">
                            <div class="col-7 mx-auto mt-2">
                                <div class="form-group">
                                    <label class="form-label" for="basic-icon-default-phone">Cuenta Especie</label>
                                    <select class="form-select item-details mb-2" id="cuenta_especie" name="cuenta_especie">
                                        <option>-- Selecciona --</option>
                                        @foreach($cuentaActivo as $cuentaAct)
                                            <option {{ old('cuenta_especie') == $cuentaAct->id ? 'selected' : '' }} value="{{$cuentaAct->cuentas_id}}">{{$cuentaAct->cuentas->nombre_cuenta}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer pt-4 pb-0">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            Cancelar
                        </button>
                        <button type="submit" class="btn btn-primary">
                            Aplicar
                            <i class="bx bx-check-circle"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    function cuentaTipoPago() {
        if($("#tipo_pago").val() == "Transferencia"){
            $("#cuentaTransferencia").slideDown('slow');
            $("#cuentaEfectivo").hide(1000);
            $("#cuentaCheque").hide(1000);
            $("#cuentaEspecie").hide(1000);
        }else if($("#tipo_pago").val() == "Efectivo"){
            $("#cuentaEfectivo").slideDown('slow');
            $("#cuentaTransferencia").hide(1000);
            $("#cuentaCheque").hide(1000);
            $("#cuentaEspecie").hide(1000);
        }else if($("#tipo_pago").val() == "Cheque"){
            $("#cuentaCheque").slideDown('slow');
            $("#cuentaEfectivo").hide(1000);
            $("#cuentaTransferencia").hide(1000);
            $("#cuentaEspecie").hide(1000);
        }else if($("#tipo_pago").val() == "Especie"){
            $("#cuentaEspecie").slideDown('slow');
            $("#cuentaTransferencia").hide(1000);
            $("#cuentaEfectivo").hide(1000); 
            $("#cuentaCheque").hide(1000);
        }else{
            $("#cuentaTransferencia").hide(1000);
            $("#cuentaEfectivo").hide(1000); 
            $("#cuentaCheque").hide(1000);
            $("#cuentaEspecie").hide(1000);

        }
    }
</script>
