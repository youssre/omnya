<template>
    <div>
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Dashboard</h4>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12">

                <content-placeholders v-show="loader">
                    <content-placeholders-text :lines="3" />
                </content-placeholders>
                <span v-show="content">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card" style='height: 110px'>
                                <router-link to="viewUser">
                                    <div class="card-body">
                                        <div class="d-flex">
                                            <div class="flex-1 overflow-hidden">
                                                <p class="text-truncate font-size-14 mb-2" style="color: #000">
                                                    Number of Users
                                                </p>
                                                <h4 class="mb-0">{{ totalpeoples }}</h4>
                                            </div>
                                            <div class="text-primary ms-auto">
                                                <img src="/public/admin/assets/images/1.svg" width="50" height="50"
                                                    alt="img" />
                                            </div>
                                        </div>
                                    </div>
                                </router-link>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card" style='height: 110px'>
                                <router-link to="viewUser">
                                    <div class="card-body">
                                        <div class="d-flex">
                                            <div class="flex-1 overflow-hidden">
                                                <p class="text-truncate font-size-14 mb-2" style="color: #000">
                                                    Number of Google Users
                                                </p>
                                                <h4 class="mb-0">{{ totalgoogleuser }}</h4>
                                            </div>
                                            <div class="text-primary ms-auto">
                                                <img src="/public/admin/assets/images/1.svg" width="50" height="50"
                                                    alt="img" />
                                            </div>
                                        </div>
                                    </div>
                                </router-link>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card" style='height: 110px'>
                                <div class="card-body">
                                    <div class="d-flex">
                                        <div class="flex-1 overflow-hidden">
                                            <p class="text-truncate font-size-14 mb-2" style="color: #000">
                                                Backup Database
                                            </p>
                                            <button class="btn btn-danger d-block w-50" @click="exportDatabase()">
                                                <i class="bi bi-cloud-download"></i>
                                            </button>
                                        </div>
                                        <div class="text-primary ms-auto">
                                            <img src="/public/admin/assets/images/cloud-download.svg" width="50" height="50"
                                                alt="img" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <div class="flex-1 overflow-hidden">
                                            <p class="text-truncate font-size-14 mb-2" style="color: #000">
                                                Import Database
                                            </p>
                                            <div>
                                                <input class="mb-2" type="file" ref="sqlFileInput"
                                                    @change="handleFileUpload" accept=".sql" />
                                                <button class="btn btn-danger d-block w-50" @click="uploadSQLFile">
                                                    <i class="bi bi-cloud-upload-fill"></i></button>
                                                <span v-if="uploading">
                                                    <b-spinner type="grow" label="Uploading..."></b-spinner>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="text-primary ms-auto">
                                            <img src="/public/admin/assets/images/cloud-upload.svg" width="50" height="50"
                                                alt="img" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </span>
                <!-- end row -->
            </div>
        </div>
    </div>
</template>

<script>
export default {

    data: () => ({
        uploading: false, // Add this property to manage the loading state
        totalpeoples: '',
        totalgoogleuser: '',
        getprodspecdata: '',
        box_styles: '',
        get_quotes: '',
        loader: true,
        content: false,
        selectedFile: null,
    }),

    methods: {

        async exportDatabase() {
            try {

                const response = await axios.post("/api/exportDatabase");
                const downloadLink = response.data.downloadLink;
                const fileName = response.data.fileName;

                // Trigger the download using JavaScript
                const newWindow = window.open(downloadLink, '_blank');
                if (newWindow) {
                    newWindow.addEventListener('load', () => {
                        newWindow.document.title = fileName;
                    });
                }
            } catch (error) {
                console.error(error);
                alert("Error exporting data");
            }
        },

        getUsers() {
            axios.post('/api/peoples-count').then((response) => {

                this.totalpeoples = response.data.peoples;
                this.totalgoogleuser = response.data.google_users;
                this.loader = false;
                this.content = true;
            })
                .catch(function (error) {
                    console.log(error);
                });
        },

        handleFileUpload(event) {
            this.selectedFile = event.target.files[0];
        },
        async uploadSQLFile() {
            this.uploading = true; // Set the uploading state to true

            if (!this.selectedFile) {
                this.uploading = false;
                console.error("No file selected");
                Swal.fire({
                    icon: 'warning',
                    title: 'No file selected!',
                    showConfirmButton: false,
                    timer: 2500
                });
                return;
            }

            const fileExtension = this.selectedFile.name.split(".").pop();
            if (fileExtension !== "sql") {
                this.uploading = false;
                console.error("Invalid file type. Only .sql files are allowed.");
                Swal.fire({
                    icon: 'warning',
                    title: 'Invalid file type. Only .sql files are allowed.',
                    showConfirmButton: false,
                    timer: 2500
                });
                return;
            }

            const formData = new FormData();
            formData.append("sqlFile", this.selectedFile);

            try {
                const response = await axios.post("/api/importDatabase", formData, {
                    headers: {
                        "Content-Type": "multipart/form-data",
                    },
                });
                console.log(response);
                Swal.fire({
                    icon: 'success',
                    title: 'Data imported successfully!',
                    showConfirmButton: false,
                    timer: 2500
                });
            } catch (error) {
                console.error(error);
            }

            this.uploading = false;
        }

    },
    created() {
        this.getUsers();
    },
    mounted() {
        console.log('Component mounted.')
    }
}
</script>

<style scoped>
.custom-icons {
    width: 70px !important;
    height: 70px !important;
    border-radius: 50% !important;
    background-color: #151f21 !important;
}

.icon-holder {
    font-size: 24px !important;
    margin: auto;
    display: block;
    width: 23px;
    margin-top: 17px;
    color: #fcd007 !important;
}
</style>
