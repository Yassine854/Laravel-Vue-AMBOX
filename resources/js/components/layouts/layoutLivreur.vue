<template>
  <body id="page-top">

<!-- Page Wrapper -->
<div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

        <!-- Sidebar - Brand -->
        <div class="sidebar-brand d-flex align-items-center justify-content-center my-4">
            <img :src="'../../../../storage/image/logo.png'" style="max-width:90px">

        </div>

        <!-- Divider -->
        <hr class="sidebar-divider my-0">

        <!-- Nav Item - Dashboard -->
        <li
          class="nav-item"
          :class="{ active: $route.name === 'dashboard-livreur' || !$route.name }"
        >
          <a
            :href="$router.resolve({ name: 'dashboard-livreur' }).href"
            class="nav-link"
          >
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
          </a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider">


        <!-- Heading -->
        <div class="sidebar-heading">
                Colis
        </div>
        <!-- Nav Item - Admins -->
        <li class="nav-item" :class="{ active: $route.name === 'agence' }">
          <a :href="$router.resolve({ name: 'agence' }).href" class="nav-link">
            <i class="fa-solid fa-cube"></i>
            <span>Gestion des colis</span></a
          >
        </li>

        <!-- Nav Item - Admins -->
        <li class="nav-item" :class="{ active: $route.name === 'pickup_livreur' }">
          <a :href="$router.resolve({ name: 'pickup_livreur' }).href" class="nav-link">
            <i class="fa-solid fa-boxes-packing"></i>
                        <span>Gestion des pickups</span></a
          >
        </li>

        <!-- Nav Item - Admins -->
        <li class="nav-item" :class="{ active: $route.name === 'Encours' }">
          <a :href="$router.resolve({ name: 'Encours' }).href" class="nav-link">
            <i class="fa-solid fa-truck-fast"></i>
                        <span>Livraisons en cours</span></a
          >
        </li>

        <li class="nav-item" :class="{ active: $route.name === 'livraison_liv' }">
          <a :href="$router.resolve({ name: 'livraison_liv' }).href" class="nav-link">
            <i class="fa-solid fa-cubes-stacked"></i>
            <span>Historique de Livraisons</span></a
          >
        </li>
        <!-- Divider -->
        <hr class="sidebar-divider">








       </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">

            <!-- Topbar -->
            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                <!-- Sidebar Toggle (Topbar) -->
                <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                    <i class="fa fa-bars"></i>
                </button>


                <!-- Topbar Navbar -->
                <ul class="navbar-nav ml-auto">



                    <!-- <div class="topbar-divider d-none d-sm-block"></div> -->

                    <!-- Nav Item - User Information -->
                    <li class="nav-item dropdown no-arrow">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ name }}</span>
                            <img class="img-profile rounded-circle" :src="'../../../../storage/image/user.png'" alt="Desktop Image" style="max-width: 200px;"  />

                        </a>
                        <!-- Dropdown - User Information -->
                        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                            aria-labelledby="userDropdown">
                            <a class="dropdown-item" :href="$router.resolve({ name: 'profile_livreur' }).href">
                                <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                Profile
                            </a>

                            <div class="dropdown-divider"></div>
                            <a
                    style="cursor: pointer"
                    class="dropdown-item"
                    @click="logout"
                  >
                    <i
                      class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"
                    ></i>
                    Déconnexion
                  </a>

                        </div>
                    </li>

                </ul>

            </nav>
            <!-- End of Topbar -->

            <!-- Begin Page Content -->
            <div class="container-fluid">


               <slot></slot>

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->

        <!-- Footer -->
        <footer class="sticky-footer bg-white">
            <div class="container my-auto">
                <div class="copyright text-center my-auto">
                    <span
                >© Copyright 2024 - FlashBox Made with
                Envision Agency</span
              >
                </div>
            </div>
        </footer>
        <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-primary" href="login.html">Logout</a>
            </div>
        </div>
    </div>
</div>

</body>
</template>

<script>
export default {
  name: "layout",
  data() {
    return {
      name: null,
    };
  },

    created() {
    if (window.Laravel.user) {
      this.name = window.Laravel.user.name;
    }
  },

    methods: {
    logout(e) {
      e.preventDefault();
      this.$axios.get("/sanctum/csrf-cookie").then((response) => {
        this.$axios
          .post("/api/logout")
          .then((response) => {
            if (response.data.success) {
              window.location.href = "/";
            } else {
              console.log(response);
            }
          })
          .catch(function (error) {
            console.error(error);
          });
      });
    },
},

}
</script>

<style>

</style>
