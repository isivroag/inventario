$(document).ready(function() {
    var id, opcion;
    opcion = 4;

    tablaVis = $("#tablaV").DataTable({



        "columnDefs": [{
            "targets": -1,
            "data": null,
            "defaultContent": "<div class='text-center'><button class='btn btn-sm btn-primary  btnEditar' data-toggle='tooltip' data-placement='top' title='Editar'><i class='fas fa-edit'></i></button><button class='btn btn-sm bg-orange btnSubpartida' data-toggle='tooltip' data-placement='top' title='Subpartidas'><i class=' text-light fas fa-list'></i></button><button class='btn btn-sm btn-danger btnBorrar' data-toggle='tooltip' data-placement='top' title='Borrar'><i class='fas fa-trash-alt'></i></button></div>"
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
    $('[data-toggle="tooltip"]').tooltip();


    $("#btnNuevo").click(function() {

        //window.location.href = "prospecto.php";
        $("#formDatos").trigger("reset");
        $(".modal-header").css("background-color", "#28a745");
        $(".modal-header").css("color", "white");
        $(".modal-title").text("Nueva Partida");
        $("#modalCRUD").modal("show");
        id = null;
        opcion = 1; //alta
    });
    $(document).on("click", ".btnSubpartida", function() {
        fila = $(this).closest("tr");
        id = parseInt(fila.find('td:eq(0)').text());
        window.location.href = "cntasubpartida.php?id=" + id;
    });
    var fila; //capturar la fila para editar o borrar el registro

    //botón EDITAR    
    $(document).on("click", ".btnEditar", function() {
        fila = $(this).closest("tr");
        id = parseInt(fila.find('td:eq(0)').text());

        //window.location.href = "actprospecto.php?id=" + id;
        nombre = fila.find('td:eq(1)').text();


        $("#nombre").val(nombre);

        opcion = 2; //editar

        $(".modal-header").css("background-color", "#007bff");
        $(".modal-header").css("color", "white");
        $(".modal-title").text("Editar Partida");
        $("#modalCRUD").modal("show");

    });

    //botón BORRAR
    $(document).on("click", ".btnBorrar", function() {
        fila = $(this);

        id = parseInt($(this).closest("tr").find('td:eq(0)').text());
        opcion = 3; //borrar

        //agregar codigo de sweatalert2
        var respuesta = confirm("¿Está seguro de eliminar el registro: " + id + "?");


        console.log(id);
        console.log(opcion);
        if (respuesta) {
            $.ajax({

                url: "bd/crudpartida.php",
                type: "POST",
                dataType: "json",
                data: { id: id, opcion: opcion },

                success: function(data) {
                    console.log(fila);

                    tablaVis.row(fila.parents('tr')).remove().draw();
                }
            });
        }
    });



    $("#formDatos").submit(function(e) {
        e.preventDefault();
        var nombre = $.trim($("#nombre").val());


        console.log(nombre);


        if (nombre.length == 0) {
            Swal.fire({
                title: 'Datos Faltantes',
                text: "Debe ingresar todos los datos la Partida",
                icon: 'warning',
            })
            return false;
        } else {
            $.ajax({
                url: "bd/crudpartida.php",
                type: "POST",
                dataType: "json",
                data: { nombre: nombre, id: id, opcion: opcion },
                success: function(data) {
                    console.log(data);
                    console.log(fila);

                    //tablaPersonas.ajax.reload(null, false);
                    id = data[0].id_partida;
                    nombre = data[0].nom_partida;

                    if (opcion == 1) {
                        tablaVis.row.add([id, nombre]).draw();
                    } else {
                        tablaVis.row(fila).data([id, nombre]).draw();
                    }
                }
            });
            $("#modalCRUD").modal("hide");
        }
    });

});