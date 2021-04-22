<?php
$pagina = "cntareq";

include_once "templates/header.php";
include_once "templates/barra.php";
include_once "templates/navegacion.php";




include_once 'bd/conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

$consulta = "SELECT * FROM requisicion WHERE estado_req=1 ORDER BY folio_req";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
$data = $resultado->fetchAll(PDO::FETCH_ASSOC);



$message = "";



?>


<style>
    .custom-file-input~.custom-file-label::after {
        content: "Elegir";
    }
</style>
<link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->


    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="card">
            <div class="card-header bg-gradient-green text-light">
                <h1 class="card-title mx-auto">Requisiciones de Material</h1>
            </div>

            <div class="card-body">

                <div class="row">
                    <div class="col-lg-12">
                        <button id="btnNuevo" type="button" class="btn bg-gradient-green btn-ms" data-toggle="modal"><i class="fas fa-plus-square text-light"></i><span class="text-light"> Nuevo</span></button>
                    </div>
                </div>
                <br>
                <div class="container-fluid">

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="table-responsive">
                                <table name="tablaV" id="tablaV" class="table table-sm table-striped table-bordered table-condensed text-nowrap w-auto mx-auto" style="width:100%">
                                    <thead class="text-center bg-gradient-green">
                                        <tr>
                                            <th>Folio</th>
                                            <th>Fecha</th>
                                            <th>Fraccionamiento</th>
                                            <th>Solicitante</th>
                                            <th>Entregadp</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($data as $dat) {
                                        ?>
                                            <tr>
                                                <td><?php echo $dat['folio_req'] ?></td>
                                                <td><?php echo $dat['fecha_req'] ?></td>
                                                <td><?php echo $dat['fraccionamiento'] ?></td>
                                                <td><?php echo $dat['solicitante'] ?></td>
                                                <td><?php echo $dat['entregado'] ?></td>
                                                <td></td>
                                            </tr>
                                        <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!-- /.card-body -->

            <!-- /.card-footer-->
        </div>
        <!-- /.card -->

    </section>

    <section>
        <div class="modal fade" id="modalCRUD" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog " role="document">
                <div class="modal-content">
                    <div class="modal-header bg-gradient-green">
                        <h5 class="modal-title" id="exampleModalLabel">Subir Archivo</h5>

                    </div>
                    <div class="card card-widget" style="margin: 10px;">
                        <form id="formDatos" action="" method="POST">
                            <div class="modal-body row">

                                <div class="col-sm-12">
                                    <input type="text" id="folioreq" name="folioreq">
                                </div>
                                <div class="col-sm-12">



                                    <div class="form-group">
                                        <label for="exampleInputFile">Subir Archivo</label>
                                        <div class="input-group">
                                            <div class="custom-file">

                                                <input type="file" class="custom-file-input" name="archivo" id="archivo">

                                                <label class="custom-file-label" for="archivo">Elegir Archivo</label>
                                            </div>
                                            <div class="input-group-append">
                                                <button class="btn btn-primary" id="upload">Subir</button>
                                            </div>
                                        </div>
                                    </div>


                                </div>

                            </div>
                    </div>


                    <?php
                    if ($message != "") {
                    ?>
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <span class="badge "><?php echo ($message); ?></span>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>

                        </div>

                    <?php
                    }
                    ?>

                    </form>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="modal fade" id="modalIMG" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-gradient-green">
                        <h5 class="modal-title" id="exampleModalLabel">Autorización</h5>

                    </div>
                    <div class="card card-widget" style="margin: 10px;">
                        <div class="modal-body ">

                            <div class="row justify-content-center">
                                <div class="col-sm-12 text-center">

                                    <img class="img-responsive img-fluid pad" id="mapa"  src="" alt="Photo" style="max-width: 600;">


                                </div>
                            </div>
                        </div>

                    </div>




                </div>
            </div>
        </div>
    </section>

</div>


<?php include_once 'templates/footer.php'; ?>
<script src="fjs/cntareq.js"></script>
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<script src="plugins/sweetalert2/sweetalert2.all.min.js"></script>