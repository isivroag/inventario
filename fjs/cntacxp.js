$(document).ready(function() {
    var id, opcion;
    opcion = 4;

    tablaVis = $("#tablaV").DataTable({

        dom: "<'row justify-content-center'<'col-sm-12 col-md-4 form-group'l><'col-sm-12 col-md-4 form-group'B><'col-sm-12 col-md-4 form-group'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",


        buttons: [{
                extend: 'excelHtml5',
                "text": "<i class='fas fa-file-excel'> Excel</i>",
                "titleAttr": "Exportar a Excel",
                "title": 'Reporte de Egresos',
                "className": 'btn bg-success ',
                exportOptions: { columns: [1, 2, 3, 4, 5, 6] }
            },
            {
                extend: 'pdfHtml5',
                "text": "<i class='far fa-file-pdf'> PDF</i>",
                "titleAttr": "Exportar a PDF",
                "title": 'Reporte de Egresos',
                "className": 'btn bg-danger',
                exportOptions: { columns: [1, 2, 3, 4, 5, 6] }
            }



        ],


        "columnDefs": [{
            "targets": -1,
            "data": null,
            "defaultContent": "<div class='text-center'><div class='btn-group'><button class='btn btn-sm btn-primary btnEditar'><i class='fas fa-search'></i></button><button class='btn btn-sm btn-success btnPagar'><i class='fas fa-hand-holding-usd'></i></button><button class='btn btn-sm btn-danger btnBorrar'><i class='fas fa-trash-alt'></i></button></div></div>"
        }, {
            "render": function(data, type, row) {
                return commaSeparateNumber(data);
            },
            "targets": [4, 5]
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

    function commaSeparateNumber(val) {
        while (/(\d+)(\d{3})/.test(val.toString())) {
            val = val.toString().replace(/(\d+)(\d{3})/, '$1' + ',' + '$2');
        }
        val = '$ ' + val
        return val;
    }


    $("#btnBuscar").click(function() {
        var inicio = $('#inicio').val();
        var final = $('#final').val();
        console.log(inicio)
        console.log(final)
        tablaVis.clear();
        tablaVis.draw();

        if (inicio != '' && final != '') {
            $.ajax({
                type: "POST",
                url: "bd/buscarcxp.php",
                dataType: "json",
                data: { inicio: inicio, final: final },
                success: function(data) {
                    console.log(data)
                    for (var i = 0; i < data.length; i++) {

                        tablaVis.row.add([data[i].folio_cxp, data[i].fecha, data[i].nombre, data[i].concepto, data[i].total, data[i].saldo, data[i].fecha_limite]).draw();

                        //tabla += '<tr><td>' + res[i].id_objetivo + '</td><td>' + res[i].desc_objetivo + '</td><td class="text-center">' + icono + '</td><td class="text-center"></td></tr>';
                    }


                }
            });
        } else {
            alert("Selecciona ambas fechas");
        }
    });

    $("#btnNuevo").click(function() {

        window.location.href = "cxp.php";
        //$("#formDatos").trigger("reset");
        //$(".modal-header").css("background-color", "#28a745");
        //$(".modal-header").css("color", "white");
        //$(".modal-title").text("Nuevo Prospecto");
        //$("#modalCRUD").modal("show");
        //id = null;
        //opcion = 1; //alta
    });

    var fila; //capturar la fila para editar o borrar el registro

    //botón EDITAR    
    $(document).on("click", ".btnEditar", function() {
        fila = $(this).closest("tr");
        id = parseInt(fila.find('td:eq(0)').text());
        console.log(id);
        window.location.href = "cxp.php?folio=" + id;


    });



    $(document).on("click", ".btnPagar", function() {
        fila = $(this).closest("tr");
        id = parseInt(fila.find('td:eq(0)').text());
        saldo = fila.find('td:eq(5)').text();

        $("#formPago").trigger("reset");
        $("#folio_cxp").val(id);
        $("#saldo").val(saldo);
        opcion = 1;
        $(".modal-header").css("background-color", "#28a745");
        $(".modal-header").css("color", "white");
        $("#modalPago").modal("show");


    });


    //botón BORRAR
    $(document).on("click", ".btnBorrar", function() {
        fila = $(this);

        folio = parseInt($(this).closest("tr").find('td:eq(0)').text());
        opcion = 3 //borrar

        //agregar codigo de sweatalert2
        var respuesta = confirm("¿Está seguro de eliminar el registro: " + folio + "?");



        if (respuesta) {
            $.ajax({

                url: "bd/crudcxp.php",
                type: "POST",
                dataType: "json",
                data: { folio: folio, opcion: opcion },

                success: function(data) {

                    if (data == '1') {
                        tablaVis.row(fila.parents('tr')).remove().draw();
                    }

                }
            });
        }
    });

    function startTime() {
        var today = new Date();
        var hr = today.getHours();
        var min = today.getMinutes();
        var sec = today.getSeconds();
        //Add a zero in front of numbers<10
        min = checkTime(min);
        sec = checkTime(sec);
        document.getElementById("clock").innerHTML = hr + " : " + min + " : " + sec;
        var time = setTimeout(function() { startTime() }, 500);
    }

    function checkTime(i) {
        if (i < 10) {
            i = "0" + i;
        }
        return i;
    }
    jQuery.extend(jQuery.fn.dataTableExt.oSort, {
        "formatted-num-pre": function(a) {
            a = (a === "-" || a === "") ? 0 : a.replace(/[^\d\-\.]/g, "");
            return parseFloat(a);
        },

        "formatted-num-asc": function(a, b) {
            return a - b;
        },

        "formatted-num-desc": function(a, b) {
            return b - a;
        }
    });


    $(document).on("click", "#btnGuardarp", function() {
        var folio_cxp = $("#folio_cxp").val();
        var fecha = $("#fecha").val();
        var nota = $("#notapago").val();
        var cuenta = $("#cuenta").val();
        var saldofin = 0;
        var monto = $("#montopago").val();
        var metodo = $("#metodo").val();
        var usuario = $("#nameuser").val();

        if (folio_cxp.length == 0 || fecha.length == 0 || cuenta.length == 0 || monto.length == 0 || metodo.length == 0 || usuario.length == 0) {
            swal.fire({
                title: "Datos Incompletos",
                text: "Verifique sus datos",
                icon: "warning",
                focusConfirm: true,
                confirmButtonText: "Aceptar",
            });
        } else {

            $.ajax({
                url: "bd/buscarsaldocxp.php",
                type: "POST",
                dataType: "json",
                async: false,
                data: {
                    folio_cxp: folio_cxp,
                },
                success: function(res) {
                    saldo = res;

                },
            });


            if (parseFloat(saldo) < parseFloat(monto)) {
                swal.fire({
                    title: "Pago Excede el Saldo",
                    text: "El pago no puede exceder el sado de la cuenta, Verifique el monto del Pago",
                    icon: "warning",
                    focusConfirm: true,
                    confirmButtonText: "Aceptar",
                });
                $("#saldo").val(saldo);

            } else {
                saldofin = saldo - monto;
                opcion = 1;
                $.ajax({
                    url: "bd/pagocxp.php",
                    type: "POST",
                    dataType: "json",
                    async: false,
                    data: {
                        folio_cxp: folio_cxp,
                        fecha: fecha,
                        nota: nota,
                        cuenta: cuenta,
                        saldo: saldo,
                        monto: monto,
                        saldofin: saldofin,
                        metodo: metodo,
                        usuario: usuario,
                        opcion: opcion,
                    },
                    success: function(res) {
                        if (res == 1) {
                            buscartotal();
                            $("#modalPago").modal("hide");
                        } else {
                            swal.fire({
                                title: "Error",
                                text: "La operacion no puedo completarse",
                                icon: "warning",
                                focusConfirm: true,
                                confirmButtonText: "Aceptar",
                            });
                        }

                    },
                });

            }

        }



    });



    function mensajepago() {
        swal.fire({
            title: "Pago Guardado",
            icon: "success",
            focusConfirm: true,
            confirmButtonText: "Aceptar",
        });

        window.setTimeout(function() {
            location.reload();
        }, 2500);

    }

    function buscartotal() {
        folio = $('#folio_cxp').val();
        monto = $('#montopago').val();
        $.ajax({
            type: "POST",
            url: "bd/actualizarsaldocxp.php",
            dataType: "json",
            data: { folio: folio, monto: monto },
            success: function(res) {

                $("#saldo").val(res[0].saldo);
                mensajepago();

            }
        });

    }





});