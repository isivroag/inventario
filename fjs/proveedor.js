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
        $(".modal-title").text("Nuevo Proveedor");
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
        nombre = fila.find('td:eq(2)').text();
        rfc = fila.find('td:eq(1)').text();
        correo = fila.find('td:eq(3)').text();
        calle = fila.find('td:eq(4)').text();
        num = fila.find('td:eq(5)').text();
        col = fila.find('td:eq(6)').text();
        cp = fila.find('td:eq(7)').text();
        cd = fila.find('td:eq(8)').text();
        edo = fila.find('td:eq(9)').text();
        tel = fila.find('td:eq(10)').text();
        cel = fila.find('td:eq(11)').text();

        $("#rfc").val(rfc);
        $("#nombre").val(nombre);
        $("#correo").val(correo);
        $("#calle").val(calle);
        $("#col").val(col);
        $("#num").val(num);
        $("#cp").val(cp);
        $("#cd").val(cd);
        $("#edo").val(edo);
        $("#tel").val(tel);
        $("#cel").val(cel);
        opcion = 2; //editar

        $(".modal-header").css("background-color", "#007bff");
        $(".modal-header").css("color", "white");
        $(".modal-title").text("Editar Proveedor");
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

                url: "bd/crudproveedor.php",
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
        var rfc = $.trim($("#rfc").val());
        var nombre = $.trim($("#nombre").val());
        var calle = $.trim($("#calle").val());
        var col = $.trim($("#col").val());
        var num = $.trim($("#num").val());
        var cp = $.trim($("#cp").val());
        var cd = $.trim($("#cd").val());
        var edo = $.trim($("#edo").val());
        var tel = $.trim($("#tel").val());
        var cel = $.trim($("#cel").val());
        var correo = $.trim($("#correo").val());



        if (nombre.length == 0) {
            Swal.fire({
                title: 'Datos Faltantes',
                text: "Debe ingresar todos los datos del Proveedor",
                icon: 'warning',
            })
            return false;
        } else {
            $.ajax({
                url: "bd/crudproveedor.php",
                type: "POST",
                dataType: "json",
                data: { nombre: nombre, rfc: rfc, correo: correo, calle: calle, num: num, col: col, cp: cp, cd: cd, edo: edo, tel: tel, cel: cel, id: id, opcion: opcion },
                success: function(data) {
                    console.log(data);
                    console.log(fila);

                    //tablaPersonas.ajax.reload(null, false);
                    id = data[0].id_prov;
                    nombre = data[0].nombre;
                    rfc = data[0].rfc;
                    correo = data[0].correo;
                    calle = data[0].calle;
                    num = data[0].num;
                    col = data[0].col;
                    cp = data[0].cp;
                    cd = data[0].cd;
                    edo = data[0].edo;
                    tel = data[0].tel;
                    cel = data[0].cel;
                    if (opcion == 1) {
                        tablaVis.row.add([id, rfc, nombre, correo, calle, num, col, cp, cd, edo, tel, cel]).draw();
                    } else {
                        tablaVis.row(fila).data([id, rfc, nombre, correo, calle, num, col, cp, cd, edo, tel, cel]).draw();
                    }
                }
            });
            $("#modalCRUD").modal("hide");
        }
    });

});