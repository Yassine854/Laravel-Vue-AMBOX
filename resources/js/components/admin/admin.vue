<template>
    <layout ref="table">
      <div
        class="container shadow p-3"
        style="background-color: white; position: relative"
      >
        <div class="row">
          <div class="col-md-4">
            <div class="input-group rounded">
              <input
                type="search"
                class="form-control rounded"
                placeholder="Rechercher"
                aria-label="Search"
                aria-describedby="search-addon"
                v-model="search"
              />
            </div>
            <br>
          </div>
          <div class="col-md-8 text-end">
            <div class="text-end">
              <button
                type="button"
                class="btn btn-primary"
                data-bs-toggle="modal"
                data-bs-target="#addAdmin"
              >
              <i class="fa-solid fa-plus"></i>
              </button>
            </div>

            <!-----------------------------------------------Create admin------------------------------------------>

            <div class="modal fade" id="addAdmin" tabindex="-1">
              <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                  <div class="modal-header">
                    <div class="d-flex align-items-center">
                    <i class="fa-solid fa-plus fa-xl me-2"></i>
                    <h5 class="modal-title mb-0" id="editProductLabel">
                        Ajouter un nouvel admin
                    </h5>
                    </div>

                    <button
                      type="button"
                      class="btn-close"
                      data-bs-dismiss="modal"
                      aria-label="Close"
                    ></button>
                  </div>
                  <div class="modal-body">

                    <form @submit.prevent="createAdmin()">
                        <div class="mb-3">
                            <label
                            class="small mb-1"

                            for="name"
                            style="float: left"
                            >Nom</label
                            >
                            <input
                            :class="['form-control', {'is-invalid': validationErrors.name}]"

                            id="name"
                            rows="4"
                            placeholder="Entrer le nom"
                            v-model="name"

                            >
                            <span class="invalid-feedback" v-for="(err, index) in validationErrors.name" :key="index">{{ err }}<br></span>

                        </div>

                        <div class="mb-3">
                            <label
                            class="small mb-1"

                            for="email"
                            style="float: left"
                            >E-mail</label
                            >
                            <input
                            :class="['form-control', {'is-invalid': validationErrors.email}]"
                            id="email"
                            rows="4"
                            placeholder="Entrer l'e-mail"
                            v-model="email"

                            >
                            <span class="invalid-feedback" v-for="(err, index) in validationErrors.email" :key="index">{{ err }}<br></span>

                        </div>

                        <div class="mb-3">
                            <label
                            class="small mb-1"

                            for="password"
                            style="float: left"
                            >Mot de passe</label
                            >
                            <input
                            :class="['form-control', {'is-invalid': validationErrors.password}]"
                            type="password"
                            id="password"
                            rows="4"
                            placeholder="Entrer le mot de passe"
                            v-model="password"

                            >
                            <span class="invalid-feedback" v-for="(err, index) in validationErrors.password" :key="index">{{ err }}<br></span>

                        </div>
                        <div class="modal-footer">
                        <button
                          type="button"
                          class="btn btn-secondary"
                          data-bs-dismiss="modal"
                        >
                          Annuler
                        </button>
                        <button
                          type="submit"
                          class="btn btn-primary"
                        >
                          Ajouter
                        </button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>

            <!----------------------------------------------- End Create admin------------------------------------------>

            <!-----------------------------------------------Edit admin------------------------------------------>

            <div class="modal fade" id="editAdmin" tabindex="-1">
              <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                  <div class="modal-header">
                    <div class="d-flex align-items-center">
                    <i class="fa-solid fa-pen fa-xl me-2"></i>
                    <h5 class="modal-title mb-0" id="editProductLabel">
                        Modifier l'admin
                    </h5>
                    </div>

                    <button
                      type="button"
                      class="btn-close"
                      data-bs-dismiss="modal"
                      aria-label="Close"
                    ></button>
                  </div>
                  <div class="modal-body">

                    <form @submit.prevent="updateAdmin(adminEdit)">
                        <div class="mb-3">
                            <label
                            class="small mb-1"

                            for="name"
                            style="float: left"
                            >Nom</label
                            >
                            <input
                            :class="['form-control', {'is-invalid': validationErrorsEdit.name}]"

                            id="name"
                            rows="4"
                            placeholder="Entrer le nom"
                            v-model="nameEdit"

                            >
                            <span class="invalid-feedback" v-for="(err, index) in validationErrorsEdit.name" :key="index">{{ err }}<br></span>

                        </div>

                        <div class="mb-3">
                            <label
                            class="small mb-1"

                            for="email"
                            style="float: left"
                            >E-mail</label
                            >
                            <input
                            :class="['form-control', {'is-invalid': validationErrorsEdit.email}]"
                            id="email"
                            rows="4"
                            placeholder="Entrer l'e-mail"
                            v-model="emailEdit"

                            >
                            <span class="invalid-feedback" v-for="(err, index) in validationErrorsEdit.email" :key="index">{{ err }}<br></span>

                        </div>
                        <div class="modal-footer">
                        <button
                          type="button"
                          class="btn btn-secondary"
                          data-bs-dismiss="modal"
                        >
                          Annuler
                        </button>
                        <button
                          type="submit"
                          class="btn btn-primary"
                        >
                          Modifier
                        </button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>

            <!----------------------------------------------- End Edit admin------------------------------------------>

          </div>
        </div>
        <br />

        <div class="card mb-4">
          <div class="card-header d-flex align-items-center">
            <i class="fa-solid fa-ticket me-2"></i>
          <h5 class="mb-0">Liste des admins</h5>
      </div>

      <div class="table-responsive">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th scope="col">ID</th>
              <th scope="col">Nom</th>
              <th scope="col">E-mail</th>
              <th scope="col">Actions</th>
            </tr>
          </thead>
          <template v-if="displayedAdminsSlice.length > 0">
          <tbody v-for="admin in displayedAdminsSlice" :key="admin.id">
            <tr :class="{ 'table-danger': admin.disabled }" >
              <th >{{ admin.id }}</th>
              <td >{{ admin.name }}</td>
              <th  scope="row">{{ admin.email }}</th>
              <td >
                <a
                  id="crudBtn"
                  @click="openEditModal(admin)"
                  class="me-4 text-warning"
                >
                  <i class="fa-solid fa-pen-to-square"></i>
                </a>
                <a id="crudBtn" @click="disableAdmin(admin)" class="text-danger" v-if="!admin.disabled">
                    <i class="fa-solid fa-user-lock"></i>
                </a>
              </td>
            </tr>
          </tbody>
        </template>
          <tbody v-else>
            <p>Pas d'admins'</p>
          </tbody>
        </table>
        </div>
        </div>

        <nav aria-label="User pagination" v-if="displayedPages.length > 1" class="pb-1">
    <ul class="pagination justify-content-end">
      <!-- Previous Page Button -->
      <li id="crudBtn" class="page-item" v-if="currentPage !== 1">
        <a class="page-link shadow" @click="changePage(currentPage - 1)">Précédent</a>
      </li>

      <!-- Page Numbers -->
      <li
        class="page-item"
        :class="{ active: page === currentPage }"
        v-for="(page, index) in displayedPages"
        :key="index"
        style="cursor: pointer"
      >
        <a v-if="page === '...'" class="page-link shadow">...</a>
        <a v-else class="page-link shadow" @click="changePage(page)">{{ page }}</a>
      </li>

      <!-- Next Page Button -->
      <li id="crudBtn" class="page-item" v-if="currentPage !== displayedPages.length">
        <a class="page-link shadow" @click="changePage(currentPage + 1)">Suivant</a>
      </li>
    </ul>
  </nav>


      </div>
    </layout>
  </template>

<script setup>
import layout from "../layouts/layout";
  import {
    checkLoginAdmin,
  } from "../../auth";
  import { onMounted, ref, computed } from "vue";
  import { useRouter } from "vue-router";
  import Swal from "sweetalert2";
  import axios from "axios";
  window.Swal = Swal;

  </script>


    <script>
  export default {
      name: "admin",
    //check auth
    beforeRouteEnter(to, from, next) {
      if (checkLoginAdmin()) {
        next();
      } else {
        next("/login");
      }
    },
    data() {
      return {
        //Validation
        validationErrors : {},
        validationErrorsEdit:{},
        //Page numeration
        Index:0,
        search:[],
        currentPage : 1,
        itemsPerPage : 1,

        //get
        admins:[],

        //create
        name: "",
        email: "",
        password: "",

        //edit
        adminEdit:[],
        nameEdit: "",
        emailEdit: "",

      };
    },
    mounted(){
        this.get_all_admins();

    },

    computed: {
        displayedAdmins() {
        const searchLower = typeof this.search === 'string' ? this.search.toLowerCase() : '';

        return this.admins.filter(admin => {
            const name = (admin.name || '').toLowerCase();

            // Perform case-insensitive search
            return name.includes(searchLower);
        });
    },


    displayedPages() {
        const pageCount = Math.ceil(this.displayedAdmins.length / this.itemsPerPage);
        const range = [];

        for (let i = 1; i <= pageCount; i++) {
            range.push(i);
        }

        return range;
        },

        displayedAdminsSlice() {
        const startIndex = (this.currentPage - 1) * this.itemsPerPage;
        const endIndex = startIndex + this.itemsPerPage;
        return this.displayedAdmins.slice(startIndex, endIndex);
        },


  },
    methods: {

        changePage(newPage) {
      if (newPage >= 1 && newPage <= this.displayedPages.length) {
        this.currentPage = newPage;
      }
    },


     async get_all_admins(){
        try {
        const response=  await axios.get(`/api/admins/get_all_admins`);
          this.admins=response.data.admins;
          console.log(this.admins);

        } catch (error) {
            console.log(error);
        }
      },


      async createAdmin() {
        this.validationErrors = {};
        try {
          await axios.post(`/api/admin/create`, {
            name: this.name,
            email: this.email,
            password: this.password,
          });
          this.name = "";
          this.email = "";
          this.password = "";

          const toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            customClass: {
              popup: "colored-toast",
            },
            timer: 3000,
          });
          toast.fire({
            icon: "success",
            title: "Admin ajouté avec succées !",
          });

          $("#addAdmin .btn-close").click();
          this.get_all_admins();
        } catch (error) {
            if (error.response.status === 400) {
          this.validationErrors = error.response.data.errors;
          console.log(this.validationErrors);
        } else {
          this.errorMessage = "Une erreur s'est produite lors de la création d'admin";
        }
        }
      },


    openEditModal(admin) {
    $("#editAdmin").modal("show");
    this.validationErrorsEdit={}
    this.adminEdit=admin;
    this.nameEdit = admin.name;
    this.emailEdit=admin.email;
    },

  async updateAdmin(admin) {
  try {
    const response = await axios.put(`/api/admin/update/${admin.id}`, {
      name: this.nameEdit,
      email: this.emailEdit,
    });

    if (response.status === 200) {

    const toast = Swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        customClass: {
            popup: "colored-toast",
        },
        timer: 3000,
        });
      toast.fire({
        icon: "success",
        title: "Admin modifié avec succés !",
      });

      $("#editAdmin .btn-close").click();
      this.get_all_admins();
      this.adminEdit=[];
      this.nameEdit = "";
      this.emailEdit = "";
    } else {
      this.errorMessage = "Une erreur s'est produite lors de la mise Ã  jour de l'admin.";
    }
  } catch (error) {
    if (error.response && error.response.status === 400) {
      this.validationErrorsEdit = error.response.data.errors;
      console.log(this.validationErrorsEdit);
    } else {
      this.errorMessage = "Une erreur s'est produite lors de la mise Ã  jour de l'admin.";
    }
  }
},


disableAdmin(admin) {
  Swal.fire({
    title: "Êtes-vous sûr(e) ?",
    text: "Vous ne pourrez pas revenir en arrière !",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Oui, Désactiver le compte !",
    cancelButtonText: "Annuler",
  }).then((result) => {
    if (result.isConfirmed) {
      axios
        .post("/api/admin/disable/" + admin.id)
        .then((response) => {
          this.get_all_admins();
          console.log(response);
          Swal.fire("Désactivé!", "Le compte a été désactivé avec succès!", "success");
        })
        .catch((errors) => {
          console.log(errors);
          Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "Il y a eu un problème!",
          });
        });
    }
  });
},


    },
  };
  </script>

    <style>
  /* Add your custom styles here if needed */
  #crudBtn {
    cursor: pointer;
  }
  </style>
