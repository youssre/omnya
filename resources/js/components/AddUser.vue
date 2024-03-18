<template>
    <div>
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Add User</h4>

                    <div class="page-title-box d-sm-flex">
                        <b-button v-b-modal.modal-center class="btn btn-success mr-1">Import</b-button>
                        <router-link to="viewUser"><b-button class="btn btn-primary">View Users</b-button></router-link>
                    </div>

                    <b-modal id="modal-center" centered title="Import Excel File" hide-footer>
                        <a @click="downloadFile" class="my-4 mb-5" style=" cursor: pointer;">Click to download sample
                            file.</a>

                        <div class="col-sm-6 col-md-6 col-lg-6 mb-3">
                            <label class="form-check-label" for="import_enable_recovery" style="margin-right: 40px;">
                                Want to show recovery email on user page.
                            </label>
                            <input class="form-check-input" type="checkbox" id="import_enable_recovery"
                                v-model="import_enable_recovery">
                        </div>

                        <div class="col-sm-6 col-md-6 col-lg-6 mb-3">
                            <label class="form-check-label" for="is_logo_enable" style="margin-right: 40px;">
                                Want to show logo on user page.
                            </label>
                            <input class="form-check-input" type="checkbox" id="is_logo_enable" v-model="is_logo_enable">
                        </div>

                        <div class="col-sm-12 col-md-12 col-lg-12 mb-3">
                            <label class="form-label" for="category_id">Office</label>
                            <v-select v-model="category_id" :options="categories" :reduce="category => category.id"
                                label="category_name"></v-select>

                            <!--<select id="category_id" name="category_id" v-model="category_id" type="text"
                                class="form-control">
                                <option value="">Select a category</option>
                                <option v-for="(category, index) in categories" :key="index" :value="category.id">
                                    {{ category.category_name }}
                                    Assuming each category has an 'id' and 'name' property
                                </option>
                            </select> -->
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
                                    <td v-if="props.column.field === 'first_name'"
                                        style="border: 0px;padding: 0;width: 80px;margin: 0;">
                                        <label>{{ props.row.first_name }}</label>
                                    </td>
                                    <td v-if="props.column.field === 'last_name'"
                                        style="border: 0px;padding: 0;width: 80px;margin: 0;">
                                        <label>{{ props.row.last_name }}</label>
                                    </td>
                                    <td v-if="props.column.field === 'email'"
                                        style="border: 0px;padding: 0;width: 80px;margin: 0;">
                                        <label>{{ props.row.email }}</label>
                                    </td>
                                    <td v-if="props.column.field === 'date_of_birth'"
                                        style="border: 0px;padding: 0;width: 80px;margin: 0;">
                                        <label>{{ props.row.date_of_birth }}</label>
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

                                            <!-- <div class="col-sm-12 col-md-3 col mb-3">
                                                <label class="form-label" for="username">Username</label>
                                                <input id="username" name="username" v-model="form.username" type="text"
                                                    class="form-control">
                                                <small v-if="form.errors.has('username')"
                                                    v-html="form.errors.get('username')" class="text-danger"> </small>
                                            </div> -->

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
                                                    v-html="form.errors.get('recovery_email')" class="text-danger">
                                                </small>
                                            </div>

                                            <div class="col-sm-12 col-md-4 col-lg-4 mb-3">
                                                <label class="form-label" for="password">Password</label>
                                                <input id="password" name="password" v-model="form.password" type="text"
                                                    class="form-control">
                                                <small v-if="form.errors.has('password')"
                                                    v-html="form.errors.get('password')" class="text-danger"> </small>
                                            </div>

                                            <div class="col-sm-12 col-md-4 col-lg-4 mb-3">
                                                <label class="form-label" for="a1">{{ form.q1 }}</label>
                                                <input id="a1" name="a1" v-model="form.a1" type="text" class="form-control">
                                                <small v-if="form.errors.has('a1')" v-html="form.errors.get('a1')"
                                                    class="text-danger"></small>
                                            </div>

                                            <!-- Add more hidden fields to the data object -->
                                            <div class="col-sm-12 col-md-4 col-lg-4 mb-3">
                                                <label class="form-label" for="a2">{{ form.q2 }}</label>
                                                <input id="a2" name="a2" v-model="form.a2" type="text" class="form-control">
                                                <small v-if="form.errors.has('a2')" v-html="form.errors.get('a2')"
                                                    class="text-danger"></small>
                                            </div>

                                            <div class="col-sm-12 col-md-4 col-lg-4 mb-3">
                                                <label class="form-label" for="a3">{{ form.q3 }}</label>
                                                <input id="a3" name="a3" v-model="form.a3" type="text" class="form-control">
                                                <small v-if="form.errors.has('a3')" v-html="form.errors.get('a3')"
                                                    class="text-danger"></small>
                                            </div>

                                            <div class="col-sm-12 col-md-4 col-lg-4 mb-3">
                                                <label class="form-label" for="date_of_birth">Date Of
                                                    Birth</label>
                                                <input id="date_of_birth" name="date_of_birth" v-model="form.date_of_birth"
                                                    type="date" class="form-control">
                                                <small v-if="form.errors.has('date_of_birth')"
                                                    v-html="form.errors.get('date_of_birth')" class="text-danger"> </small>
                                            </div>

                                            <div class="col-sm-12 col-md-4 col-lg-4 mb-3">
                                                <label class="form-check-label" for="is_logo_enable"
                                                    style="margin-right: 23px;">
                                                    Want to show logo on user page.
                                                </label>
                                                <input class="form-check-input" type="checkbox" id="is_logo_enable"
                                                    v-model="form.is_logo_enable">
                                            </div>

                                            <!-- <div class="col-sm-12 col-md-4 col-lg-4 mb-3">
                                                <label class="form-label" for="first_name">First
                                                    Name</label>
                                                <input id="first_name" name="first_name" v-model="form.first_name"
                                                    type="text" class="form-control">
                                                <small v-if="form.errors.has('first_name')"
                                                    v-html="form.errors.get('first_name')" class="text-danger"> </small>
                                            </div>

                                            <div class="col-sm-12 col-md-4 col-lg-4 mb-3">
                                                <label class="form-label" for="last_name">Last Name</label>
                                                <input id="last_name" name="last_name" v-model="form.last_name" type="text"
                                                    class="form-control">
                                                <small v-if="form.errors.has('last_name')"
                                                    v-html="form.errors.get('last_name')" class="text-danger"> </small>
                                            </div> -->

                                        </div>
                                        <input type="submit" value="Create User" id="userButton" name="userButton"
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
            // first_name: '',
            // last_name: '',
            email: '',
            enable_recovery: false, // Initial value of the constant
            is_logo_enable: false, // Initial value of the constant
            recovery_email: '',
            password: '',
            // username: '',
            date_of_birth: '',
            q1: QUESTION_1,
            a1: '',
            q2: QUESTION_2,
            a2: '',
            q3: QUESTION_3,
            a3: '',
        }),

        columns: [
            // {
            //     label: 'First Name',
            //     field: 'first_name',
            // },
            // {
            //     label: 'Last Name',
            //     field: 'last_name',
            // },
            {
                label: 'Recovery Email',
                field: 'recovery_email',
            },
            {
                label: 'Email',
                field: 'email',
            },
            {
                label: 'Date Of Birth',
                field: 'date_of_birth',
            },

            // Add more columns as needed
        ],

        showModal: false,
        formId: '',
        categories: [],
        category_id: '',
        userButton: 'Create User',
        import_enable_recovery: false, // Initial value of the constant
        is_logo_enable: false, // Initial value of the constant
        getUserList: [],
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
            await axios.post('/api/download-sample-file').then(response => {
                console.log(response.data);
                this.sampleFileLink = response.data;

                const downloadLink = response.data;
                const fileName = 'sample-file.xlsx';

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

            const formData = new FormData();
            this.import_enable_recovery = this.import_enable_recovery ? 1 : 0;
            this.is_logo_enable = this.is_logo_enable ? 1 : 0;
            formData.append("file", this.file);
            formData.append("category_id", this.category_id);
            formData.append("import_enable_recovery", this.import_enable_recovery);
            formData.append("is_logo_enable", this.is_logo_enable);

            await axios
                .post("/api/people/import", formData, {
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
            await this.form.post('/api/add-people').then(response => {
                this.$Progress.finish()
                Swal.fire({

                    icon: 'success',
                    title: 'User has successfully been updated!',
                    showConfirmButton: false,
                    timer: 2500
                })
            });
            this.$router.push('/viewUser');
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












