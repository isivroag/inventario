$(document).ready(function() {
    var id, opcion;







    tablaC = $("#tablaC").DataTable({



        "columnDefs": [{
            "targets": -1,
            "data": null,
            "defaultContent": "<div class='text-center'><div class='btn-group'><button class='btn btn-sm btn-success btnSelCuenta'><i class='fas fa-hand-pointer'></i></button></div></div>"
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

    tablaCon = $("#tablaCon").DataTable({



        "columnDefs": [{
            "targets": -1,
            "data": null,
            "defaultContent": "<div class='text-center'><div class='btn-group'><button class='btn btn-sm btn-success btnSelConcepto'><i class='fas fa-hand-pointer'></i></button></div></div>"
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






    $(document).on("click", "#bcuenta", function() {

        $(".modal-header").css("background-color", "#007bff");
        $(".modal-header").css("color", "white");

        $("#modal1").modal("show");

    });








    $(document).on("click", ".btnSelCuenta", function() {
        fila = $(this).closest("tr");

        id_cuenta = fila.find('td:eq(0)').text();
        cuenta = fila.find('td:eq(1)').text();
        saldo = fila.find('td:eq(2)').text();



        $("#id_cuenta").val(id_cuenta);
        $("#cuenta").val(cuenta);
        $("#saldoini").val(saldo);

        $("#modal1").modal("hide");


    });

    $(document).on("click", ".btnSelSubpartida", function() {
        fila = $(this).closest("tr");

        id_subpartida = fila.find('td:eq(0)').text();
        nomsubpartida = fila.find('td:eq(1)').text();

        opcion = 1;

        $("#id_subpartida").val(id_subpartida);
        $("#subpartida").val(nomsubpartida);
        $("#modalSubpartida").modal("hide");


    });


    $(document).on("click", ".btnSelCliente", function() {
        fila = $(this).closest("tr");

        idprov = fila.find('td:eq(0)').text();
        nomprov = fila.find('td:eq(2)').text();

        opcion = 1;

        $("#id_prov").val(idprov);
        $("#nombre").val(nomprov);
        $("#modalProspecto").modal("hide");

    });

    $(document).on("click", "#btnGuardar", function() {
        folio = $("#folio").val();
        fecha = $("#fecha").val();
        fechal = $("#fechal").val();
        id_prov = $("#id_prov").val();
        id_partida = $("#id_partida").val();
        id_subpartida = $("#id_subpartida").val();
        concepto = $("#concepto").val();
        if ($('#cfactura').prop('checked')) {
            facturado = 1;
        } else {
            facturado = 0;
        }
        referencia = $("#referencia").val();
        subtotal = $("#subtotal").val();
        iva = $("#iva").val();
        total = $("#total").val();
        usuario = $("#nameuser").val();
        opcion = $("#opcion").val();;




        if (subtotal.length != 0 && iva.length != 0 && total.length != 0 &&
            concepto.length != 0 && id_partida.length != 0 && id_subpartida.length != 0 &&
            id_prov.length != 0) {
            $.ajax({

                type: "POST",
                url: "bd/crudcxp.php",
                dataType: "json",
                data: { fecha: fecha, fechal: fechal, id_prov: id_prov, id_partida: id_partida, id_subpartida: id_subpartida, concepto: concepto, facturado: facturado, referencia: referencia, subtotal: subtotal, iva: iva, total: total, saldo: total, usuario: usuario, folio: folio, opcion: opcion },
                success: function(res) {

                    if (res == 0) {
                        Swal.fire({
                            title: 'Error al Guardar',
                            text: "No fue poisible guardar el registro",
                            icon: 'error',
                        })
                    } else {
                        Swal.fire({
                            title: 'Operación Exitosa',
                            text: "Cuenta por pagar guardada",
                            icon: 'success',
                        })

                        /*window.setTimeout(function() {
                            window.location.href = "cntacxp.php";
                        }, 1500);*/

                    }
                }
            });
        } else {
            Swal.fire({
                title: 'Datos Faltantes',
                text: "Debe ingresar todos los datos del Item",
                icon: 'warning',
            })
            return false;
        }
    });




    $(document).on("click", ".btnSelConcepto", function() {
        fila = $(this).closest("tr");
        idpartida = fila.find('td:eq(0)').text();
        partida = fila.find('td:eq(1)').text();
        $("#id_partida").val(idpartida);
        $("#partida").val(partida);
        $("#modalConcepto").modal("hide");

    });

    $(document).on("click", "#btnNuevo", function() {
        limpiar();
    });




    $("#subtotal").on("change keyup paste click", function() {
        if ($('#cmanual').prop('checked')) {


        } else {
            if ($('#cinverso').prop('checked')) {

            } else {
                valor = $("#subtotal").val();
                calculo(valor);
            }
        }


    });

    $("#total").on("change keyup paste click", function() {
        if ($('#cmanual').prop('checked')) {


        } else {
            if ($('#cinverso').prop('checked')) {
                valor = $("#total").val();
                calculoinverso(valor);
            }
        }

    });

    $("#ccredito").on("click", function() {
        if ($('#ccredito').prop('checked')) {
            $("#fechal").prop('disabled', false);
        } else {
            $("#fechal").prop('disabled', true);
        }
        $("#fechal").val($("#fecha").val());


    });

    $("#cinverso").on("click", function() {
        if ($('#cinverso').prop('checked')) {
            $("#total").prop('disabled', false);
            $("#subtotal").prop('disabled', true);
        } else {
            $("#total").prop('disabled', true);
            $("#subtotal").prop('disabled', false);
        }


    });

    $("#cmanual").on("click", function() {
        if ($('#cmanual').prop('checked')) {
            $("#total").prop('disabled', false);
            $("#subtotal").prop('disabled', false);
            $("#iva").prop('disabled', false);
        } else {
            if ($('#cinverso').prop('checked')) {
                $("#total").prop('disabled', false);
                $("#subtotal").prop('disabled', true);
            } else {
                $("#total").prop('disabled', true);
                $("#subtotal").prop('disabled', false);
            }
            $("#iva").prop('disabled', true);
        }

    });


    function limpiar() {

        var today = new Date();
        var dd = today.getDate();

        var mm = today.getMonth() + 1;
        var yyyy = today.getFullYear();
        if (dd < 10) {
            dd = '0' + dd;
        }

        if (mm < 10) {
            mm = '0' + mm;
        }

        today = yyyy + '-' + mm + '-' + dd;


        $("#id_prov").val('');
        $("#nombre").val('');
        $("#fecha").val(today);
        $("#folio").val('');
        $("#folior").val('');
        $("#id_partida").val('');
        $("#id_subpartida").val('');
        $("#partida").val('');
        $("#subpartida").val('');
        $("#ccredito").val(false);
        $("#fechal").val(today);
        $("#cfactura").val(false);
        $("#referencia").val('');
        $("#proyecto").val('');
        $("#subtotal").val('');
        $("#iva").val('');
        $("#total").val('');
        $("#cinverso").val(false);
    };


    function calculo(subtotal) {

        total = round(subtotal * 1.16, 2);

        iva = round(total - subtotal, 2);


        $("#iva").val(iva);
        $("#total").val(total);
    };

    function calculoinverso(total) {

        subtotal = round(total / 1.16, 2);
        iva = round(total - subtotal, 2);

        $("#subtotal").val(subtotal);
        $("#iva").val(iva);

    };

    function round(value, decimals) {
        return Number(Math.round(value + 'e' + decimals) + 'e-' + decimals);
    }


    function listarsubpartida(id_partida) {
        tablaSub.clear();
        tablaSub.draw();


        $.ajax({
            type: "POST",
            url: "bd/buscarsubpartida.php",
            dataType: "json",
            data: { id_partida: id_partida },

            success: function(res) {
                for (var i = 0; i < res.length; i++) {
                    tablaSub.row
                        .add([res[i].id_subpartida, res[i].nom_subpartida])
                        .draw();

                    //tabla += '<tr><td>' + res[i].id_objetivo + '</td><td>' + res[i].desc_objetivo + '</td><td class="text-center">' + icono + '</td><td class="text-center"></td></tr>';
                }
            },
        });
    }



})