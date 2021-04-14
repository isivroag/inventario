<aside class="main-sidebar sidebar-light-primary elevation-3 ">
  <!-- Brand Logo -->

  <a href="inicio.php" class="brand-link">

    <img src="img/logob.png" alt="INBA Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-bold">INBA</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex ">
      <div class="image">
        <img src="img/user.png" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="#" class="d-block"><?php echo $_SESSION['s_nombre']; ?></a>
        <input type="hidden" id="nameuser" name="nameuser" value="<?php echo $_SESSION['s_nombre']; ?>">
        <input type="hidden" id="fechasys" name="fechasys" value="<?php echo date('Y-m-d') ?>">
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
        <li class="nav-item  has-treeview <?php echo ($pagina == 'producto' ||  $pagina == 'umedida' ||  $pagina == 'cntareq' ||  $pagina == 'tipop') ? "menu-open" : ""; ?>">


          <a href="#" class="nav-link  <?php echo ($pagina == 'producto' || $pagina == 'umedida' ||  $pagina == 'cntareq' ||  $pagina == 'tipop') ? "active" : ""; ?>">
            <i class="nav-icon fas fa-cogs "></i>
            <p>
              Operaciones
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>


          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="cntaumedida.php" class="nav-link <?php echo ($pagina == 'umedida') ? "active seleccionado" : ""; ?>  ">
                <i class="fas fa-ruler-combined nav-icon"></i>
                <p>Unidad de Medida</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="cntatipop.php" class="nav-link <?php echo ($pagina == 'tipop') ? "active seleccionado" : ""; ?>  ">
              <i class="fas fa-layer-group nav-icon"></i>
                <p>Tipo de Materiales</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="cntaproducto.php" class="nav-link <?php echo ($pagina == 'producto') ? "active seleccionado" : ""; ?>  ">
                <i class="fas fa-barcode nav-icon"></i>
                <p>Materiales</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="cntareq.php" class="nav-link <?php echo ($pagina == 'cntareq') ? "active seleccionado" : ""; ?>  ">
                <i class="far fa-clipboard nav-icon"></i>
                <p>Requisiciones</p>
              </a>
            </li>
           


          </ul>

        </li>

        


       
          <li class="nav-item has-treeview <?php echo ($pagina == 'resumencxp') ? "menu-open" : ""; ?>">


            <a href="#" class="nav-link <?php echo ($pagina == 'resumencxp') ? "active" : ""; ?>">
              <span class="fa-stack">
                <i class="fas fa-chart-line nav-icon"></i>

              </span>
              <p>
                Reportes
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">

              <li class="nav-item">
                <a href="inventario.php" class="nav-link <?php echo ($pagina == 'resumencxp') ? "active seleccionado" : ""; ?>  ">
                  <i class="fas fa-file-invoice nav-icon"></i>
                  <p>Inventario</p>
                </a>
              </li>


            </ul>
          </li>
     




        <?php if ($_SESSION['s_rol'] == '2') {
        ?>
          <hr class="sidebar-divider">
          <li class="nav-item">
            <a href="cntausuarios.php" class="nav-link <?php echo ($pagina == 'usuarios') ? "active" : ""; ?> ">
              <i class="fas fa-user-shield"></i>
              <p>Usuarios</p>
            </a>
          </li>
        <?php
        }
        ?>

        <hr class="sidebar-divider">
        <li class="nav-item">
          <a class="nav-link" href="bd/logout.php">
            <i class="fas fa-fw fa-sign-out-alt"></i>
            <p>Salir</p>
          </a>
        </li>

      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>
<!-- Main Sidebar Container -->