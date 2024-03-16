<template>
    <layout_admin v-if="checkLoginStatus() && checkLoginAdmin()">
  <div class="container-fluid">

<!-- 404 Error Text -->
<div class="text-center">
    <div class="error mx-auto" data-text="404">404</div>
    <p class="lead text-gray-800 mb-5">Page Not Found</p>
    <a :href="$router.resolve({ name: 'dashboard-admin' }).href">&larr; Retour au Dashboard</a>
</div>

</div>
</layout_admin>

<layout_expediteur v-if="checkLoginStatus() && checkLoginExpediteur()">
  <div class="container-fluid">

<!-- 404 Error Text -->
<div class="text-center">
    <div class="error mx-auto" data-text="404">404</div>
    <p class="lead text-gray-800 mb-5">Page Not Found</p>
    <a :href="$router.resolve({ name: 'dashboard-expediteur' }).href">&larr; Retour au Dashboard</a>
</div>

</div>
</layout_expediteur>

<layout_livreur v-if="checkLoginStatus() && checkLoginLivreur()">
  <div class="container-fluid">

<!-- 404 Error Text -->
<div class="text-center">
    <div class="error mx-auto" data-text="404">404</div>
    <p class="lead text-gray-800 mb-5">Page Not Found</p>
    <a :href="$router.resolve({ name: 'dashboard-livreur' }).href">&larr; Retour au Dashboard</a>
</div>

</div>
</layout_livreur>


<!-- 404 Error Text -->
<body v-if="!checkLoginStatus()" style="display: flex; justify-content: center; align-items: center; height: 100vh;">
  <div class="container-fluid">
    <div class="d-flex flex-column justify-content-center align-items-center">
      <div class="error" data-text="404">404</div>
      <p class="lead text-gray-800 mb-5">Page Not Found</p>
      <a :href="$router.resolve({ name: 'login' }).href">&larr; Retour à la page de connexion</a>
    </div>
  </div>
</body>



</template>

<script setup>
import layout_admin from "../components/layouts/layoutAdmin";
import layout_expediteur from "../components/layouts/layoutExpediteur";
import layout_livreur from "../components/layouts/layoutLivreur";
import {
  checkLoginStatus,
  checkLoginAdmin,
  checkLoginExpediteur,
  checkLoginLivreur
} from "../auth";
</script>
<script>
export default {

}
</script>

<style>

</style>
