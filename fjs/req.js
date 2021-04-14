
$(document).ready(function() {
    jQuery.ajaxSetup({
        beforeSend: function() {
            $("#div_carga").show();
        },
        complete: function() {
            $("#div_carga").hide();
        },
        success: function() {},
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

    $("#btnNuevo").click(function() {

        window.location.href = "requisicion.php";
    });


    $("#btnGuardar").click(function() {
        folio_req = $("#folio_tmp").val();
        window.location.href = "requisicion.php?folio=" + folio_req;
    });
    
    function round(value, decimals) {
        return Number(Math.round(value + "e" + decimals) + "e-" + decimals);
    }

    $(document).on("click", "#btnVer", function() {

        folio = $('#folio').val();
        var ancho = 1000;
        var alto = 800;
        var x = parseInt((window.screen.width / 2) - (ancho / 2));
        var y = parseInt((window.screen.height / 2) - (alto / 2));

        url = "formatos/pdfreq.php?folio=" + folio;

        window.open(url, "Requisición", "left=" + x + ",top=" + y + ",height=" + alto + ",width=" + ancho + "scrollbar=si,location=no,resizable=si,menubar=no");

    });
});