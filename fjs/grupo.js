$(document).ready(function() {
    var id, opcion;
    opcion = 4;

    $('#tablaRpt tfoot th').each(function() {
        var title = $(this).text();
        $(this).html('<input type="text" placeholder="Filtrar.." />');
    });


    var tablaVis = $("#tablaRpt").DataTable({

        dom: "<'row justify-content-center'<'col-sm-12 col-md-4 form-group'l><'col-sm-12 col-md-4 form-group'B><'col-sm-12 col-md-4 form-group'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",


        buttons: [{
                extend: 'excelHtml5',
                "text": "<i class='fas fa-file-excel'> Excel</i>",
                "titleAttr": "Exportar a Excel",
                "title": 'Reporte de Grupos',
                "className": 'btn bg-success ',
                orientation: 'landscape',
                exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9] }
            },
            {
                extend: 'pdfHtml5',
                "text": "<i class='far fa-file-pdf'> PDF</i>",
                "titleAttr": "Exportar a PDF",
                "title": 'Reporte de Grupos',
                "className": 'btn bg-danger',
                orientation: 'landscape',
                exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9] }
            }



        ],


        "responsive": true,
        "columnDefs": [{
                "targets": -1,
                "data": null,
                "defaultContent": "<div class='text-center'><div class='btn-group'><button class='btn btn-success  btnEditar'><i class='fas fa-info-circle'></i> Info</button></div></div>",

            },

            {
                "targets": 1,
                "visible": false,
                "searchable": false,
            },

            {
                "targets": 4,
                "visible": false,
                "searchable": false,
            },
            {
                "targets": 7,
                "visible": false,
                "searchable": false,
            }, {
                "targets": 6,
                "visible": false,
                "searchable": false,
            }

        ],

        "order": [
            [1, "asc"],
            [2, "asc"]

        ],




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
        },



        "initComplete": function() {
            this.api().columns().every(function() {
                var that = this;

                $('input', this.footer()).on('keyup change', function() {
                    if (that.search() !== this.value) {
                        that
                            .search(this.value)
                            .draw();
                    }
                });
            })
        }
    });



    $("#btnNuevo").click(function() {

        window.location.href = "usuario.php";
        //$("#formPersonas").trigger("reset");
        //$(".modal-header").css("background-color", "#28a745");
        //$(".modal-header").css("color", "white");
        //$(".modal-title").text("Nuevo Visitante");
        //$("#modalCRUD").modal("show");
        //id = null;
        //opcion = 1; //alta
    });

    var fila; //capturar la fila para editar o borrar el registro

    //botón EDITAR    
    $(document).on("click", ".btnEditar", function() {
        fila = $(this).closest("tr");
        id = parseInt(fila.find('td:eq(0)').text());

        window.location.href = "viewgrupo.php?id=" + id;
        // nombre = fila.find('td:eq(1)').text();
        // ine = fila.find('td:eq(2)').text();
        // licencia = parseInt(fila.find('td:eq(3)').text());
        // pasaporte = parseInt(fila.find('td:eq(4)').text());
        // otro = parseInt(fila.find('td:eq(5)').text());

        // $("#nombre").val(nombre);
        // $("#ine").val(ine);
        // $("#licencia").val(licencia);
        // $("#pasaporte").val(pasaporte);
        // $("#otro").val(otro);
        // opcion = 2; //editar

        // $(".modal-header").css("background-color", "#007bff");
        // $(".modal-header").css("color", "white");
        // $(".modal-title").text("Editar Visitante");
        //$("#modalCRUD").modal("show");

    });

    //botón BORRAR

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