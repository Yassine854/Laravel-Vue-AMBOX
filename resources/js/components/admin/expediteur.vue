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
                data-bs-target="#addexpediteur"
              >
              <i class="fa-solid fa-plus"></i>
              </button>
            </div>

            <!-----------------------------------------------Create expediteur------------------------------------------>

            <div class="modal fade" id="addexpediteur" tabindex="-1">
              <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                  <div class="modal-header">
                    <div class="d-flex align-items-center">
                    <i class="fa-solid fa-plus fa-xl me-2"></i>
                    <h5 class="modal-title mb-0" id="editProductLabel">
                        Ajouter un nouvel expéditeur
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

                    <form @submit.prevent="createExpediteur()">
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

                        <div class="mb-3">
                        <label class="small mb-1" for="entreprise" style="float: left">Nom d'entreprise</label>
                        <input
                            :class="['form-control', {'is-invalid': validationErrors.entreprise}]"
                            id="entreprise"
                            placeholder="Entrer le nom d'entreprise"
                            v-model="entreprise"
                        >
                        <span class="invalid-feedback" v-for="(err, index) in validationErrors.entreprise" :key="index">{{ err }}<br></span>
                        </div>




                        <div class="row">
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label for="gouvernorat">Gouvernorat:</label>
                                  <select
                                    :class="[
                                      'form-select',
                                      {
                                        'is-invalid':
                                          validationErrors.gouvernorat,
                                      },
                                    ]"
                                    v-model="gouvernorat"
                                    @change="updateDelegations"
                                  >
                                    <option value="" selected hidden disabled>
                                      Sélectionner la gouvernorat
                                    </option>
                                    <option
                                      v-for="(gov, index) in uniqueGovernorats"
                                      :key="index"
                                    >
                                      {{ gov }}
                                    </option>
                                  </select>
                                  <span
                                    class="invalid-feedback"
                                    v-for="(
                                      err, index
                                    ) in validationErrors.gouvernorat"
                                    :key="index"
                                    >{{ err }}<br
                                  /></span>
                                </div>
                              </div>
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label for="delegation">Délégation:</label>
                                  <select
                                    :class="[
                                      'form-select',
                                      {
                                        'is-invalid':
                                          validationErrors.delegation,
                                      },
                                    ]"
                                    v-model="delegation"
                                    @change="updateLocalite"
                                  >
                                    <option value="" selected hidden disabled>
                                      Sélectionner la délégation
                                    </option>
                                    <option
                                      v-for="(deleg, index) in listeDelegations"
                                      :key="index"
                                    >
                                      {{ deleg }}
                                    </option>
                                  </select>
                                  <span
                                    class="invalid-feedback"
                                    v-for="(
                                      err, index
                                    ) in validationErrors.delegation"
                                    :key="index"
                                    >{{ err }}<br
                                  /></span>
                                </div>
                              </div>
                            </div>

                            <div class="row">
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label for="localite">Localité:</label>
                                  <select
                                    :class="[
                                      'form-select',
                                      {
                                        'is-invalid': validationErrors.localite,
                                      },
                                    ]"
                                    v-model="localite"
                                  >
                                    <option value="" selected hidden disabled>
                                      Sélectionner la localité
                                    </option>
                                    <option
                                      v-for="(cite, index) in listeLocalite"
                                      :key="index"
                                    >
                                      {{ cite }}
                                    </option>
                                  </select>
                                  <span
                                    class="invalid-feedback"
                                    v-for="(
                                      err, index
                                    ) in validationErrors.localite"
                                    :key="index"
                                    >{{ err }}<br
                                  /></span>
                                </div>
                            </div>
                                <div class="col-md-6">
                                <div class="form-group">
                                  <label for="address">Adresse:</label>
                                  <textarea
                                    rows="1"
                                    :class="[
                                      'form-control',
                                      {
                                        'is-invalid': validationErrors.address,
                                      },
                                    ]"
                                    id="address"
                                    name="address"
                                    v-model="address"
                                    placeholder="Entrer l'adresse d'expéditeur"
                                  ></textarea>
                                  <span
                                    class="invalid-feedback"
                                    v-for="(
                                      err, index
                                    ) in validationErrors.address"
                                    :key="index"
                                    >{{ err }}<br
                                  /></span>
                                </div>
                            </div>
                              </div>




                        <div class="mb-3">
                        <label class="small mb-1" for="prix_livraison" style="float: left">Prix de livraison (en TND)</label>
                        <input
                            :class="['form-control', {'is-invalid': validationErrors.prix_livraison}]"
                            id="prix_livraison"
                            placeholder="Entrer le prix de livraison"
                            v-model="prix_livraison"
                        >
                        <span class="invalid-feedback" v-for="(err, index) in validationErrors.prix_livraison" :key="index">{{ err }}<br></span>
                        </div>

                        <div class="mb-3">
                        <label class="small mb-1" for="prix_retour" style="float: left">Prix de retour (en TND)</label>
                        <input
                            :class="['form-control', {'is-invalid': validationErrors.prix_retour}]"
                            id="prix_retour"
                            placeholder="Entrer le prix de retour"
                            v-model="prix_retour"
                        >
                        <span class="invalid-feedback" v-for="(err, index) in validationErrors.prix_retour" :key="index">{{ err }}<br></span>
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

            <!----------------------------------------------- End Create expediteur------------------------------------------>

            <!-----------------------------------------------Edit expediteur------------------------------------------>

            <div class="modal fade" id="editexpediteur" tabindex="-1">
              <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                  <div class="modal-header">
                    <div class="d-flex align-items-center">
                    <i class="fa-solid fa-pen fa-xl me-2"></i>
                    <h5 class="modal-title mb-0" id="editProductLabel">
                        Modifier l'expediteur
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

                    <form @submit.prevent="updateExpediteur(expediteurEdit)">
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

                        <div class="mb-3">
                        <label class="small mb-1" for="entreprise" style="float: left">Nom d'entreprise</label>
                        <input
                            :class="['form-control', {'is-invalid': validationErrorsEdit.entreprise}]"
                            id="entreprise"
                            placeholder="Entrer le nom d'entreprise"
                            v-model="entrepriseEdit"
                        >
                        <span class="invalid-feedback" v-for="(err, index) in validationErrorsEdit.entreprise" :key="index">{{ err }}<br></span>
                        </div>


                        <div class="row">
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label for="gouvernorat">Gouvernorat:</label>
                                  <select
                                    :class="[
                                      'form-select',
                                      {
                                        'is-invalid':
                                          validationErrorsEdit.gouvernorat,
                                      },
                                    ]"
                                    v-model="gouvernoratEdit"
                                    @change="updateDelegationsEdit"
                                  >
                                    <option value="" selected hidden disabled>
                                      Sélectionner la gouvernorat
                                    </option>
                                    <option
                                      v-for="(gov, index) in uniqueGovernorats"
                                      :key="index"
                                    >
                                      {{ gov }}
                                    </option>
                                  </select>
                                  <span
                                    class="invalid-feedback"
                                    v-for="(
                                      err, index
                                    ) in validationErrorsEdit.gouvernorat"
                                    :key="index"
                                    >{{ err }}<br
                                  /></span>
                                </div>
                              </div>
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label for="delegation">Délégation:</label>
                                  <select
                                    :class="[
                                      'form-select',
                                      {
                                        'is-invalid':
                                        validationErrorsEdit.delegation,
                                      },
                                    ]"
                                    v-model="delegationEdit"
                                    @change="updateLocaliteEdit"
                                  >
                                    <option value="" selected hidden disabled>
                                      Sélectionner la délégation
                                    </option>
                                    <option
                                      v-for="(deleg, index) in listeDelegations"
                                      :key="index"
                                    >
                                      {{ deleg }}
                                    </option>
                                  </select>
                                  <span
                                    class="invalid-feedback"
                                    v-for="(
                                      err, index
                                    ) in validationErrorsEdit.delegation"
                                    :key="index"
                                    >{{ err }}<br
                                  /></span>
                                </div>
                              </div>
                            </div>

                            <div class="row">
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label for="localite">Localité:</label>
                                  <select
                                    :class="[
                                      'form-select',
                                      {
                                        'is-invalid': validationErrorsEdit.localite,
                                      },
                                    ]"
                                    v-model="localiteEdit"
                                  >
                                    <option value="" selected hidden disabled>
                                      Sélectionner la localité
                                    </option>
                                    <option
                                      v-for="(cite, index) in listeLocalite"
                                      :key="index"
                                    >
                                      {{ cite }}
                                    </option>
                                  </select>
                                  <span
                                    class="invalid-feedback"
                                    v-for="(
                                      err, index
                                    ) in validationErrorsEdit.localite"
                                    :key="index"
                                    >{{ err }}<br
                                  /></span>
                                </div>
                            </div>
                                <div class="col-md-6">
                                <div class="form-group">
                                  <label for="address">Adresse:</label>
                                  <textarea
                                    rows="1"
                                    :class="[
                                      'form-control',
                                      {
                                        'is-invalid': validationErrorsEdit.address,
                                      },
                                    ]"
                                    id="address"
                                    name="address"
                                    v-model="addressEdit"
                                    placeholder="Entrer l'adresse d'expéditeur"
                                  ></textarea>
                                  <span
                                    class="invalid-feedback"
                                    v-for="(
                                      err, index
                                    ) in validationErrorsEdit.address"
                                    :key="index"
                                    >{{ err }}<br
                                  /></span>
                                </div>
                            </div>
                              </div>


                        <div class="mb-3">
                        <label class="small mb-1" for="prix_livraison" style="float: left">Prix de livraison (en TND)</label>
                        <input
                            :class="['form-control', {'is-invalid': validationErrorsEdit.prix_livraison}]"
                            id="prix_livraison"
                            placeholder="Entrer le prix de livraison"
                            v-model="prix_livraisonEdit"
                        >
                        <span class="invalid-feedback" v-for="(err, index) in validationErrorsEdit.prix_livraison" :key="index">{{ err }}<br></span>
                        </div>

                        <div class="mb-3">
                        <label class="small mb-1" for="prix_retour" style="float: left">Prix de retour (en TND)</label>
                        <input
                            :class="['form-control', {'is-invalid': validationErrorsEdit.prix_retour}]"
                            id="prix_retour"
                            placeholder="Entrer le prix de retour"
                            v-model="prix_retourEdit"
                        >
                        <span class="invalid-feedback" v-for="(err, index) in validationErrorsEdit.prix_retour" :key="index">{{ err }}<br></span>
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

            <!----------------------------------------------- End Edit expediteur------------------------------------------>

          </div>
        </div>
        <br />

        <div class="card mb-4">
          <div class="card-header d-flex align-items-center">
            <i class="fa-solid fa-users me-2"></i>
          <h5 class="mb-0">Liste des expediteurs</h5>
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
          <template v-if="displayedexpediteursSlice.length > 0">
          <tbody v-for="expediteur in displayedexpediteursSlice" :key="expediteur.id">
            <tr>
              <th >{{ expediteur.id }}</th>
              <td >{{ expediteur.name }}</td>
              <td >{{ expediteur.phone }}</td>
              <td  scope="row">{{ expediteur.email }}</td>
              <td>
                <div v-if="expediteur.disabled==false">
                    <i class="fa-solid fa-circle text-success"></i> <p>Actif</p>
                </div>
                <div v-if="expediteur.disabled==true">
                    <i class="fa-solid fa-circle text-danger"></i> <p>Désactivé</p>
                </div>
            </td>
              <td >
                <a id="crudBtn" @click="openEditModal(expediteur)" class="btn btn-warning m-2"
                      ><i class="fa-solid fa-pen-to-square"></i>
                      <span class="textHover">Modifier</span>
                      </a

                    >

                    <a  id="crudBtn" @click="disableExpediteur(expediteur)" class="btn btn-danger m-2" v-if="!expediteur.disabled"
                      ><i class="fa-solid fa-user-lock"></i>
                      <span class="textHover">Désactiver</span>
                      </a

                    >

                    <a  id="crudBtn" @click="enableExpediteur(expediteur)" class="btn btn-success m-2" v-if="expediteur.disabled"
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
            <td colspan="18">Pas d'expéditeurs</td>
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
  import tunisia from "../../../../storage/app/public/json/zip-postcodes.json";
  window.Swal = Swal;

  </script>


    <script>
  export default {
      name: "expediteurs",
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
        expediteurs:[],

        //create
        listeDelegations: [],
        listeLocalite: [],
        name: "",
        email: "",
        entreprise: "",
        gouvernorat: "",
        delegation: "",
        localite: "",
        address: "",
        prix_livraison: "",
        prix_retour: "",
        phone:"",
        password: "",

        //edit
        expediteurEdit:[],
        nameEdit: "",
        entrepriseEdit:"",
        gouvernoratEdit: "",
        delegationEdit: "",
        localiteEdit: "",
        addressEdit: "",
        prix_livraisonEdit: "",
        prix_retourEdit: "",
        phoneEdit:"",
        emailEdit: "",

      };
    },
    mounted(){
        this.get_all_expediteurs();

    },
    watch: {
    gouvernoratEdit(newGouvernorat, oldGouvernorat) {
      if (newGouvernorat !== oldGouvernorat) {
        this.updateDelegationsEdit();
      }
    },
    delegationEdit(newDelegation, oldDelegation) {
      if (newDelegation !== oldDelegation) {
        this.updateLocaliteEdit();
      }
    },
  },
    computed: {

        uniqueGovernorats() {
      return [...new Set(tunisia.map((item) => item.Gov))];
    },

        displayedexpediteurs() {
        const searchLower = typeof this.search === 'string' ? this.search.toLowerCase() : '';

        return this.expediteurs.filter(expediteur => {
            const name = (expediteur.name || '').toLowerCase();

            // Perform case-insensitive search
            return name.includes(searchLower);
        });
    },


    displayedPages() {
        const pageCount = Math.ceil(this.displayedexpediteurs.length / this.itemsPerPage);
        const range = [];

        for (let i = 1; i <= pageCount; i++) {
            range.push(i);
        }

        return range;
        },

        displayedexpediteursSlice() {
        const startIndex = (this.currentPage - 1) * this.itemsPerPage;
        const endIndex = startIndex + this.itemsPerPage;
        return this.displayedexpediteurs.slice(startIndex, endIndex);
        },


  },
    methods: {

        changePage(newPage) {
      if (newPage >= 1 && newPage <= this.displayedPages.length) {
        this.currentPage = newPage;
      }
    },


    updateDelegations() {
      this.listeDelegations = [];
      this.listeLocalite = [];
      this.listeDelegations = [
        ...new Set(
          tunisia
            .filter((item) => item.Gov === this.gouvernorat)
            .map((item) => item.Deleg)
        ),
      ];
      console.log(this.listeDelegations);
    },

    updateLocalite() {
      this.listeLocalite = [
        ...new Set(
          tunisia
            .filter((item) => item.Deleg === this.delegation)
            .map((item) => item.Cite)
        ),
      ];
      console.log(this.listeLocalite);
    },

    updateDelegationsEdit() {
      this.listeDelegations = [];
      this.listeLocalite = [];
      this.listeDelegations = [
        ...new Set(
          tunisia
            .filter((item) => item.Gov === this.gouvernoratEdit)
            .map((item) => item.Deleg)
        ),
      ];
    },

    updateLocaliteEdit() {
      this.listeLocalite = [
        ...new Set(
          tunisia
            .filter((item) => item.Deleg === this.delegationEdit)
            .map((item) => item.Cite)
        ),
      ];
    },

     async get_all_expediteurs(){
        try {
        const response=  await axios.get(`/api/expediteurs/get_all_expediteurs`);
          this.expediteurs=response.data.expediteurs;
          console.log(this.expediteurs);

        } catch (error) {
            console.log(error);
        }
      },


      async createExpediteur() {
        this.validationErrors = {};
        try {
          await axios.post(`/api/expediteur/create`, {
            name: this.name,
            email: this.email,
            entreprise:this.entreprise,
            gouvernorat: this.gouvernorat,
            delegation: this.delegation,
            localite: this.localite,
            address: this.address,
            prix_livraison:this.prix_livraison,
            prix_retour:this.prix_retour,
            phone:this.phone,
            password: this.password,
          });
          this.name = "";
          this.email = "";
          this.entreprise="";
          this.gouvernorat = "";
          this.delegation = "";
          this.localite = "";
          this.address="";
          this.prix_livraison="",
          this.prix_retour="",
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
            title: "Expediteur ajouté avec succées !",
          });

          $("#addexpediteur .btn-close").click();
          this.get_all_expediteurs();
        } catch (error) {
            if (error.response.status === 400) {
          this.validationErrors = error.response.data.errors;
          console.log(this.validationErrors);
        } else {
          this.errorMessage = "Une erreur s'est produite lors de la création d'expediteur";
        }
        }
      },


    openEditModal(expediteur) {
    $("#editexpediteur").modal("show");
    this.validationErrorsEdit={}
    this.expediteurEdit=expediteur;
    this.nameEdit = expediteur.name;
    this.emailEdit=expediteur.email;
    this.entrepriseEdit=expediteur.entreprise;
    this.gouvernoratEdit = expediteur.gouvernorat;
    this.delegationEdit = expediteur.delegation;
    this.localiteEdit = expediteur.localite;
    this.addressEdit=expediteur.address;
    this.prix_livraisonEdit=expediteur.prix_livraison;
    this.prix_retourEdit=expediteur.prix_retour;
    this.phoneEdit=expediteur.phone;
    },

  async updateExpediteur(expediteur) {
  try {
    const response = await axios.put(`/api/expediteur/update/${expediteur.id}`, {
        name: this.nameEdit,
        email: this.emailEdit,
        entreprise:this.entrepriseEdit,
        gouvernorat: this.gouvernoratEdit,
        delegation: this.delegationEdit,
        localite: this.localiteEdit,
        address: this.addressEdit,
        prix_livraison:this.prix_livraisonEdit,
        prix_retour:this.prix_retourEdit,
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
        title: "Expediteur modifié avec succés !",
      });

      $("#editexpediteur .btn-close").click();
      this.get_all_expediteurs();
        this.expediteurEdit=[];
        this.nameEdit = "";
        this.emailEdit = "";
        this.entrepriseEdit="";
        this.gouvernoratEdit = "";
        this.delegationEdit = "";
        this.localiteEdit = "";
        this.addressEdit="";
        this.prix_livraisonEdit="",
        this.prix_retourEdit="",
        this.phoneEdit="";
    } else {
      this.errorMessage = "Une erreur s'est produite lors de la mise Ã  jour de l'expediteur.";
    }
  } catch (error) {
    if (error.response && error.response.status === 400) {
      this.validationErrorsEdit = error.response.data.errors;
      console.log(this.validationErrorsEdit);
    } else {
      this.errorMessage = "Une erreur s'est produite lors de la mise Ã  jour de l'expediteur.";
    }
  }
},


disableExpediteur(expediteur) {
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
        .post("/api/expediteur/disable/" + expediteur.id)
        .then((response) => {
          this.get_all_expediteurs();
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


enableExpediteur(expediteur) {
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
        .post("/api/expediteur/enable/" + expediteur.id)
        .then((response) => {
          this.get_all_expediteurs();
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
