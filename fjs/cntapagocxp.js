$(document).ready(function() {
    /*jQuery.ajaxSetup({
        beforeSend: function() {
            $("#div_carga").show();
        },
        complete: function() {
            $("#div_carga").hide();
        },
        success: function() {},
    });*/

    var id, opcion, fila;
    opcion = 5;



    dt = $("#tablaV").DataTable({
        info: false,


        "ajax": {
            "type": "POST",
            "url": "bd/resumencxp.php",
            "dataType": "json",
            "dataSrc": "",

        },

        "columns": [{
                "class": "details-control",
                "orderable": false,
                "data": null,
                "defaultContent": ""
            },
            { "data": "folio_cxp" },
            { "data": "nombre" },
            { "data": "concepto" },
            { "data": "total" },
            { "data": "pagos" },
            { "data": "saldo" },

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


    });

    var detailRows = [];

    $('#tablaV tbody').on('click', 'tr td.details-control', function() {
        var tr = $(this).closest('tr');
        var row = dt.row(tr);
        var idx = $.inArray(tr.attr('id'), detailRows);
        folio = parseInt($(this).closest("tr").find('td:eq(1)').text());


        if (row.child.isShown()) {
            tr.removeClass('details');
            row.child.hide();

            // Remove from the 'open' array
            detailRows.splice(idx, 1);
        } else {
            tr.addClass('details');
            row.child(format(row.data(), folio)).show();

            // Add to the 'open' array
            if (idx === -1) {
                detailRows.push(tr.attr('id'));
            }
        }
    });

    dt.on('draw', function() {
        $.each(detailRows, function(i, id) {
            $('#' + id + ' td.details-control').trigger('click');
        })
    });

    function format(d, folio) {

        tabla = "";

        tabla = " <div class='container fluid'><div class='row'>" +
            "<div class='col-lg-12'>" +
            "<div class='table-responsive'>" +
            "<table class='table table-sm table-striped table-hover table-bordered table-condensed text-nowrap mx-auto ' style='width:100%'>" +
            "<thead class='text-center '>" +
            "<tr>" +
            "<th>Folio</th>" +
            "<th>Fecha</th>" +
            "<th>Monto</th>" +
            "<th>Metodo</th>" +
            "<th>Acciones</th>" +
            "</tr>" +
            "</thead>" +
            "<tbody>";

        $.ajax({

            url: "bd/detalleresumen.php",
            type: "POST",
            dataType: "json",
            data: { folio: folio },
            async: false,
            success: function(res) {
                console.log(res);
                for (var i = 0; i < res.length; i++) {
                    tabla += '<tr><td class="text-center">' + res[i].folio + '</td><td class="text-center">' + res[i].fecha + '</td><td class="text-center">' + res[i].monto + '</td><td class="text-center">' + res[i].metodo + "</td><td><div class='text-center'><div class='btn-group'><button class='btn btn-info btnVer'><i class='fas fa-info-circle'></i> Info</button></div></div></td></tr>";
                }

            }
        });

        tabla += "</tbody>" +
            "</table>" +
            "</div>" +
            "</div>" +
            "</div>" +
            "</div>";

        return tabla;
    };


    $(document).on("click", ".btnVer", function() {
        fila = $(this).closest("tr");
        id = parseInt(fila.find('td:eq(0)').text());

        console.log(id);


    });

});