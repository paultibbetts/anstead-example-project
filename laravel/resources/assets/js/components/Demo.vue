<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-default">
                    <div class="card-header">
                        <h2>Completed Jobs</h2>
                    </div>

                    <div class="card-body">
                        <span v-if="jobs.length === 0">
                            There are no completed jobs
                        </span>
                        <ol v-else>
                            <li v-for="job in jobs">
                                {{ job.created_at }}
                            </li>
                        </ol>
                    </div>

                    <div style="margin: 1rem auto">
                        <button class="add button" v-if="! processing" @click="newJob">
                            New job
                        </button>
                        <button class="remove button" v-if="jobs.length >= 20" @click="removeJobs">
                            Clear
                        </button>
                        <span v-if="processing">
                            <div class="spinner">
                                <div class="double-bounce1"></div>
                                <div class="double-bounce2"></div>
                            </div>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
  data() {
    return {
      jobs: [],
      processing: false,
      polling: null
    };
  },
  methods: {
    newJob() {
      axios
        .post("/jobs")
        .then(res => {
          this.processing = true;
          this.pollForNewJobs();
        })
        .catch(err => console.error(err));
    },
    // <3 https://github.com/laravel/horizon/blob/e5dd662a2f94214fb93ee03be8ae6153f8253b29/resources/assets/js/pages/Dashboard.vue#L109
    pollForNewJobs() {
      this.polling = setInterval(() => {
        this.getJobs();
      }, 1000);
    },
    getJobs() {
      axios
        .get("/jobs")
        .then(({ data }) => this.processJobsData(data))
        .catch(err => console.error(err));
    },
    processJobsData(data) {
      if (!data || data === [] || data.length === this.jobs.length) return;
      this.jobs = data;
      this.processing = false;
      this.polling = null;
    },
    removeJobs() {
      axios
        .post("/delete-jobs")
        .then(res => {
          this.jobs = [];
        })
        .catch(err => console.error(err));
    }
  },
  mounted() {
    this.getJobs();
  }
};
</script>

<style>
ol {
  padding-left: 0;
}
.button {
  border-radius: 2px;
  border: 1px solid transparent;
  color: white;
  cursor: pointer;
  padding: 0.5rem;
  text-transform: uppercase;
}
.add.button {
  background: #4fc08d;
  border-color: #4fc08d;
}
.remove.button {
  background: #fe5e5e;
  border-color: #fe5e5e;
}
/* <3 http://tobiasahlin.com/spinkit/ # 2 */
.spinner {
  width: 2rem;
  height: 2rem;

  position: relative;
  margin: 20px auto;
}

.double-bounce1,
.double-bounce2 {
  width: 100%;
  height: 100%;
  border-radius: 50%;
  background-color: #333;
  opacity: 0.6;
  position: absolute;
  top: 0;
  left: 0;

  -webkit-animation: sk-bounce 2s infinite ease-in-out;
  animation: sk-bounce 2s infinite ease-in-out;
}

.double-bounce2 {
  -webkit-animation-delay: -1s;
  animation-delay: -1s;
}

@-webkit-keyframes sk-bounce {
  0%,
  100% {
    -webkit-transform: scale(0);
  }
  50% {
    -webkit-transform: scale(1);
  }
}

@keyframes sk-bounce {
  0%,
  100% {
    transform: scale(0);
    -webkit-transform: scale(0);
  }
  50% {
    transform: scale(1);
    -webkit-transform: scale(1);
  }
}
</style>
