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
        <!------------------------------- Affecter Livreur ---------------------------------->

        <div class="modal fade" id="affecterLivreur" tabindex="-1">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <div class="d-flex align-items-center">
                    <i class="fa-solid fa-pen fa-xl me-2"></i>
                    <h5 class="modal-title mb-0" id="changeSelectedStateLabel">
                      Affecter un livreur
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
                  <form @submit.prevent="AffecterLivreur()">
                    <div class="form-group">
                      <label for="state">Livreurs:</label>
                      <select
                        :class="['form-select', {'is-invalid': validationErrors.livreur_id}]"
                          id="livreur_id"
                          v-model="livreur"
                        >
                        <option value="" disabled selected hidden>Sélectionner un livreur</option>
                          <option
                            v-for="livreur in livreurs"
                            :key="livreur.id"
                            :value="livreur.id"
                          >
                          {{ livreur.name }}
                          </option>
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
                        Affecter
                      </button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>



        <!-------------------------------------- End Affecter Livreur ------------------------------->


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
            <i class="fa-solid fa-clipboard-list me-2"></i>
          <h5 class="mb-0">Gestion des manifestes</h5>
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
      <button @click="openLivreurModal()" class="btn btn-primary m-2" :disabled="isChangerEtatButtonDisabled">Livrer colis</button>

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
import layout_admin from "../layouts/layoutAdmin";
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
      name: "colis_admin",
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
      validationErrors: {},
      validationErrorsEdit: {},
      //Page numeration
      Index: 0,
      search: [],
      currentPage: 1,
      itemsPerPage: 10,

      //get
      colis: [],
      livreurs:[],
      livreur:"",


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
    this.get_all_manifestes_colis();
    this.get_all_livreurs();
    console.log(window.Laravel.user);
  },

  computed: {
    displayedColis() {
      const searchLower =
        typeof this.search === "string" ? this.search.toLowerCase() : "";

      return this.colis.filter((coli) => {
        const nom = (coli.nom || "").toLowerCase();

        // Perform case-insensitive search
        return nom.includes(searchLower);
      });
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

    async get_all_manifestes_colis() {
      try {
        const response = await axios.get(`/api/colis/get_all_manifestes_colis`);
        this.colis = response.data.colis;
        console.log(this.colis);
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

    async get_all_livreurs(){
        try {
        const response=  await axios.get(`/api/livreurs/get_all_livreurs`);
          this.livreurs=response.data.livreurs;
          console.log(this.livreurs);

        } catch (error) {
            console.log(error);
        }
      },


  async LivrerColis() {
    this.validationErrors=[];
      try {
      const response = await axios.put('/api/colis/updateSelectedStates', {
        coliIds: this.selectedColis,
        etat: "En cours",
      });

      if (response.status === 200) {
        this.toast.fire({
          icon: "success",
          title: "Colis en cours de livraison !",
        });
        this.selectedColis=[];
        this.get_all_manifestes_colis();
      }
        else {
        this.errorMessage = "Une erreur s'est produite lors de la mise à jour du colis.";
        // Handle the error as needed
      }
  } catch (error) {
        if (error.response.status === 400) {
          this.validationErrors = error.response.data.errors;
          console.log(this.validationErrors);
        }
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

    openLivreurModal() {
      $("#affecterLivreur").modal("show");
    },


    async AffecterLivreur() {
        try {
        const response = await axios.post(`/api/affectations2/PickupDepotSortant`, {
          coliIds: this.selectedColis,
          livreur_id: this.livreur,
          etat: "En cours de livraison"

        });

        if (response.status === 200) {

          this.toast.fire({
            icon: "success",
            title: "Colis livré(s) et affecté(s) avec succès !",
          });

          $("#affecterLivreur .btn-close").click();
          this.get_all_manifestes_colis();
          this.selectedColis=[];
          this.validationErrors={};
        } else {
          this.errorMessage =
            "Une erreur s'est produite lors de la mise Ãƒ jour du colis.";
        }
      } catch (error) {
        if (error.response && error.response.status === 400) {
          this.validationErrors = error.response.data.errors;
          console.log(this.validationErrors);
        }
        else if (error.response && error.response.status === 422) {
            $("#affecterLivreurSelected .btn-close").click();
            this.toast.fire({
            icon: "error",
            title: "Oops...",
            text: "Il y a eu un probéme!",
          });

        }
        else {
          this.errorMessage =
            "Une erreur s'est produite lors de la mise Ãƒ  jour de l'coli.";
        }
      }
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
  ['Nom', window.Laravel.user.name],
  ['Entreprise', window.Laravel.user.entreprise],
  ['Téléphone', window.Laravel.user.phone],
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
