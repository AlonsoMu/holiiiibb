<?php

require_once 'permisos.php';
/*if(!isset($_SESSION['login']) || $_SESSION['login'] == false){
    header("location:login.php");
}*/
?>
<div id="wrapper">
    <div class="d-flex flex-column" id="content-wrapper">
        <div id="content">
            <!-- INICIO PERFIL -->

            <!-- FIN PERFIL -->

            <div class="container-fluid">
                <div class="card shadow">
                    <!-- Datatable  -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 text-center">
                            <div class="d-grid gap-2 col-6 mx-auto">
                                <!-- Título oculto para pc y laptop -->
                                <div class="d-inline-block d-md-none" style="text-align: center;">
                                    <h3 class="title-tablas2">
                                        Subcategorías
                                    </h3>
                                </div>
                                <!-- Título oculto para móvil y tablet -->
                                <div class="d-none d-md-inline-block" style="text-align: center;">
                                    <h3 class="title-tablas">
                                        Módulo de Subcategorías
                                    </h3>
                                </div>

                                <div class="btn-group" role="group">
                                    <!-- Botón para mostrar el modal de Registrar Categoría -->
                                    <button class="btn btn-success btn-sm d-none d-md-inline-block" role="button" data-toggle="modal" data-target="#modal-subcategorias" data-target="#modal-libros-subcategorias" id="mostrar-modal-registro">
                                        <i class="fas fa-list fa-sm text-black fa-xl"></i>
                                        &nbsp;Registrar Subcategoría
                                    </button>
                                    <!-- Botón para mostrar el modal de Generar  Reporte -->
                                    <button class="btn btn-danger btn-sm d-none d-md-inline-block" style="margin-left: 50px;" id="reportButton">
                                        <a href="index.php?view=report-subcategoria.php"></a>
                                        <i class="fas fa-download fa-sm text-black fa-xl"></i>
                                        &nbsp;Generar Reporte
                                    </button>
                                </div>
                                <!-- INICIO Versión Móvil -->
                                <div class="d-flex mx-auto d-md-none">
                                    <div class="btn-group w-100" role="group">
                                        <!-- Botón para mostrar el modal de registrar libro (versión móvil) -->
                                        <button class="btn btn-outline-success btn-sm d-inline-block mr-2" role="button" data-toggle="modal" data-target="#modal-libros" data-target="#modal-libros-editar" id="mostrar-modal-registro">
                                            <i class="fas fa-list  fa-sm text-black fa-xl"></i>
                                            &nbsp;Registrar
                                        </button>
                                        <!-- Botón para mostrar el modal de generación de reporte (versión móvil) -->
                                        <a class="btn btn-outline-danger btn-sm d-inline-block" id="reportButton" href="index.php?view=report-subcategoria.php">
                                            <i class="fas fa-download fa-sm text-black fa-xl"></i>
                                            &nbsp;Reporte
                                        </a>
                                    </div>
                                </div>
                                <!-- FIN Versión Móvil -->
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table">
                                <table class="table display responsive" id="tabla-subcategoria" width="85%" cellspacing="0">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>#</th>
                                            <th>Subcategoría</th>
                                            <th>Categoría</th>
                                            <th>Fecha de Registro</th>
                                            <th>Comandos</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>



                    <!-- Zona Modales registro-->
                    <div class="modal fade" data-backdrop="static" data-keyboard="false" id="modal-subcategorias" tabindex="-1" aria-labelledby="modal-subcategorias" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header bg-success text-light">
                                    <h5 class="modal-title" id="titulo-modal-subcategorias">Registrar Subcategoría</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span class="text-light" aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="" id="formulario-subcategorias" autocomplete="off">
                                        <!-- Creación de controles -->
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label for="categoria">Categoría:</label>
                                                <select name="categoria" id="categoria" class="form-control form-control-sm">
                                                    <option value="">Seleccione:</option>
                                                </select>
                                            </div>

                                            <div class="col-md-6 form-group">
                                                <label for="subcategoryname">Nombre de SubCategoría:</label>
                                                <input type="text" id="subcategoryname" class="form-control form-control-sm">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" id="cancelar-modal" class="btn btn-sm btn-secondary" data-dismiss="modal">Cerrar</button>
                                    <button id="guardar-subcategoria" class="btn btn-sm btn-success" type="button">Guardar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- </div> -->
                </div>
            </div>
            <!-- Footer -->
            <footer class="bg-white sticky-footer">
                <div class="container my-auto">
                    <div class="text-center my-auto copyright">
                        <span>Copyright © ARFECAS 2023</span>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <!-- Mis funciones y eventos javascript -->
    <script>
        // Script para el cambio de Titulo
        let isTitle = document.title;
        let titleTimeout;

        const starChangeTitle = () => {
            titleTimeout = setInterval(function() {
                document.title = document.title === isTitle ? "Horacio Zeballos Gamez" : isTitle;
            }, 1800);
        };
        window.addEventListener("load", starChangeTitle);


        $(document).ready(function() {
            var datosNuevos = true;
            var datos = {
                'operacion': "",
                'idcategorie': "",
                'idsubcategorie': "",
                'subcategoryname': ""
            };

            function alertar(textoMensaje = "") {
                Swal.fire({
                    title: 'SubCategorías',
                    text: textoMensaje,
                    icon: 'info',
                    footer: 'Horacio Zeballos Gámez',
                    timer: 2000,
                    confirmButtonText: 'Aceptar'
                });
            }

            function alertarToast(titulo = "", textoMensaje = "", icono = "") {
                Swal.fire({
                    title: titulo,
                    text: textoMensaje,
                    icon: icono,
                    toast: true,
                    position: 'bottom-end',
                    showConfirmButton: false,
                    timer: 1500,
                    timerProgressBar: true
                });
            }

            function reiniciarFormulario() {
                $("#formulario-subcategorias")[0].reset();
            }

            function abrirModalRegistro() {
                datosNuevos = true;

                //Le indicimas el titulo del modal y su clase
                $(".modal-header").removeClass("bg-info");
                $(".modal-header").addClass("bg-success");
                $("#titulo-modal-subcategorias").html("Registrar SubCategoria");

                //Button
                $("#guardar-subcategoria").removeClass("bg-info");
                $("#guardar-subcategoria").addClass("bg-success");

                reiniciarFormulario();
            }

            function ListarSubcategoria() {
                $.ajax({
                    url: '../../controllers/subcategoria.controller.php',
                    type: 'GET',
                    data: 'operacion=listarSubcategoria3',
                    success: function(result) {
                        let registros = JSON.parse(result);
                        let nuevaFila = ``;

                        let tabla = $("#tabla-subcategoria").DataTable();
                        tabla.destroy();

                        $("#tabla-subcategoria tbody").html("");
                        registros.forEach(registro => {
                            nuevaFila = `
                        <tr>
                            <td>${registro['idsubcategorie']}</td>
                            <td>${registro['subcategoryname']}</td>
                            <td>${registro['categoryname']}</td>
                            <td>${registro['registrationdate']}</td>
                            <td>
                                <a href='#' data-idsubcategorie='${registro['idsubcategorie']}' class = ' eliminar'><i class="fa-solid fa-user-xmark fa-lg" style="color: #e00000;"></i></a>
                                <a href='#' data-idsubcategorie='${registro['idsubcategorie']}' class = ' editar'><i class="fa-solid fa-user-pen fa-lg" style="color: #1959c8;"></i></a>
                            </td>
                        </tr>
                        `;
                            $("#tabla-subcategoria tbody").append(nuevaFila);
                        });
                        $('#tabla-subcategoria').DataTable({
                            language: {
                                url: '//cdn.datatables.net/plug-ins/1.12.1/i18n/es-MX.json'
                            }
                        });
                    }
                });

            }

            function listarCategorias() {
                $.ajax({
                    url: '../../controllers/categoria.controller.php',
                    type: 'GET',
                    data: 'operacion=listarCategoria',
                    success: function(result) {
                        let registros = JSON.parse(result);
                        let elementosLista = ``;

                        if (registros.length > 0) {
                            elementosLista = `<option select>Seleccione:</option>`;
                            registros.forEach(registro => {
                                elementosLista += `<option value=${registro['idcategorie']}>${registro['categoryname']}</option>`;
                            });
                        } else {
                            elementosLista = `option>No hay datos asiganados</option>`;
                        }
                        $("#categoria").html(elementosLista);
                    }
                });
            }

            function RegistrarSubcategoria() {
                datos['idcategorie'] = $("#categoria").val();
                datos['subcategoryname'] = $("#subcategoryname").val();

                if (datosNuevos) {
                    datos['operacion'] = "registrarSubcategoria";
                } else {
                    datos['operacion'] = "actualizarSubcategoria";
                    datos['idsubcategorie'] = idsubcategorie;
                }

                if (datos['idcategorie'] == "" || datos['subcategoryname'] == "") {
                    alertar("Complete el formulario por favor")
                } else {
                    Swal.fire({
                        title: "SubCategoría",
                        text: "¿Los datos ingresados son correctos?",
                        icon: "question",
                        footer: "Horacio Zeballos Gámez",
                        confirmButtonText: "Aceptar",
                        confirmButtonColor: "#38AD4D",
                        showCancelButton: true,
                        cancelButtonText: "Cancelar",
                        cancelButtonColor: "#D3280A"
                    }).then(result => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: '../../controllers/subcategoria.controller.php',
                                type: 'GET',
                                data: datos,
                                success: function(result) {
                                    alertarToast("Proceso completado", "", "success")
                                    setTimeout(function() {
                                        reiniciarFormulario();
                                        $('#modal-subcategorias').modal('hide');
                                        ListarSubcategoria();
                                    }, 1800)
                                }
                            });
                        }
                    });

                }

            }

            $("#tabla-subcategoria tbody").on("click", ".editar", function() {
                idsubcategorie = $(this).data("idsubcategorie");

                $.ajax({
                    url: '../../controllers/subcategoria.controller.php',
                    type: 'GET',
                    dataType: 'JSON',
                    data: {
                        'operacion': 'getSubcategoria',
                        'idsubcategorie': idsubcategorie
                    },
                    success: function(result) {
                        $("#categoria").val(result['idcategorie']);
                        $("#subcategoryname").val(result['subcategoryname']);

                        //Canbiando la configuracion modal
                        $("#titulo-modal-subcategorias").html("Actualizar datos");
                        $(".modal-header").removeClass("bg-success");
                        $(".modal-header").addClass("bg-info");
                        //Button
                        $("#guardar-subcategoria").removeClass("bg-success");
                        $("#guardar-subcategoria").addClass("bg-info");

                        $("#modal-subcategorias").modal("show");
                        datosNuevos = false;
                    }
                });
            });

            $("#tabla-subcategoria tbody").on("click", ".eliminar", function() {
                idsubcategorie = $(this).data("idsubcategorie");
                Swal.fire({
                    title   : "Sub Categoría",
                    text    : "¿Esta seguro de eliminar la sub categoría?",
                    icon    : "question",
                    footer  : "I.E. Horacio Zeballos Gámez",
                    confirmButtonText   : "Aceptar",
                    confirmButtonColor  : "#38AD4D",
                    showCancelButton    : true,
                    cancelButtonText    : "Cancelar",
                    cancelButtonColor   : "#D3280A"
                }).then(result => {
                    if (result.isConfirmed){
                        $.ajax({
                            url: '../../controllers/subcategoria.controller.php',
                            type: 'GET',
                            data: {'operacion':'eliminarSubcategoria','idsubcategorie':idsubcategorie},
                            success: function(result){
                                if(result == ""){
                                    idcategorie = ``;
                                    alertarToast("Perfecto","Sub categoría eliminada correctamente","success")
                                    ListarSubcategoria();
                                }
                            }
                        });
                    }
                })

            });

            document.getElementById('reportButton').addEventListener('click', function(event) {
                // Evitar que el evento de clic se propague al botón
                event.preventDefault();

                // Obtener el enlace dentro del botón
                var link = this.querySelector('a');

                // Obtener la URL de href del enlace
                var url = link.getAttribute('href');

                // Redirigir a la URL indicada en el href
                window.location.href = url;
            });


            $("#guardar-subcategoria").click(RegistrarSubcategoria);
            $("#mostrar-modal-registro").click(abrirModalRegistro);
            $("#cancelar-modal").click(reiniciarFormulario);
            ListarSubcategoria();
            listarCategorias();

        });
    </script>