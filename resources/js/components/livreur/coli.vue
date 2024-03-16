<template>
    <layout_livreur ref="table">
      <div
        class=" shadow p-3"
        style="background-color: white; position: relative"
      >
      <a href="#" class="btn btn-primary" onclick="history.back()">&#60; Retour</a>
        <br><br>
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
        <i class="fa-solid fa-cube me-2"></i>
        <h5 class="mb-0">Liste des colis</h5>
        <div class="ms-auto">
            <a id="crudBtn" @click="BonDeSortie()" class="btn btn-secondary m-2">
                <i class="fa-solid fa-print"></i>
                <!-- <span class="textHover">Bon de sortie</span> -->
            </a>
        </div>
    </div>



        <div class="table-responsive">
          <table class="table table-bordered">
            <thead>
              <tr>
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
                  <th>#{{ coli.colis.id }}</th>
                  <td>{{ currentDateTime1(coli.colis.created_at) }}</td>
                  <!-- <td> {{ moment(coli.created_at).format("DD/MM/YYYY HH:mm:ss") }}</td> -->
                  <td>{{ coli.colis.designation }}</td>
                  <td>{{ coli.colis.nom }}</td>
                  <td>{{ coli.colis.prix }} Dt</td>
                  <td>
                    <i v-if="coli.etat==='En attente'" class="fa-solid fa-circle text-danger"></i>
                    <i v-else-if="coli.colis.etat==='Pickup enlever chez livreur'" class="fa-solid fa-circle" style="color: #ff4500;"></i>
                    <i v-else-if="coli.colis.etat==='Pickup dépôt entrant'" class="fa-solid fa-circle" style="color: #ffa500;"></i>
                    <i v-else-if="coli.colis.etat==='En cours de livraison'" class="fa-solid fa-circle" style="color: #9acd32;"></i>
                    <i v-else-if="coli.colis.etat==='Livré'" class="fa-solid fa-circle" style="color: #008000;"></i>
                    <i v-else-if="coli.colis.etat==='Retour Définitif'" class="fa-solid fa-circle text-dark"></i>
                    <i v-else-if="coli.colis.etat==='Retour Dépôt'" class="fa-solid fa-circle text-danger"></i>

                    <p>{{ coli.colis.etat }}</p>
                </td>
                  <td>

                    <a id="crudBtn" @click="openHistoriqueModal(coli.colis)" class="btn btn-info m-2"
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
import layout_livreur from "../layouts/layoutLivreur.vue";
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
      name: "colis_livreur",
    //check auth
    beforeRouteEnter(to, from, next) {
      if (checkLoginLivreur() && !checkDisabledAccount()) {
        next();
      } else {
        next("/");
      }
    },
    props: {
    agence: {
      required: true,
    },
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
      colis: [],
      agence_name:"",


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
      listeColis:[],
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

    };
    },
    mounted() {
    this.user=window.Laravel.user;
    this.agence_name = this.$route.params.agence;
    console.log(this.agence_name);
    this.get_livreurs_colis_par_agence(this.user);
    // console.log(window.Laravel.user);
  },

  computed: {
    displayedColis() {
      const searchLower =
        typeof this.search === "string" ? this.search.toLowerCase() : "";

      return this.colis.filter((coli) => {
        const nom = (coli.colis.nom || "").toLowerCase();
        const id = (coli.colis.id || "").toString().toLowerCase();
        const state = (coli.colis.etat || "").toString().toLowerCase();
        const date = (this.currentDateTime1(coli.colis.created_at) || "").toString();
        const gouvernorat = (coli.gouvernorat || "").toLowerCase();
        const delegation = (coli.delegation || "").toLowerCase();
        const localite = (coli.delegation || "").toLowerCase();
        // Perform case-insensitive search
        return nom.includes(searchLower) || id.includes(searchLower)|| state.includes(searchLower)|| date.includes(searchLower)|| delegation.includes(searchLower)|| gouvernorat.includes(searchLower)|| localite.includes(searchLower);
      });
    },
    currentDateTime() {
        var date = new Date();
        var year = date.getFullYear();
        var month = String(date.getMonth() + 1).padStart(2, '0');
        var day = String(date.getDate()).padStart(2, '0');
        var hours = String(date.getHours()).padStart(2, '0');
        var minutes = String(date.getMinutes()).padStart(2, '0');
        var seconds = String(date.getSeconds()).padStart(2, '0');

        return day+'/'+month+'/' +year +  ' ' + hours + ':' + minutes + ':' + seconds;
    },

    uniqueGovernorats() {
      return [...new Set(tunisia.map((item) => item.Gov))];
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


  },
  methods: {
    changePage(newPage) {
      if (newPage >= 1 && newPage <= this.displayedPages.length) {
        this.currentPage = newPage;
      }
    },

    async get_livreurs_colis_par_agence(user) {
        console.log(user.id);
      try {
        const response = await axios.get(`/api/colis/get_livreurs_colis_par_agence/${user.id}/${this.agence_name}`);
        this.colis = response.data.colis;
        console.log(this.colis);
      } catch (error) {
        console.log(error);
      }
    },

    currentDateTime1(date) {
        var date = new Date(date);
        var year = date.getFullYear();
        var month = String(date.getMonth() + 1).padStart(2, '0');
        var day = String(date.getDate()).padStart(2, '0');
        var hours = String(date.getHours()).padStart(2, '0');
        var minutes = String(date.getMinutes()).padStart(2, '0');
        var seconds = String(date.getSeconds()).padStart(2, '0');

        return day+'/'+month+'/' +year +  ' ' + hours + ':' + minutes + ':' + seconds;
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


    async BonDeSortie() {
  try {
    this.listeColis = this.displayedColisSlice;
    console.log("ayoo");
    console.log(this.listeColis);
    const doc = new jsPDF();

    doc.setFontSize(20);
    doc.text(85,14,"Bon de Sortie");
    doc.setFontSize(12);
    doc.text(20,25,"Agence: Sfax");
    doc.text(20,32,"Nom livreur: "+this.user.name);
    doc.text(20,39,"Nombre totale des colis est "+this.listeColis.length)
    doc.text(20,46,"Date: "+this.currentDateTime)


    // // Barcode
    // doc.barcode(row.colis.id, {
    //   fontSize: 70,
    //   textColor: "#000000",
    //   x: 130,
    //   y: 40,
    //   textOptions: { align: "center" },
    // });
    // doc.setFont('helvetica');
    // doc.setFontSize(14);
    // doc.text(117,45,String(coli.id));




    doc.autoTable({
    head: [['N° Colis', 'Expéditeur', 'Désignation', 'Montant', 'Client', 'Adresse']],
    body: this.listeColis.map(row => [
    row.colis.id,row.colis.expediteur.name+'\n'+row.colis.expediteur.phone+'\n'+row.colis.expediteur.entreprise, row.colis.designation, row.colis.prix+" dt", row.colis.nom+'\n'+row.colis.address+'\n'+row.colis.tel, row.colis.delegation+"/"+row.colis.localite
    ]),
    theme: 'plain',
    styles: {
      halign: 'center',
      lineWidth: 0.2,
    },
    margin: { top: 70 },
  });

    // Save the PDF
    window.open(doc.output('bloburl'), '_blank');
  } catch (error) {
    console.log(error);
  }
}



}
  };
  </script>

    <style>
  /* Add your custom styles here if needed */
  #crudBtn {
    cursor: pointer;
  }
  </style>
