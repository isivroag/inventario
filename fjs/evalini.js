$(document).ready(function() {


    listar();

    $("#etapa").change(function() {
        listar();
    });

    tablavis = $("#tablaobjetivos").DataTable({
        "paging": false,
        "ordering": false,
        "info": false,
        "searching": false,


        "columnDefs": [{
            "targets": -1,
            "data": null,
            "defaultContent": "<div class='text-center'><div class='btn-group'><button class='btn btn-success  btnVer'><i class='fas fa-info-circle'></i> Info</button></div> <div class='btn-group'><button class='btn btn-primary  btnEval'><i class='fas fa-tasks'></i> Evaluar</button></div></div>"
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
    /*
        $('#tbody').on('click', function() {

            fila = $(this).closest("tr");
            id = parseInt(fila.find('td:eq(0)').text());


            objetivo = fila.find('td:eq(1)').text();
            estado = fila.find('td:eq(2)').text();
            console.log(id);

          
            /*
                $.ajax({

                    url: "bd/evaluar.php",
                    type: "POST",
                    dataType: "json",
                    data: { id: id, eval: eval },

                    success: function(data) {
                        console.log(data);
                        window.location.href = "bd/evaluar.php";
                    }
                });


}); */

    $(document).on("click", ".btnEditar", function() {

        fila = $(this).closest("tr");
        idf = parseInt(fila.find('td:eq(0)').text());


        objetivo = fila.find('td:eq(1)').text();
        valor = parseInt(fila.find('td:eq(3)').text());
        icono = '<i class="fas fa-swimmer text-success" value="1"></i>';
        buton = '<button type="button" class="btn btn-suc btnEditar"><i class="fas fa-edit"></i>Logrado</button>';
        console.log(idf);
        console.log(objetivo);

        console.log(valor);
        if (valor == 0) {
            fila.find('.fa-swimmer').addClass("text-success");
            fila.find('.fa-swimmer').removeClass("text-warning");
            fila.find('td:eq(3)').html('1');
        } else {
            fila.find('.fa-swimmer').removeClass("text-success");
            fila.find('.fa-swimmer').addClass("text-warning");
            fila.find('td:eq(3)').html('0');
        }
        /*
                $.ajax({

                    url: "bd/evaluar.php",
                    type: "POST",
                    dataType: "json",
                    data: { id: id, eval: objetivo },

                    success: function(data) {
                        console.log(data);
                        window.location.href = "bd/evaluar.php";
                    }
                });*/

    });



});






function listar() {
    id = $('#id').val();
    id_nivel = $('#id_nivel').val();
    id_etapa = $('#etapa').val();



    $.ajax({
        type: "POST",
        url: "bd/dbevalini.php",
        dataType: "json",
        data: { id: id, id_nivel: id_nivel, id_etapa: id_etapa },
        success: function(res) {

            var tabla;
            for (var i = 0; i < res.length; i++) {

                if (res[i].valor == 1) {
                    icono = '<i class="fas fa-swimmer text-success" value="1"></i>';
                } else if (res[i].activo == 1) {
                    icono = '<i class="fas fa-swimmer text-warning" value="0"></i>';
                } else {
                    icono = '<i class="fas fa-swimmer text-grey" value="2"></i>';
                }

                tabla += '<tr><td>' + res[i].id_objetivo + '</td><td>' + res[i].desc_objetivo + '</td><td class="text-center">' + icono + '</td><td>' + res[i].valor + '</td><td class="text-center"><button type="button" class="btn btn-success btnEditar"><i class="fas fa-edit"></i>Cambiar</button></td></tr>';
                //tabla += '<tr><td>' + res[i].id_objetivo + '</td><td>' + res[i].desc_objetivo + '</td><td class="text-center">' + icono + '</td><td class="text-center"></td></tr>';
            }
            $('#tbody').html(tabla);
        }
    });


}