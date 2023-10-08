<template >
    <layout_expediteur>
        <div
      class="d-sm-flex align-items-center justify-content-between mb-4"
      v-if="!checkDisabledAccount()"
    >
      <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    </div>

    <div v-else>
      <div v-if="checkDisabledAccount()" class="alert alert-danger">
        Votre compte est temporairement désactivé. <br />Veuillez nous contacter
        pour résoudre ce problème.
      </div>
    </div>
    </layout_expediteur>
</template>

<script setup>
import layout_expediteur from "../layouts/layoutExpediteur.vue";
import {
    checkLoginExpediteur,checkDisabledAccount
  } from "../../auth";
</script>

<script>
export default {
    name: "dashboard-expediteur",
    //check auth
    beforeRouteEnter(to, from, next) {
      if (checkLoginExpediteur()) {
        next();
      } else {
        next("/");
      }
    },
    data() {
        return {
            name: null,
        }
    },
    created() {
        if (window.Laravel.user) {
            this.name = window.Laravel.user.name
        }
    },
}
</script>
