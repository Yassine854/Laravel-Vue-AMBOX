<template>
    <layout_livreur ref="table">
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

          </div>
        </div>

 <!------------------------------- Type Retour ---------------------------------->

 <div class="modal fade" id="typeRetour" tabindex="-1">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <div class="d-flex align-items-center">
                    <i class="fa-solid fa-pen fa-xl me-2"></i>
                    <h5 class="modal-title mb-0" id="changeSelectedStateLabel">
                      Type de retour
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
                  <form @submit.prevent="Retour()">
                    <div class="form-group">
                      <label for="state">Type de Retour:</label>
                      <select
                        :class="['form-select', {'is-invalid': validationErrors.etat}]"
                          v-model="retour"
                        >
                        <option value="" disabled selected hidden>Sélectionner le type de retour</option>
                        <option value="Retour Dépôt">Retour Dépôt</option>
                        <option value="Retour Définitif">Retour Définitif</option>
                        </select>

                      <span
                        class="invalid-feedback"
                        v-for="(err, index) in validationErrors.livreur_id"
                        :key="index"
                        >{{ err }}<br
                      /></span>
                    </div>
                    <br />

                    <div class="modal-footer">
                      <button
                        type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal"
                      >
                        Annuler
                      </button>
                      <button type="submit" class="btn btn-primary">
                        Confirmer
                      </button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>



        <!-------------------------------------- End Type Retour ------------------------------->

             <!----------------------------------------------- historique------------------------------------------>

            <div class="modal fade" id="historique" tabindex="-1">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                  <div class="d-flex align-items-center">
                    <i class="fa-solid fa-clock-rotate-left fa-xl me-2"></i>
                    <h5 class="modal-title mb-0" id="historiqueLabel">
                      Historique du colis
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

          <table class="table table-bordered">
            <thead class="table-info">
              <tr>
                <th scope="col">État</th>
                <th scope="col">Informations colis</th>
                <th scope="col" style="white-space: nowrap;" >Action par</th>

              </tr>
            </thead>
            <template v-if="historiques.length > 0">
              <tbody>
                <tr
                  v-for="historique in historiques"
                  :key="historique.id"
                >

                  <td>{{ historique.etat }}</td>
                  <td>{{ historique.information }}</td>
                  <td>{{ historique.role }}</td>

                </tr>
              </tbody>
            </template>
            <tbody v-else>
              <tr>
                <td colspan="18">Pas d'historique pour cet colis</td>
              </tr>
            </tbody>
          </table>

                </div>
              </div>
            </div>
          </div>

          <!----------------------------------------------- End historique------------------------------------------>



          <div class="card mb-4">
        <div class="card-header d-flex align-items-center">
            <i class="fa-solid fa-truck-fast me-2"></i>
          <h5 class="mb-0">Livraisons En cours</h5>
        </div>

        <div class="table-responsive">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th scope="col"></th>
                <th scope="col">CODE</th>
                <th scope="col">Date</th>
                <th scope="col">Désignation</th>
                <th scope="col">Client</th>
                <th scope="col">Prix</th>
                <th scope="col">État</th>
                <th scope="col">Actions</th>
              </tr>
            </thead>
            <template v-if="displayedColisSlice.length > 0">
              <tbody>
                <tr
                  v-for="coli in displayedColisSlice"
                  :key="coli.id"
                >
                  <td>
                    <div class="form-check">
                        <input
                      class="form-check-input"
                      type="checkbox"
                      v-model="selectedColis"
                      :value="coli.id"
                      @click="toggleRowSelection(coli)"
                      style="cursor: pointer;"
                    />
                    </div>
                  </td>
                  <th>#{{ coli.id }}</th>
                  <td>{{ currentDateTime(coli.created_at) }}</td>
                  <!-- <td> {{ moment(coli.created_at).format("DD/MM/YYYY HH:mm:ss") }}</td> -->
                  <td>{{ coli.designation }}</td>
                  <td>{{ coli.nom }}</td>
                  <td>{{ coli.prix }} Dt</td>
                  <td>
                    <i v-if="coli.etat==='En attente'" class="fa-solid fa-circle text-danger"></i>
                    <i v-else-if="coli.etat==='Pickup enlever chez livreur'" class="fa-solid fa-circle" style="color: #ff4500;"></i>
                    <i v-else-if="coli.etat==='Pickup dépôt entrant'" class="fa-solid fa-circle" style="color: #ffa500;"></i>
                    <i v-else-if="coli.etat==='En cours de livraison'" class="fa-solid fa-circle" style="color: #9acd32;"></i>
                    <i v-else-if="coli.etat==='Livré'" class="fa-solid fa-circle" style="color: #008000;"></i>
                    <i v-else-if="coli.etat==='Retour Définitif'" class="fa-solid fa-circle text-dark"></i>
                    <i v-else-if="coli.etat==='Retour Dépôt'" class="fa-solid fa-circle text-danger"></i>
                    <p>{{ coli.etat }}</p>
                </td>
                  <td>

                    <a id="crudBtn" @click="openHistoriqueModal(coli)" class="btn btn-info m-2"
                      ><i class="fa-solid fa-clock-rotate-left"></i>
                      <span class="textHover">Historique</span>
                      </a
                    >

                  </td>
                </tr>
              </tbody>
            </template>
            <tbody v-else>
              <tr>
                <td colspan="18">Pas de colis</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <button @click="Paiement()" class="btn btn-success m-2" :disabled="isChangerEtatButtonDisabled">Paiement</button>
      <button @click="openRetourModal()" class="btn btn-danger m-2" :disabled="isChangerEtatButtonDisabled">Retour</button>

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
    </layout_livreur>
  </template>

<script setup>
import layout_livreur from "../layouts/layoutLivreur";
import tunisia from "../../../../storage/app/public/json/zip-postcodes.json";
  import {
    checkLoginLivreur,checkDisabledAccount
  } from "../../auth";
  import { onMounted, ref, computed } from "vue";
  import { useRouter } from "vue-router";
  import Swal from "sweetalert2";
  import axios from "axios";
  import { jsPDF } from "jspdf";
  import 'jspdf-autotable';
  import moment from "moment";
  window.Swal = Swal;

  const toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            customClass: {
              popup: "colored-toast",
            },
            timer: 3000,
          });
  </script>


    <script>
  export default {
      name: "Encours",
    //check auth
    beforeRouteEnter(to, from, next) {
      if (checkLoginLivreur() && !checkDisabledAccount()) {
        next();
      } else {
        next("/");
      }
    },
    data() {
        return {
      //Validation
      validationErrors: {},
      validationErrorsEdit: {},
      //Page numeration
      Index: 0,
      search: [],
      currentPage: 1,
      itemsPerPage: 10,

      //get
      colis: [],
      user:"",
      retour:"",


      //Changer Etat
      selectedColis: [],
      state:"",

      //historique
      historiques:[],

      //imprimer
      colisInfo:[],
    };
    },
    mounted() {
    this.user=window.Laravel.user;
    this.get_all_Encours_colis(this.user);
    console.log(window.Laravel.user);
  },

  computed: {
    displayedColis() {
      const searchLower =
        typeof this.search === "string" ? this.search.toLowerCase() : "";

      return this.colis.filter((coli) => {
        const nom = (coli.nom || "").toLowerCase();
        const id = (coli.id || "").toString().toLowerCase();
        const state = (coli.etat || "").toString().toLowerCase();
        const date = (this.currentDateTime(coli.created_at) || "").toString();

        // Perform case-insensitive search
        return nom.includes(searchLower) || id.includes(searchLower)|| state.includes(searchLower)|| date.includes(searchLower);
      });
    },

    displayedPages() {
      const pageCount = Math.ceil(
        this.displayedColis.length / this.itemsPerPage
      );
      const range = [];

      for (let i = 1; i <= pageCount; i++) {
        range.push(i);
      }

      return range;
    },

    displayedColisSlice() {
      const startIndex = (this.currentPage - 1) * this.itemsPerPage;
      const endIndex = startIndex + this.itemsPerPage;
      return this.displayedColis.slice(startIndex, endIndex);
    },

    isChangerEtatButtonDisabled() {
    return this.selectedColis.length === 0;
  },
  },
  methods: {
    changePage(newPage) {
      if (newPage >= 1 && newPage <= this.displayedPages.length) {
        this.currentPage = newPage;
      }
    },

    async get_all_Encours_colis(user) {
      try {
        const response = await axios.get(`/api/colis/get_all_Encours_colis/${user.id}`);
        this.colis = response.data.colis;
        console.log(this.colis);
      } catch (error) {
        console.log(error);
      }
    },



    toggleRowSelection(coli) {
      // Toggle row selection when a row is clicked
      const index = this.selectedColis.indexOf(coli.id);
      if (index === -1) {
        this.selectedColis.push(coli.id);
      } else {
        this.selectedColis.splice(index, 1);
      }
    },
    isRowSelected(coli) {
      return this.selectedColis.includes(coli.id);
    },


  async Paiement() {
      try {
      const response = await axios.put('/api/colis/LivrerRetour', {
        coliIds: this.selectedColis,
        etat: "Livré",
      });

      if (response.status === 200) {
        this.toast.fire({
          icon: "success",
          title: "Colis Livré avec succés !",
        });
        this.selectedColis=[];
        this.get_all_Encours_colis(this.user);
        this.validationErrors={};
      } else {
        this.errorMessage = "Une erreur s'est produite lors de la mise à jour du colis.";
        // Handle the error as needed
      }
  } catch (error) {
    console.log(error);
    this.toast.fire({
            icon: "error",
            title: "Oops...",
            text: "Il y a eu un probléme!",
          });
  }
    },

    async Retour() {
      try {
      const response = await axios.put('/api/colis/LivrerRetour', {
        coliIds: this.selectedColis,
        etat: this.retour,
      });

      if (response.status === 200) {
        this.toast.fire({
          icon: "warning",
          title: "Colis mis en retour !",
        });
        $("#typeRetour .btn-close").click();
        this.selectedColis=[];
        this.get_all_Encours_colis(this.user);
        this.validationErrors={};
      } else {
        this.errorMessage = "Une erreur s'est produite lors de la mise à jour du colis.";
        // Handle the error as needed
      }
  } catch (error) {
    this.toast.fire({
            icon: "error",
            title: "Oops...",
            text: "Il y a eu un probléme!",
          });
  }
    },


   async openHistoriqueModal(coli) {
      $("#historique").modal("show");
      try {
        const response = await axios.get(`/api/historiques/${coli.id}`);
        this.historiques = response.data.historiques;
        // console.log(this.historiques);
      } catch (error) {
        console.log(error);
      }

    },

    openRetourModal() {
      $("#typeRetour").modal("show");
    },
    currentDateTime(date) {
        var date = new Date(date);
        var year = date.getFullYear();
        var month = String(date.getMonth() + 1).padStart(2, '0');
        var day = String(date.getDate()).padStart(2, '0');
        var hours = String(date.getHours()).padStart(2, '0');
        var minutes = String(date.getMinutes()).padStart(2, '0');
        var seconds = String(date.getSeconds()).padStart(2, '0');

        return day+'/'+month+'/' +year +  ' ' + hours + ':' + minutes + ':' + seconds;
    },


}
  };
  </script>

    <style>
  /* Add your custom styles here if needed */
  #crudBtn {
    cursor: pointer;
  }
  </style>
