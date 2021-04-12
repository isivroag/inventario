$(document).ready(function () {
    var id, opcion, proyecto
    opcion = 4
  
    tablaVis = $('#tablaV').DataTable({
      columnDefs: [
        {
          targets: -1,
          data: null,
          defaultContent:
            "<div class='text-center'><button class='btn btn-sm btn-primary  btnEditar' data-toggle='tooltip' data-placement='top' title='Editar'><i class='fas fa-edit'></i></button><button class='btn btn-sm bg-gradient-orange text-light btnMov' data-toggle='tooltip' data-placement='top' title='Movimientos'><i class='fas fa-exchange-alt'></i></button><button class='btn btn-sm bg-gradient-purple text-light btnKardex' data-toggle='tooltip' data-placement='top' title='Kardex'><i class='fas fa-bars'></i></button><button class='btn btn-sm btn-danger btnBorrar' data-toggle='tooltip' data-placement='top' title='Borrar'><i class='fas fa-trash-alt'></i></button></div>",
        },
      ],
  
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
    })
    $('[data-toggle="tooltip"]').tooltip()
  
    $('#btnNuevo').click(function () {
      window.location.href = "requisicion.php";
      
    })
  
  
  
    var fila //capturar la fila para editar o borrar el registro
  
    //botón EDITAR
    $(document).on('click', '.btnEditar', function () {
      fila = $(this).closest('tr')
      id = parseInt(fila.find('td:eq(0)').text())
  
      //window.location.href = "actprospecto.php?id=" + id;
      clave = fila.find('td:eq(1)').text()
      nombre = fila.find('td:eq(2)').text()
  
      precio = fila.find('td:eq(3)').text()
  
      cant_prod = fila.find('td:eq(4)').text()
      umedida = fila.find('td:eq(5)').text()
  
  
      $('#clave').val(clave)
      $('#nombre').val(nombre)
      $('#precio').val(precio)
      $('#umedida').val(umedida)
  
  
      opcion = 2 //editar
  
      $('.modal-header').css('background-color', '#007bff')
      $('.modal-header').css('color', 'white')
      $('.modal-title').text('Editar Producto')
      $('#modalCRUD').modal('show')
    })
  
    //botón BORRAR
    $(document).on('click', '.btnBorrar', function () {
      fila = $(this)
  
      id = parseInt($(this).closest('tr').find('td:eq(0)').text())
      opcion = 3 //borrar
  
      //agregar codigo de sweatalert2
      var respuesta = confirm('¿Está seguro de eliminar el registro: ' + id + '?')
  
      console.log(id)
      console.log(opcion)
      if (respuesta) {
        $.ajax({
          url: 'bd/crudproducto.php',
          type: 'POST',
          dataType: 'json',
          data: { id: id, opcion: opcion },
  
          success: function (data) {
            tablaVis.row(fila.parents('tr')).remove().draw()
          },
        })
      }
    })
 
  
  })
  