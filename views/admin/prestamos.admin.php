<?php

require_once 'permisos.php';

?>
<div id="wrapper">
    <!-- INICIO SIDEBAR LEFT -->

    <div class="d-flex flex-column" id="content-wrapper">
        <div id="content">
            <!-- INICIO PERFIL -->

            <!-- FIN PERFIL -->
            <div class="container-fluid">
                <div class="card shadow">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <div class="d-grid gap-2 col-6 mx-auto">
                                <!-- Título oculto para pc y laptop -->
                                <div class="d-inline-block d-md-none text-center">
                                    <h3 class="title-tablas2">
                                        Préstamos
                                    </h3>
                                </div>
                                <!-- Título oculto para móvil y tablet -->
                                <div class="d-none d-md-inline-block text-center">
                                    <h3 class="title-tablas">
                                        Módulo de Préstamos
                                    </h3>
                                </div>

                                <div class="btn-group" role="group">
                                    <!-- Example single danger button -->
                                    <div class="btn-group d-sm-none  d-none d-md-inline-block" style="margin-right: 10px;">
                                        <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                            <i class="fa-solid fa-filter fa-lg" style="color: #000000;"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="#">PRÉSTADOS</a>
                                            <a class="dropdown-item" href="#">PENDIENTES</a>
                                            <a class="dropdown-item" href="#">DEVUELTOS</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="#">CANCELADOS</a>
                                        </div>
                                    </div>
                                    <!-- Enlace para redirigir a la vista de reporte -->
                                    <a href="index.php?view=report-prestamo.php" class="btn btn-danger  d-none d-md-inline-block" style="margin-right: 10px;">
                                        <i class="fas fa-solid fa-file-pdf fa-sm text-black fa-xl"></i>
                                        &nbsp;Reporte
                                    </a>
                                    <!-- Enlace para redirigir a la vista de gráficos -->
                                    <a href="index.php?view=grafico-prestamos.php" class="btn btn-info d-none d-md-inline-block">
                                        <i class="fas fa-chart-pie fa-sm text-black fa-xl"></i>
                                        &nbsp;Gráfico
                                    </a>
                                </div>

                                <!-- INICIO Versión Móvil -->
                                <div class="d-flex mx-auto d-md-none">
                                    <div class="btn-group w-100" role="group">
                                        <div class="btn-group w-100" role="group">
                                            <!-- Estados -->
                                            <div class="btn-group d-md-none" style="margin-right: 10px;">
                                                <button type="button" class="btn btn-outline-warning dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                    <i class="fa-solid fa-filter text-black fa-xl" style="color: #000000;"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="#">Action</a>
                                                    <a class="dropdown-item" href="#">Another action</a>
                                                    <a class="dropdown-item" href="#">Something else here</a>
                                                    <div class="dropdown-divider"></div>
                                                    <a class="dropdown-item" href="#">Separated link</a>
                                                </div>
                                            </div>
                                            <!-- Botón para mostrar la vista de generar de reporte (versión móvil) -->
                                            <a class="btn btn-outline-danger btn-sm d-inline-block mr-2" id="reportButton" href="index.php?view=report-prestamo.php">
                                                <i class="fas fa-solid fa-file-pdf fa-sm text-black fa-xl"></i>
                                                &nbsp;Reporte
                                            </a>
                                            <!-- Botón para mostrar la vista de generar de reporte (versión móvil) -->
                                            <a class="btn btn-outline-info btn-sm d-inline-block" id="chartsButton" href="index.php?view=grafico-prestamos.php">
                                                <i class="fas fa-chart-pie fa-sm text-black fa-xl"></i>
                                                &nbsp;Gráfico
                                            </a>
                                        </div>
                                    </div>
                                    <!-- FIN Versión Móvil -->
                                </div>
                            </div>

                            <!-- Datatable -->
                            <div style="width: 90%; margin:auto" class="mt-2">
                                <div class="card-body">
                                    <table class="table display responsive" id="tabla-prestamos">
                                        <colgroup>
                                            <col width="5%">
                                            <col width="25%">
                                            <col width="20%">
                                            <col width="20%">
                                            <col width="15%">
                                            <col width="15%">
                                        </colgroup>
                                        <thead class="table-dark">
                                            <tr>
                                                <th>#</th>
                                                <th>Libro</th>
                                                <th>Usuario</th>
                                                <th>Observación</th>
                                                <th>Registro</th>
                                                <th>Recojo</th>
                                                <th>Retorno</th>
                                                <th>Cancelado</th>
                                                <th>Cantidad</th>
                                                <th>Reporte</th>
                                                <th>Estado</th>
                                                <th>Comandos</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <footer class="bg-white sticky-footer">
                <div class="container my-auto">
                    <div class="text-center my-auto copyright">
                        <span>Copyright © ARFECAS 2023</span>
                    </div>
                </div>
            </footer>
        </div>



        <!-- Mis funciones y eventos javascript -->
        <script>
            $(document).ready(function() {
                idusers = <?php echo $_SESSION['login']['idusers']; ?>;
                accesslevel = "<?php echo $_SESSION['login']['accesslevel']; ?>";
                const selectLibro = document.querySelector("#libro");



                function listarPrestamos() {
                    $.ajax({
                        url: '../../controllers/prestamo.controller.php',
                        type: 'GET',
                        data: {
                            'operacion': 'listarPrestamo',
                            'idusers': idusers,
                            'accesslevel': accesslevel
                        },
                        success: function(result) {
                            let registros = JSON.parse(result);
                            let nuevaFila = ''; // Mover la declaración aquí

                            let tabla = $("#tabla-prestamos").DataTable();
                            tabla.destroy();
                            $("#tabla-prestamos tbody").html("");
                            registros.forEach(registro => {
                                nuevaFila += `
                    <tr>
                        <td>${registro['idloan']}</td>
                        <td>${registro['Titulo']}</td>
                        <td>${registro['Usuario']}</td>
                        <td>${registro['Observacion']}</td>
                        <td>${registro['F. Registro']}</td>
                        <td>${registro['F. Recojo']}</td>
                        <td>${registro['F. Retorno']}</td>
                        <td>${registro['F. Cancelacion']}</td>
                        <td>${registro['Cantidad']}</td>
                        <td>${registro['Perdida']}</td>
                        <td>${registro['Estado']}</td>
                        <td>
                            <button id='entregar' class='btn btn-success' data-id="" title='Entregar'>
                                <a style='color: black; font-weight:bold;'>
                                <i class="fa-solid fa-hand-holding-hand" style="color: #000000;"></i>
                                </a>
                            </button>
                            <button id='cancelar' class='btn btn-danger' data-id="" title='Cancelar'>
                                <a style='color: black; font-weight:bold;'>
                                    <i class="fa-solid fa-ban" style="color: #000000;"></i>
                                </a>
                            </button>
                            <button id='devolver' class='btn btn-warning' data-id="" title='Devolver'>
                                <a style='color: black; font-weight:bold;'>
                                    <i class="fa-solid fa-rotate-left" style="color: #000000;"></i>
                                </a>
                            </button>
                            <button id='observado' class='btn' style='background:#154360;' data-id="" title='Observado'>
                                <a style='color: black; font-weight:bold;'>
                                <i class="fa-solid fa-triangle-exclamation" style="color: #ffffff;"></i>
                                </a>
                            </button>
                        </td>
                    </tr>
                `;
                            });
                            $("#tabla-prestamos tbody").html(nuevaFila); // Asignar el contenido al tbody una vez fuera del bucle
                            $('#tabla-prestamos').DataTable({
                                language: {
                                    url: '//cdn.datatables.net/plug-ins/1.12.1/i18n/es-MX.json'
                                }
                            });
                        }
                    });
                }

                listarPrestamos();
            });
        </script>

        </body>

        </html>