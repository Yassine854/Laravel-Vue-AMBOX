<template>
  <layout_admin>
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
  </layout_admin>
</template>

<script setup>
import layout_admin from "../layouts/layoutAdmin.vue";
import { checkLoginAdmin, checkDisabledAccount } from "../../auth";
</script>

<script>
export default {
  name: "dashboard-admin",
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
      name: null,
    };
  },
  created() {
    if (window.Laravel.user) {
      this.name = window.Laravel.user.name;
    }
  },
};
</script>
