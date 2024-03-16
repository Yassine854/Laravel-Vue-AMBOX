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
            <i class="fa-solid fa-users me-2"></i>
          <h5 class="mb-0">Liste des expéditeurs</h5>
        </div>

        <div class="table-responsive">
          <table class="table table-hover">

            <template v-if="displayedExpediteurSlice.length > 0">
              <tbody>
                <tr
                  v-for="(coli,index) in colis"
                  :key="index"
                  @click="showColis(coli.expediteur.id)"
                  id="crudBtn"
                >

                  <td>{{ coli.expediteur.name }}</td>
                  <th ><i class="fa-solid fa-chevron-right fa-lg text-dark"></i></th>

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
      name: "pickup_livreur",
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
      colis: [],


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
    this.get_all_expediteurs_colis();
  },

  computed: {
    displayedExpediteur() {
      const searchLower =
        typeof this.search === "string" ? this.search.toLowerCase() : "";

      return this.colis.filter((coli) => {
        const nom = (coli.expediteur.name || "").toLowerCase();

        // Perform case-insensitive search
        return nom.includes(searchLower);
      });
    },

    uniqueGovernorats() {
      return [...new Set(tunisia.map((item) => item.Gov))];
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

    async get_all_expediteurs_colis() {
      try {
        const response = await axios.get(`/api/livreurs/get_all_expediteurs_colis`);
        this.colis = response.data.colis;
        console.log(this.colis);

      } catch (error) {
        console.log(error);
      }
    },

    showColis(expediteur_id) {
            this.$router.push({
                name: 'pickup_livreur_colis',
                params: { expediteur: expediteur_id },
                props: true
         });
      },




    async imprimercolis(coli){
        try {
        const response = await axios.get(`/api/colis/imprimer/${coli.id}`);
        this.colisInfo = response.data.colis;
        // console.log(this.colisInfo);

        const boldColumn = [0];
        const doc = new jsPDF();

// Load the grayscale image
const img = new Image();
img.src = '../../../../storage/image/gray_logo.png';

const imageWidth = 40; // Set the width of the image
const imageHeight = 40; // Set the height of the image
const imageX = (doc.internal.pageSize.getWidth() - imageWidth) / 2; // Center horizontally
const imageY = 10; // Position at the top
doc.addImage(img, 'png', imageX, imageY, imageWidth, imageHeight);
const contentY = imageY + imageHeight + 10; // Adjust the vertical space as needed


const columnWidth = 90; // Adjust the width as needed

// Info Expediteur
doc.setFont('helvetica', 'bold');
doc.setFontSize(14);

const expediteurData = [
  ['Nom', "Entreprise","Téléphone"],
  [window.Laravel.user.entreprise.name,window.Laravel.user.entreprise,window.Laravel.user.phone ],
];

const formattedExpediteurData= expediteurData.map((row, rowIndex) => {
  return row.map((cell, columnIndex) => {
    if (boldColumn.includes(columnIndex)) {
      return { content: cell, styles: { fontStyle: 'bold' } };
    }
    return { content: cell, styles: { fontStyle: 'normal' } };
  });
});

const tableX = 15;
const tableY = imageY + imageHeight + 10;

doc.autoTable({
  startY: contentY + 10,
  head: [['Expéditeur:','']],
  body: formattedExpediteurData,
  theme: 'plain',
  styles: {
    halign: 'center',
  },
  startY: tableY,
  margin: { left: tableX },
  columnStyles: {
    0: { cellWidth: columnWidth }, // Set column 0 width
    1: { cellWidth: columnWidth }, // Set column 1 width
  },
});

// Info Client
doc.setFontSize(14);

const clientData = [
  ['Nom', this.colisInfo.nom],
  ['Téléphone1', this.colisInfo.tel],
  ['Téléphone2', this.colisInfo.tel2 ?? ''],
  ['Ville/Délégation/Localité', `${this.colisInfo.gouvernorat}/${this.colisInfo.delegation}/${this.colisInfo.localite}`],
  ['Adresse', this.colisInfo.address],
  ['Date de création', new Date(this.colisInfo.created_at).toLocaleDateString('fr-FR', { year: 'numeric', month: 'long', day: 'numeric' })],
  ['Prix', this.colisInfo.prix + " Dt"],
  ['Type', this.colisInfo.type],
  ['Désignation', this.colisInfo.designation],
  ['Poids', this.colisInfo.poid + " Kg"],
  ['Nbr de pièces', this.colisInfo.Nb_pieces],
];


// Make specific columns bold in the clientData
const formattedClientData = clientData.map((row, rowIndex) => {
  return row.map((cell, columnIndex) => {
    if (boldColumn.includes(columnIndex)) {
      return { content: cell, styles: { fontStyle: 'bold' } };
    }
    return { content: cell, styles: { fontStyle: 'normal' } };
  });
});


doc.autoTable({
  startY: doc.autoTable.previous.finalY + 10,
  head: [['Destinataire:','']],
  body: formattedClientData,
  theme: 'plain',
  styles: {
    halign: 'center',
  },
  margin: { left: tableX },
  columnStyles: {
    0: { cellWidth: columnWidth }, // Set column 0 width
    1: { cellWidth: columnWidth }, // Set column 1 width
  },
});

// Montant
doc.setFontSize(14);

const montantData = [
  ['Prix', this.colisInfo.prix + " Dt"],
  ['Prix de livraison', window.Laravel.user.prix_livraison + " Dt"],
  ['TVA 19%', (this.colisInfo.prix * 19) / 100 + " Dt"],
  ['Total en TTC', (this.colisInfo.prix + (this.colisInfo.prix * 19) / 100 + window.Laravel.user.prix_livraison)+ " Dt"] ,
];

const formattedMontantData= montantData.map((row, rowIndex) => {
  return row.map((cell, columnIndex) => {
    if (boldColumn.includes(columnIndex)) {
      return { content: cell, styles: { fontStyle: 'bold' } };
    }
    return { content: cell, styles: { fontStyle: 'normal' } };
  });
});


doc.autoTable({
  startY: doc.autoTable.previous.finalY + 10,
  head: [['Montant','']],
  body: formattedMontantData,
  theme: 'striped',
  styles: {
    halign: 'center',
  },
  margin: { left: tableX },
});

// Save the PDF
doc.save('structured-pdf.pdf');





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
