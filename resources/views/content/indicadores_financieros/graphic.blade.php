<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>

@extends('layouts/contentNavbarLayout')
@section('title', 'Modals - UI elements')

@section('page-script')
    <script src="{{ asset('assets/js/ui-modals.js') }}"></script>
@endsection


@section('title', 'Tables - Basic Tables')

@section('vendor-script')
    <script></script>

@endsection

@section('content')

    <div class="layout-demo-wrapper">
        <h1>Gráfico Comportamiento de Indicador</h1>
        <form id="form-busqueda">
            @csrf
            <div class="row">
                <div class="col-4">
                    <label for="gDesde" class="col-md-2 col-form-label">Desde</label>
                    <div class="col-md-10">
                        <input class="form-control" name="gDesde" type="date" value="2021-06-18" id="gDesde">
                    </div>
                </div>
                <div class="col-4">
                    <label for="gHasta" class="col-md-2 col-form-label">Hasta</label>
                    <div class="col-md-10">
                        <input class="form-control" name="gHasta" type="date" value="2021-06-18" id="gHasta">
                    </div>
                </div>
                <div class="col-4 mt-2">
                    <label for="defaultSelect" class="form-label">Indicador</label>
                    <select id="codigoIndicador" class="form-select" name="codigoIndicador">
                        <option>Seleccionar Indicador</option>
                        @foreach ($listas as $lista)
                            <option value={{ $lista->codigoIndicador }}>{{ $lista->codigoIndicador }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <button type="submit" class="mt-2 btn btn-primary" id="buscar-g">buscar</button>
                </div>
            </div>
        </form>
        <canvas id="grafica"></canvas>
    </div>

    <!--/ Layout Demo -->
    <script type="text/javascript">
        let token = $("meta[name='csrf-token']").attr("content");



        $(document).on('submit', '#form-busqueda', function(event) {
            event.preventDefault();
            var btn = $(this);
            var codigoIndicador = btn.closest('form').find('select[name="codigoIndicador"]').val();
            var gDesde = btn.closest('form').find('input[name="gDesde"]').val();
            var gHasta = btn.closest('form').find('input[name="gHasta"]').val();

            $.ajax({
                url: 'getmeses',
                type: 'GET',
                data: {
                    "_token": token,
                    codigoIndicador,
                    gDesde,
                    gHasta
                },
                success: function(obj, id) {

                    getGraphic(obj.result.fecha, obj.result.valor)

                }
            });
        });

        function getGraphic(etiquetas, data) {
            const $grafica = document.querySelector("#grafica");
            const datos = {
                label:"Indicador",
                data: data,
                backgroundColor: 'rgba(54, 162, 235, 0.2)', // Color de fondo
                borderColor: 'rgba(54, 162, 235, 1)', // Color del borde
                borderWidth: 1, // Ancho del borde
            };
            new Chart($grafica, {
                type: 'line', // Tipo de gráfica
                data: {
                    labels: etiquetas,
                    datasets: [
                        datos,
                        // Aquí más datos...
                    ]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }],
                    },
                }
            });
        }
    </script>
@endsection
