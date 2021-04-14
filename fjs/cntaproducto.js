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
      { className: "hide_column", targets: [6] }
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
    //window.location.href = "prospecto.php";
    $('#formDatos').trigger('reset')
    $('.modal-header').css('background-color', '#28a745')
    $('.modal-header').css('color', 'white')
    $('.modal-title').text('Nuevo Producto')
    $('#modalCRUD').modal('show')
    id = null
    opcion = 1 //alta
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
    id_tipop = fila.find('td:eq(6)').text()
    tipop = fila.find('td:eq(7)').text()


    $('#clave').val(clave)
    $('#nombre').val(nombre)
    $('#precio').val(precio)
    $('#umedida').val(umedida)
    $('#tipop').val(id_tipop)


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



  $('#formDatos').submit(function (e) {
    e.preventDefault()
    var nombre = $.trim($('#nombre').val())
    var clave = $.trim($('#clave').val())
    var umedida = $.trim($('#umedida').val())
    var precio = $.trim($('#precio').val())
    var tipop = $.trim($('#tipop').val())

    if (nombre.length == 0) {
      Swal.fire({
        title: 'Datos Faltantes',
        text: 'Debe ingresar todos los datos la Partida',
        icon: 'warning',
      })
      return false
    } else {
      $.ajax({
        url: 'bd/crudproducto.php',
        type: 'POST',
        dataType: 'json',
        data: { nombre: nombre, clave: clave, umedida: umedida, precio: precio, id: id,tipop: tipop, opcion: opcion },
        success: function (data) {
          //tablaPersonas.ajax.reload(null, false);
          id = data[0].id_prod
          nombre = data[0].nom_prod
          clave = data[0].clave_prod
          umedida = data[0].umedida
          precio = data[0].precio_prod
          cantidad = data[0].cant_prod
          id_tipop = data[0].id_tipop
          nom_tipop = data[0].nom_tipop

          if (opcion == 1) {
            tablaVis.row.add([id, clave, nombre, precio, cantidad, umedida,id_tipop,nom_tipop]).draw()
          } else {
            tablaVis.row(fila).data([id, clave, nombre, precio, cantidad, umedida,id_tipop,nom_tipop]).draw()
          }
        },
      })
      $('#modalCRUD').modal('hide')
    }
  })

  $(document).on('click', '.btnMov', function () {
    fila = $(this).closest('tr')
    id = parseInt(fila.find('td:eq(0)').text())

    nombre = fila.find('td:eq(2)').text()
    saldo = fila.find('td:eq(4)').text()

    $('#id').val(id)
    $('#nombrep').val(nombre)

    $('#extact').val(saldo)

    $('.modal-header').css('background-color', '#007bff')
    $('.modal-header').css('color', 'white')
    $('.modal-title').text('Movimiento de Inventario')
    $('#modalMOV').modal('show')
  })

  $('#formMov').submit(function (e) {
    e.preventDefault();
    var id = $.trim($('#id').val());
    var descripcion = $('#descripcion').val();
    var tipomov = $.trim($('#tipomov').val());
    var saldo = $('#extact').val();
    var montomov = $('#montomov').val();
    var saldofin = 0;



    if (id.length == 0 || tipomov.length == 0 || montomov.length == 0) {
      Swal.fire({
        title: 'Datos Faltantes',
        text: 'Debe ingresar todos los datos de la cuenta',
        icon: 'warning',
      })
      return false
    } else {
      switch (tipomov) {
        case 'Entrada':
          saldofin = parseFloat(saldo) + parseFloat(montomov);
          $.ajax({
            url: 'bd/crudmovimiento.php',
            type: 'POST',
            dataType: 'json',
            data: {
              id: id,
              tipomov: tipomov,
              saldo: saldo,
              saldofin: saldofin,
              montomov: montomov,
              descripcion: descripcion
            },
            success: function (data) {
              if (data == 3) {
                Swal.fire({
                  title: 'Operación Exitosa',
                  text: 'Movimiento Guardado',
                  icon: 'success',
                })
                $('#modalMOV').modal('hide');
                window.location.reload();
              } else {
                Swal.fire({
                  title: 'No fue posible cocluir la operacion',
                  text: 'Movimiento No Guardado',
                  icon: 'error',
                })
              }
            },
          })

          break
        case 'Salida':
          saldofin = parseFloat(saldo) - parseFloat(montomov);
          $.ajax({
            url: 'bd/crudmovimiento.php',
            type: 'POST',
            dataType: 'json',
            data: {
              id: id,
              tipomov: tipomov,
              saldo: saldo,
              saldofin: saldofin,
              montomov: montomov,
              descripcion: descripcion
            },
            success: function (data) {
              if (data == 3) {
                Swal.fire({
                  title: 'Operación Exitosa',
                  text: 'Movimiento Guardado',
                  icon: 'success',
                })
                window.location.reload()
                $('#modalMOV').modal('hide');
                window.location.reload();
              } else {
                Swal.fire({
                  title: 'No fue posible cocluir la operacion',
                  text: 'Movimiento No Guardado',
                  icon: 'error',
                })
              }
            },
          })
          break
        case 'Inventario Inicial':
          //Advertir y preguntar
          swal
            .fire({
              title: 'Inventario Inicial',
              text:
                'Este movimiento cambia las Existencias totales del Producto por la cantidad establecida sin importar los movimientos anteriores ¿Desea Continuar?',

              showCancelButton: true,
              icon: 'warning',
              focusConfirm: true,
              confirmButtonText: 'Aceptar',

              cancelButtonText: 'Cancelar',
            })
            .then(function (isConfirm) {
              if (isConfirm.value) {
                saldofin = montomov;

                $.ajax({
                  url: 'bd/crudmovimiento.php',
                  type: 'POST',
                  dataType: 'json',
                  data: {
                    id: id,
                    tipomov: tipomov,
                    saldo: saldo,
                    saldofin: saldofin,
                    montomov: montomov,
                    descripcion: descripcion
                  },
                  success: function (data) {
                    if (data == 3) {
                      Swal.fire({
                        title: 'Operación Exitosa',
                        text: 'Movimiento Guardado',
                        icon: 'success',
                      })
                      $('#modalMOV').modal('hide');
                      window.location.reload();
                    } else {
                      Swal.fire({
                        title: 'No fue posible cocluir la operacion',
                        text: 'Movimiento No Guardado',
                        icon: 'error',
                      })
                    }
                  },
                })
              } else if (isConfirm.dismiss === swal.DismissReason.cancel) {
              }
            })

          break
      }
    }
  })

  $(document).on('click', '.btnKardex', function () {
    fila = $(this).closest('tr')
    id = parseInt(fila.find('td:eq(0)').text())
    window.location='cntamovp.php?id='+id;
    

    
})

})
