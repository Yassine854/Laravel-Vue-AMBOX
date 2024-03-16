<template>
  <layout_admin>
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
                    {{ adminsCount }}
                  </div>
                  <div
                    class="text-xs font-weight-bold text-primary text-uppercase mb-1"
                  >
                    Admins
                  </div>

                </div>
                <div class="col-auto">
                  <i class="fa-solid fa-users fa-2x text-gray-300"></i>
                </div>
              </div>
            </div>
          </div>
        </div>

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
                  {{ expediteursCount }}
                  </div>
                  <div
                    class="text-xs font-weight-bold text-primary text-uppercase mb-1"
                  >
                    Expéditeurs
                  </div>
                </div>
                <div class="col-auto">
                  <i class="fa-solid fa-users fa-2x text-gray-300"></i>
                </div>
              </div>
            </div>
          </div>
        </div>

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
                  {{ livreursCount }}
                  </div>
                  <div
                    class="text-xs font-weight-bold text-primary text-uppercase mb-1"
                  >
                    Livreurs
                  </div>

                </div>
                <div class="col-auto">
                  <i class="fa-solid fa-users fa-2x text-gray-300"></i>
                </div>
              </div>
            </div>
          </div>
        </div>

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
    <!-- Top 10 des villes les plus livrées -->
    <div class="col-xl-6 col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    Top 10 des villes les plus livrées
                </h6>
            </div>
            <div class="card-body">
                <div class="chart-bar">
                    <canvas ref="city"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Top 10 des Livreurs les plus performants -->
    <div class="col-xl-6 col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    Top 10 des Livreurs les plus performants
                </h6>
            </div>
            <div class="card-body">
                <div class="chart-bar">
                    <canvas ref="liv"></canvas> <!-- Adjust the ref name if needed -->
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
  </layout_admin>
</template>

<script setup>
import layout_admin from "../layouts/layoutAdmin";
import { checkLoginAdmin, checkDisabledAccount } from "../../auth";
import axios from "axios";
import Chart from 'chart.js/auto';


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


      livreurBarChartArray: [],
      livreurBarChartData: {
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
    this.fetchAdminsCount();
    this.fetchExpediteursCount();
    this.fetchLivreursCount();
    this.fetchTotalColisCount();
    this.fetchColisAttenteCount();
    this.fetchColisEnDepotCount();
    this.fetchRetourDepotCount();
    this.fetchEncoursCount();
    this.fetchColisLivreCount();
    this.fetchRetourDefinitifCount();
    this.cityBarChart();
    this.livreurBarChart();
  },
  created() {
    if (window.Laravel.user) {
      this.name = window.Laravel.user.name;
    }
  },

  methods:{
    async cityBarChart() {
      try {
        const response = await axios.get("/api/dashboard/cityBarChart");
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





    async livreurBarChart() {
      try {
        const response = await axios.get("/api/dashboard/topLivreurBarChart");
        this.livreurBarChartArray = response.data.colis;
console.log(this.livreurBarChartArray);
        this.livreurBarChartArray.forEach((data) => {
        this.livreurBarChartData.labels.push(data.livreur.name);
        this.livreurBarChartData.datasets[0].data.push(data.colis_count);
        });

      const ctx = this.$refs.liv.getContext('2d');
      new Chart(ctx, {
        type: 'bar',
        data: this.livreurBarChartData,
        options: {
    responsive: true,
    maintainAspectRatio: false,
    scales: {
      x: {
        beginAtZero: true,
        title: {
          display: true,
          text: 'Livreurs',
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



    fetchAdminsCount() {
      axios
        .get("/api/dashboard/fetchAdminsCount")
        .then((response) => {
          this.adminsCount = response.data.adminsCount;
        })
        .catch((error) => {
          console.error("Error fetching admins count:", error);
        });
    },

    fetchExpediteursCount() {
      axios
        .get("/api/dashboard/fetchExpediteursCount")
        .then((response) => {
          this.expediteursCount = response.data.expediteursCount;
        })
        .catch((error) => {
          console.error("Error fetching expediteurs count:", error);
        });
    },

    fetchLivreursCount() {
      axios
        .get("/api/dashboard/fetchLivreursCount")
        .then((response) => {
          this.livreursCount = response.data.livreursCount;
        })
        .catch((error) => {
          console.error("Error fetching livreurs count:", error);
        });
    },

    fetchTotalColisCount() {
      axios
        .get("/api/dashboard/fetchTotalColisCount")
        .then((response) => {
          this.totalColisCount = response.data.totalColisCount;
        })
        .catch((error) => {
          console.error("Error fetching total colis count:", error);
        });
    },

    fetchColisAttenteCount() {
      axios
        .get("/api/dashboard/fetchColisAttenteCount")
        .then((response) => {
          this.colisAttenteCount = response.data.colisAttenteCount;
        })
        .catch((error) => {
          console.error("Error fetching colisAttenteCount :", error);
        });
    },

    fetchColisEnDepotCount() {
      axios
        .get("/api/dashboard/fetchColisEnDepotCount")
        .then((response) => {
          this.colisEnDepotCount = response.data.colisEnDepotCount;
        })
        .catch((error) => {
          console.error("Error fetching colisEnDepotCount :", error);
        });
    },

    fetchRetourDepotCount() {
      axios
        .get("/api/dashboard/fetchRetourDepotCount")
        .then((response) => {
          this.retourDepotCount = response.data.retourDepotCount;
        })
        .catch((error) => {
          console.error("Error fetching retourDepotCount:", error);
        });
    },

    fetchEncoursCount() {
      axios
        .get("/api/dashboard/fetchEncoursCount")
        .then((response) => {
          this.EncoursCount = response.data.EncoursCount;
        })
        .catch((error) => {
          console.error("Error fetching retourDepotCount :", error);
        });
    },

    fetchColisLivreCount() {
      axios
        .get("/api/dashboard/fetchColisLivreCount")
        .then((response) => {
          this.colisLivreCount = response.data.colisLivreCount;
        })
        .catch((error) => {
          console.error("Error fetching colisLivreCount", error);
        });
    },

    fetchRetourDefinitifCount() {
      axios
        .get("/api/dashboard/fetchRetourDefinitifCount")
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
