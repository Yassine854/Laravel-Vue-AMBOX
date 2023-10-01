<template >
    <layout_expediteur>
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>

        </div>
        Welcome {{ name }}
    </layout_expediteur>
</template>

<script setup>
import layout_expediteur from "../layouts/layoutExpediteur.vue";
import {
    checkLoginExpediteur,
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
