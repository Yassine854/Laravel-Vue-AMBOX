<template>
    <layout_admin ref="table">
      <div
        class=" shadow p-3"
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
                data-bs-target="#addlivreur"
              >
              <i class="fa-solid fa-plus"></i>
              </button>
            </div>

            <!-----------------------------------------------Create livreur------------------------------------------>

            <div class="modal fade" id="addlivreur" tabindex="-1">
              <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                  <div class="modal-header">
                    <div class="d-flex align-items-center">
                    <i class="fa-solid fa-plus fa-xl me-2"></i>
                    <h5 class="modal-title mb-0" id="editProductLabel">
                        Ajouter un nouvel livreur
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

                    <form @submit.prevent="createLivreur()">
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
                        <label class="small mb-1" for="phone" style="float: left">Téléphone</label>
                        <input
                            :class="['form-control', {'is-invalid': validationErrors.phone}]"
                            id="phone"
                            placeholder="Entrer le numéro de téléphone"
                            v-model="phone"
                        >
                        <span class="invalid-feedback" v-for="(err, index) in validationErrors.phone" :key="index">{{ err }}<br></span>
                        </div>

                        <div class="mb-3">
                            <label
                            class="small mb-1"

                            for="email"
                            style="float: left"
                            >E-mail (Optionnel)</label
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

            <!----------------------------------------------- End Create livreur------------------------------------------>

            <!-----------------------------------------------Edit livreur------------------------------------------>

            <div class="modal fade" id="editlivreur" tabindex="-1">
              <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                  <div class="modal-header">
                    <div class="d-flex align-items-center">
                    <i class="fa-solid fa-pen fa-xl me-2"></i>
                    <h5 class="modal-title mb-0" id="editProductLabel">
                        Modifier le livreur
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

                    <form @submit.prevent="updateLivreur(livreurEdit)">
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
                        <label class="small mb-1" for="phone" style="float: left">Téléphone</label>
                        <input
                            :class="['form-control', {'is-invalid': validationErrorsEdit.phone}]"
                            id="phone"
                            placeholder="Entrer le numéro de téléphone"
                            v-model="phoneEdit"
                        >
                        <span class="invalid-feedback" v-for="(err, index) in validationErrorsEdit.phone" :key="index">{{ err }}<br></span>
                        </div>

                        <div class="mb-3">
                            <label
                            class="small mb-1"

                            for="email"
                            style="float: left"
                            >E-mail (Optionnel)</label
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

            <!----------------------------------------------- End Edit livreur------------------------------------------>

          </div>
        </div>
        <br />

        <div class="card mb-4">
          <div class="card-header d-flex align-items-center">
            <i class="fa-solid fa-users me-2"></i>
            <h5 class="mb-0">Liste des livreurs</h5>

      </div>

      <div class="table-responsive">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th scope="col">ID</th>
              <th scope="col">Nom</th>
              <th scope="col">Téléphone</th>
              <th scope="col">E-mail</th>
              <th scope="col">État</th>
              <th scope="col">Actions</th>
            </tr>
          </thead>
          <template v-if="displayedlivreursSlice.length > 0">
          <tbody v-for="livreur in displayedlivreursSlice" :key="livreur.id">
            <tr >
              <th >{{ livreur.id }}</th>
              <td >{{ livreur.name }}</td>
              <td  scope="row">{{ livreur.phone }}</td>
              <td  scope="row">{{ livreur.email }}</td>
              <td>
                <div v-if="livreur.disabled==false">
                    <i class="fa-solid fa-circle text-success"></i> <p>Actif</p>
                </div>
                <div v-if="livreur.disabled==true">
                    <i class="fa-solid fa-circle text-danger"></i> <p>Désactivé</p>
                </div>
            </td>
              <td >
                <a id="crudBtn" @click="openEditModal(livreur)" class="btn btn-warning m-2"
                      ><i class="fa-solid fa-pen-to-square"></i>
                      <span class="textHover">Modifier</span>
                      </a

                    >

                    <a  id="crudBtn" @click="disableLivreur(livreur)" class="btn btn-danger m-2" v-if="!livreur.disabled"
                      ><i class="fa-solid fa-user-lock"></i>
                      <span class="textHover">Désactiver</span>
                      </a

                    >

                    <a  id="crudBtn" @click="enableLivreur(livreur)" class="btn btn-success m-2" v-if="livreur.disabled"
                      ><i class="fa-solid fa-unlock"></i>
                      <span class="textHover">Activer</span>
                      </a

                    >


              </td>
            </tr>
          </tbody>
        </template>
          <tbody v-else>
            <tr>
            <td colspan="18">Pas de livreurs</td>
        </tr>
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
    </layout_admin>
  </template>

<script setup>
import layout_admin from "../layouts/layoutAdmin.vue";
  import {
    checkLoginAdmin,checkDisabledAccount
  } from "../../auth";
  import { onMounted, ref, computed } from "vue";
  import { useRouter } from "vue-router";
  import Swal from "sweetalert2";
  import axios from "axios";
  window.Swal = Swal;

  </script>


    <script>
  export default {
      name: "livreurs",
    //check auth
    beforeRouteEnter(to, from, next) {
      if (checkLoginAdmin() && !checkDisabledAccount()) {
        next();
      } else {
        next("/");
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
        itemsPerPage : 10,

        //get
        livreurs:[],

        //create
        name: "",
        email: "",
        phone:"",
        password: "",

        //edit
        livreurEdit:[],
        nameEdit: "",
        emailEdit: "",
        phoneEdit:"",

      };
    },
    mounted(){
        this.get_all_livreurs();

    },

    computed: {
        displayedlivreurs() {
        const searchLower = typeof this.search === 'string' ? this.search.toLowerCase() : '';

        return this.livreurs.filter(livreur => {
            const name = (livreur.name || '').toLowerCase();

            // Perform case-insensitive search
            return name.includes(searchLower);
        });
    },


    displayedPages() {
        const pageCount = Math.ceil(this.displayedlivreurs.length / this.itemsPerPage);
        const range = [];

        for (let i = 1; i <= pageCount; i++) {
            range.push(i);
        }

        return range;
        },

        displayedlivreursSlice() {
        const startIndex = (this.currentPage - 1) * this.itemsPerPage;
        const endIndex = startIndex + this.itemsPerPage;
        return this.displayedlivreurs.slice(startIndex, endIndex);
        },


  },
    methods: {

        changePage(newPage) {
      if (newPage >= 1 && newPage <= this.displayedPages.length) {
        this.currentPage = newPage;
      }
    },


     async get_all_livreurs(){
        try {
        const response=  await axios.get(`/api/livreurs/get_all_livreurs`);
          this.livreurs=response.data.livreurs;
          console.log(this.livreurs);

        } catch (error) {
            console.log(error);
        }
      },


      async createLivreur() {
        this.validationErrors = {};
        try {
          await axios.post(`/api/livreur/create`, {
            name: this.name,
            email: this.email,
            phone:this.phone,
            password: this.password,
          });
          this.name = "";
          this.email = "";
          this.phone="";
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
            title: "livreur ajouté avec succées !",
          });

          $("#addlivreur .btn-close").click();
          this.get_all_livreurs();
        } catch (error) {
            if (error.response.status === 400) {
          this.validationErrors = error.response.data.errors;
          console.log(this.validationErrors);
        } else {
          this.errorMessage = "Une erreur s'est produite lors de la création d'livreur";
        }
        }
      },


    openEditModal(livreur) {
    $("#editlivreur").modal("show");
    this.validationErrorsEdit={}
    this.livreurEdit=livreur;
    this.nameEdit = livreur.name;
    this.emailEdit=livreur.email;
    this.phoneEdit=livreur.phone;
    },

  async updateLivreur(livreur) {
  try {
    const response = await axios.put(`/api/livreur/update/${livreur.id}`, {
        name: this.nameEdit,
        email: this.emailEdit,
        phone:this.phoneEdit,
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
        title: "livreur modifié avec succés !",
      });

      $("#editlivreur .btn-close").click();
      this.get_all_livreurs();
      this.livreurEdit=[];
      this.nameEdit = "";
      this.emailEdit = "";
      this.phoneEdit="";
    } else {
      this.errorMessage = "Une erreur s'est produite lors de la mise Ã  jour de l'livreur.";
    }
  } catch (error) {
    if (error.response && error.response.status === 400) {
      this.validationErrorsEdit = error.response.data.errors;
      console.log(this.validationErrorsEdit);
    } else {
      this.errorMessage = "Une erreur s'est produite lors de la mise Ã  jour de l'livreur.";
    }
  }
},


disableLivreur(livreur) {
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
        .post("/api/livreur/disable/" + livreur.id)
        .then((response) => {
          this.get_all_livreurs();
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

enableLivreur(livreur) {
  Swal.fire({
    title: "Êtes-vous sûr(e) ?",
    text: "Vous ne pourrez pas revenir en arrière !",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Oui, Activer le compte !",
    cancelButtonText: "Annuler",
  }).then((result) => {
    if (result.isConfirmed) {
      axios
        .post("/api/livreur/enable/" + livreur.id)
        .then((response) => {
          this.get_all_livreurs();
          console.log(response);
          Swal.fire("Activé!", "Le compte a été activé avec succès!", "success");
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

  </style>
