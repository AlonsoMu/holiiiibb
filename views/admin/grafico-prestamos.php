<?php
require_once 'permisos.php';
?>
<style>
    /* Estilo para la clase month-year-input-field */
    .month-year-input-field {
        width: 250px;
        border-radius: 6px;
        height: 40px;
        font-size: 16px;
    }

    /* Media query para la vista móvil */
    @media (max-width: 576px) {
        .month-year-input-field {
            width: 180px;
            /* Cambia el ancho del campo de entrada para la vista móvil */
        }
    }
</style>
<div class="d-flex flex-column" id="content-wrapper">
    <div id="content">
        <!-- INICIO PERFIL -->

        <!-- FIN PERFIL -->
        <div class="container-fluid">
            <div class="container">
                <!-- Cabecera -->
                <!-- Botón de retroceso -->
                <div class="text-left">
                    <a href="javascript:history.back()" class="btn btn-primary btn-sm d-inline-block" role="button">
                        <i class="fas fa-chevron-left"></i>
                        &nbsp;Volver
                    </a>
                </div>
                <div class="d-grid gap-2 col-12 col-md-6 mx-auto">
                    <!-- Título oculto para pc y laptop -->
                    <div class="d-inline-block d-md-none text-center mt-2">
                        <h3 class="title-tablas2">Gráfico</h3>
                    </div>
                    <!-- Título oculto para móvil y tablet -->
                    <div class="row mt-3 d-none d-md-inline-block text-center">
                        <h3 class="title-tablas">Gráfico Préstamos</h3>
                    </div>
                </div>

                <div class="card mt-2">
                    <div class="card mt-2">
                        <div class="card-header d-flex flex-column justify-content-center align-items-center">
                            <input type="text" id="sum-amounts" style="width: 100px; color: black; background-color: aquamarine;" class="form-control" readonly>
                        </div>
                        <div class="card-body d-flex flex-column justify-content-center align-items-center">
                            <input type="month" id="month-year-input" name="month-year" class="form-control month-year-input-field" />
                            <button class="btn btn-warning text-black mt-2" type="button" id="mostrar"><b>Mostrar</b></button>
                        </div>
                    </div>

                    <div class="card-footer text-muted">
                        <div class="chart-container" style="position: relative; height: 300px;">
                            <canvas id="prestamos-chart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <script src="https://cdn.jsdelivr.net/npm/jquery"></script>
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
                $(document).ready(function() {
                    $('#mostrar').click(function() {
                        var monthYearInput = $('#month-year-input');
                        var selectedDate = new Date(monthYearInput.val() + '-01'); // Obtener la fecha seleccionada (primero del mes)
                        var selectedMonth = selectedDate.getMonth() + 2; // Obtener el mes y ajustar en 1
                        var selectedYear = selectedDate.getFullYear(); // Obtener el año

                        $.ajax({
                            url: '../../controllers/prestamo.controller.php',
                            type: 'GET',
                            data: {
                                operacion: 'graficoPrestamos',
                                mes: selectedMonth,
                                anio: selectedYear
                            },
                            dataType: 'json',
                            success: function(data) {
                                // Crear un array para los nombres de los libros
                                var bookTitles = $.map(data, function(item) {
                                    return item.Titulo;
                                });

                                // Crear un array para las cantidades de los préstamos
                                var loanAmounts = $.map(data, function(item) {
                                    return item.Cantidad;
                                });

                                // Calcular la suma de los amounts
                                var sumAmounts = loanAmounts.reduce(function(a, b) {
                                    return a + b;
                                }, 0);

                                // Formatear la suma como número entero y concatenar la palabra "libros"
                                var formattedSum = Math.round(sumAmounts).toLocaleString() + " libros";

                                // Actualizar el campo de texto con la suma de los amounts
                                $('#sum-amounts').val(formattedSum);

                                // Configurar los datos y opciones del gráfico Doughnut
                                var chartData = {
                                    labels: bookTitles,
                                    datasets: [{
                                        data: loanAmounts,
                                        backgroundColor: [
                                            '#FF6384',
                                            '#36A2EB',
                                            '#FFCE56',
                                            '#8A2BE2',
                                            '#FF4500',
                                            '#28B463',
                                            '#9ACD32',
                                            '#F7464A',
                                            '#1E90FF',
                                            '#FFDAB9',
                                            '#273746',
                                            '#CD5C5C',
                                            '#DC143C',
                                            '#DB7093',
                                            '#A04000',
                                            '#DA70D6',
                                            '#D4AC0D',
                                            '#DDA0DD',
                                            '#ADD8E6',
                                            '#FA8072',
                                            '#FFFACD',
                                            '#512E5F',
                                            '#186A3B',
                                            '#21618C',
                                            '#EEE8AA',
                                            '#B0C4DE',
                                            '#AFEEEE',
                                            '#66CDAA',
                                            '#BA55D3'
                                        ]
                                    }]
                                };

                                var chartOptions = {
                                    responsive: true,
                                    maintainAspectRatio: false
                                };

                                // Obtener el contexto del elemento canvas del gráfico
                                var ctx = document.getElementById('prestamos-chart').getContext('2d');

                                // Destruir el gráfico existente si existe
                                if (window.prestamosChart) {
                                    window.prestamosChart.destroy();
                                }

                                // Crear el gráfico Doughnut
                                window.prestamosChart = new Chart(ctx, {
                                    type: 'doughnut',
                                    data: chartData,
                                    options: chartOptions
                                });
                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                console.error(errorThrown);
                            }
                        });
                    });
                });
            </script>