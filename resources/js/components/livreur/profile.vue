<template>
    <layout_livreur>
      <div class="container-xl px-4">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
          <h1 class="h3 mb-0 text-gray-800">Profile</h1>
        </div>

        <div class="row">
          <div class="col-xl-12">
            <!-- Account details card-->
            <div class="card mb-4">
              <div class="card-header">
                <ul class="nav nav-pills" id="pills-tab" role="tablist">
                  <li class="nav-item" role="presentation">
                    <button
                      class="nav-link active"
                      id="pills-profile-tab"
                      data-bs-toggle="pill"
                      data-bs-target="#pills-security"
                      type="button"
                      role="tab"
                      aria-controls="pills-security"
                      aria-selected="true"
                    >
                      Sécurité
                    </button>
                  </li>
                </ul>
              </div>
              <div class="card-body">
                <div class="tab-content" id="pills-tabContent">
                  <div
                    class="tab-pane fade show active"
                    id="pills-security"
                    role="tabpanel"
                    aria-labelledby="pills-profile-tab"
                  >
                    <form @submit.prevent="updatePassword(user)">
                        <div class="mb-3">
                        <label class="small mb-1" for="email"
                          >Adresse Email</label
                        >
                        <input
                          class="form-control"
                          id="email"
                          rows="4"
                          v-model="email"
                          disabled
                        />
                      </div>

                      <div class="mb-3">
                        <label class="small mb-1" for="old_password"
                          >Mot de passe actuel</label
                        >
                        <input
                          type="password"
                          class="form-control"
                          id="old_password"
                          rows="4"
                          placeholder="Mot de passe actuel"
                          v-model="old_password"
                          required
                        />
                      </div>

                      <div class="row gx-3 mb-3">
                        <!-- Form Group (organization name)-->
                        <div class="col-md-6">
                          <label class="small mb-1" for="new_password"
                            >Nouveau mot de passe</label
                          >
                          <input
                            class="form-control"
                            id="new_password"
                            type="password"
                            placeholder="Nouveau mot de passe"
                            v-model="new_password"
                            minlength="8"
                            required
                          />
                        </div>
                        <!-- Form Group (location)-->
                        <div class="col-md-6">
                          <label class="small mb-1" for="password_confirmation"
                            >Confirmez votre nouveau mot de passe</label
                          >
                          <input
                            class="form-control"
                            id="password_confirmation"
                            type="password"
                            placeholder="Confirmez votre nouveau mot de passe"
                            v-model="password_confirmation"
                            minlength="8"
                            required
                          />
                        </div>
                      </div>

                      <!-- Save changes button-->
                      <button class="btn btn-primary" type="submit">
                        Modifier
                      </button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
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
    name: "profile_livreur",
    //check auth
    beforeRouteEnter(to, from, next) {
      if (checkLoginLivreur() && !checkDisabledAccount()) {
        next();
      } else {
        next("/");
      }
    },

    created() {
      if (window.Laravel.user) {
        this.user = window.Laravel.user;
        this.email = window.Laravel.user.email;
        this.password = window.Laravel.user.password;
        this.role = window.Laravel.user.role;
        this.id = window.Laravel.user.id;
      }
    },

    data() {
      return {
        validationErrorsEdit:{},
        formSubmitted: false,
        user: {},
        role: null,
        id: "",
        name: "",
        email: "",
        password: "",
        password_confirmation: "",
        society: "",
        type_ind: "",
        N_responsable: "",
        selectedCountry: "",
        selectedState: "",
        states: [],
        address: "",
        password: "",
        old_password: "",
        new_password: "",
        password_confirmation: "",
      };
    },

    methods: {


      async updatePassword(user) {
    try {
      // Perform an API call to check if the old password is correct
      const response = await this.$axios.post(
        `/api/user/verifyOldPassword/${user.id}`,
        {
          old_password: this.old_password,
        }
      );

      if (response.data.success) {
        console.log("Old password is correct.");
        if (this.new_password == this.password_confirmation) {
          try {
            await axios.put(`/api/user/updatePassword/${user.id}`, {
              new_password: this.new_password,
            });
            this.old_password = "";
            this.new_password = "";
            this.password_confirmation = "";

            // this.$router.push("/profile");
            // window.location.reload();

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
              title: "Mot de passe mis à jour avec succès!",
            });
          } catch (error) {
            console.error("Error updating password:", error);
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
              icon: "error",
              title: "Une erreur s'est produite lors de la mise à jour du mot de passe.",
            });
          }
        } else {
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
              icon: "error",
              title: "Une erreur s'est produite lors de la mise à jour du mot de passe.",
            });
        }
      } else {
        console.log("Old password is incorrect.");
      }
    } catch (error) {
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
              icon: "error",
              title: "Ancien mot de passe ne correspond pas!",
            });
    }
  },

    },
  };
  </script>

  <style>
  </style>
