$(document).ready(function() {
    var id, opcion;
    opcion = 4;

    tablavis = $("#tablavis").DataTable({
        stateSave: true,


        "columnDefs": [{
            "targets": -1,
            "data": null,
            "defaultContent": "<div class='text-center'><div class='btn-group'><button class='btn btn-info btnVer'><i class='fas fa-info-circle'></i> Info</button><button class='btn btn-primary  btnEval'><i class='fas fa-tasks'></i> Plan</button><button class='btn bg-purple  btnVerHist'><i class='fas fa-clock'></i> Historia</button><button class='btn bg-success text-light btnPromover'><i class='fas fa-award'></i> Promover</button></div></div>"
        }],

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



    var fila; //capturar la fila para editar o borrar el registro

    //botón EDITAR    
    $(document).on("click", ".btnVer", function() {
        fila = $(this).closest("tr");
        id = parseInt(fila.find('td:eq(0)').text());

        window.location.href = "viewalumno.php?id=" + id;


    });

    $(document).on("click", ".btnPromover", function() {
        fila = $(this).closest("tr");
        id = parseInt(fila.find('td:eq(0)').text());

        window.location.href = "promo.php?id=" + id;


    });


    $(document).on("click", ".btnVerHist", function() {
        fila = $(this).closest("tr");
        id = parseInt(fila.find('td:eq(0)').text());

        window.location.href = "verevaluaciones.php?id=" + id;


    });

    $(document).on("click", ".btnEval", function() {
        fila = $(this).closest("tr");
        id = parseInt(fila.find('td:eq(0)').text());

        window.location.href = "regevaluacion.php?id=" + id;


    });

    //botón BORRAR
    $(document).on("click", ".btnBorrar", function() {
        fila = $(this);

        id = parseInt($(this).closest("tr").find('td:eq(0)').text());
        opcion = 3 //borrar

        //agregar codigo de sweatalert2
        var respuesta = confirm("¿Está seguro de eliminar el registro: " + id + "?");



        if (respuesta) {
            $.ajax({

                url: "bd/crudusu.php",
                type: "POST",
                dataType: "json",
                data: { id: id, opcion: opcion },

                success: function() {
                    console.log(data);

                    tablaPersonas.row(fila.parents('tr')).remove().draw();
                }
            });
        }
    });
    /*
        $("#formPersonas").submit(function(e) {
            e.preventDefault();
            nombre = $.trim($("#nombre").val());
            ine = $.trim($("#ine").val());
            licencia = $.trim($("#licencia").val());
            pasaporte = $.trim($("#pasaporte").val());
            otro = $.trim($("#otro").val());


            $.ajax({
                url: "bd/crud.php",
                type: "POST",
                dataType: "json",
                data: { nombre: nombre, ine: ine, licencia: licencia, id: id, pasaporte: pasaporte, otro: otro, opcion: opcion },
                success: function(data) {
                    console.log(data);

                    //tablaPersonas.ajax.reload(null, false);
                    id = data[0].id;
                    nombre = data[0].nombre;
                    ine = data[0].ine;
                    licencia = data[0].licencia;
                    pasaporte = data[0].pasaporte;
                    otro = data[0].otro;
                    if (opcion == 1) { tablaPersonas.row.add([id, nombre, ine, licencia, pasaporte, otro]).draw(); } else { tablaPersonas.row(fila).data([id, nombre, ine, licencia, pasaporte, otro]).draw(); }
                }
            });
            $("#modalCRUD").modal("hide");

        });*/

});