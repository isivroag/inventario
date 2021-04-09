$(document).ready(function () {
    /*jQuery.ajaxSetup({
        beforeSend: function() {
            $("#div_carga").show();
        },
        complete: function() {
            $("#div_carga").hide();
        },
        success: function() {},
    });*/

    var id, opcion;
    opcion = 5;



    tablaVis = $("#tablaV").DataTable({
        info: false,
        "ajax": {
            "type": "POST",
            "url": "bd/datosticket.php",
            "dataType": "json",
            "dataSrc": "",

        },


        "columns": [
            { "data": "folio_ti" },
            { "data": "cliente_ti" },
            { "data": "apertura_ti" },
            { "data": "clausura_ti" },
            { "data": "descripcion_ti" },
            { "data": "costo_ti" },
            { "data": "estado_ti" },
            { "defaultContent": "<div class='text-center'><button class='btn btn-sm bg-purple  btnTarea' data-toggle='tooltip' data-placement='top' title='Alta de Tareas'><i class='fas fa-list-ol'></i></button><button class='btn btn-sm bg-orange btnVerTareas' data-toggle='tooltip' data-placement='top' title='Ver Tareas'><i class='text-light fas fa-search'></i></button></button></div>" },
            { "defaultContent": "<div class='text-center'><button class='btn btn-sm btn-primary  btnEditar' data-toggle='tooltip' data-placement='top' title='Editar'><i class='fas fa-edit'></i></button><button class='btn btn-sm bg-success btnCerrar' data-toggle='tooltip' data-placement='top' title='Cerrar'><i class=' text-light fas fa-check-circle'></i></button><button class='btn btn-sm btn-danger btnBorrar' data-toggle='tooltip' data-placement='top' title='Borrar'><i class='fas fa-ban'></i></button></div>" }
        ],

        /*{ className: "hide_column", targets: [5] },*/


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

        rowCallback: function (row, data) {
            $($(row).find("td")["6"]).css("color", "white");
            $($(row).find("td")["6"]).addClass("text-center");
            $($(row).find("td")["5"]).addClass("text-right");

            if (data["estado_ti"] == 1) {
                $($(row).find("td")[6]).css("background-color", "green");
                $($(row).find("td")[6]).addClass("bg-gradient-success");
                $($(row).find("td")["6"]).text("ABIERTO");
            } else if (data["estado_ti"] == 2) {
                $($(row).find("td")[6]).css("background-color", "blue");
                $($(row).find("td")[6]).addClass("bg-gradient-primary");
                $($(row).find("td")["6"]).text("CERRADO");
            } else {
                $($(row).find("td")[6]).css("background-color", "red");
                $($(row).find("td")[6]).addClass("bg-gradient-danger");
                $($(row).find("td")["6"]).text("CANCELADO");
            }
        },
    });

    tablaT = $("#tablaT").DataTable({
        info: false,
        paging: false,
        searching: false,



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

    $('[data-toggle="tooltip"]').tooltip();

    $(document).on("click", ".btnVerTareas", function () {
        fila = $(this).closest("tr");
        folio = parseInt(fila.find("td:eq(0)").text());
        tablaT.clear();
        tablaT.draw();
        opcion = 5;
        $.ajax({
            url: "bd/crudtarea.php",
            type: "POST",
            dataType: "json",
            data: {
                folio: folio,
                opcion: opcion
            },
            success: function (res) {
                if (res.length > 0) {
                    for (var i = 0; i < res.length; i++) {
                        tablaT.row.add([res[i].folio_ta, res[i].fecha_ta, res[i].nombre_ta, res[i].desc_ta,]).draw();

                        $("#modalVerTar").modal("show");

                    }
                } else {
                    Swal.fire({
                        title: "Sin Tareas",
                        text: "El Ticket no tiene tareas registradas ",
                        icon: "info",
                    });
                }


            }
        });



    });

    //FUNCION ACTUALIZAR CADA 5 SEG
    // setInterval(function(){ tablaVis.ajax.reload(null, false); }, 5000);



    //FUNCION PUSH
    /*  function mensaje(){
    Push.create("Hola Mundo");
}*/

    $("#btnNuevo").click(function () {
        //window.location.href = "prospecto.php";
        $("#formDatos").trigger("reset");
        opcion = 1;
        $(".modal-header").css("background-color", "#28a745");
        $(".modal-header").css("color", "white");
        $("#modalCRUD").modal("show");
        id = null;
        opcion = 1; //alta
        var today = new Date();
        var date =
            today.getFullYear() +
            "-" +
            (today.getMonth() + 1) +
            "-" +
            today.getDate();
        var time =
            today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
        var dateTime = date + " " + time;
        $("#inicio").val(dateTime);
        $("#fin").val(dateTime);
        $("#costo").val(0);
        $("#estado").removeClass("bg-success");
        $("#estado").removeClass("bg-primary");
        $("#estado").removeClass("bg-danger");
    });

    var fila; //capturar la fila para editar o borrar el registro
    $(document).on("click", ".btnTarea", function () {

        $("#formTareas").trigger("reset");
        fila = $(this).closest("tr");
        folio = parseInt(fila.find("td:eq(0)").text());
        $("#folio_ti").val(folio);
        opcion = 1;
        $(".modal-header").css("background-color", "#28a745");
        $(".modal-header").css("color", "white");
        $("#modalTarea").modal("show");

    });

    $(document).on("click", "#btnGuardarTar", function () {


        var tarea = $("#tarea").val();
        var tareadesc = $("#tareadesc").val();
        var folio = $("#folio_ti").val();

        if (tarea.length == 0) {
            Swal.fire({
                title: "Datos Faltantes",
                text: "Debe ingresar el nombre de la Tarea",
                icon: "warning",
            });
            return false;
        } else {
            $.ajax({
                url: "bd/crudtarea.php",
                type: "POST",
                dataType: "json",
                data: {
                    folio: folio,
                    tarea: tarea,
                    tareadesc: tareadesc,
                    opcion: opcion
                },
                success: function (data) {

                    if (data == 1) {
                        Swal.fire({
                            title: "Operacion Exitosa",
                            text: "Tarea asignada ",
                            icon: "success",
                        });
                    } else {
                        Swal.fire({
                            title: "Error",
                            text: "La tarea no pudo ser registrada ",
                            icon: "warning",
                        });
                    }
                }

            });
            $("#modalTarea").modal("hide");
        }



    });


    //mensaje();

    //botón EDITAR
    $(document).on("click", ".btnEditar", function () {
        fila = $(this).closest("tr");
        folio = parseInt(fila.find("td:eq(0)").text());
        id = folio;
        //window.location.href = "actprospecto.php?id=" + id;
        inicio = fila.find("td:eq(2)").text();
        fin = fila.find("td:eq(3)").text();
        cliente = fila.find("td:eq(1)").text();
        descripcion = fila.find("td:eq(4)").text();
        costo = fila.find("td:eq(5)").text();
        estado = fila.find("td:eq(6)").text();

        $("#cliente").val(cliente);
        $("#inicio").val(inicio);
        $("#fin").val(fin);
        $("#folio").val(folio);
        $("#costo").val(costo);
        $("#descripcion").val(descripcion);
        $("#estado").val(estado);
        opcion = 2;

        /**/
        $("#estado").removeClass("bg-success");
        $("#estado").removeClass("bg-primary");
        $("#estado").removeClass("bg-danger");

        /* if ($.trim(estado) == 'Abierto') {
                 $('#estado').addClass('bg-success');
             } else {
                 $('#estado').addClass('bg-primary');
             }*/

        switch ($.trim(estado)) {
            case "Abierto":
                $("#estado").addClass("bg-success");
                break;

            case "Cerrado":
                $("#estado").addClass("bg-primary");
                break;
            case "Cancelado":
                $("#estado").addClass("bg-danger");
                break;
            default:
                $("#estado").removeClass("bg-success");
                $("#estado").removeClass("bg-primary");
                $("#estado").removeClass("bg-danger");
        }

        opcion = 2; //editar

        $(".modal-header").css("background-color", "#007bff");
        $(".modal-header").css("color", "white");
        $(".modal-title").text("Editar Partida");
        $("#modalCRUD").modal("show");
    });

    //botón BORRAR
    $(document).on("click", ".btnBorrar", function () {
        fila = $(this);

        folio = parseInt($(this).closest("tr").find("td:eq(0)").text());
        usuario = $("#nameuser").val();
        fecha=actual();
        opcion = 3; //borrar

        swal
            .fire({
                title: "Cancelar",
                text: "¿Desea eliminar el registro seleccionado?",
                showCancelButton: true,
                icon: "question",
                focusConfirm: true,
                confirmButtonText: "Aceptar",
                cancelButtonText: "Cancelar",
                confirmButtonColor: "#28B463",
                cancelButtonColor: "#d33",
            })
            .then(function (isConfirm) {
                if (isConfirm.value) {
                    $.ajax({
                        url: "bd/crudticket.php",
                        type: "POST",
                        dataType: "json",
                        data: { folio: folio, opcion: opcion, usuario: usuario,fecha:fecha },

                        success: function (data) {
                            tablaVis.ajax.reload(null, false);
                            //tablaVis.row(fila.parents("tr")).remove().draw();
                        },
                    });
                } else if (isConfirm.dismiss === swal.DismissReason.cancel) { }
            });
    });

    function actual(){
       


        let date_ob = new Date();

        // adjust 0 before single digit date
        let date = ("0" + date_ob.getDate()).slice(-2);

        // current month
        let month = ("0" + (date_ob.getMonth() + 1)).slice(-2);

        // current year
        let year = date_ob.getFullYear();

        // current hours
        let hours = date_ob.getHours();

        // current minutes
        let minutes = date_ob.getMinutes();

        // current seconds
        let seconds = date_ob.getSeconds();
        fecha=year + "-" + month + "-" + date + " " + hours + ":" + minutes + ":" + seconds;
        return (fecha);
        // prints date & time in YYYY-MM-DD HH:MM:SS format

    }
    $(document).on("click", ".btnCerrar", function () {
        fila = $(this).closest("tr");
        folio = parseInt(fila.find("td:eq(0)").text());
        fecha=actual();

        //window.location.href = "actprospecto.php?id=" + id;

        opcion = 4;
        swal.fire({
            title: "Cerrar Ticket",
            text: "¿Desea cerrar el ticket seleccionado?",
            showCancelButton: true,
            icon: "question",
            focusConfirm: true,
            confirmButtonText: "Aceptar",
            cancelButtonText: "Cancelar",
            confirmButtonColor: "#28B463",
            cancelButtonColor: "#d33",
        })
            .then(function (isConfirm) {
                if (isConfirm.value) {

                    $.ajax({
                        url: "bd/crudticket.php",
                        type: "POST",
                        dataType: "json",
                        data: {
                            folio: folio,
                            opcion: opcion,
                            fecha:fecha
                        },
                        success: function (data) {
                            /* tfolio = data[0].folio_ti;
                             tcliente = data[0].cliente_ti;
                             tinicio = data[0].apertura_ti;
                             tfin = data[0].clausura_ti;
                             tdescripcion = data[0].descripcion_ti;
                             tcosto = data[0].costo_ti;
                             testado = data[0].estado_ti;
                             if (testado == 1) {
                                 testado = "Abierto";
                             } else if (testado == 2) {
                                 testado = "Cerrado";
                             } else {
                                 testado = "Cancelado";
                             }*/
                            //tablaVis.row(fila).data([tfolio, tcliente, tinicio, tfin, tdescripcion, tcosto, testado]).draw();
                            tablaVis.ajax.reload(null, false);

                        },
                    });
                } else if (isConfirm.dismiss === swal.DismissReason.cancel) { }
            });
    });

    /*
        $(document).on("click", ".btnCerrar", function() {
            fila = $(this);

            folio = parseInt($(this).closest("tr").find("td:eq(0)").text());


            var inicio = $("#inicio").val();
            var fin = $("#fin").val();
            var cliente = $("#cliente").val();
            var descripcion = $("#descripcion").val();
            var costo = $("#costo").val();
            var usuario = $("#nameuser").val();


            opcion = 4; //Cerrar
            var estado = 2;
            swal
                .fire({
                    title: "Cerrar Ticket",
                    text: "¿Desea cerrar el ticket seleccionado?",
                    showCancelButton: true,
                    icon: "question",
                    focusConfirm: true,
                    confirmButtonText: "Aceptar",
                    cancelButtonText: "Cancelar",
                    confirmButtonColor: "#28B463",
                    cancelButtonColor: "#d33",
                })
                .then(function(isConfirm) {
                    if (isConfirm.value) {
                        $.ajax({
                            url: "bd/crudticket.php",
                            type: "POST",
                            dataType: "json",
                            data: {
                                folio: folio,
                                inicio: inicio,
                                fin: fin,
                                cliente: cliente,
                                descripcion: descripcion,
                                costo: costo,
                                usuario: usuario,
                                estado: estado,
                                opcion: opcion,
                            },
                            success: function(data) {

                                console.log(data);
                                tfolio = data[0].folio_ti;
                                tcliente = data[0].cliente_ti;
                                tinicio = data[0].apertura_ti;
                                tfin = data[0].clausura_ti;
                                tdescripcion = data[0].descripcion_ti;
                                tcosto = data[0].costo_ti;
                                testado = data[0].estado_ti;
                                if (testado == 1) {
                                    testado = "Abierto";
                                } else if (testado == 2) {
                                    testado = "Cerrado";
                                } else {
                                    testado = "Cancelado";
                                }


                                tablaVis.row(fila).data([tfolio, tcliente, tinicio, tfin, tdescripcion, tcosto, testado]).draw();

                            },
                        });

                        /*
                        $.ajax({
                            url: "bd/crudticket.php",
                            type: "POST",
                            dataType: "json",
                            data: { folio: folio, opcion: opcion, },
                            success: function(data) {
                                console.log(data);
                                tfolio = data[0].folio_ti;
                                tcliente = data[0].cliente_ti;
                                tinicio = data[0].apertura_ti;
                                tfin = data[0].clausura_ti;
                                tdescripcion = data[0].descripcion_ti;
                                tcosto = data[0].costo_ti;
                                testado = data[0].estado_ti;
                                if (testado == 1) {
                                    testado = "Abierto";
                                } else if (testado == 2) {
                                    testado = "Cerrado";
                                } else {
                                    testado = "Cancelado";
                                }

                                tablaVis.row(fila).data([tfolio, tcliente, tinicio, tfin, tdescripcion, tcosto, testado]).draw();

                            },
                        });
                    } else if (isConfirm.dismiss === swal.DismissReason.cancel) {}
                });
        });*/

    $("#formDatos").submit(function (e) {
        e.preventDefault();

        var inicio = $("#inicio").val();
        var fin = $("#fin").val();
        var cliente = $("#cliente").val();
        var descripcion = $("#descripcion").val();
        var costo = $("#costo").val();
        var usuario = $("#nameuser").val();
        var folio = id;
        var estado = 1;
        if (cliente.length == 0) {
            Swal.fire({
                title: "Datos Faltantes",
                text: "Debe ingresar todos los datos del Cliente",
                icon: "warning",
            });
            return false;
        } else {
            $.ajax({
                url: "bd/crudticket.php",
                type: "POST",
                dataType: "json",
                data: {
                    folio: folio,
                    inicio: inicio,
                    fin: fin,
                    cliente: cliente,
                    descripcion: descripcion,
                    costo: costo,
                    usuario: usuario,
                    estado: estado,
                    opcion: opcion,
                },
                success: function (data) {

                    console.log(data);
                    tfolio = data[0].folio_ti;
                    tcliente = data[0].cliente_ti;
                    tinicio = data[0].apertura_ti;
                    tfin = data[0].clausura_ti;
                    tdescripcion = data[0].descripcion_ti;
                    tcosto = data[0].costo_ti;
                    testado = data[0].estado_ti;
                    if (testado == 1) {
                        testado = "Abierto";
                    } else if (testado == 2) {
                        testado = "Cerrado";
                    } else {
                        testado = "Cancelado";
                    }

                    if (opcion == 1) {
                        // tablaVis.row.add([tfolio, tcliente, tinicio, tfin, tdescripcion, tcosto, testado]).draw();
                        tablaVis.ajax.reload(null, false);

                    } else {
                        //                        tablaVis.row(fila).data([tfolio, tcliente, tinicio, tfin, tdescripcion, tcosto, testado]).draw();
                        tablaVis.ajax.reload(null, false);

                    }
                },
            });
            $("#modalCRUD").modal("hide");
        }
    });
});