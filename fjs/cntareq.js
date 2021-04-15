$(document).ready(function () {
  var id, opcion, proyecto
  opcion = 4
  const MAXIMO_TAMANIO_BYTES = 2000000;

  tablaVis = $('#tablaV').DataTable({
    columnDefs: [
      {
        targets: -1,
        data: null,
        defaultContent:
          "<div class='text-center'><button class='btn btn-sm btn-primary  btnEditar' data-toggle='tooltip' data-placement='top' title='Ver'><i class='fas fa-search'></i></button><button class='btn btn-sm btn-success  btnUpload' data-toggle='tooltip' data-placement='top' title='Subir Comprobante'><i class='fas fa-cloud-upload-alt'></i></button><button class='btn btn-sm btn-danger btnBorrar' data-toggle='tooltip' data-placement='top' title='Borrar'><i class='fas fa-trash-alt'></i></button></div>",
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

    window.location.href = 'req.php?folio=' + id
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


  $(document).on('click', '.btnUpload', function () {
    fila = $(this).closest('tr')
    id = parseInt(fila.find('td:eq(0)').text())



    
    $("#formDatos").trigger("reset");
    $("#folioreq").val(id);
    $(".modal-header").css("background-color", "#28a745");
    $(".modal-header").css("color", "white");
    $(".modal-title").text("Subir Archivo");
    $("#modalCRUD").modal("show");
  })


  $("#archivo").on('change', function () {
    var fileName = $(this).val().split("\\").pop();
    $(this).siblings(".custom-file-label").addClass("selected").html(fileName);

  })

  $(document).on('click', '#upload', function () {
    
    var folioreq = $("#folioreq").val();
    var formData = new FormData();
    var files = $('#archivo')[0].files[0];
    console.log(files.size);
    if (files.size > MAXIMO_TAMANIO_BYTES) {
      const tamanioEnMb = MAXIMO_TAMANIO_BYTES / 1000000;
      alert(`El tamaño máximo es ${tamanioEnMb} MB`);
      // Limpiar
      $("#archivo").val();
    }
    else {
      formData.append('file', files);
      formData.append('folioreq',folioreq)
      $.ajax({
        url: 'bd/upload.php',
        type: 'post',
        data: formData,
        contentType: false,
        processData: false,
        success: function (response) {
          if (response != 0) {
            console.log(response)
            //respuesta exitosa
          } else {
            //swal incorrecto
            alert('Formato de imagen incorrecto.');

          }
        }
      });
    }

    return false;
  });


})
