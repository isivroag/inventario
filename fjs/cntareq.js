$(document).ready(function () {
  var id, opcion, proyecto
  opcion = 4
  const MAXIMO_TAMANIO_BYTES = 12000000;

  tablaVis = $('#tablaV').DataTable({
    columnDefs: [
      {
        targets: -1,
        data: null,
        defaultContent:
        
       
          "<div class='text-center'>\
          <button class='btn btn-sm btn-primary  btnEditar' data-toggle='tooltip' data-placement='top' title='Ver'><i class='fas fa-search'></i></button>\
          <button class='btn btn-sm bg-gradient-orange  btnVer' data-toggle='tooltip' data-placement='top' title='Ver Autorización'><i class='fab fa-searchengin'></i></button>\
          <button class='btn btn-sm btn-success  btnUpload' data-toggle='tooltip' data-placement='top' title='Subir Comprobante'><i class='fas fa-cloud-upload-alt'></i></button>\
          <button class='btn btn-sm btn-danger btnBorrar' data-toggle='tooltip' data-placement='top' title='Borrar'><i class='fas fa-trash-alt'></i></button></div>",
      },
      { className: "hide_column", targets: [4] }
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


    rowCallback: function (row, data) {
      $($(row).find('td')['5']).addClass('text-center')
      

      if (data[5] == 'ENTREGADO') {
          //$($(row).find("td")[6]).css("background-color", "warning");
          $($(row).find('td')[5]).addClass('bg-gradient-green')
          //$($(row).find('td')['2']).text('PENDIENTE')
        } else  {
          //$($(row).find("td")[2]).css("background-color", "success");
          $($(row).find('td')[5]).addClass('bg-gradient-warning')
          //$($(row).find('td')['6']).text('ACEPTADO')
        }


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
    entregado= parseInt($(this).closest('tr').find('td:eq(4)').text())


     //borrar

    //agregar codigo de sweatalert2

    if (entregado==1){
      swal.fire({
        title: "La Requisición ya ha sido Entregada",
        html: "Los Materiales serán <b>regresados al almacen</b><br><h4 style='color:blue'>¿Realmente desea borrar esta Requisición?</h4>",

        showCancelButton: true,
        icon: "question",
        focusConfirm: true,
        confirmButtonText: "Aceptar",

        cancelButtonText: "Cancelar",
    })
    .then(function (isConfirm) {
        if (isConfirm.value) {
          opcion = 3
            $.ajax({
              url: 'bd/eliminarreq.php',
              type: 'POST',
              dataType: 'json',
              data: { id: id, opcion: opcion },
      
              success: function (data) {
                if (data==1){
                  tablaVis.row(fila.parents('tr')).remove().draw()
                }
              },
            })
          
        } else if (isConfirm.dismiss === swal.DismissReason.cancel) { }
    });
    }
    else{
      swal.fire({
        title: "Eliminiar Requsición",
        text: "¿Realmente desea borrar este elemento?",

        showCancelButton: true,
        icon: "warning",
        focusConfirm: true,
        confirmButtonText: "Aceptar",

        cancelButtonText: "Cancelar",
    })
    .then(function (isConfirm) {
        if (isConfirm.value) {
          opcion = 4
            $.ajax({
              url: 'bd/eliminarreq.php',
              type: 'POST',
              dataType: 'json',
              data: { id: id, opcion: opcion },
      
              success: function (data) {
                if (data==1){
                  tablaVis.row(fila.parents('tr')).remove().draw()
                }
                
              },
            })
          
        } else if (isConfirm.dismiss === swal.DismissReason.cancel) { }
    });



    }


 


    
  })


  $(document).on('click', '.btnVer', function () {
    fila = $(this).closest('tr')
    id = parseInt(fila.find('td:eq(0)').text())

    $.ajax({
      type: "POST",
      url: "bd/buscarimg.php",
      dataType: "json",
      data: { id: id },

      success: function(res) {
         if (res!=""){
          archivo=res;
          document.getElementById("mapa").src = archivo;
          $("#modalIMG").modal("show");
         }else{
          Swal.fire({
            title: 'No existe elemento',
            text: "La requisición no tiene documento asignado",
            icon: 'warning',
        })
         }
         
      },
  });


    
 
    
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
     

      Swal.fire({
        title: 'El tamaño del archivo es muy grande',
        text: "El archivo no puede exceder los "+ tamanioEnMb+"MB",
        icon: 'warning',
    })
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
            Swal.fire({
              title: 'Imagen Guardada',
              text: "Se anexo el documento a la Requisición",
              icon: 'success',
          })
          $("#modalCRUD").modal("hide");
            //respuesta exitosa
          } else {
            //swal incorrecto
            Swal.fire({
              title: 'Formato de Imagen Incorrecto',
              text: "El archivo no es una imagen ",
              icon: 'warning',
          })

          }
        }
      });
    }

    return false;
  });


})
