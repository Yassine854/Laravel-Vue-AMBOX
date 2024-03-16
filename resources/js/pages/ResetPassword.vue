<template>
    <div class="container d-flex flex-column">
    <div class="row align-items-center justify-content-center min-vh-100">
      <div class="col-12 col-md-8 col-lg-8">
        <div class="card shadow-sm">
            <div class="card card-outline-secondary">
    <div class="card-header">
      <h3 class="mb-0">Réinitialisation du mot de passe</h3>
    </div>
    <div class="card-body">
      <form @submit.prevent="resetPassword" >
        <div class="form-group">
          <label for="password">Nouveau mot de passe</label>
          <input
            type="password"
            class="form-control"
            id="password"
            required="" v-model="password" minlength="8"
            placeholder="Entrer votre nouveau mot de passe"
          />
        </div>
        <div class="form-group">
          <label for="password_confirmation">Confirmation du mot de passe</label>
          <input
            type="password"
            class="form-control"
            id="password_confirmation"
            required="" v-model="passwordConfirmation" minlength="8"
            placeholder="Répéter votre nouveau mot de passe"
          />
        </div>
        <div class="form-group">
          <button type="submit" class="btn btn-success btn-lg float-right">
            Réinitialiser
          </button>
        </div>
      </form>
    </div>
  </div>
        </div>
      </div>
    </div>
  </div>
  </template>

  <script>
  import Swal from "sweetalert2";
  import axios from "axios";
window.Swal = Swal;
  export default {
    data() {
      return {
        password: '',
        passwordConfirmation: '',
      };
    },
    methods: {
        async resetPassword() {
            const toast = Swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        customClass: {
          popup: "colored-toast",
        },
        timer: 8000,
      });
  try {
    const token = this.$route.params.token;
    const email = this.$route.params.email;
    console.log(email);
    console.log(token);
    console.log(this.password);
    console.log(this.passwordConfirmation);

    await axios.post(`/api/password/reset/${token}/${email}`, {
      password: this.password,
      password_confirmation: this.passwordConfirmation,
      token: token,
      email: email,
    });
    this.$router.push("/");
    toast.fire({
          icon: "success",
          title:
            "Mot de passe mis à jour avec succès !",
        });

  } catch (error) {
    toast.fire({
            icon: "error",
            title: "Une erreur s'est produite lors de la mise à jour du mot de passe.",
          });
          console.log(error);
  }
},

    },
  };
  </script>
