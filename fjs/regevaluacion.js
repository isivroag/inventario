$(document).ready(function() {


    /*listar();*/

    $("#etapa").change(function() {
        /*listar();*/
    });

    tablavis = $("#tablaObj").DataTable({

        "paging": false,
        "ordering": false,
        "info": false,
        "searching": false,


        "columnDefs": [{
            "targets": -1,
            "data": null,
            "defaultContent": "<div class='text-center'><div class='btn-group'><button class='btn btn-danger btnborrarObj'><i class='fas fa-trash-alt'></i></div></div>"
        }, { className: "hide_column", targets: [0] }, ],


        //Para cambiar el lenguaje a español
        "language": {
            "lengthMenu": "Mostrar _MENU_ registros",
            "zeroRecords": "No se encontraron resultados",
            "info": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
            "infoFiltered": "(filtrado de un total de _MAX_ registros)",
            "sSearch": "Buscar:",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "Último",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            },
            "sProcessing": "Procesando...",
        }
    });

    tablaObj = $("#tablabuscarobj").DataTable({



        "columnDefs": [{
            "targets": -1,
            "data": null,
            "defaultContent": "<div class='text-center'><div class='btn-group'><button class='btn btn-sm btn-success btnSelObj'><i class='fas fa-hand-pointer'></i></button></div></div>"
        }],

        //Para cambiar el lenguaje a español
        "language": {
            "lengthMenu": "Mostrar _MENU_ registros",
            "zeroRecords": "No se encontraron Objetivos",
            "info": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
            "infoFiltered": "(filtrado de un total de _MAX_ registros)",
            "sSearch": "Buscar:",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "Último",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            },
            "sProcessing": "Procesando...",
        }
    });

    tablaActividad = $("#tablaActividad").DataTable({
        "paging": false,
        "ordering": false,
        "info": false,
        "searching": false,
        "columnDefs": [{
            "targets": -1,
            "data": null,
            "defaultContent": "<div class='text-center'><div class='btn-group'><button class='btn btn-sm btn-danger btnborrarcond'><i class='fas fa-times'></i></button></div></div>"
        }, { className: "hide_column", "targets": [0] }],
        "language": {
            "lengthMenu": "Mostrar _MENU_ registros",
            "zeroRecords": "No existen terminos y condiciones",
            "info": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
            "infoFiltered": "(filtrado de un total de _MAX_ registros)",
            "sSearch": "Buscar:",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "Último",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            },
            "sProcessing": "Procesando...",
        }
    });


    $(document).on("click", "#btnAddActividad", function() {
        $("#formotro").trigger("reset");
        $(".modal-header").css("background-color", "#007bff");
        $(".modal-header").css("color", "white");

        $("#modalactividad").modal("show");

    });



    $(document).on("click", "#btnAddObj", function() {

        $(".modal-header").css("background-color", "#007bff");
        $(".modal-header").css("color", "white");

        $("#modalObj").modal("show");


    });






    $(document).on("click", ".btnborrarObj", function(event) {
        event.preventDefault();
        fila = $(this).closest("tr");

        id = fila.find('td:eq(0)').text();

        opc = 2;


        $.ajax({

            type: "POST",
            url: "bd/agregarobjetivo.php",
            dataType: "json",
            data: { id: id, opc: opc },
            success: function(data) {

                if (data == 1) {
                    tablavis.row(fila.parents("tr")).remove().draw();
                }




            }

        });





    });

    $(document).on("click", ".btnSelObj", function() {
        fila = $(this).closest("tr");
        folio = $("#folio").val();
        id_objetivo = fila.find('td:eq(0)').text();
        objetivo = fila.find('td:eq(1)').text();
        opc = 1;


        $.ajax({

            type: "POST",
            url: "bd/agregarobjetivo.php",
            dataType: "json",
            data: { folio: folio, id_objetivo: id_objetivo, objetivo: objetivo, opc: opc },
            success: function(data) {

                id = data[0].registro
                id_objetivo = data[0].id_objetivo
                descripcion = data[0].descripcion

                tablavis.row.add([id, id_objetivo, descripcion]).draw();


            }

        });

        $("#modalObj").modal("hide");



    });


    $(document).on("click", "#btnguardaractividad", function() {


        actividad = $("#actividad").val();
        folio = $("#folio").val();

        opc = 1


        $.ajax({

            type: "POST",
            url: "bd/agregaractividad.php",
            dataType: "json",
            data: { folio: folio, actividad: actividad, opc: opc },
            success: function(data) {
                fidreg = data[0].reg_act;
                fcondicion = "<li>" + data[0].actividad + "</li>";
                tablaActividad.row.add([fidreg, fcondicion]).draw();
            }
        });

        $("#modalactividad").modal("hide");



    });


    $(document).on("click", ".btnborrarcond", function(event) {
        event.preventDefault();
        fila = $(this).closest("tr");

        id = fila.find('td:eq(0)').text();

        opc = 2;


        $.ajax({

            type: "POST",
            url: "bd/agregaractividad.php",
            dataType: "json",
            data: { id: id, opc: opc },
            success: function(data) {

                if (data == 1) {
                    tablaActividad.row(fila.parents("tr")).remove().draw();
                }




            }

        });





    });

    $(document).on("click", "#btnGuardar", function() {
        folio = $("#folio").val();
        fecha = $("#fecha").val();


        $.ajax({

            type: "POST",
            url: "bd/guardareval.php",
            dataType: "json",
            data: { folio: folio, fecha: fecha },
            success: function(data) {
                if (data == 1) {
                    console.log(data);
                    Swal.fire({
                        title: "Operación Exitosa",
                        text: "Evaluación Guardada",
                        icon: "success",
                    });
                    window.setTimeout(function() {
                        window.location.href = "cntaalumno.php";
                    }, 1000);
                } else {
                    Swal.fire({
                        title: "Error al Guardar",
                        text: "No se puedo guardar los datos",
                        icon: "error",
                    });
                }

            }
        });


    });



});






function listar() {
    id = $('#id').val();
    id_nivel = $('#id_nivel').val();
    id_etapa = $('#etapa').val();



    $.ajax({
        type: "POST",
        url: "bd/dbevalini.php",
        dataType: "json",
        data: { id: id, id_nivel: id_nivel, id_etapa: id_etapa },
        success: function(res) {

            var tabla;
            for (var i = 0; i < res.length; i++) {

                if (res[i].valor == 1) {
                    icono = '<i class="fas fa-swimmer text-success" value="1"></i>';
                } else if (res[i].activo == 1) {
                    icono = '<i class="fas fa-swimmer text-warning" value="0"></i>';
                } else {
                    icono = '<i class="fas fa-swimmer text-grey" value="2"></i>';
                }

                tabla += '<tr><td>' + res[i].id_objetivo + '</td><td>' + res[i].desc_objetivo + '</td><td class="text-center">' + icono + '</td><td>' + res[i].valor + '</td><td class="text-center"><button type="button" class="btn btn-secondary btnEditar"><i class="fas fa-edit"></i>Cambiar</button></td></tr>';
                //tabla += '<tr><td>' + res[i].id_objetivo + '</td><td>' + res[i].desc_objetivo + '</td><td class="text-center">' + icono + '</td><td class="text-center"></td></tr>';
            }
            $('#tbody').html(tabla);
        }
    });


}