<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>

@extends('layouts/contentNavbarLayout')
@section('title', 'Modals - UI elements')

@section('page-script')
    <script src="{{ asset('assets/js/ui-modals.js') }}"></script>
@endsection


@section('title', 'Tables - Basic Tables')

@section('vendor-script')
    <script>
        let token = $("meta[name='csrf-token']").attr("content");

        let tableName = '#indicadoresTable';
        $(tableName).DataTable({
            scrollX: true,
            deferRender: true,
            scroller: true,
        });


        $(document).on('click', '.delete_indi', function(event) {
            let recordId = $(event.currentTarget).data('id');

            $.ajax({
                url: `indicadorfinanciero/`,
                type: 'DELETE',
                data: {
                    "id": recordId,
                    "_token": token,
                },
                success: function(obj) {
                    if (obj.success) {

                        alert('Registro eliminado con Exito')
                        setTimeout(location.reload(), 5000);;
                    }
                },
            });
        });

        $(document).on('click', '.update_indi', function(event) {
            let id = $(event.currentTarget).data('id');
            document.getElementById('actualizar_indicador').reset();

            $.ajax({
                url: "indicadorfinanciero/" + id + "/edit",
                dataType: "json",
                type: 'GET',
                success: function(html) {
                    $('#idIndicador').val(id);
                    $('#nombreIndicador_e').val(html.data.nombreIndicador);
                    $('#codigoIndicador_e').val(html.data.codigoIndicador);
                    $('#unidadMedidaIndicador_e').val(html.data.unidadMedidaIndicador);
                    $('#valorIndicador_e').val(html.data.valorIndicador);
                    $('#fechaIndicador_e').val(html.data.fechaIndicador);
                    $('#tiempoIndicador_e').val(html.data.tiempoIndicador);
                    $('#origenIndicador_e').val(html.data.origenIndicador);
                }

            })


        });

        $(document).on('submit', '#registrar_indicador', function(event) {
            event.preventDefault();
            var btn = $(this);
            var nombreIndicador = btn.closest('form').find('input[name="nombreIndicador"]').val();
            var codigoIndicador = btn.closest('form').find('input[name="codigoIndicador"]').val();
            var unidadMedidaIndicador = btn.closest('form').find('input[name="unidadMedidaIndicador"]').val();
            var valorIndicador = btn.closest('form').find('input[name="valorIndicador"]').val();
            var fechaIndicador = btn.closest('form').find('input[name="fechaIndicador"]').val();
            var tiempoIndicador = btn.closest('form').find('input[name="tiempoIndicador"]').val();
            var origenIndicador = btn.closest('form').find('input[name="origenIndicador"]').val();

            if (!$.isNumeric(valorIndicador)) {

                return alert('Este campo es numerico');

            }
            let result = moment(fechaIndicador, 'YYYY-MM-DD', true).isValid();

            if (result === false) {

                return alert('Este campo es de tipo fecha');

            }

            $.ajax({
                url: 'indicadorfinanciero/',
                type: 'POST',
                data: {
                    "_token": token,
                    nombreIndicador,
                    codigoIndicador,
                    unidadMedidaIndicador,
                    valorIndicador,
                    fechaIndicador,
                    tiempoIndicador,
                    origenIndicador
                },
                success: function(obj) {
                    if (obj.success) {

                        if (obj.success) {

                            alert(obj.message)
                            setTimeout(location.reload(), 5000);;
                        }

                    }

                },
                error: function(data) {

                    let errors = ''

                    $.each(data.responseJSON.message, function(index, value) {

                        errors = errors + '\n' + value

                    });

                    alert(errors)
                },

            });

        });
        // iniciar API//
        $("#conexionapi").on("click", function() {
            $.ajax({
                url: 'webservice/',
                type: 'GET',
                success: function(obj, id) {
                    if (obj.success) {

                        if (obj.success) {

                            alert(obj.message)
                            setTimeout(location.reload(), 5000);;
                        }

                    }

                },
            });
        });
        // submit de actualizar //

        $(document).on('submit', '#actualizar_indicador', function(event) {
            event.preventDefault();
            var id = $(this).closest('form').find('input[name="idIndicador"]').val();
            var name = $(this).closest('form').find('input[name="valorIndicador"]').val();
            var nombreIndicador = $(this).closest('form').find('input[name="nombreIndicador"]').val();
            var codigoIndicador = $(this).closest('form').find('input[name="codigoIndicador"]').val();
            var unidadMedidaIndicador = $(this).closest('form').find('input[name="unidadMedidaIndicador"]').val();
            var valorIndicador = $(this).closest('form').find('input[name="valorIndicador"]').val();
            var fechaIndicador = $(this).closest('form').find('input[name="fechaIndicador"]').val();
            var tiempoIndicador = $(this).closest('form').find('input[name="tiempoIndicador"]').val();
            var origenIndicador = $(this).closest('form').find('input[name="origenIndicador"]').val();

            if (!$.isNumeric(valorIndicador)) {
                alert(valorIndicador);
                return alert('Este campo es numerico');

            }
            let result = moment(fechaIndicador, 'YYYY-MM-DD', true).isValid();

            if (result === false) {

                return alert('Este campo es de tipo fecha');

            }

            $.ajax({
                url: 'indicadorfinanciero/' + id + '/update',
                type: 'PUT',
                data: {
                    "_token": token,
                    nombreIndicador,
                    codigoIndicador,
                    unidadMedidaIndicador,
                    valorIndicador,
                    fechaIndicador,
                    tiempoIndicador,
                    origenIndicador
                },
                success: function(obj, id) {
                    if (obj.success) {

                        if (obj.success) {

                            alert(obj.message)
                            setTimeout(location.reload(), 5000);;
                        }

                    }

                },
                error: function(data) {

                    let errors = ''

                    $.each(data.responseJSON.message, function(index, value) {

                        errors = errors + '\n' + value

                    });

                    alert(errors)
                },

            });

        });
    </script>
@endsection

@section('content')
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Indicadores Financieros</span>
    </h4>
    <table>
        <tr>
            <td align="right">
                <div><button id="conexionapi" type="button" class="btn btn-primary">Conexion API</button></div>
            </td>
            <td align="left">
                <div><button id="newindi" type="button" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#addModal">Nuevo Indicador</button></div>
            </td>
        </tr>
    </table>
    <!-- Basic Bootstrap Table -->
    <div class="card">
        <h5 class="card-header">Datos de Indicadores Finacieros</h5>
        <div class="table-responsive text-nowrap">
            <table class="table" id="indicadoresTable">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Nombre Indicador</th>
                        <th>Código Indicador</th>
                        <th>Unidad Medida Indicador</th>
                        <th>Valor Indicador</th>
                        <th>Fecha Indicador</th>
                        <th>Tiempo Indicador</th>
                        <th>Origen Indicador</th>
                        <th>Operaciones Disponibles</th>

                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">

                    @foreach ($indicadores as $indicador)
                        <tr>
                            <td>
                                {{ $indicador->id }}
                            </td>
                            <td>
                                {{ $indicador->nombreIndicador }}
                            </td>
                            <td>
                                {{ $indicador->codigoIndicador }}
                            </td>
                            <td>
                                {{ $indicador->unidadMedidaIndicador }}
                            </td>
                            <td>
                                {{ $indicador->valorIndicador }}
                            </td>
                            <td>
                                {{ $indicador->fechaIndicador }}
                            </td>
                            <td>
                                {{ $indicador->tiempoIndicador }}
                            </td>
                            <td>
                                {{ $indicador->origenIndicador }}
                            </td>
                            <td>
                                <button data-id={{ $indicador->id }} type="button" class="btn btn-primary update_indi"
                                    data-bs-toggle="modal" data-bs-target="#updateModal"><i
                                        class="bx bx-edit-alt"></i></button>
                                <button data-id={{ $indicador->id }} type="button" class="btn btn-primary delete_indi"><i
                                        class="bx bxs-folder-minus"></i></button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <!--modal de registrar-->
    <div class="col-lg-4 col-md-6">
        <small class="text-light fw-semibold">Default</small>
        <div class="mt-3">
            <!-- Modal -->
            <div class="modal fade" id="addModal" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel1">Nuevo Indicador</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form id="registrar_indicador">
                            @csrf
                            <div class="modal-body">

                                <div class="row">
                                    <div class="col mb-3">
                                        <label class="form-label">Nombre Indicador</label>
                                        <input value='' name='nombreIndicador' type="text" id="nombreIndicador"
                                            class="form-control">
                                    </div>
                                </div>
                                <div class="row g-2">
                                    <div class="col mb-0">
                                        <label class="form-label">Código Indicador</label>
                                        <input value='' name='codigoIndicador' type="text" id="codigoIndicador"
                                            class="form-control">
                                    </div>
                                    <div class="col mb-0">
                                        <label class="form-label">Unidad Medida Indicador</label>
                                        <input value='' name='unidadMedidaIndicador' type="text"
                                            id="unidadMedidaIndicador" class="form-control">
                                    </div>
                                </div>
                                <div class="row g-3">
                                    <div class="col mb-0">
                                        <label class="form-label">Valor Indicador</label>
                                        <input value='' name='valorIndicador' type="text" id="valorIndicador"
                                            class="form-control">
                                    </div>
                                    <div class="col mb-0">
                                        <label class="form-label">Fecha Indicador</label>
                                        <input value='' name='fechaIndicador' type="date" id="fechaIndicador"
                                            class="form-control">
                                    </div>
                                </div>
                                <div class="row g-4">
                                    <div class="col mb-0">
                                        <label for="tiempoIndicador" class="form-label">Tiempo Indicador</label>
                                        <input value='' type="text" name='tiempoIndicador' id="tiempoIndicador"
                                            class="form-control">
                                    </div>
                                    <div class="col mb-0">
                                        <label class="form-label">Origen Indicador</label>
                                        <input value='' type="text" name='origenIndicador' id="origenIndicador"
                                            class="form-control">
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-outline-secondary"
                                        data-bs-dismiss="modal">Cerrar</button>
                                    <button type="submit" id="guardar_indicador"
                                        class="btn btn-primary">Guardar</button>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!--modal de actualizar-->
        <div class="col-lg-4 col-md-6">
            <small class="text-light fw-semibold">Default</small>
            <div class="mt-3">
                <!-- Modal -->
                <div class="modal fade" id="updateModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel1">Actualizar Indicador</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <form id="actualizar_indicador">
                                @csrf
                                <input value='' name='idIndicador' type="hidden" id="idIndicador">
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col mb-3">
                                            <label class="form-label">Nombre Indicador</label>
                                            <input value='' name='nombreIndicador' type="text"
                                                id="nombreIndicador_e" class="form-control">
                                        </div>
                                    </div>
                                    <div class="row g-2">
                                        <div class="col mb-0">
                                            <label class="form-label">Código Indicador</label>
                                            <input value='' type="text" name="codigoIndicador"
                                                id="codigoIndicador_e" class="form-control">
                                        </div>
                                        <div class="col mb-0">
                                            <label class="form-label">Unidad Medida Indicador</label>
                                            <input value='' type="text" name="unidadMedidaIndicador"
                                                id="unidadMedidaIndicador_e" class="form-control">
                                        </div>
                                    </div>
                                    <div class="row g-3">
                                        <div class="col mb-0">
                                            <label class="form-label">Valor Indicador</label>
                                            <input value='' type="text" name="valorIndicador"
                                                id="valorIndicador_e" class="form-control">
                                        </div>
                                        <div class="col mb-0">
                                            <label class="form-label">Fecha Indicador</label>
                                            <input value='' type="text" name="fechaIndicador"
                                                id="fechaIndicador_e" class="form-control">
                                        </div>
                                    </div>
                                    <div class="row g-4">
                                        <div class="col mb-0">
                                            <label class="form-label">Tiempo Indicador</label>
                                            <input value='' type="text" name="tiempoIndicador"
                                                id="tiempoIndicador_e" class="form-control">
                                        </div>
                                        <div class="col mb-0">
                                            <label class="form-label">Origen Indicador</label>
                                            <input value='' type="text" name=id="origenIndicador"
                                                id="origenIndicador_e" class="form-control">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-outline-secondary"
                                            data-bs-dismiss="modal">Cerrar</button>
                                        <button type="submit"
                                            class="btn btn-primary"id="actu_indicador">Actualizar</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endsection
