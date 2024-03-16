<template>
    <layout_expediteur>
      <div v-if="!checkDisabledAccount()">
        <div class="row">

          <!-- Earnings (Monthly) Card Example -->
          <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
              <div class="card-body">
                <div class="row no-gutters align-items-center">
                  <div class="col mr-2">
                    <div
                      class="text-xs font-weight-bold text-primary text-uppercase mb-1"
                      style="font-size: 24px"
                    >
                    {{ totalColisCount }}
                    </div>
                    <div
                      class="text-xs font-weight-bold text-primary text-uppercase mb-1"
                    >
                      Total des colis
                    </div>
                  </div>
                  <div class="col-auto">
                    <i class="fa-solid fa-boxes-stacked fa-2x text-gray-300"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Pending Requests Card Example -->
          <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
              <div class="card-body">
                <div class="row no-gutters align-items-center">
                  <div class="col mr-2">
                    <div
                      class="text-xs font-weight-bold text-warning text-uppercase mb-1"
                      style="font-size: 24px"
                    >
                    {{ colisAttenteCount }}
                    </div>
                    <div
                      class="text-xs font-weight-bold text-warning text-uppercase mb-1"
                    >
                      Colis en attente
                    </div>

                  </div>
                  <div class="col-auto">
                    <i class="fa-solid fa-cube fa-2x text-gray-300"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Earnings (Monthly) Card Example -->
          <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
              <div class="card-body">
                <div class="row no-gutters align-items-center">
                  <div class="col mr-2">
                    <div
                      class="text-xs font-weight-bold text-info text-uppercase mb-1"
                      style="font-size: 24px"
                    >
                    {{ colisEnDepotCount }}
                    </div>
                    <div
                      class="text-xs font-weight-bold text-info text-uppercase mb-1"
                    >
                      colis au dépôt
                    </div>
                    <div class="row no-gutters align-items-center">
                      <div class="col-auto">

                      </div>
                    </div>
                  </div>
                  <div class="col-auto">
                    <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Earnings (Monthly) Card Example -->
          <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
              <div class="card-body">
                <div class="row no-gutters align-items-center">
                  <div class="col mr-2">
                    <div
                      class="text-xs font-weight-bold text-danger text-uppercase mb-1"
                      style="font-size: 24px"
                    >
                    {{ retourDepotCount }}
                    </div>
                    <div
                      class="text-xs font-weight-bold text-danger text-uppercase mb-1"
                    >
                      Retour au dépôt
                    </div>
                    <div class="row no-gutters align-items-center">
                      <div class="col-auto">

                      </div>
                    </div>
                  </div>
                  <div class="col-auto">
                    <i
                      class="fa-solid fa-building-circle-arrow-right fa-2x text-gray-300"
                    ></i>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Earnings (Monthly) Card Example -->
          <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
              <div class="card-body">
                <div class="row no-gutters align-items-center">
                  <div class="col mr-2">
                    <div
                      class="text-xs font-weight-bold text-info text-uppercase mb-1"
                      style="font-size: 24px"
                    >
                    {{ EncoursCount }}
                    </div>
                    <div
                      class="text-xs font-weight-bold text-info text-uppercase mb-1"
                    >
                      en cours de livraison
                    </div>
                    <div class="row no-gutters align-items-center">
                      <div class="col-auto">

                      </div>
                    </div>
                  </div>
                  <div class="col-auto">
                    <i class="fa-solid fa-truck-fast fa-2x text-gray-300"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Earnings (Monthly) Card Example -->
          <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
              <div class="card-body">
                <div class="row no-gutters align-items-center">
                  <div class="col mr-2">
                    <div
                      class="text-xs font-weight-bold text-success text-uppercase mb-1"
                      style="font-size: 24px"
                    >
                    {{ colisLivreCount }}
                    </div>
                    <div
                      class="text-xs font-weight-bold text-success text-uppercase mb-1"
                    >
                      colis livrés
                    </div>

                  </div>
                  <div class="col-auto">
                    <i class="fa-solid fa-circle-check fa-2x text-gray-300"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Earnings (Monthly) Card Example -->
          <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-dark shadow h-100 py-2">
              <div class="card-body">
                <div class="row no-gutters align-items-center">
                  <div class="col mr-2">
                    <div
                      class="text-xs font-weight-bold text-dark text-uppercase mb-1"
                      style="font-size: 24px"
                    >
                    {{ retourDefinitifCount }}
                    </div>
                    <div
                      class="text-xs font-weight-bold text-dark text-uppercase mb-1"
                    >
                      retour définitif
                    </div>

                  </div>
                  <div class="col-auto">
                    <i
                      class="fa-solid fa-circle-arrow-right fa-2x text-gray-300"
                    ></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-xl-8 col-lg-7">
            <!-- Area Chart -->
            <div class="card shadow mb-4">
              <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                  Top 10 des villes les plus livrés
                </h6>
              </div>
              <div class="card-body">
                <div class="chart-bar">
                  <canvas ref="city"></canvas>
                </div>
              </div>
            </div>
          </div>
        </div>
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
  import layout_expediteur from "../layouts/layoutExpediteur";
  import { checkLoginExpediteur, checkDisabledAccount } from "../../auth";
  import axios from "axios";
  import Chart from 'chart.js/auto';


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
        user: "",
        adminsCount:"",
        expediteursCount:"",
        livreursCount:"",
        totalColisCount:"",
        colisAttenteCount:"",
        colisEnDepotCount:"",
        retourDepotCount:"",
        EncoursCount:"",
        colisLivreCount:"",
        retourDefinitifCount:"",



        cityBarChartArray: [],
        cityBarChartData: {
          labels: [],
          datasets: [
            {
              label:"Nombre de colis livrés",
              data: [],
            },
          ],
        },
      };
    },

    mounted() {
      this.fetchTotalColisCount();
      this.fetchColisAttenteCount();
      this.fetchColisEnDepotCount();
      this.fetchRetourDepotCount();
      this.fetchEncoursCount();
      this.fetchColisLivreCount();
      this.fetchRetourDefinitifCount();
      this.cityBarChart();
    },
    created() {
      if (window.Laravel.user) {
        this.user = window.Laravel.user;
      }
    },

    methods:{
      async cityBarChart() {
        try {
          const response = await axios.get(`/api/dashboard/expediteur_cityBarChart/${this.user.id}`);
          this.cityBarChartArray = response.data.colis;
  console.log(this.cityBarChartArray);
          this.cityBarChartArray.forEach((data) => {
          this.cityBarChartData.labels.push(data.gouvernorat);
          this.cityBarChartData.datasets[0].data.push(data.colis_count);
          });

        const ctx = this.$refs.city.getContext('2d');
        new Chart(ctx, {
          type: 'bar',
          data: this.cityBarChartData,
          options: {
      responsive: true,
      maintainAspectRatio: false,
      scales: {
        x: {
          beginAtZero: true,
          title: {
            display: true,
            text: 'Villes',
          },
        },
        y: {
          beginAtZero: true,
          title: {
            display: true,
            text: "Colis livrés",
          },
          ticks: {
            precision: 0,
          },
          borderWidth: 1

        },
      },
  },
        });

        } catch (error) {
          console.error(error);
        }
      },



      fetchTotalColisCount() {
        axios
          .get(`/api/dashboard/expediteur_fetchTotalColisCount/${this.user.id}`)
          .then((response) => {
            this.totalColisCount = response.data.totalColisCount;
          })
          .catch((error) => {
            console.error("Error fetching total colis count:", error);
          });
      },

      fetchColisAttenteCount() {
        axios
        .get(`/api/dashboard/expediteur_fetchColisAttenteCount/${this.user.id}`)
          .then((response) => {
            this.colisAttenteCount = response.data.colisAttenteCount;
          })
          .catch((error) => {
            console.error("Error fetching colisAttenteCount :", error);
          });
      },

      fetchColisEnDepotCount() {
        axios
        .get(`/api/dashboard/expediteur_fetchColisEnDepotCount/${this.user.id}`)
          .then((response) => {
            this.colisEnDepotCount = response.data.colisEnDepotCount;
          })
          .catch((error) => {
            console.error("Error fetching colisEnDepotCount :", error);
          });
      },

      fetchRetourDepotCount() {
        axios
        .get(`/api/dashboard/expediteur_fetchRetourDepotCount/${this.user.id}`)
          .then((response) => {
            this.retourDepotCount = response.data.retourDepotCount;
          })
          .catch((error) => {
            console.error("Error fetching retourDepotCount:", error);
          });
      },

      fetchEncoursCount() {
        axios
        .get(`/api/dashboard/expediteur_fetchEncoursCount/${this.user.id}`)
          .then((response) => {
            this.EncoursCount = response.data.EncoursCount;
          })
          .catch((error) => {
            console.error("Error fetching retourDepotCount :", error);
          });
      },

      fetchColisLivreCount() {
        axios
        .get(`/api/dashboard/expediteur_fetchColisLivreCount/${this.user.id}`)
          .then((response) => {
            this.colisLivreCount = response.data.colisLivreCount;
          })
          .catch((error) => {
            console.error("Error fetching colisLivreCount", error);
          });
      },

      fetchRetourDefinitifCount() {
        axios
        .get(`/api/dashboard/expediteur_fetchRetourDefinitifCount/${this.user.id}`)
          .then((response) => {
            this.retourDefinitifCount = response.data.retourDefinitifCount;
          })
          .catch((error) => {
            console.error("Error fetching retourDefinitifCount:", error);
          });
      },



    }
  };
  </script>
