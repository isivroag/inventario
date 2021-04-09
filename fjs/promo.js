$(document).ready(function() {
    tablavis = $("#tablaobjetivos").DataTable({
        paging: false,
        ordering: false,
        info: false,
        searching: false,

        columnDefs: [{
                targets: -1,
                data: null,
                defaultContent: "<div class='text-center'><div class='btn-group'><button type='button' class='btn btn-success btnEditar'><i class='fas fa-edit'></i>Cambiar</button></div></div>",
            },
            { className: "hide_column", targets: [3] },
            { className: "text-center", targets: [2] },
        ],

        //Para cambiar el lenguaje a español
        language: {
            lengthMenu: "Mostrar _MENU_ registros",
            zeroRecords: "No se encontraron resultados",
            info: "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            infoEmpty: "Mostrando registros del 0 al 0 de un total de 0 registros",
            infoFiltered: "(filtrado de un total de _MAX_ registros)",
            sSearch: "Buscar:",
            oPaginate: {
                sFirst: "Primero",
                sLast: "Último",
                sNext: "Siguiente",
                sPrevious: "Anterior",
            },
            sProcessing: "Procesando...",
        },
    });

    objetivos();

    $("#etapa").change(function() {
        objetivos();
    });
    /*
        $('#tbody').on('click', function() {

            fila = $(this).closest("tr");
            id = parseInt(fila.find('td:eq(0)').text());


            objetivo = fila.find('td:eq(1)').text();
            estado = fila.find('td:eq(2)').text();
            console.log(id);

          
            /*
                $.ajax({

                    url: "bd/evaluar.php",
                    type: "POST",
                    dataType: "json",
                    data: { id: id, eval: eval },

                    success: function(data) {
                        console.log(data);
                        window.location.href = "bd/evaluar.php";
                    }
                });


}); */

    $(document).on("click", ".btnEditar", function() {
        fila = $(this).closest("tr");
        swal
            .fire({
                title: "Cambiar Objetivo a Logrado",
                html: "¿Desea Registrar que este objetivo ha sido logrado?<br><b> Si acepta, esta acción no podrá ser desecha<b>",

                showCancelButton: true,
                icon: "question",
                focusConfirm: true,
                confirmButtonText: "Aceptar",

                cancelButtonText: "Cancelar",
            })
            .then(function(isConfirm) {
                if (isConfirm.value) {


                    id_nivel = $("#id_nivel").val();
                    id_etapa = $("#etapa").val();
                    id_alumno = $("#id").val();
                    id_objetivo = fila.find("td:eq(0)").text();
                    fecha = $("#fecha").val();
                    $.ajax({
                        url: "bd/evaluar.php",
                        type: "POST",
                        dataType: "json",
                        data: {
                            id_alumno: id_alumno,
                            id_nivel: id_nivel,
                            id_etapa: id_etapa,
                            id_objetivo: id_objetivo,
                            fecha: fecha
                        },
                        success: function(data) {
                            if (data == 1) {
                                objetivos();
                            } else if (data == 2) {
                                swal
                                    .fire({
                                        title: "<strong>Objetivos Logrados</strong>",
                                        html: "El Alumno ha terminado exitosamente los objetivos de este programa.<br><b>Se creara una notificacion para realizar la promoción de etapa/nivel",
                                        confirmButtonText: "Aceptar",
                                    });
                                console.log(id_alumno);
                                console.log(fecha);
                                /*Crear Registro de Revisión de Alumno */
                                $.ajax({

                                    url: "bd/notificacion.php",
                                    type: "POST",
                                    dataType: "json",
                                    data: { id_alumno: id_alumno, fecha: fecha },

                                    success: function(resp) {
                                        console.log(resp);

                                        window.setTimeout(function() {
                                            window.location.href = "cntaalumno.php";
                                        }, 2500);

                                    }
                                });

                            }
                        },
                    });
                } else if (isConfirm.dismiss === swal.DismissReason.cancel) {}
            });
    });
});

function objetivos() {
    id = $("#id").val();
    id_nivel = $("#id_nivel").val();
    id_etapa = $("#etapa").val();
    tablavis.clear();
    tablavis.draw();

    $.ajax({
        type: "POST",
        url: "bd/dbevalini.php",
        dataType: "json",
        data: { id: id, id_nivel: id_nivel, id_etapa: id_etapa },
        success: function(res) {
            for (var i = 0; i < res.length; i++) {
                if (res[i].valor == 1) {
                    icono =
                        '<i class="fas fa-swimmer text-success text-center" value="1"></i>';
                } else if (res[i].activo == 1) {
                    icono =
                        '<i class="fas fa-swimmer text-warning text-center" value="0"></i>';
                } else {
                    icono =
                        '<i class="fas fa-swimmer text-grey text-center" value="2"></i>';
                }

                tablavis.row
                    .add([res[i].id_objetivo, res[i].desc_objetivo, icono, res[i].valor])
                    .draw();
            }
        },
    });

    function listar() {
        id = $("#id").val();
        id_nivel = $("#id_nivel").val();
        id_etapa = $("#etapa").val();

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
                    tabla.rows.addClass;
                    tabla +=
                        "<tr><td>" +
                        res[i].id_objetivo +
                        "</td><td>" +
                        res[i].desc_objetivo +
                        '</td><td class="text-center">' +
                        icono +
                        "</td><td>" +
                        res[i].valor +
                        '</td><td class="text-center"><button type="button" class="btn btn-success btnEditar"><i class="fas fa-edit"></i>Cambiar</button></td></tr>';
                    //tabla += '<tr><td>' + res[i].id_objetivo + '</td><td>' + res[i].desc_objetivo + '</td><td class="text-center">' + icono + '</td><td class="text-center"></td></tr>';
                }
                $("#tbody").html(tabla);
            },
        });
    }
}