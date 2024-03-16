<template>


  <div class="container d-flex flex-column">
    <div class="row align-items-center justify-content-center min-vh-100">
      <div class="col-12 col-md-8 col-lg-8">
        <div class="card shadow-sm">
            <div class="card card-outline-secondary">
    <div class="card-header">
      <h3 class="mb-0">Mot de passe oublié ?</h3>
    </div>
    <div class="card-body">
      <form @submit.prevent="sendPasswordResetEmail()" >
        <div class="form-group">
          <label for="inputResetPasswordEmail">Email</label>
          <input
            type="email"
            class="form-control"
            id="inputResetPasswordEmail"
            required="" v-model="email"
            placeholder="Entrer votre adresse E-mail"
          />
          <span id="helpResetPasswordEmail" class="form-text small text-muted">
            Les instructions de réinitialisation du mot de passe seront envoyées à cette adresse e-mail.
          </span>
        </div>
        <div class="form-group">
          <button type="submit" class="btn btn-success btn-lg float-right">
            Envoyer
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
      email: "",
    };
  },
  methods: {
    async sendPasswordResetEmail() {
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
        const response = await axios.post("/api/password/reset", { email: this.email });

        if (response.status === 200) {
          toast.fire({
            icon: "success",
            title: "Un lien de réinitialisation a été envoyé à votre adresse e-mail !",
          });
        }
      } catch (error) {
        if (error.response.status === 400) {
          toast.fire({
            icon: "error",
            title: "L'adresse e-mail n'existe pas dans notre système !",
          });
        } else {
          this.errorMessage = "Une erreur s'est produite lors de l'envoi du mot de passe.";
        }
      }
    },
  },
};
</script>
