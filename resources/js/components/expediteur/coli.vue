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
          <br />
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
                        <h2
                          class="accordion-header"
                          id="panelsStayOpen-headingOne"
                        >
                          <button
                            class="accordion-button"
                            type="button"
                            data-bs-toggle="collapse"
                            data-bs-target="#panelsStayOpen-collapseOne"
                            aria-expanded="true"
                            aria-controls="panelsStayOpen-collapseOne"
                          >
                            Informations du colis
                          </button>
                        </h2>
                        <div
                          id="panelsStayOpen-collapseOne"
                          class="accordion-collapse collapse show"
                          aria-labelledby="panelsStayOpen-headingOne"
                        >
                          <div class="accordion-body">
                            <!-- Colis Fields -->
                            <div class="row">
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label for="prix">Prix (en TND):</label>
                                  <input
                                    type="text"
                                    :class="[
                                      'form-control',
                                      { 'is-invalid': validationErrors.prix },
                                    ]"
                                    id="prix"
                                    name="prix"
                                    v-model="prix"
                                    placeholder="Entrer le prix"
                                  />
                                  <span
                                    class="invalid-feedback"
                                    v-for="(
                                      err, index
                                    ) in validationErrors.prix"
                                    :key="index"
                                    >{{ err }}<br
                                  /></span>
                                </div>
                                <div class="form-group">
                                  <label for="Nb_pieces"
                                    >Nombre de pièces:</label
                                  >
                                  <input
                                    type="number"
                                    :class="[
                                      'form-control',
                                      {
                                        'is-invalid':
                                          validationErrors.Nb_pieces,
                                      },
                                    ]"
                                    id="Nb_pieces"
                                    name="Nb_pieces"
                                    min="1"
                                    v-model="Nb_pieces"
                                    placeholder="Entrer le nombre de piéces"
                                  />
                                  <span
                                    class="invalid-feedback"
                                    v-for="(
                                      err, index
                                    ) in validationErrors.Nb_pieces"
                                    :key="index"
                                    >{{ err }}<br
                                  /></span>
                                </div>
                                <div class="form-group">
                                  <label for="designation">Désignation:</label>
                                  <input
                                    type="text"
                                    :class="[
                                      'form-control',
                                      {
                                        'is-invalid':
                                          validationErrors.designation,
                                      },
                                    ]"
                                    id="designation"
                                    name="designation"
                                    v-model="designation"
                                    placeholder="Entrer la désignation"
                                  />
                                  <span
                                    class="invalid-feedback"
                                    v-for="(
                                      err, index
                                    ) in validationErrors.designation"
                                    :key="index"
                                    >{{ err }}<br
                                  /></span>
                                </div>
                              </div>
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label for="poid">Poids (en Kg):</label>
                                  <input
                                    type="text"
                                    :class="[
                                      'form-control',
                                      { 'is-invalid': validationErrors.poid },
                                    ]"
                                    id="poid"
                                    name="poid"
                                    v-model="poid"
                                    placeholder="Entrer le poid"
                                  />
                                  <span
                                    class="invalid-feedback"
                                    v-for="(
                                      err, index
                                    ) in validationErrors.poid"
                                    :key="index"
                                    >{{ err }}<br
                                  /></span>
                                </div>
                                <div class="form-group">
                                  <label for="echange">Échange:</label>
                                  <select
                                    :class="[
                                      'form-select',
                                      {
                                        'is-invalid': validationErrors.echange,
                                      },
                                    ]"
                                    id="echange"
                                    name="echange"
                                    v-model="echange"
                                  >
                                    <option value="" disabled hidden selected>
                                      Sélectioner une option
                                    </option>
                                    <option value="1">Oui</option>
                                    <option value="0">Non</option>
                                  </select>
                                  <span
                                    class="invalid-feedback"
                                    v-for="(
                                      err, index
                                    ) in validationErrors.echange"
                                    :key="index"
                                    >{{ err }}<br
                                  /></span>
                                </div>
                                <div class="form-group">
                                  <label for="type">Type:</label>
                                  <select
                                    :class="[
                                      'form-select',
                                      { 'is-invalid': validationErrors.type },
                                    ]"
                                    id="type"
                                    name="type"
                                    v-model="type"
                                  >
                                    <option value="" disabled hidden selected>
                                      Sélectioner le type
                                    </option>
                                    <option value="VO">VO</option>
                                    <option value="VM">VM</option>
                                    <option value="VM">GV</option>
                                    <option value="VM">Exp</option>
                                  </select>
                                  <span
                                    class="invalid-feedback"
                                    v-for="(
                                      err, index
                                    ) in validationErrors.type"
                                    :key="index"
                                    >{{ err }}<br
                                  /></span>
                                </div>
                              </div>
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label for="fragile">Fragile:</label>
                                  <select
                                    :class="[
                                      'form-select',
                                      {
                                        'is-invalid': validationErrors.fragile,
                                      },
                                    ]"
                                    id="fragile"
                                    name="fragile"
                                    v-model="fragile"
                                  >
                                    <option value="" disabled hidden selected>
                                      Sélectioner une option
                                    </option>
                                    <option value="1">Oui</option>
                                    <option value="0">Non</option>
                                  </select>
                                  <span
                                    class="invalid-feedback"
                                    v-for="(
                                      err, index
                                    ) in validationErrors.fragile"
                                    :key="index"
                                    >{{ err }}<br
                                  /></span>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="accordion-item">
                        <h2
                          class="accordion-header"
                          id="panelsStayOpen-headingTwo"
                        >
                          <button
                            class="accordion-button"
                            type="button"
                            data-bs-toggle="collapse"
                            data-bs-target="#panelsStayOpen-collapseTwo"
                            aria-expanded="true"
                            aria-controls="panelsStayOpen-collapseTwo"
                          >
                            Paramétres du client
                          </button>
                        </h2>
                        <div
                          id="panelsStayOpen-collapseTwo"
                          class="accordion-collapse collapse show"
                          aria-labelledby="panelsStayOpen-headingTwo"
                        >
                          <div class="accordion-body">
                            <div class="row">
                              <div class="col-md-6">
                                <!-- Client Fields -->
                                <div class="form-group">
                                  <label for="tel">Téléphone:</label>
                                  <input
                                    type="text"
                                    :class="[
                                      'form-control',
                                      { 'is-invalid': validationErrors.tel },
                                    ]"
                                    id="tel"
                                    name="tel"
                                    v-model="tel"
                                    placeholder="Entrer le numéro de téléphone du client"
                                  />
                                  <span
                                    class="invalid-feedback"
                                    v-for="(err, index) in validationErrors.tel"
                                    :key="index"
                                    >{{ err }}<br
                                  /></span>
                                </div>
                              </div>
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label for="nom">Nom:</label>
                                  <input
                                    type="text"
                                    :class="[
                                      'form-control',
                                      { 'is-invalid': validationErrors.nom },
                                    ]"
                                    id="nom"
                                    name="nom"
                                    v-model="nom"
                                    placeholder="Entrer le nom du client"
                                  />
                                  <span
                                    class="invalid-feedback"
                                    v-for="(err, index) in validationErrors.nom"
                                    :key="index"
                                    >{{ err }}<br
                                  /></span>
                                </div>
                              </div>
                            </div>

                            <div class="row">
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label for="address">Adresse:</label>
                                  <textarea
                                    :class="[
                                      'form-control',
                                      {
                                        'is-invalid': validationErrors.address,
                                      },
                                    ]"
                                    id="address"
                                    name="address"
                                    v-model="address"
                                    placeholder="Entrer l'adresse du client"
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
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label for="tel2"
                                    >Téléphone 2 (optionnel):</label
                                  >
                                  <input
                                    type="text"
                                    :class="[
                                      'form-control',
                                      { 'is-invalid': validationErrors.tel2 },
                                    ]"
                                    id="tel2"
                                    name="tel2"
                                    v-model="tel2"
                                  />
                                  <span
                                    class="invalid-feedback"
                                    v-for="(
                                      err, index
                                    ) in validationErrors.tel2"
                                    :key="index"
                                    >{{ err }}<br
                                  /></span>
                                </div>
                              </div>
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
                                  <label for="commentaire"
                                    >Commentaire (optionnel):</label
                                  >
                                  <textarea
                                    rows="1"
                                    :class="[
                                      'form-control',
                                      {
                                        'is-invalid':
                                          validationErrors.commentaire,
                                      },
                                    ]"
                                    id="commentaire"
                                    name="commentaire"
                                    v-model="commentaire"
                                  ></textarea>
                                  <span
                                    class="invalid-feedback"
                                    v-for="(
                                      err, index
                                    ) in validationErrors.commentaire"
                                    :key="index"
                                    >{{ err }}<br
                                  /></span>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
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
                        <h2
                          class="accordion-header"
                          id="panelsStayOpen-headingOne"
                        >
                          <button
                            class="accordion-button"
                            type="button"
                            data-bs-toggle="collapse"
                            data-bs-target="#panelsStayOpen-collapseOne"
                            aria-expanded="true"
                            aria-controls="panelsStayOpen-collapseOne"
                          >
                            Informations du colis
                          </button>
                        </h2>
                        <div
                          id="panelsStayOpen-collapseOne"
                          class="accordion-collapse collapse show"
                          aria-labelledby="panelsStayOpen-headingOne"
                        >
                          <div class="accordion-body">
                            <!-- Colis Fields -->
                            <div class="row">
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label for="prix">Prix (en TND):</label>
                                  <input
                                    type="text"
                                    :class="[
                                      'form-control',
                                      {
                                        'is-invalid': validationErrorsEdit.prix,
                                      },
                                    ]"
                                    id="prix"
                                    name="prix"
                                    v-model="prixEdit"
                                    placeholder="Entrer le prix"
                                  />
                                  <span
                                    class="invalid-feedback"
                                    v-for="(
                                      err, index
                                    ) in validationErrorsEdit.prix"
                                    :key="index"
                                    >{{ err }}<br
                                  /></span>
                                </div>
                                <div class="form-group">
                                  <label for="Nb_pieces"
                                    >Nombre de pièces:</label
                                  >
                                  <input
                                    type="number"
                                    :class="[
                                      'form-control',
                                      {
                                        'is-invalid':
                                          validationErrorsEdit.Nb_pieces,
                                      },
                                    ]"
                                    id="Nb_pieces"
                                    name="Nb_pieces"
                                    min="1"
                                    v-model="Nb_piecesEdit"
                                    placeholder="Entrer le nombre de piéces"
                                  />
                                  <span
                                    class="invalid-feedback"
                                    v-for="(
                                      err, index
                                    ) in validationErrorsEdit.Nb_pieces"
                                    :key="index"
                                    >{{ err }}<br
                                  /></span>
                                </div>
                                <div class="form-group">
                                  <label for="designation">Désignation:</label>
                                  <input
                                    type="text"
                                    :class="[
                                      'form-control',
                                      {
                                        'is-invalid':
                                          validationErrorsEdit.designation,
                                      },
                                    ]"
                                    id="designation"
                                    name="designation"
                                    v-model="designationEdit"
                                    placeholder="Entrer la désignation"
                                  />
                                  <span
                                    class="invalid-feedback"
                                    v-for="(
                                      err, index
                                    ) in validationErrorsEdit.designation"
                                    :key="index"
                                    >{{ err }}<br
                                  /></span>
                                </div>
                              </div>
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label for="poid">Poids (en Kg):</label>
                                  <input
                                    type="text"
                                    :class="[
                                      'form-control',
                                      {
                                        'is-invalid': validationErrorsEdit.poid,
                                      },
                                    ]"
                                    id="poid"
                                    name="poid"
                                    v-model="poidEdit"
                                    placeholder="Entrer le poid"
                                  />
                                  <span
                                    class="invalid-feedback"
                                    v-for="(
                                      err, index
                                    ) in validationErrorsEdit.poid"
                                    :key="index"
                                    >{{ err }}<br
                                  /></span>
                                </div>
                                <div class="form-group">
                                  <label for="echange">Échange:</label>
                                  <select
                                    :class="[
                                      'form-select',
                                      {
                                        'is-invalid':
                                          validationErrorsEdit.echange,
                                      },
                                    ]"
                                    id="echange"
                                    name="echange"
                                    v-model="echangeEdit"
                                  >
                                    <option value="" disabled hidden selected>
                                      Sélectioner une option
                                    </option>
                                    <option value="1">Oui</option>
                                    <option value="0">Non</option>
                                  </select>
                                  <span
                                    class="invalid-feedback"
                                    v-for="(
                                      err, index
                                    ) in validationErrorsEdit.echange"
                                    :key="index"
                                    >{{ err }}<br
                                  /></span>
                                </div>
                                <div class="form-group">
                                  <label for="type">Type:</label>
                                  <select
                                    :class="[
                                      'form-select',
                                      {
                                        'is-invalid': validationErrorsEdit.type,
                                      },
                                    ]"
                                    id="type"
                                    name="type"
                                    v-model="typeEdit"
                                  >
                                    <option value="" disabled hidden selected>
                                      Sélectioner le type
                                    </option>
                                    <option value="VO">VO</option>
                                    <option value="VM">VM</option>
                                    <option value="VM">GV</option>
                                    <option value="VM">Exp</option>
                                  </select>
                                  <span
                                    class="invalid-feedback"
                                    v-for="(
                                      err, index
                                    ) in validationErrorsEdit.type"
                                    :key="index"
                                    >{{ err }}<br
                                  /></span>
                                </div>
                              </div>
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label for="fragile">Fragile:</label>
                                  <select
                                    :class="[
                                      'form-select',
                                      {
                                        'is-invalid':
                                          validationErrorsEdit.fragile,
                                      },
                                    ]"
                                    id="fragile"
                                    name="fragile"
                                    v-model="fragileEdit"
                                  >
                                    <option value="" disabled hidden selected>
                                      Sélectioner une option
                                    </option>
                                    <option value="1">Oui</option>
                                    <option value="0">Non</option>
                                  </select>
                                  <span
                                    class="invalid-feedback"
                                    v-for="(
                                      err, index
                                    ) in validationErrorsEdit.fragile"
                                    :key="index"
                                    >{{ err }}<br
                                  /></span>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="accordion-item">
                        <h2
                          class="accordion-header"
                          id="panelsStayOpen-headingTwo"
                        >
                          <button
                            class="accordion-button"
                            type="button"
                            data-bs-toggle="collapse"
                            data-bs-target="#panelsStayOpen-collapseTwo"
                            aria-expanded="true"
                            aria-controls="panelsStayOpen-collapseTwo"
                          >
                            Paramétres du client
                          </button>
                        </h2>
                        <div
                          id="panelsStayOpen-collapseTwo"
                          class="accordion-collapse collapse show"
                          aria-labelledby="panelsStayOpen-headingTwo"
                        >
                          <div class="accordion-body">
                            <div class="row">
                              <div class="col-md-6">
                                <!-- Client Fields -->
                                <div class="form-group">
                                  <label for="tel">Téléphone:</label>
                                  <input
                                    type="text"
                                    :class="[
                                      'form-control',
                                      {
                                        'is-invalid': validationErrorsEdit.tel,
                                      },
                                    ]"
                                    id="tel"
                                    name="tel"
                                    v-model="telEdit"
                                    placeholder="Entrer le numéro de téléphone du client"
                                  />
                                  <span
                                    class="invalid-feedback"
                                    v-for="(
                                      err, index
                                    ) in validationErrorsEdit.tel"
                                    :key="index"
                                    >{{ err }}<br
                                  /></span>
                                </div>
                              </div>
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label for="nom">Nom:</label>
                                  <input
                                    type="text"
                                    :class="[
                                      'form-control',
                                      {
                                        'is-invalid': validationErrorsEdit.nom,
                                      },
                                    ]"
                                    id="nom"
                                    name="nom"
                                    v-model="nomEdit"
                                    placeholder="Entrer le nom du client"
                                  />
                                  <span
                                    class="invalid-feedback"
                                    v-for="(
                                      err, index
                                    ) in validationErrorsEdit.nom"
                                    :key="index"
                                    >{{ err }}<br
                                  /></span>
                                </div>
                              </div>
                            </div>

                            <div class="row">
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label for="address">Adresse:</label>
                                  <textarea
                                    :class="[
                                      'form-control',
                                      {
                                        'is-invalid':
                                          validationErrorsEdit.address,
                                      },
                                    ]"
                                    id="address"
                                    name="address"
                                    v-model="addressEdit"
                                    placeholder="Entrer l'adresse du client"
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
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label for="tel2"
                                    >Téléphone 2 (optionnel):</label
                                  >
                                  <input
                                    type="text"
                                    :class="[
                                      'form-control',
                                      {
                                        'is-invalid': validationErrorsEdit.tel2,
                                      },
                                    ]"
                                    id="tel2"
                                    name="tel2"
                                    v-model="tel2Edit"
                                  />
                                  <span
                                    class="invalid-feedback"
                                    v-for="(
                                      err, index
                                    ) in validationErrorsEdit.tel2"
                                    :key="index"
                                    >{{ err }}<br
                                  /></span>
                                </div>
                              </div>
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
                                        'is-invalid':
                                          validationErrorsEdit.localite,
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
                                  <label for="commentaire"
                                    >Commentaire (optionnel):</label
                                  >
                                  <textarea
                                    rows="1"
                                    :class="[
                                      'form-control',
                                      {
                                        'is-invalid':
                                          validationErrorsEdit.commentaire,
                                      },
                                    ]"
                                    id="commentaire"
                                    name="commentaire"
                                    v-model="commentaireEdit"
                                  ></textarea>
                                  <span
                                    class="invalid-feedback"
                                    v-for="(
                                      err, index
                                    ) in validationErrorsEdit.commentaire"
                                    :key="index"
                                    >{{ err }}<br
                                  /></span>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
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
                        Modifier
                      </button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>

          <!----------------------------------------------- End Edit coli------------------------------------------>

          <!-----------------------------------------------Change State------------------------------------------>

          <div class="modal fade" id="affecterLivreur" tabindex="-1">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <div class="d-flex align-items-center">
                    <i class="fa-solid fa-pen fa-xl me-2"></i>
                    <h5 class="modal-title mb-0" id="changeStateLabel">
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
                  <form @submit.prevent="AffecterLivreur(coliEdit.id)">
                    <div class="form-group">
                      <label for="state">Livreurs:</label>
                      <select
                        :class="['form-select', {'is-invalid': validationErrors.livreur_id}]"
                          id="livreur_id"
                          v-model="livreur"
                        >
                        <option value="" disabled selected hidden>Sélectionner un livreur</option>
                          <option
                            v-for="liv in livreurs"
                            :key="liv.id"
                            :value="liv.id"
                          >
                          {{ liv.name }}
                          </option>
                        </select>

                      <span
                        class="invalid-feedback"
                        v-for="(err, index) in validationErrors.etat"
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

          <!----------------------------------------------- End change state------------------------------------------>

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
                <th class="col-2" scope="col">Action par</th>
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


         <!-----------------------------------------------Change Selected State------------------------------------------>

         <div class="modal fade" id="affecterLivreurSelected" tabindex="-1">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <div class="d-flex align-items-center">
                    <i class="fa-solid fa-pen fa-xl me-2"></i>
                    <h5 class="modal-title mb-0" id="changeSelectedStateLabel">
                      Changer l'état des colis sélectionnés
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
                  <form @submit.prevent="AffecterLivreurSelected()">
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
                        v-for="(err, index) in validationErrors.etat"
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

          <!----------------------------------------------- End change selected state------------------------------------------>
        </div>
      </div>
      <br />


      <div class="card mb-4">
        <div class="card-header d-flex align-items-center">
            <i class="fa-solid fa-cube me-2"></i>
          <h5 class="mb-0">Liste des colis</h5>
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
                  <th>#{{ coli.id }} </th>
                  <td>{{ currentDateTime(coli.created_at)}}</td>
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
                    <a id="crudBtn" @click="openEditModal(coli)" class="btn btn-warning m-2"
                      ><i class="fa-solid fa-pen-to-square"></i>
                      <span class="textHover">Modifier</span>
                      </a

                    >

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


      <nav
        aria-label="User pagination"
        v-if="displayedPages.length > 1"
        class="pb-1"
      >
        <ul class="pagination justify-content-end">
          <!-- Previous Page Button -->
          <li id="crudBtn" class="page-item" v-if="currentPage !== 1">
            <a class="page-link shadow" @click="changePage(currentPage - 1)"
              >Précédent</a
            >
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
            <a v-else class="page-link shadow" @click="changePage(page)">{{
              page
            }}</a>
          </li>

          <!-- Next Page Button -->
          <li
            id="crudBtn"
            class="page-item"
            v-if="currentPage !== displayedPages.length"
          >
            <a class="page-link shadow" @click="changePage(currentPage + 1)"
              >Suivant</a
            >
          </li>
        </ul>
      </nav>
    </div>
  </layout_expediteur>
</template>

<script setup>
import layout_expediteur from "../layouts/layoutExpediteur";
import moment from "moment";
import tunisia from "../../../../storage/app/public/json/zip-postcodes.json";
import { checkLoginExpediteur, checkDisabledAccount } from "../../auth";
import { onMounted, ref, computed } from "vue";
import { useRouter } from "vue-router";
import Swal from "sweetalert2";
import axios from "axios";
import { jsPDF } from "jspdf";
import "jspdf-barcode";
import 'jspdf-autotable';
import Vue3Barcode from 'vue3-barcode'

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
  name: "colis_expediteur",
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
      colis: [],
      livreurs:[],

      //create
      listeDelegations: [],
      listeLocalite: [],
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

      //edit
      coliEdit: [],
      //colis
      prix: "",
      Nb_piecesEdit: "",
      designationEdit: "",
      poidEdit: "",
      echangeEdit: "",
      typeEdit: "",
      fragileEdit: "",
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
      livreurs:"",
      state:"",

      //historique
      historiques:[],

      //imprimer
      colisInfo:[],
    };
  },
  mounted() {
    this.user=window.Laravel.user;
    this.get_expediteurs_colis(this.user);
    this.get_all_livreurs();
    // console.log(window.Laravel.user);
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
    displayedColis() {
      const searchLower =
        typeof this.search === "string" ? this.search.toLowerCase() : "";

      return this.colis.filter((coli) => {
        const nom = (coli.nom || "").toLowerCase();
        const id = (coli.id || "").toString().toLowerCase();
        const state = (coli.etat || "").toString().toLowerCase();
        const date = (this.currentDateTime(coli.created_at) || "").toString();
        const gouvernorat = (coli.gouvernorat || "").toLowerCase();
        const delegation = (coli.delegation || "").toLowerCase();
        const localite = (coli.delegation || "").toLowerCase();
        // Perform case-insensitive search
        return nom.includes(searchLower) || id.includes(searchLower)|| state.includes(searchLower)|| date.includes(searchLower)|| delegation.includes(searchLower)|| gouvernorat.includes(searchLower)|| localite.includes(searchLower);
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

    async get_expediteurs_colis(user) {
      try {
        const response = await axios.get(`/api/colis/get_expediteurs_colis/${user.id}`);
        this.colis = response.data.colis;
        console.log(this.colis);
      } catch (error) {
        console.log(error);
      }
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

    async createColis() {
        console.log(window.Laravel.user.id);
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
          expediteur_id:window.Laravel.user.id
        });
        this.prix = "";
        this.Nb_pieces = "1";
        this.designation = "";
        this.poid = "1";
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
        this.get_expediteurs_colis(this.user);
      } catch (error) {
        if (error.response.status === 400) {
          this.validationErrors = error.response.data.errors;
          console.log(this.validationErrors);
        } else {
          this.errorMessage =
            "Une erreur s'est produite lors de la création du colis";
        }
      }
    },

    openEditModal(coli) {
      $("#editColi").modal("show");
      this.validationErrorsEdit = {};
      this.coliEdit = coli;
      this.prixEdit = coli.prix;
      this.Nb_piecesEdit = coli.Nb_pieces;
      this.designationEdit = coli.designation;
      this.poidEdit = coli.poid;
      this.echangeEdit = coli.echange;
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
          this.get_expediteurs_colis(this.user);
          this.coliEdit = [];
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
        } else {
          this.errorMessage =
            "Une erreur s'est produite lors de la mise Ã  jour du colis.";
        }
      } catch (error) {
        if (error.response && error.response.status === 400) {
          this.validationErrorsEdit = error.response.data.errors;
          console.log(this.validationErrorsEdit);
        } else {
          this.errorMessage =
            "Une erreur s'est produite lors de la mise Ã  jour de l'coli.";
        }
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

    openLivreurModal(coli) {
      $("#affecterLivreur").modal("show");
      this.coliEdit=coli;
    },

    openLivreurSelectedModal() {
      $("#affecterLivreurSelected").modal("show");
    },

   async AffecterLivreur(coli_id) {
        try {
        const response = await axios.post(`/api/affectations/affecterLivreur`, {
          colis_id: coli_id,
          livreur_id: this.livreur,
          etat: "Manifest chez livreur",

        });


        if (response.status === 200) {

          this.toast.fire({
            icon: "success",
            title: "Livreur affecté avec succés !",
          });

          $("#affecterLivreur .btn-close").click();
          this.get_expediteurs_colis(this.user);
          this.validationErrors={};
          this.coliEdit = [];
          this.state = "";
        } else {
          this.errorMessage =
            "Une erreur s'est produite lors de la mise Ã  jour du colis.";
        }
      } catch (error) {
        if (error.response && error.response.status === 400) {
          this.validationErrors = error.response.data.errors;
          console.log(this.validationErrors);
        }
        else if (error.response && error.response.status === 422) {
            $("#changeState .btn-close").click();
            this.toast.fire({
            icon: "error",
            title: "Oops...",
            text: "Il y a eu un probléme!",
          });

        }
        else {
          this.errorMessage =
            "Une erreur s'est produite lors de la mise Ã  jour de l'coli.";
        }
      }
  },


  async AffecterLivreurSelected() {
        try {
        const response = await axios.post(`/api/affectations/affecterLivreurSelected`, {
          coliIds: this.selectedColis,
          livreur_id: this.livreur,
          etat: "Manifest chez livreur"

        });

        if (response.status === 200) {

          this.toast.fire({
            icon: "success",
            title: "Livreur affecté avec succés !",
          });

          $("#affecterLivreurSelected .btn-close").click();
          this.get_expediteurs_colis(this.user);
          this.selectedColis=[];
          this.validationErrors={};
        } else {
          this.errorMessage =
            "Une erreur s'est produite lors de la mise Ã  jour du colis.";
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
            text: "Il y a eu un probléme!",
          });

        }
        else {
          this.errorMessage =
            "Une erreur s'est produite lors de la mise Ã  jour de l'coli.";
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
  body:[  [window.Laravel.user.name, window.Laravel.user.entreprise, window.Laravel.user.phone]],
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
  body: [[window.Laravel.user.gouvernorat+"/"+window.Laravel.user.delegation+"/"+window.Laravel.user.localite,window.Laravel.user.address,""]],
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
