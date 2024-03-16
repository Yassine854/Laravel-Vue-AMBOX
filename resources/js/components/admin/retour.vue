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
            <i class="fa-solid fa-rotate-left me-2"></i>
          <h5 class="mb-0">Colis en retour</h5>
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
                    <a id="crudBtn" @click="imprimercolis(coli)" class="btn btn-secondary m-2"
                      ><i class="fa-solid fa-print"></i>
                      <span class="textHover">Imprimer</span>
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
    this.get_all_retours_colis();
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

    async get_all_retours_colis() {
      try {
        const response = await axios.get(`/api/colis/get_all_retours_colis`);
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


    async imprimercolis(coli) {
  try {
    const response = await axios.get(`/api/colis/imprimer/${coli.id}`);
    this.colisInfo = response.data.colis;

    const doc = new jsPDF();

    // Load the grayscale image
    const img = new Image();
    img.src = '../../../../storage/image/gray_logo.png';

    const imageWidth = 40;
    const imageHeight = 40;
    // const imageX = (doc.internal.pageSize.getWidth() - imageWidth) / 2;
    const imageX =50;

    const imageY = 10;
    doc.addImage(img, 'png', imageX, imageY, imageWidth, imageHeight);



    //Barcode
    doc.barcode(coli.id, {
      fontSize: 70,
      textColor: "#000000",
      x: 130,
      y: 40,
      textOptions: { align: "center" },
    });



    // Info Expediteur
    doc.setFont('helvetica');
    doc.setFontSize(14);
    doc.text(117,45,String(coli.id));

    doc.autoTable({
  head: [['Expéditeur:', 'Entreprise:', 'Téléphone:']],
  body:[  [this.colisInfo.expediteur.name, this.colisInfo.expediteur.entreprise, this.colisInfo.expediteur.phone]],
  theme: 'plain',
  styles: {
    halign: 'center',
    valign:'middle'
  },
  margin: { top: 70 },
  columnStyles: {
        0: {cellWidth: 60},
        1: {cellWidth: 60},
        2: {cellWidth: 60},
    },
})

    doc.autoTable({
  head:[['Ville/Délégation/Localité:','Adresee:',""]],
  body: [[this.colisInfo.expediteur.gouvernorat+"/"+this.colisInfo.expediteur.delegation+"/"+this.colisInfo.expediteur.localite,this.colisInfo.expediteur.address,""]],
  theme: 'plain',
  styles: {
    halign: 'center',
  },
  columnStyles: {
        0: {cellWidth: 60},
        1: {cellWidth: 60},
        2: {cellWidth: 60},
    },
})

    // Info Client

    doc.autoTable({
  head: [['Destinataire:', 'Téléphone1:', 'Téléphone2:']],
  body: [
  [this.colisInfo.nom, this.colisInfo.tel, this.colisInfo.tel2]],
  theme: 'plain',
  styles: {
    halign: 'center',

  },
  columnStyles: {
        0: {cellWidth: 60},
        1: {cellWidth: 60},
        2: {cellWidth: 60},
    },
})

doc.autoTable({
  head: [['Ville/Délégation/Localité:', 'Adresse:',""]],
  body: [
  [`${this.colisInfo.gouvernorat}/${this.colisInfo.delegation}/${this.colisInfo.localite}`
      , this.colisInfo.address,""]],
  theme: 'plain',
  styles: {
    halign: 'center',
  },
  columnStyles: {
        0: {cellWidth: 60},
        1: {cellWidth: 60},
        2: {cellWidth: 60},
    },
})

doc.autoTable({
  head: [['Date de création:', 'Montant:',""]],
  body: [
  [this.currentDateTime(this.colisInfo.created_at)
      , this.colisInfo.prix + " Dt",""]],
  theme: 'plain',
  styles: {
    halign: 'center',
  },
  columnStyles: {
        0: {cellWidth: 60},
        1: {cellWidth: 60},
        2: {cellWidth: 60},
    },
})

doc.autoTable({
  head: [['Désignation:', 'Poids:', 'Nbr de pièces:']],
  body: [
  [this.colisInfo.designation
      , this.colisInfo.poid + " Kg"
      , this.colisInfo.Nb_pieces]],
  theme: 'plain',
  styles: {
    halign: 'center',
  },
  columnStyles: {
        0: {cellWidth: 60},
        1: {cellWidth: 60},
        2: {cellWidth: 60},
    },
})

    // Montant
    doc.autoTable({
  head: [['Montant HT:','Prix de retour','TVA 19%:']],
  body: [[Math.round(((this.colisInfo.prix/(1+19/100))-(this.colisInfo.expediteur.prix_retour))*100)/100+ " Dt",
  this.colisInfo.expediteur.prix_retour+ " Dt",
  Math.round((this.colisInfo.prix-this.colisInfo.prix/(1+19/100))*100)/100+ " Dt"]],
  theme: 'plain',
  styles: {
    halign: 'center',
  },
  columnStyles: {
        0: {cellWidth: 60},
        1: {cellWidth: 60},
        2: {cellWidth: 60},
    },

})



    doc.autoTable({
  head: [['Total en TTC:']],
  body: [[this.colisInfo.prix+ " Dt"]],
  theme: 'plain',
  margin: { left: 32 },

})

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
