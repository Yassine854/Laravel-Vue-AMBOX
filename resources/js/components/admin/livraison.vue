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

          </div>
        </div>


          <div class="card mb-4">
        <div class="card-header d-flex align-items-center">
            <i class="fa-solid fa-users me-2"></i>
          <h5 class="mb-0">Liste des livreurs</h5>
        </div>

        <div class="table-responsive">
          <table class="table table-hover">

            <template v-if="displayedLivreursSlice.length > 0">
              <tbody>
                <tr
                  v-for="(livreur,index) in livreurs"
                  :key="index"
                  @click="showLivraisons(livreur.livreur_id)"
                  id="crudBtn"
                >

                  <td>{{ livreur.livreur.name }}</td>
                  <th ><i class="fa-solid fa-chevron-right fa-lg text-dark"></i></th>

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
import tunisia from "../../../../storage/app/public/json/zip-postcodes.json";
  import {
    checkLoginAdmin,checkDisabledAccount
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
      name: "livraison",
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
      livreurs: [],

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
    this.get_all_livreurs_livraisons();
  },

  computed: {
    displayedLivreur() {
      const searchLower =
        typeof this.search === "string" ? this.search.toLowerCase() : "";

      return this.livreurs.filter((livreur) => {
        const nom = (livreur.livreur.name || "").toLowerCase();

        // Perform case-insensitive search
        return nom.includes(searchLower);
      });
    },

    uniqueGovernorats() {
      return [...new Set(tunisia.map((item) => item.Gov))];
    },

    displayedPages() {
      const pageCount = Math.ceil(
        this.displayedLivreur.length / this.itemsPerPage
      );
      const range = [];

      for (let i = 1; i <= pageCount; i++) {
        range.push(i);
      }

      return range;
    },

    displayedLivreursSlice() {
      const startIndex = (this.currentPage - 1) * this.itemsPerPage;
      const endIndex = startIndex + this.itemsPerPage;
      return this.displayedLivreur.slice(startIndex, endIndex);
    },

  },
  methods: {
    changePage(newPage) {
      if (newPage >= 1 && newPage <= this.displayedPages.length) {
        this.currentPage = newPage;
      }
    },

    async get_all_livreurs_livraisons() {
      try {
        const response = await axios.get(`/api/get_all_livreurs_livraisons`);
        this.livreurs = response.data.livreurs;
        console.log(this.livreurs);

      } catch (error) {
        console.log(error);
      }
    },

  async  showLivraisons(livreur_id) {
            this.$router.push({
                name: 'livraison_livreurs',
                params: { livreur: livreur_id },
                props: true
         });
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
