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
        </div>

          <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
    <div class="d-flex align-items-center">
        <i class="fa-solid fa-cubes-stacked me-2"></i>
        <h5 class="mb-0">Historique de Livraisons</h5>
    </div>

</div>


        <div class="table-responsive">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th scope="col">Voyage ID</th>
                <th scope="col">Date de fin du voyage</th>
                <th scope="col">Nb Totale de colis</th>
                <th scope="col">Nb de colis livrés</th>
                <th scope="col">Nb de colis en retour</th>
                <th scope="col">Montant Totale de colis</th>
                <th scope="col">Montant de colis Livrés</th>


              </tr>
            </thead>
            <template v-if="displayedLivraisonsSlice.length > 0">
              <tbody>
                <tr
                  v-for="livraison in displayedLivraisonsSlice"
                  :key="livraison.id"
                >

                  <th>#{{ livraison.id }}</th>
                  <td>{{ currentDateTime(livraison.created_at) }}</td>
                  <td>{{ livraison.nb_total }}</td>
                  <td>{{ livraison.nb_livre }}</td>
                  <td>{{ livraison.nb_retour }}</td>
                  <td>{{ livraison.montant_totale }} Dt</td>
                  <td>{{ livraison.montant_livre }} Dt</td>




                </tr>
              </tbody>
            </template>
            <tbody v-else>
              <tr>
                <td colspan="18">Pas de livraisons</td>
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
  import VueBarcode from 'vue-barcode';

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
      name: "livraison_liv",
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
      user:"",
      //Validation
      validationErrors: {},
      validationErrorsEdit: {},
      //Page numeration
      Index: 0,
      search: [],
      currentPage: 1,
      itemsPerPage: 10,

      //get
      livraisons: [],
       livreur_id:"",

      //colis
      prix: "",
      Nb_pieces: "1",
      designation: "",
      poid: "1",
      echange: "",
      type: "",
      fragile: "",
      //client
      tel: "",
      nom: "",
      address: "",
      tel2: "",
      gouvernorat: "",
      delegation: "",
      localite: "",
      commentaire: "",

      //colis
      prix: "",
      Nb_piecesEdit: "",
      designationEdit: "",
      poidEdit: "",
      echangeEdit: "",
      typeEdit: "",
      fragileEdit: "",
        //edit
        coliEdit: [],
      //client
      telEdit: "",
      nomEdit: "",
      addressEdit: "",
      tel2Edit: "",
      gouvernoratEdit: "",
      delegationEdit: "",
      localiteEdit: "",
      commentaireEdit: "",


      //historique
      historiques:[],

      //imprimer
      colisInfo:[],
    };
    },
    mounted() {
    this.user=window.Laravel.user;
    this.livreur_id = this.$route.params.livreur;

    this.get_all_livraisons();
  },

  computed: {
    displayedLivraisons() {
      const searchLower =
        typeof this.search === "string" ? this.search.toLowerCase() : "";

      return this.livraisons.filter((livraison) => {
        const date = (this.currentDateTime(livraison.created_at) || "").toString();

        // Perform case-insensitive search
        return date.includes(searchLower);
      });
    },

    displayedPages() {
      const pageCount = Math.ceil(
        this.displayedLivraisons.length / this.itemsPerPage
      );
      const range = [];

      for (let i = 1; i <= pageCount; i++) {
        range.push(i);
      }

      return range;
    },

    displayedLivraisonsSlice() {
      const startIndex = (this.currentPage - 1) * this.itemsPerPage;
      const endIndex = startIndex + this.itemsPerPage;
      return this.displayedLivraisons.slice(startIndex, endIndex);
    },

  },
  methods: {
    changePage(newPage) {
      if (newPage >= 1 && newPage <= this.displayedPages.length) {
        this.currentPage = newPage;
      }
    },

    async get_all_livraisons() {
      try {
        const response = await axios.get(`/api/livraisons/get_all_livraisons/${this.user.id}`);
        this.livraisons = response.data.livraisons;
        console.log(this.livraisons);

      } catch (error) {
        console.log(error);
      }
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
