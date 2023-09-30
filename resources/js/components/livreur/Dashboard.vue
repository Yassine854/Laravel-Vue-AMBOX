<template>
    <layout_livreur>
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>

        </div>
        Welcome {{ name }}
    </layout_livreur>
</template>

<script setup>
import layout_livreur from "../layouts/layoutLivreur.vue";
import {
    checkLoginLivreur,
  } from "../../auth";
</script>

<script>
export default {
    name: "dashboard-livreur",
    //check auth
    beforeRouteEnter(to, from, next) {
      if (checkLoginLivreur()) {
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
