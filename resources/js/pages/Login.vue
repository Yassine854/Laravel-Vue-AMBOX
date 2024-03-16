<template>
    <div class="container">
        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
            <div class="d-flex justify-content-center">
            <div class="col-md-8">

                <div class="d-flex justify-content-center">

                <img :src="'../../../../storage/image/logo.png'" style="max-width:120px">
                </div>
             <br>
             <div v-if="error !== null" class="alert alert-danger" role="alert">
                    <strong>{{error}}</strong>
                </div>
                <div class="card card-default">
                    <div class="card-header"><h5>Login</h5></div>
                    <div class="card-body">
                        <form>
                            <div class="form-group row">
                        <label for="identifier" class="col-sm-4 col-form-label text-md-right">Email / Téléphone</label>
                        <div class="col-md-8">
                            <input id="identifier" type="text" class="form-control" v-model="identifier"
                                autofocus placeholder="Entrer votre email ou votre téléphone" required>
                        </div>
                    </div>
                            <br>

                            <div class="form-group row mt-1">
                                <label for="password" class="col-md-4 col-form-label text-md-right">Mot de passe</label>
                                <div class="col-md-8">
                                    <input id="password" type="password" class="form-control" v-model="password"
                                           required autocomplete="off" placeholder="Entrer votre mot de passe">
                                </div>
                            </div>
                            <br>
                            <div class="form-group row mt-1 mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-success" @click="handleSubmit">
                                        Login
                                    </button>
                                </div>
                            </div>

                            <div class="row mt-1">
                                <div class="col-md-8 offset-md-4">
                                    <small class="text-muted">
                                    <router-link to="/forgot-password">Mot de passe oublié ?</router-link>
                                    </small>

                                </div>
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
import {
    checkLoginAdmin,checkLoginExpediteur,checkLoginLivreur
  } from "../auth";
    export default {
        data() {
            return {
                email: "",
                password: "",
                Identifier:"",
                error: null
            }
        },

        methods: {
            handleSubmit(e) {
                e.preventDefault()
                if(this.password.length > 0) {
                    this.$axios.get('/sanctum/csrf-cookie').then(response => {
                        this.$axios.post('api/login', {
                            // phone:this.Identifier,
                            identifier: this.identifier,
                            password: this.password
                        })
                        .then(response => {
                            if (response.data.success) {
                                this.$router.go('/login')
                            } else {
                                this.error = response.data.message
                            }
                        })
                        .catch(function (error) {
                            console.error(error);
                        });
                    })
                }
            }
        },

        beforeRouteEnter(to, from, next) {
            if (window.Laravel.isLoggedin) {
                if (checkLoginAdmin()) {
                    return next('dashboard-admin');
                }
               else if (checkLoginExpediteur()) {
                    return next('dashboard-expediteur');
                }
                else if (checkLoginLivreur()) {
                    return next('dashboard-livreur');

                }
                else{
                    next('/');
                }
            }
            next();
        }
    }
</script>
