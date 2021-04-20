$(document).ready(function () {
    jQuery.ajaxSetup({
        beforeSend: function () {
            $("#div_carga").show();
        },
        complete: function () {
            $("#div_carga").hide();
        },
        success: function () { },
    });

    var id, opcion;

    tablaVis = $("#tablaV").DataTable({
        paging: false,
        ordering: false,
        info: false,
        searching: false,

        columnDefs: [{
            targets: -1,
            data: null,
            defaultContent: "<div class='text-center'><button class='btn btn-sm btn-danger btnBorrar'><i class='fas fa-trash-alt'></i></button></div>",
        },
        { className: "text-center", targets: [0] },
        { className: "hide_column", targets: [1] },
        { className: "text-center", targets: [2] },
        { className: "text-right", targets: [3] },


        ],

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

    tablaC = $("#tablaCon").DataTable({
        columnDefs: [{
            targets: -1,
            data: null,
            defaultContent: "<div class='text-center'><div class='btn-group'><button class='btn btn-sm btn-success btnSelConcepto'><i class='fas fa-hand-pointer'></i></button></div></div>",
        },

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




    $(document).on("click", "#bconcepto", function () {
        $(".modal-header").css("background-color", "#007bff");
        $(".modal-header").css("color", "white");

        $("#modalConcepto").modal("show");
        /*
                $("#claveconcepto").val("");
                $("#concepto").val("");
                $("#id_umedida").val("");
                $("#usomat").val("");
                $("#nom_umedida").val("");
                $("#bmaterial").prop("disabled", true);
                $("#clavemat").val("");
                $("#material").val("");
                $("#clave").val("");
                $("#idprecio").val("");
                $("#unidad").val("");
        
                $("#precio").val("");
                $("#cantidad").val("");
                $("#cantidad").prop("disabled", true);*/
    });


    $(document).on("click", "#btnGuardar", function () {

        solicitante = $("#solicitante").val();
        fecha = $("#fecha").val();
        tokenid = $("#tokenid").val();
        folio = $("#folio").val();
        fraccionamiento = $("#fraccionamiento").val();
        obs = $("#obs").val();
        requisicion = $("#requisicion").val();
        console.log(requisicion);




        if (
            solicitante.length != 0 &&
            fraccionamiento.length != 0 &&
            tablaVis.data().any()

        ) {
            $.ajax({
                type: "POST",
                url: "bd/tmppres.php",
                dataType: "json",
                //async: false,
                data: {
                    folio: folio,
                    fecha: fecha,
                    tokenid: tokenid,
                    solicitante: solicitante,
                    fraccionamiento: fraccionamiento,
                    obs: obs,
                },
                success: function (res) {
                    if (res == 0) {
                        Swal.fire({
                            title: "Error al Guardar",
                            text: "No se puedo guardar los datos del cliente",
                            icon: "error",
                        });
                    } else {
                        /* MODIFICAR O GUARDAR NUEVO PRESUPUESTO*/
                        if (requisicion == 0) {
                            $.ajax({
                                type: "POST",
                                url: "bd/trasladoreq.php",
                                dataType: "json",
                                //async: false,
                                data: { folio: folio },
                                success: function (res) {
                                    if (res == 0) {
                                        Swal.fire({
                                            title: "Error al Guardar",
                                            text: "No se puedo guardar los datos",
                                            icon: "error",
                                        });
                                    } else {
                                        Swal.fire({
                                            title: "Operación Exitosa",
                                            text: "Presupuesto Guardado",
                                            icon: "success",
                                        });
                                        folio = res;
                                        window.setTimeout(function () {
                                            window.location.href = "req.php?folio=" + folio;
                                        }, 1000);
                                    }
                                },
                            });
                        } else {
                            console.log(folio);
                            console.log(requisicion);

                            $.ajax({
                                type: "POST",
                                url: "bd/modificarreq.php",
                                dataType: "json",
                                //async: false,
                                data: { folio: folio, requisicion: requisicion },
                                success: function (res) {
                                    if (res == 0) {
                                        Swal.fire({
                                            title: "Error al Guardar",
                                            text: "No se puedo guardar los datos del cliente",
                                            icon: "error",
                                        });
                                    } else {
                                        Swal.fire({
                                            title: "Operación Exitosa",
                                            text: "Presupuesto Modificado",
                                            icon: "success",
                                        });
                                        folio = res;
                                        window.setTimeout(function () {
                                            window.location.href = "req.php?folio=" + folio;
                                        }, 1000);
                                    }
                                },
                            });
                        }
                    }
                },
            });
        } else {
            Swal.fire({
                title: "No es posible Guardar",
                text: "Revise sus datos, es posible que no haya capturado toda la información",
                icon: "error",
            });
        }
    });

    $(document).on("click", "#btnGuardarHead", function () {
        guardarhead();


    });

    $(document).on("click", ".btnBorrar", function (event) {
        event.preventDefault();
        fila = $(this);
        id = parseInt($(this).closest("tr").find("td:eq(0)").text());
        folio = $("#folio").val();
        opcion = 2;

        swal
            .fire({
                title: "Borrar",
                text: "¿Realmente desea borrar este elemento?",

                showCancelButton: true,
                icon: "warning",
                focusConfirm: true,
                confirmButtonText: "Aceptar",

                cancelButtonText: "Cancelar",
            })
            .then(function (isConfirm) {
                if (isConfirm.value) {
                    $.ajax({
                        url: "bd/detalletemp.php",
                        type: "POST",
                        dataType: "json",
                        async: false,
                        data: { id: id, folio: folio, opcion: opcion },
                        success: function (data) {
                            if (data == 1) {
                                tablaVis.row(fila.parents("tr")).remove().draw();
                            }
                        },
                    });
                } else if (isConfirm.dismiss === swal.DismissReason.cancel) { }
            });
    });

    $(document).on("click", ".btnSelConcepto", function () {
        fila = $(this).closest("tr");

        idConcepto = fila.find("td:eq(0)").text();
        NomConcepto = fila.find("td:eq(1)").text();
        id_umedida = fila.find("td:eq(2)").text();



        $("#claveconcepto").val(idConcepto);
        $("#concepto").val(NomConcepto);
        $("#nom_umedida").val(id_umedida);
        $("#cantidad").prop("disabled", false);
        $("#modalConcepto").modal("hide");
    });


    $(document).on("click", "#btlimpiar", function () {

        limpiar();

    });

    $(document).on("click", "#btnagregar", function () {
        folio = $("#folio").val();
        idprod = $("#claveconcepto").val();
        nomprod = $("#concepto").val();
        umedida = $("#nom_umedida").val();
        cantidad = $("#cantidad").val();
        unidad = $("#unidad").val();
        opcion = 1;

        if (
            folio.length != 0 &&
            idprod.length != 0 &&
            cantidad.length != 0
        ) {
            // inicia buscar existencia
            $.ajax({
                type: "POST",
                url: "bd/buscarexistencias.php",
                dataType: "json",
                //async: false,
                data: {

                    idprod: idprod,

                },
                success: function (data) {
                    console.log(data);
                    if (data > 0) {
                        if (parseFloat(data) >= parseFloat(cantidad)) {
                            console.log(data);
                            console.log(cantidad);
                            //inicia insertar mov en requisicion
                            $.ajax({
                                type: "POST",
                                url: "bd/detalletemp.php",
                                dataType: "json",
                                //async: false,
                                data: {
                                    folio: folio,
                                    idprod: idprod,
                                    nomprod: nomprod,
                                    umedida: umedida,
                                    cantidad: cantidad,
                                    opcion: opcion,
                                },
                                success: function (data) {
                                    id_reg = data[0].id_reg;
                                    idprod = data[0].id_prod;
                                    nom_prod = data[0].nom_prod;
                                    umedida = data[0].umedida;
                                    cantidad = data[0].cantidad;


                                    tablaVis.row
                                        .add([
                                            id_reg,
                                            idprod,
                                            nom_prod,
                                            cantidad,
                                            umedida,
                                        ])
                                        .draw();
                                    limpiar();


                                },
                            });
                            //termina insertar mov en requisicion
                        }
                        else {
                            Swal.fire({
                                title: "Sin Inventario",
                                text: "No existe inventario Suficiente del Material",
                                icon: "warning",
                            });
                            return false;
                        }

                    }
                    else {
                        Swal.fire({
                            title: "Sin Inventario",
                            text: "No existe inventario del Material",
                            icon: "warning",
                        });
                        return false;
                    }


                },
            });

            //termina buscar existencia



        } else {
            Swal.fire({
                title: "Datos Faltantes",
                text: "Debe ingresar todos los datos del Material",
                icon: "warning",
            });
            return false;
        }
    });

    function guardarhead() {

        fecha = $("#fecha").val();
        tokenid = $("#tokenid").val();
        folio = $("#folio").val();
        console.log(folio);
        solicitante = $("#solicitante").val();
        fraccionamiento = $("#fraccionamiento").val();
        obs = $("#obs").val();



        $.ajax({
            type: "POST",
            url: "bd/tmppres.php",
            dataType: "json",
            data: {
                folio: folio,
                fecha: fecha,
                tokenid: tokenid,
                solicitante: solicitante,
                fraccionamiento: fraccionamiento,
                obs: obs,

            },
            success: function (res) {
                if (res == 0) {
                    Swal.fire({
                        title: "Error al Guardar",
                        text: "No se puedo guardar el encabezado de la Requisición",
                        icon: "error",
                    }

                    );
                } else {
                    mensaje();
                }
            },
        });
    }


    function limpiar() {
        $("#concepto").val("");
        $("#nom_umedida").val("");
        $("#bmaterial").prop("disabled", true);
        $("#unidad").val("");

        $("#cantidad").val("");

        $("#cantidad").prop("disabled", true);
    }




    function mensaje() {
        swal.fire({
            title: "Requisición",
            text: "Guardada",
            icon: "success",
            focusConfirm: true,
            confirmButtonText: "Aceptar",
        });
    }

    function round(value, decimals) {
        return Number(Math.round(value + "e" + decimals) + "e-" + decimals);
    }
});