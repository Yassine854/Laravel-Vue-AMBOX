<template>
    <layout_admin ref="table">
      <div
        class="container shadow p-3"
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
                data-bs-target="#addColi"
              >
              <i class="fa-solid fa-plus"></i>
              </button>
            </div>

            <!-----------------------------------------------Create coli------------------------------------------>

            <div class="modal fade" id="addColi" tabindex="-1">
              <div class="modal-dialog modal-dialog-centered modal-xl">
                <div class="modal-content">
                  <div class="modal-header">
                    <div class="d-flex align-items-center">
                    <i class="fa-solid fa-plus fa-xl me-2"></i>
                    <h5 class="modal-title mb-0" id="editProductLabel">
                        Ajouter un nouvel coli
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

                    <form @submit.prevent="createColis()">

                        <div class="accordion" id="accordionPanelsStayOpenExample">
  <div class="accordion-item">
    <h2 class="accordion-header" id="panelsStayOpen-headingOne">
      <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
        Informations du colis
      </button>
    </h2>
    <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingOne">
      <div class="accordion-body">

        <!-- Colis Fields -->
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="prix">Prix (en TND):</label>
                    <input type="text" :class="['form-control', {'is-invalid': validationErrors.prix}]" id="prix" name="prix" v-model="prix">
                    <span class="invalid-feedback" v-for="(err, index) in validationErrors.prix" :key="index">{{ err }}<br></span>
                </div>
                <div class="form-group">
                    <label for="Nb_pieces">Nombre de pièces:</label>
                    <input type="number" :class="['form-control', {'is-invalid': validationErrors.Nb_pieces}]" id="Nb_pieces" name="Nb_pieces" min="1" v-model="Nb_pieces">
                    <span class="invalid-feedback" v-for="(err, index) in validationErrors.Nb_pieces" :key="index">{{ err }}<br></span>
                </div>
                <div class="form-group">
                    <label for="designation">Désignation:</label>
                    <input type="text" :class="['form-control', {'is-invalid': validationErrors.designation}]" id="designation" name="designation" v-model="designation">
                    <span class="invalid-feedback" v-for="(err, index) in validationErrors.designation" :key="index">{{ err }}<br></span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="poid">Poids (en Kg):</label>
                    <input type="text" :class="['form-control', {'is-invalid': validationErrors.poid}]" id="poid" name="poid" v-model="poid">
                    <span class="invalid-feedback" v-for="(err, index) in validationErrors.poid" :key="index">{{ err }}<br></span>
                </div>
                <div class="form-group">
                    <label for="echange">Échange:</label>
                    <select :class="['form-select', {'is-invalid': validationErrors.echange}]" id="echange" name="echange" v-model="echange">
                        <option value="1">Oui</option>
                        <option value="0">Non</option>
                    </select>
                    <span class="invalid-feedback" v-for="(err, index) in validationErrors.echange" :key="index">{{ err }}<br></span>
                </div>
                <div class="form-group">
                    <label for="type">Type:</label>
                    <input type="text" :class="['form-control', {'is-invalid': validationErrors.type}]" id="type" name="type" v-model="type">
                    <span class="invalid-feedback" v-for="(err, index) in validationErrors.type" :key="index">{{ err }}<br></span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="fragile">Fragile:</label>
                    <select :class="['form-select', {'is-invalid': validationErrors.fragile}]" id="fragile" name="fragile" v-model="fragile">
                        <option value="1">Oui</option>
                        <option value="0">Non</option>
                    </select>
                    <span class="invalid-feedback" v-for="(err, index) in validationErrors.fragile" :key="index">{{ err }}<br></span>
                </div>
            </div>
        </div>

      </div>
    </div>
  </div>
  <div class="accordion-item">
    <h2 class="accordion-header" id="panelsStayOpen-headingTwo">
      <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="true" aria-controls="panelsStayOpen-collapseTwo">
        Paramétres du client
      </button>
    </h2>
    <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingTwo">
      <div class="accordion-body">

        <div class="row">
    <div class="col-md-6">
        <!-- Client Fields -->
        <div class="form-group">
            <label for="tel">Téléphone:</label>
            <input type="text" :class="['form-control', {'is-invalid': validationErrors.tel}]" id="tel" name="tel" v-model="tel">
            <span class="invalid-feedback" v-for="(err, index) in validationErrors.tel" :key="index">{{ err }}<br></span>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="nom">Nom:</label>
            <input type="text" :class="['form-control', {'is-invalid': validationErrors.nom}]" id="nom" name="nom" v-model="nom">
            <span class="invalid-feedback" v-for="(err, index) in validationErrors.nom" :key="index">{{ err }}<br></span>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="address">Adresse:</label>
            <textarea :class="['form-control', {'is-invalid': validationErrors.address}]" id="address" name="address" v-model="address"></textarea>
            <span class="invalid-feedback" v-for="(err, index) in validationErrors.address" :key="index">{{ err }}<br></span>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="tel2">Téléphone 2 (optionnel):</label>
            <input type="text" :class="['form-control', {'is-invalid': validationErrors.tel2}]" id="tel2" name="tel2" v-model="tel2">
            <span class="invalid-feedback" v-for="(err, index) in validationErrors.tel2" :key="index">{{ err }}<br></span>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="gouvernorat">Gouvernorat:</label>
        <select :class="['form-select', {'is-invalid': validationErrors.gouvernorat}]" v-model="gouvernorat" @change="updateDelegations">
            <option value="" selected hidden disabled>Sélectionner la gouvernorat</option>
        <option v-for="(gov,index) in uniqueGovernorats" :key="index">{{ gov }}</option>
    </select>
    <span class="invalid-feedback" v-for="(err, index) in validationErrors.gouvernorat" :key="index">{{ err }}<br></span>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="delegation">Délégation:</label>
            <select :class="['form-select', {'is-invalid': validationErrors.delegation}]" v-model="delegation" @change="updateLocalite">
                <option value="" selected hidden disabled>Sélectionner la délégation</option>
                <option v-for="(deleg, index) in listeDelegations" :key="index">{{ deleg }}</option>
            </select>
            <span class="invalid-feedback" v-for="(err, index) in validationErrors.delegation" :key="index">{{ err }}<br></span>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="localite">Localité:</label>
            <select :class="['form-select', {'is-invalid': validationErrors.localite}]" v-model="localite">
                <option value="" selected hidden disabled>Sélectionner la localité</option>
                <option v-for="(cite, index) in listeLocalite" :key="index">{{ cite }}</option>
            </select>
            <span class="invalid-feedback" v-for="(err, index) in validationErrors.localite" :key="index">{{ err }}<br></span>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="commentaire">Commentaire (optionnel):</label>
            <textarea  :class="['form-control', {'is-invalid': validationErrors.commentaire}]" id="commentaire" name="commentaire" v-model="commentaire"></textarea>
            <span class="invalid-feedback" v-for="(err, index) in validationErrors.commentaire" :key="index">{{ err }}<br></span>
        </div>
    </div>
</div>

      </div>

    </div>
  </div>
</div>

<br>
<div class="form-group">
    <label for="livraison" style="color: black;">Livraison:</label>
    <select :class="['form-select', {'is-invalid': validationErrors.livraison}]" id="livraison" name="livraison" v-model="livraison">
        <option value="0">Non</option>
        <option value="1">Oui</option>
    </select>
    <span class="invalid-feedback" v-for="(err, index) in validationErrors.livraison" :key="index">{{ err }}<br></span>
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

            <!----------------------------------------------- End Create coli------------------------------------------>

            <!-----------------------------------------------Edit coli------------------------------------------>

            <div class="modal fade" id="editColi" tabindex="-1">
              <div class="modal-dialog modal-dialog-centered modal-xl">
                <div class="modal-content">
                  <div class="modal-header">
                    <div class="d-flex align-items-center">
                    <i class="fa-solid fa-pen fa-xl me-2"></i>
                    <h5 class="modal-title mb-0" id="editProductLabel">
                        Modifier le colis
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

                    <form @submit.prevent="updateColis(coliEdit)">

                        <div class="accordion" id="accordionPanelsStayOpenExample">
  <div class="accordion-item">
    <h2 class="accordion-header" id="panelsStayOpen-headingOne">
      <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
        Informations du colis
      </button>
    </h2>
    <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingOne">
      <div class="accordion-body">

        <!-- Colis Fields -->
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="prix">Prix (en TND):</label>
                    <input type="text" :class="['form-control', {'is-invalid': validationErrorsEdit.prix}]" id="prix" name="prix" v-model="prixEdit">
                    <span class="invalid-feedback" v-for="(err, index) in validationErrorsEdit.prix" :key="index">{{ err }}<br></span>
                </div>
                <div class="form-group">
                    <label for="Nb_pieces">Nombre de pièces:</label>
                    <input type="number" :class="['form-control', {'is-invalid': validationErrorsEdit.Nb_pieces}]" id="Nb_pieces" name="Nb_pieces" min="1" v-model="Nb_piecesEdit">
                    <span class="invalid-feedback" v-for="(err, index) in validationErrorsEdit.Nb_pieces" :key="index">{{ err }}<br></span>
                </div>
                <div class="form-group">
                    <label for="designation">Désignation:</label>
                    <input type="text" :class="['form-control', {'is-invalid': validationErrorsEdit.designation}]" id="designation" name="designation" v-model="designationEdit">
                    <span class="invalid-feedback" v-for="(err, index) in validationErrorsEdit.designation" :key="index">{{ err }}<br></span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="poid">Poids (en Kg):</label>
                    <input type="text" :class="['form-control', {'is-invalid': validationErrorsEdit.poid}]" id="poid" name="poid" v-model="poidEdit">
                    <span class="invalid-feedback" v-for="(err, index) in validationErrorsEdit.poid" :key="index">{{ err }}<br></span>
                </div>
                <div class="form-group">
                    <label for="echange">Échange:</label>
                    <select :class="['form-select', {'is-invalid': validationErrorsEdit.echange}]" id="echange" name="echange" v-model="echangeEdit">
                        <option value="1">Oui</option>
                        <option value="0">Non</option>
                    </select>
                    <span class="invalid-feedback" v-for="(err, index) in validationErrorsEdit.echange" :key="index">{{ err }}<br></span>
                </div>
                <div class="form-group">
                    <label for="type">Type:</label>
                    <input type="text" :class="['form-control', {'is-invalid': validationErrorsEdit.type}]" id="type" name="type" v-model="typeEdit">
                    <span class="invalid-feedback" v-for="(err, index) in validationErrorsEdit.type" :key="index">{{ err }}<br></span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="fragile">Fragile:</label>
                    <select :class="['form-select', {'is-invalid': validationErrorsEdit.fragile}]" id="fragile" name="fragile" v-model="fragileEdit">
                        <option value="1">Oui</option>
                        <option value="0">Non</option>
                    </select>
                    <span class="invalid-feedback" v-for="(err, index) in validationErrorsEdit.fragile" :key="index">{{ err }}<br></span>
                </div>
            </div>
        </div>

      </div>
    </div>
  </div>
  <div class="accordion-item">
    <h2 class="accordion-header" id="panelsStayOpen-headingTwo">
      <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="true" aria-controls="panelsStayOpen-collapseTwo">
        Paramétres du client
      </button>
    </h2>
    <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingTwo">
      <div class="accordion-body">

        <div class="row">
    <div class="col-md-6">
        <!-- Client Fields -->
        <div class="form-group">
            <label for="tel">Téléphone:</label>
            <input type="text" :class="['form-control', {'is-invalid': validationErrorsEdit.tel}]" id="tel" name="tel" v-model="telEdit">
            <span class="invalid-feedback" v-for="(err, index) in validationErrorsEdit.tel" :key="index">{{ err }}<br></span>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="nom">Nom:</label>
            <input type="text" :class="['form-control', {'is-invalid': validationErrorsEdit.nom}]" id="nom" name="nom" v-model="nomEdit">
            <span class="invalid-feedback" v-for="(err, index) in validationErrorsEdit.nom" :key="index">{{ err }}<br></span>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="address">Adresse:</label>
            <textarea :class="['form-control', {'is-invalid': validationErrorsEdit.address}]" id="address" name="address" v-model="addressEdit"></textarea>
            <span class="invalid-feedback" v-for="(err, index) in validationErrorsEdit.address" :key="index">{{ err }}<br></span>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="tel2">Téléphone 2 (optionnel):</label>
            <input type="text" :class="['form-control', {'is-invalid': validationErrorsEdit.tel2}]" id="tel2" name="tel2" v-model="tel2Edit">
            <span class="invalid-feedback" v-for="(err, index) in validationErrorsEdit.tel2" :key="index">{{ err }}<br></span>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="gouvernorat">Gouvernorat:</label>
        <select :class="['form-select', {'is-invalid': validationErrorsEdit.gouvernorat}]" v-model="gouvernoratEdit" @change="updateDelegationsEdit">
            <option value="" selected hidden disabled>Sélectionner la gouvernorat</option>
        <option v-for="(gov,index) in uniqueGovernorats" :key="index">{{ gov }}</option>
    </select>
    <span class="invalid-feedback" v-for="(err, index) in validationErrorsEdit.gouvernorat" :key="index">{{ err }}<br></span>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="delegation">Délégation:</label>
            <select :class="['form-select', {'is-invalid': validationErrorsEdit.delegation}]" v-model="delegationEdit" @change="updateLocaliteEdit">
                <option value="" selected hidden disabled>Sélectionner la délégation</option>
                <option v-for="(deleg, index) in listeDelegations" :key="index">{{ deleg }}</option>
            </select>
            <span class="invalid-feedback" v-for="(err, index) in validationErrorsEdit.delegation" :key="index">{{ err }}<br></span>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="localite">Localité:</label>
            <select :class="['form-select', {'is-invalid': validationErrorsEdit.localite}]" v-model="localiteEdit">
                <option value="" selected hidden disabled>Sélectionner la localité</option>
                <option v-for="(cite, index) in listeLocalite" :key="index">{{ cite }}</option>
            </select>
            <span class="invalid-feedback" v-for="(err, index) in validationErrorsEdit.localite" :key="index">{{ err }}<br></span>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="commentaire">Commentaire (optionnel):</label>
            <textarea  :class="['form-control', {'is-invalid': validationErrorsEdit.commentaire}]" id="commentaire" name="commentaire" v-model="commentaireEdit"></textarea>
            <span class="invalid-feedback" v-for="(err, index) in validationErrorsEdit.commentaire" :key="index">{{ err }}<br></span>
        </div>
    </div>
</div>

      </div>

    </div>
  </div>
</div>

<br>
<div class="form-group">
    <label for="livraison" style="color: black;">Livraison:</label>
    <select :class="['form-select', {'is-invalid': validationErrorsEdit.livraison}]" id="livraison" name="livraison" v-model="livraisonEdit">
        <option value="0">Non</option>
        <option value="1">Oui</option>
    </select>
    <span class="invalid-feedback" v-for="(err, index) in validationErrorsEdit.livraison" :key="index">{{ err }}<br></span>
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

            <!----------------------------------------------- End Edit coli------------------------------------------>

          </div>
        </div>
        <br />

        <div class="card mb-4">
          <div class="card-header d-flex align-items-center">
            <i class="fa-solid fa-ticket me-2"></i>
          <h5 class="mb-0">Liste des colis</h5>
      </div>

      <div class="table-responsive">
  <table class="table table-bordered">
    <thead>
      <tr>
        <th scope="col">ID</th>
        <th scope="col">Prix</th>
        <th scope="col">NB pièces</th>
        <th scope="col">Désignation</th>
        <th scope="col">Poids</th>
        <th scope="col">Échange</th>
        <th scope="col">Type</th>
        <th scope="col">Fragile</th>
        <th scope="col">Téléphone</th>
        <th scope="col">Nom</th>
        <th scope="col">Adresse</th>
        <th scope="col">Téléphone2</th>
        <th scope="col">Gouvernorat</th>
        <th scope="col">Délégation</th>
        <th scope="col">Localité</th>
        <th scope="col">Commentaire</th>
        <th scope="col">Livraison</th>
        <th scope="col">Actions</th>
      </tr>
    </thead>
    <template v-if="displayedColisSlice.length > 0">
      <tbody>
        <tr v-for="coli in displayedColisSlice" :key="coli.id">
          <th>{{ coli.id }}</th>
          <td>{{ coli.prix }} Dt</td>
          <td>{{ coli.Nb_pieces }}</td>
          <td>{{ coli.designation }}</td>
          <td>{{ coli.poid }} Kg</td>
          <td>{{ coli.echange ? 'Oui' : 'Non' }}</td>
          <td>{{ coli.type }}</td>
          <td>{{ coli.fragile ? 'Oui' : 'Non' }}</td>
          <td>{{ coli.tel }}</td>
          <td>{{ coli.nom }}</td>
          <td>{{ coli.address }}</td>
          <td>{{ coli.tel2 }}</td>
          <td>{{ coli.gouvernorat }}</td>
          <td>{{ coli.delegation }}</td>
          <td>{{ coli.localite }}</td>
          <td>{{ coli.commentaire }}</td>
          <td>{{ coli.livraison ? 'Oui' : 'Non' }}</td>
          <td>
            <a id="crudBtn" @click="openEditModal(coli)" class="me-4 text-warning">
              <i class="fa-solid fa-pen-to-square"></i>
            </a>
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
import layout_admin from "../layouts/layoutAdmin.vue";
import tunisia from "../../../../storage/app/public/json/zip-postcodes.json";
  import {
    checkLoginAdmin,
  } from "../../auth";
  import { onMounted, ref, computed } from "vue";
  import { useRouter } from "vue-router";
  import Swal from "sweetalert2";
  import axios from "axios";
  window.Swal = Swal;

  </script>


    <script>
  export default {
      name: "colis",
    //check auth
    beforeRouteEnter(to, from, next) {
      if (checkLoginAdmin()) {
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
        colis:[],

        //create
        listeDelegations:[],
        listeLocalite:[],
            //colis
            prix:"",
            Nb_pieces:"",
            designation:"",
            poid:"",
            echange:"",
            type:"",
            fragile:"",
            //client
            tel:"",
            nom:"",
            address:"",
            tel2:"",
            gouvernorat:"",
            delegation:"",
            localite:"",
            commentaire:"",
            livraison:"",


        //edit
        coliEdit:[],
        //colis
        prix:"",
            Nb_piecesEdit:"",
            designationEdit:"",
            poidEdit:"",
            echangeEdit:"",
            typeEdit:"",
            fragileEdit:"",
            //client
            telEdit:"",
            nomEdit:"",
            addressEdit:"",
            tel2Edit:"",
            gouvernoratEdit:"",
            delegationEdit:"",
            localiteEdit:"",
            commentaireEdit:"",
            livraisonEdit:"",

      };
    },
    mounted(){
        this.get_all_colis();

    },
    watch: {
    gouvernoratEdit(newGouvernorat, oldGouvernorat) {
      if (newGouvernorat !== oldGouvernorat) {
        this.updateDelegationsEdit();
      }
    },
    delegationEdit(newDelegation, oldDelegation){
        if (newDelegation !== oldDelegation) {
        this.updateLocaliteEdit();
      }
    }
  },
    computed: {
        displayedColis() {
        const searchLower = typeof this.search === 'string' ? this.search.toLowerCase() : '';

        return this.colis.filter(coli => {
            const nom = (coli.nom || '').toLowerCase();

            // Perform case-insensitive search
            return nom.includes(searchLower);
        });
    },

    uniqueGovernorats() {
        return [...new Set(tunisia.map(item => item.Gov))];
    },


    displayedPages() {
        const pageCount = Math.ceil(this.displayedColis.length / this.itemsPerPage);
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

    updateDelegations() {
    this.listeDelegations=[];
    this.listeLocalite=[];
    this.listeDelegations = [...new Set(tunisia
        .filter(item => item.Gov === this.gouvernorat)
        .map(item => item.Deleg))];
    console.log(this.listeDelegations);
},

updateLocalite() {
    this.listeLocalite = [...new Set(tunisia
        .filter(item => item.Deleg === this.delegation)
        .map(item => item.Cite))];
    console.log(this.listeLocalite);
},

updateDelegationsEdit() {
    this.listeDelegations=[];
    this.listeLocalite=[];
    this.listeDelegations = [...new Set(tunisia
        .filter(item => item.Gov === this.gouvernoratEdit)
        .map(item => item.Deleg))];
},

updateLocaliteEdit() {
    this.listeLocalite = [...new Set(tunisia
        .filter(item => item.Deleg === this.delegationEdit)
        .map(item => item.Cite))];
},


     async get_all_colis(){
        try {
        const response=  await axios.get(`/api/colis/get_all_colis`);
          this.colis=response.data.colis;
          console.log(this.colis);

        } catch (error) {
            console.log(error);
        }
      },


      async createColis() {
        this.validationErrors = {};
        try {
          await axios.post(`/api/colis/create`, {
            prix: this.prix,
            Nb_pieces: this.Nb_pieces,
            designation: this.designation,
            poid: this.poid,
            echange: this.echange,
            type: this.type,
            fragile: this.fragile,
            tel: this.tel,
            nom: this.nom,
            address: this.address,
            tel2: this.tel2,
            gouvernorat: this.gouvernorat,
            delegation: this.delegation,
            localite: this.localite,
            commentaire: this.commentaire,
            livraison: this.livraison
          });
            this.prix = "";
            this.Nb_pieces = "";
            this.designation = "";
            this.poid = "";
            this.echange = "";
            this.type = "";
            this.fragile = "";
            this.tel = "";
            this.nom = "";
            this.address = "";
            this.tel2 = "";
            this.gouvernorat = "";
            this.delegation = "";
            this.localite = "";
            this.commentaire = "";
            this.livraison = "";


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
            title: "Colis ajouté avec succées !",
          });

          $("#addColi .btn-close").click();
          this.get_all_colis();
        } catch (error) {
            if (error.response.status === 400) {
          this.validationErrors = error.response.data.errors;
          console.log(this.validationErrors);
        } else {
          this.errorMessage = "Une erreur s'est produite lors de la création du colis";
        }
        }
      },


    openEditModal(coli) {
    $("#editColi").modal("show");
    this.validationErrorsEdit={}
    this.coliEdit=coli;
    this.prixEdit = coli.prix;
    this.Nb_piecesEdit = coli.Nb_pieces;
    this.designationEdit = coli.designation;
    this.poidEdit = coli.poid;
    this.echangeEdit =coli.echange;
    this.typeEdit = coli.type;
    this.fragileEdit = coli.fragile;
    this.telEdit = coli.tel;
    this.nomEdit = coli.nom;
    this.addressEdit = coli.address;
    this.tel2Edit = coli.tel2;
    this.gouvernoratEdit = coli.gouvernorat;
    this.delegationEdit = coli.delegation;
    this.localiteEdit = coli.localite;
    this.commentaireEdit = coli.commentaire;
    this.livraisonEdit = coli.livraison;

    },

  async updateColis(coli) {
  try {
    const response = await axios.put(`/api/colis/update/${coli.id}`, {
        prix: this.prixEdit,
        Nb_pieces: this.Nb_piecesEdit,
        designation: this.designationEdit,
        poid: this.poidEdit,
        echange: this.echangeEdit,
        type: this.typeEdit,
        fragile: this.fragileEdit,
        tel: this.telEdit,
        nom: this.nomEdit,
        address: this.addressEdit,
        tel2: this.tel2Edit,
        gouvernorat: this.gouvernoratEdit,
        delegation: this.delegationEdit,
        localite: this.localiteEdit,
        commentaire: this.commentaireEdit,
        livraison: this.livraisonEdit
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
        title: "Colis modifié avec succés !",
      });

      $("#editColi .btn-close").click();
        this.get_all_colis();
        this.coliEdit=[];
        this.prixEdit = "";
        this.Nb_piecesEdit = "";
        this.designationEdit = "";
        this.poidEdit = "";
        this.echangeEdit = "";
        this.typeEdit = "";
        this.fragileEdit = "";
        this.telEdit = "";
        this.nomEdit = "";
        this.addressEdit = "";
        this.tel2Edit = "";
        this.gouvernoratEdit = "";
        this.delegationEdit = "";
        this.localiteEdit = "";
        this.commentaireEdit = "";
        this.livraisonEdit = "";
    } else {
      this.errorMessage = "Une erreur s'est produite lors de la mise Ã  jour du colis.";
    }
  } catch (error) {
    if (error.response && error.response.status === 400) {
      this.validationErrorsEdit = error.response.data.errors;
      console.log(this.validationErrorsEdit);
    } else {
      this.errorMessage = "Une erreur s'est produite lors de la mise Ã  jour de l'coli.";
    }
  }
},


disableColi(coli) {
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
        .post("/api/coli/disable/" + coli.id)
        .then((response) => {
          this.get_all_colis();
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


    },
  };
  </script>

    <style>
  /* Add your custom styles here if needed */
  #crudBtn {
    cursor: pointer;
  }
  </style>
