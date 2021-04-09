$(document).ready(function() {
    var id, opcion;
    opcion = 4;

    tablaVis = $("#tablaV").DataTable({



        "columnDefs": [{
            "targets": -1,
            "data": null,
            "defaultContent": "<div class='text-center'><button class='btn btn-sm btn-primary  btnEditar'><i class='fas fa-edit'></i></button><button class='btn btn-sm btn-danger btnBorrar'><i class='fas fa-trash-alt'></i></button></div>"
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

    $("#btnNuevo").click(function() {

        //window.location.href = "prospecto.php";
        $("#formDatos").trigger("reset");
        $(".modal-header").css("background-color", "#28a745");
        $(".modal-header").css("color", "white");
        $(".modal-title").text("Nueva Cuenta");
        $("#modalCRUD").modal("show");
        id = null;
        opcion = 1; //alta
    });

    var fila; //capturar la fila para editar o borrar el registro

    //botón EDITAR    
    $(document).on("click", ".btnEditar", function() {
        fila = $(this).closest("tr");
        id = parseInt(fila.find('td:eq(0)').text());

        //window.location.href = "actprospecto.php?id=" + id;
        nombre = fila.find('td:eq(1)').text();
        tipo = fila.find('td:eq(2)').text();
        saldo = fila.find('td:eq(3)').text();


        $("#id").val(id);
        $("#nombre").val(nombre);
        $("#tipo").val(tipo);
        $("#saldo").val(saldo);

        opcion = 2; //editar

        $(".modal-header").css("background-color", "#007bff");
        $(".modal-header").css("color", "white");
        $(".modal-title").text("Editar Cuenta");
        $("#modalCRUD").modal("show");

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

                url: "bd/crudcuenta.php",
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
        var id = $.trim($("#id").val());
        var nombre = $.trim($("#nombre").val());
        var tipo = $.trim($("#tipo").val());
        var saldo = $.trim($("#saldo").val());




        if (nombre.length == 0 || tipo.length == 0 || saldo.length == 0) {
            Swal.fire({
                title: 'Datos Faltantes',
                text: "Debe ingresar todos los datos de la cuenta",
                icon: 'warning',
            })
            return false;
        } else {
            $.ajax({
                url: "bd/crudcuenta.php",
                type: "POST",
                dataType: "json",
                data: { nombre: nombre, id: id, tipo: tipo, saldo: saldo, opcion: opcion },
                success: function(data) {
                    console.log(data);
                    console.log(fila);

                    //tablaPersonas.ajax.reload(null, false);
                    id = data[0].id_cuenta;
                    nombre = data[0].nom_cuenta;
                    tipo = data[0].tipo_cuenta;
                    saldo = data[0].saldo_cuenta;

                    if (opcion == 1) {
                        tablaVis.row.add([id, nombre, tipo, saldo]).draw();
                    } else {
                        tablaVis.row(fila).data([id, nombre, tipo, saldo, ]).draw();
                    }
                }
            });
            $("#modalCRUD").modal("hide");
        }
    });

});