$(document).ready(function () {
    var id, opcion
    opcion = 4

    $('#tablaV thead tr').clone(true).appendTo( '#tablaV thead' );
    $('#tablaV thead tr:eq(1) th').each( function (i) {


        var title = $(this).text();


        $(this).html( '<input class="form-control form-control-sm" type="text" placeholder="'+title+'" />' );
 
        $( 'input', this ).on( 'keyup change', function () {
          

            valbuscar=this.value;


          
            if ( tablaVis.column(i).search() !== valbuscar ) {
                tablaVis
                    .column(i)
                    .search( valbuscar,true,true )
                    .draw();
            }
        } );
    } );


    //Agregar comentario al final de la tabla
    var titulo=$("#titulo").val();
    var fechaini=$("#fechaini").val();
    var fechafin=$("#fechafin").val();
 
    tablaVis = $('#tablaV').DataTable({
      dom:
        "<'row justify-content-center'<'col-sm-12 col-md-4 form-group'l><'col-sm-12 col-md-4 form-group'B><'col-sm-12 col-md-4 form-group'f>>" +
        "<'row'<'col-sm-12'tr>>" +
        "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
        
        columnDefs: [
            {
                "targets": 0,
                "data": "cntamovp.php",
                "render": function ( data, type, full, meta ) {
                  return '<a href=cntamovp.php?id='+data+'&fechaini='+fechaini+'&fechafin='+fechafin+'>'+data+'</a>';    }
             }
          
         
        ],
    
      buttons: [
        {
          extend: 'excelHtml5',
          text: "<i class='fas fa-file-excel'> Excel</i>",
          titleAttr: 'Exportar a Excel',
          title: 'Reporte de Presupuestos',
          className: 'btn bg-success ',
          messageTop: titulo,
          exportOptions: {
            columns: [0, 1, 2, 3, 4, 5],
          },
        },
        {
          extend: 'pdfHtml5',
          text: "<i class='far fa-file-pdf'> PDF</i>",
          titleAttr: 'Exportar a PDF',
          title: 'Reporte de Presupuestos',
          className: 'btn bg-danger',
          exportOptions: { columns: [0, 1, 2, 3, 4, 5] },
          format: {
              body: function (data, row, column, node) {
                if (column === 6) {
                  return data
                } else {
                  return data
                }
              },
            },
        },
      ],
      stateSave: true,
      orderCellsTop: true,
    fixedHeader: true,
    paging:false,
      
  
      
  
      //Para cambiar el lenguaje a español
      language: {
        lengthMenu: 'Mostrar _MENU_ registros',
        zeroRecords: 'No se encontraron resultados',
        info:
          'Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros',
        infoEmpty: 'Mostrando registros del 0 al 0 de un total de 0 registros',
        infoFiltered: '(filtrado de un total de _MAX_ registros)',
        sSearch: 'Buscar:',
        oPaginate: {
          sFirst: 'Primero',
          sLast: 'Último',
          sNext: 'Siguiente',
          sPrevious: 'Anterior',
        },
        sProcessing: 'Procesando...',
      },
  
      rowCallback: function (row, data) {
        
        $($(row).find('td')['0']).addClass('text-center')
        $($(row).find('td')['1']).addClass('text-center')
        $($(row).find('td')['3']).addClass('text-center')
        $($(row).find('td')['4']).addClass('text-center')
        $($(row).find('td')['5']).addClass('text-center')
        $($(row).find('td')['6']).addClass('text-center')
        $($(row).find('td')['7']).addClass('text-center')
        
        
  
      
      },


    });
  

  
    var fila //capturar la fila para editar o borrar el registro
  
    //botón EDITAR

  

  
    //botón BORRAR

  
    $('#btnBuscar').click(function () {
      var inicio = $('#inicio').val()
      var final = $('#final').val()
  
      if ($('#ctodos').prop('checked')) {
        opcion = 0
      } else {
        opcion = 1
      }
  
      tablaVis.clear()
      tablaVis.draw()
  
      console.log(opcion)
  
      if (inicio != '' && final != '') {
        $.ajax({
          type: 'POST',
          url: 'bd/buscarpresupuestos.php',
          dataType: 'json',
          data: { inicio: inicio, final: final, opcion: opcion },
          success: function (data) {
            for (var i = 0; i < data.length; i++) {
              estado = data[i].estado_pres
              total = data[i].gtotal
  
              tablaVis.row
                .add([
                  data[i].folio_pres,
                  data[i].fecha_pres,
                  data[i].nombre,
                  data[i].concepto_pres,
                  data[i].ubicacion,
                  data[i].gtotal,
                  data[i].estado_pres,
                  data[i].vendedor,
                ])
                .draw()
  
              //tabla += '<tr><td>' + res[i].id_objetivo + '</td><td>' + res[i].desc_objetivo + '</td><td class="text-center">' + icono + '</td><td class="text-center"></td></tr>';
            }
          },
        })
      } else {
        alert('Selecciona ambas fechas')
      }
    })


    $("#btnconsulta").click(function() {
        mes = $("#mes").val();
        ejercicio = $("#ejercicio").val();
        window.location.href = "inventariodet.php?mes=" + mes + "&ejercicio="+ejercicio;

    });
  })
  

