<template>
    <div>
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Import Excel File</h4>
                </div>
            </div>
        </div>


        <div class="row">

            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">

                        <div id="addproduct-nav-pills-wizard" class="twitter-bs-wizard">

                            <div class="tab-content twitter-bs-wizard-tab-content justify-content-md-center">
                                <div class="tab-pane active" id="basic-info" style="text-align: center;">
                                    <a @click="downloadFile" class="my-4 mb-5 btn btn-rounded btn-primary"
                                        style=" cursor: pointer;">Click to download
                                        sample
                                        file.</a>
                                    <br>

                                    <!-- <div class="offset-md-3 col-sm-6 col-md-6 col-lg-6 mb-3">
                                        <label class="form-label" for="category_id">Category</label>
                                        <v-select v-model="category_id" :options="categories"
                                            :reduce="category => category.id" label="category_name"></v-select>
                                    </div> -->

                                    <!-- <div class="offset-md-3 col-sm-6 col-md-6 col-lg-6 mb-3">
                                        <label class="form-label" for="category_id">Category</label>
                                        <select id="category_id" name="category_id" v-model="category_id" type="text"
                                            class="form-control">
                                            <option value="">Select a category</option>
                                            <option v-for="(category, index) in categories" :key="index"
                                                :value="category.id">
                                                {{ category.category_name }}

                                            </option>
                                        </select>
                                    </div> -->


                                    <input type="file" ref="fileInput" @change="handleFileChange" />
                                    <button class="btn btn-success" type="button" @click="importData">Import</button>
                                    <span v-if="uploading">
                                        <b-spinner type="grow" label="Uploading..."></b-spinner>
                                    </span>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>

export default {
    data: () => ({
        uploading: false, // Add this property to manage the loading state
        showModal: false,
        sampleFileLink: '',
        // categories: [],
        // category_id: '',
        file: null,
    }),

    methods: {
        // async fetchCategory() {
        //     try {
        //         const response = await axios.post('/api/get-category');
        //         this.categories = response.data.data;
        //     } catch (error) {
        //         console.error(error);
        //     }
        // },

        handleFileChange(event) {
            this.file = event.target.files[0];
        },

        async downloadFile() {
            this.$Progress.start()
            await axios.post('/api/download-import-sample-file').then(response => {
                console.log(response.data);
                this.sampleFileLink = response.data;

                const downloadLink = response.data;
                const fileName = 'import-sample-file.xlsx';

                // Trigger the download using JavaScript
                const newWindow = window.open(downloadLink, '_blank');
                if (!newWindow) {
                } else {
                    newWindow.addEventListener('load', () => {
                        newWindow.document.title = fileName;
                    });
                }
                this.$Progress.finish()
            });
        },

        async importData() {
            this.$Progress.start();
            this.uploading = true; // Set the uploading state to true

            const formData = new FormData();
            formData.append("file", this.file);
            // formData.append("category_id", this.category_id);

            await axios
                .post("/api/people/import-excel", formData, {
                    headers: {
                        "Content-Type": "multipart/form-data",
                    },
                })
                .then(response => {
                    Swal.fire({

                        icon: 'success',
                        title: 'Data imported successfully!',
                        showConfirmButton: false,
                        timer: 2500
                    });
                    this.$router.push('/viewUser');

                })
                .catch(error => {
                    console.error(error);
                });
            this.uploading = false; // Set the uploading state to false once upload is complete
            this.$Progress.finish();
        },

    },
    created() {
        // this.fetchCategory();
    },
    mounted() {
        console.log('Component mounted.')
    }
}
</script>

<style>
.swal2-container .swal2-title {
    font-size: 16px !important;
    font-weight: 500 !important;
}

.btn-success {
    color: #151f21 !important;
    background-color: #fcd007 !important;
    border-color: #fcd007 !important;
}
</style>












