<template>
    <layout_expediteur ref="table">
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
        <i class="fa-solid fa-cash-register me-2"></i>
        <h5 class="mb-0">Historique de paiements</h5>
    </div>
    <div>
        <h5 class="mb-0">Solde : {{ solde }} Dt</h5>
    </div>
</div>


        <div class="table-responsive">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th scope="col">ID</th>
                <th scope="col">Date</th>
                <th scope="col">Montant Payé</th>

              </tr>
            </thead>
            <template v-if="displayedExpediteurSlice.length > 0">
              <tbody>
                <tr
                  v-for="paiement in displayedExpediteurSlice"
                  :key="paiement.id"
                >

                  <th>#{{ paiement.id }}</th>
                  <td>{{ currentDateTime(paiement.created_at) }}</td>
                  <td>{{ paiement.montant }} Dt</td>
                </tr>
              </tbody>
            </template>
            <tbody v-else>
              <tr>
                <td colspan="18">Pas de Paiement</td>
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
    </layout_expediteur>
  </template>

<script setup>
import layout_expediteur from "../layouts/layoutExpediteur";
import tunisia from "../../../../storage/app/public/json/zip-postcodes.json";
  import {
    checkLoginExpediteur,checkDisabledAccount
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
      name: "paiement_expediteurs",
    //check auth
    beforeRouteEnter(to, from, next) {
      if (checkLoginExpediteur() && !checkDisabledAccount()) {
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
      paiements: [],
      expediteurs:[],
      expediteur:"",
      expediteur_id:"",
      solde:"",


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
    this.get_all_expediteur_paiements();
    this.get_solde();

  },

  computed: {
    displayedExpediteur() {
      const searchLower =
        typeof this.search === "string" ? this.search.toLowerCase() : "";

      return this.paiements.filter((paiement) => {
        const date = (this.currentDateTime(paiement.created_at) || "").toString();

        // Perform case-insensitive search
        return date.includes(searchLower);
      });
    },

    displayedPages() {
      const pageCount = Math.ceil(
        this.displayedExpediteur.length / this.itemsPerPage
      );
      const range = [];

      for (let i = 1; i <= pageCount; i++) {
        range.push(i);
      }

      return range;
    },

    displayedExpediteurSlice() {
      const startIndex = (this.currentPage - 1) * this.itemsPerPage;
      const endIndex = startIndex + this.itemsPerPage;
      return this.displayedExpediteur.slice(startIndex, endIndex);
    },

  },
  methods: {
    changePage(newPage) {
      if (newPage >= 1 && newPage <= this.displayedPages.length) {
        this.currentPage = newPage;
      }
    },

    async get_all_expediteur_paiements() {
      try {
        const response = await axios.get(`/api/paiement/get_all_expediteur_paiements/${this.user.id}`);
        this.paiements = response.data.paiements;
        console.log(this.paiements);

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
    async get_solde(){
        try {
        const response=  await axios.get(`/api/get_solde/${this.user.id}`);
          this.solde=response.data.solde;
            console.log(this.solde);
        } catch (error) {
            console.log(error);
        }
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
