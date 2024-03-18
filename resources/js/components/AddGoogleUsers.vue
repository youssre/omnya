<template>
    <div>
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Add Google User</h4>

                    <div class="page-title-box d-sm-flex">
                        <b-button v-b-modal.modal-center class="btn btn-success mr-1">Import</b-button>
                        <router-link to="viewgoogleusers"><b-button class="btn btn-primary">View Google
                                Users</b-button></router-link>
                    </div>

                    <b-modal id="modal-center" centered title="Import Excel File" hide-footer>
                        <a @click="downloadFile" class="my-4 mb-5" style=" cursor: pointer;">Click to download sample
                            file.</a>

                        <div class="col-sm-12 col-md-6 col-lg-6 mb-3">
                            <label class="form-check-label" for="import_enable_recovery" style="margin-right: 40px;">
                                Want to show recovery email on user page.
                            </label>
                            <input class="form-check-input" type="checkbox" id="import_enable_recovery"
                                v-model="import_enable_recovery">
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-6 mb-3">
                            <label class="form-check-label" for="pop_is_logo_enable" style="margin-right: 23px;">
                                Want to show logo on user page.
                            </label>
                            <input class="form-check-input" type="checkbox" id="pop_is_logo_enable"
                                v-model="is_logo_enable">
                        </div>

                        <div class="col-sm-12 col-md-12 col-lg-12 mb-3">
                            <label class="form-label" for="category_id">Office</label>
                            <v-select v-model="category_id" :options="categories" :reduce="category => category.id"
                                label="category_name"></v-select>
                        </div>

                        <input type="file" ref="fileInput" @change="handleFileChange" />
                        <button class="btn btn-primary" type="button" @click="importData">Import</button>
                        <span v-if="uploading">
                            <b-spinner type="grow" label="Uploading..."></b-spinner>
                        </span>


                        <div class="duplicate-data-div" v-if="duplicateRecords.length > 0">
                            <hr>
                            <h5>Duplicate Record</h5>
                            <div class="duplicate-actions" style="text-align: right;">
                                <button class="btn btn-info btn-sm" @click="exportData">Export to Excel</button>
                            </div>

                            <vue-good-table class="vgt-wrap-dup" mode="remote" :line-numbers="true" :rows="duplicateRecords"
                                :columns="columns">
                                <template slot="table-row" slot-scope="props">
                                    <td v-if="props.column.field === 'email'"
                                        style="border: 0px;padding: 0;width: 80px;margin: 0;">
                                        <label>{{ props.row.email }}</label>
                                    </td>
                                    <td v-if="props.column.field === 'recovery_email'"
                                        style="border: 0px;padding: 0;width: 80px;margin: 0;">
                                        <label>{{ props.row.recovery_email }}</label>
                                    </td>
                                    <td v-if="props.column.field === 'profile_id'"
                                        style="border: 0px;padding: 0;width: 80px;margin: 0;">
                                        <label>{{ props.row.profile_id }}</label>
                                    </td>
                                    <!-- ... other columns -->
                                </template>
                            </vue-good-table>
                        </div>

                    </b-modal>
                </div>
            </div>
        </div>
        <div class="row">

            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">

                        <div id="addproduct-nav-pills-wizard" class="twitter-bs-wizard">

                            <div class="tab-content twitter-bs-wizard-tab-content">
                                <div class="tab-pane active" id="basic-info">


                                    <form @submit.prevent="submitForm" @keydown="form.onKeydown($event)">
                                        <div class="row">

                                            <div class="col-sm-12 col-md-4 col-lg-4 mb-3">
                                                <label class="form-label" for="category_id">Office</label>
                                                <v-select v-model="form.category_id" :options="categories"
                                                    :reduce="category => category.id" label="category_name"></v-select>
                                                <small v-if="form.errors.has('category_id')"
                                                    v-html="form.errors.get('category_id')" class="text-danger"></small>
                                            </div>

                                            <div class="col-sm-12 col-md-4 col-lg-4 mb-3">
                                                <label class="form-label" for="email">Email</label>
                                                <input id="email" name="email" v-model="form.email" type="text"
                                                    class="form-control">
                                                <small v-if="form.errors.has('email')" v-html="form.errors.get('email')"
                                                    class="text-danger">
                                                </small>
                                            </div>

                                            <div class="col-sm-12 col-md-4 col-lg-4 mb-3">
                                                <label class="form-label" for="recovery_email">Recovery Email
                                                    <!-- Add the checkbox input here -->
                                                    (
                                                    <label class="form-check-label" for="enable_recovery"
                                                        style="margin-right: 23px;">
                                                        Want to show this on user page.
                                                    </label>
                                                    <input class="form-check-input" type="checkbox" id="enable_recovery"
                                                        v-model="form.enable_recovery">
                                                    )
                                                </label>
                                                <input id="recovery_email" name="recovery_email"
                                                    v-model="form.recovery_email" type="text" class="form-control">
                                                <small v-if="form.errors.has('recovery_email')"
                                                    v-html="form.errors.get('recovery_email')" class="text-danger"></small>
                                            </div>


                                            <!-- <div class="col-sm-12 col-md-4 col-lg-4 mb-3">
                                                <label class="form-label" for="recovery_email">Recovery Email</label>
                                                <input id="recovery_email" name="recovery_email"
                                                    v-model="form.recovery_email" type="text" class="form-control">
                                                <small v-if="form.errors.has('recovery_email')"
                                                    v-html="form.errors.get('recovery_email')" class="text-danger">
                                                </small>
                                            </div> -->

                                            <div class="col-sm-12 col-md-4 col-lg-4 mb-3">
                                                <label class="form-label" for="plain_password">Password</label>
                                                <input id="plain_password" name="plain_password"
                                                    v-model="form.plain_password" type="text" class="form-control">
                                                <small v-if="form.errors.has('plain_password')"
                                                    v-html="form.errors.get('plain_password')" class="text-danger"> </small>
                                            </div>

                                            <div class="col-sm-12 col-md-4 col-lg-4 mb-3">
                                                <label class="form-check-label" for="is_logo_enable"
                                                    style="margin-right: 23px;">
                                                    Want to show logo on user page.
                                                </label>
                                                <input class="form-check-input" type="checkbox" id="is_logo_enable"
                                                    v-model="form.is_logo_enable">
                                            </div>

                                        </div>
                                        <input type="submit" value="Create Google User" id="userButton" name="userButton"
                                            v-model="userButton" class="btn btn-success" :disabled="form.busy">
                                    </form>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>
<style>
/* Custom CSS to increase the modal size */
#modal-center .modal-dialog {
    max-width: 60%;
    /* Adjust the width as needed */
    max-height: 60%;
    /* Adjust the height as needed */
}

.vgt-wrap-dup {
    overflow-y: scroll !important;
    height: 300px !important;
}
</style>
<script>
import Vue from 'vue'
import vSelect from 'vue-select'
import 'vue-select/dist/vue-select.css';
import { QUESTION_1, QUESTION_2, QUESTION_3 } from '../constants';
Vue.component('v-select', vSelect)
export default {

    data: () => ({
        uploading: false, // Add this property to manage the loading state
        form: new Form({
            category_id: '',
            email: '',
            recovery_email: '',
            plain_password: '',
            enable_recovery: false, // Initial value of the constant
            is_logo_enable: false, // Initial value of the constant
        }),
        columns: [
            {
                label: 'Email',
                field: 'email',
            },
            {
                label: 'Recovery Email',
                field: 'recovery_email',
            },
            {
                label: 'Profile ID',
                field: 'profile_id',
            },
            // Add more columns as needed
        ],

        showModal: false,
        formId: '',
        userButton: 'Create Google User',
        getUserList: [],
        import_enable_recovery: false, // Initial value of the constant
        is_logo_enable: false, // Initial value of the constant
        category_id: '',
        categories: [],
        sampleFileLink: '',
        duplicateRecords: [],
        duplicateRecordsFilePath: '',
        duplicateRecordsFileName: '',
        file: null,
    }),

    methods: {

        async fetchCategory() {
            try {
                const response = await axios.post('/api/get-category');
                this.categories = response.data.data;
            } catch (error) {
                console.error(error);
            }
        },

        exportData() {
            const downloadLink = this.duplicateRecordsFilePath;
            const fileName = this.duplicateRecordsFileName;

            // Trigger the download using JavaScript
            const newWindow = window.open(downloadLink, '_blank');
            if (newWindow) {
                newWindow.addEventListener('load', () => {
                    newWindow.document.title = fileName;
                });
            }
        },

        async downloadFile() {
            this.$Progress.start()
            await axios.post('/api/download-google-sample-file').then(response => {
                console.log(response.data);
                this.sampleFileLink = response.data;

                const downloadLink = response.data;
                const fileName = 'omnya-google-sample-file.xlsx';

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
        openModal() {
            this.showModal = true;
        },
        closeModal() {
            this.showModal = false;
        },

        handleFileChange(event) {
            this.file = event.target.files[0];
        },
        async importData() {
            this.uploading = true; // Set the uploading state to true
            this.import_enable_recovery = this.import_enable_recovery ? 1 : 0;
            this.is_logo_enable = this.is_logo_enable ? 1 : 0;
            const formData = new FormData();
            formData.append("file", this.file);
            formData.append("category_id", this.category_id);
            formData.append("import_enable_recovery", this.import_enable_recovery);
            formData.append("is_logo_enable", this.is_logo_enable);

            await axios
                .post("/api/googleUser/import", formData, {
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
                    if (response.data.duplicateRecordsFilePath) {
                        this.duplicateRecords = response.data.duplicateRecordsFilePath;
                        this.duplicateRecordsFilePath = response.data.filePath.filePath.downloadLink;
                        this.duplicateRecordsFileName = response.data.filePath.filePath.fileName;
                    }
                    // this.closeModal();
                    // this.$router.push('/viewUser');

                })
                .catch(error => {
                    console.error(error);
                });
            this.uploading = false; // Set the uploading state to false once upload is complete
            this.closeModal();
        },

        async submitForm() {
            this.$Progress.start()
            this.form.enable_recovery = this.form.enable_recovery ? 1 : 0;
            this.form.is_logo_enable = this.form.is_logo_enable ? 1 : 0;
            await this.form.post('/api/add-google-user').then(response => {
                this.$Progress.finish()
                Swal.fire({

                    icon: 'success',
                    title: 'User has successfully been updated!',
                    showConfirmButton: false,
                    timer: 2500
                })
            });
            this.$router.push('/viewgoogleusers');
        },

    },
    created() {
        this.fetchCategory();
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












