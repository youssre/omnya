<template>
    <div>
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Update Google User</h4>

                    <div class="page-title-box d-sm-flex">
                        <router-link to="../viewGoogleUsers"><b-button class="btn btn-primary">View Google
                                Users</b-button></router-link>
                    </div>

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
                                                    v-html="form.errors.get('recovery_email')" class="text-danger">
                                                </small>
                                            </div>


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
                                        <input type="submit" value="Update Google User" id="userButton" name="userButton"
                                            v-model="form.userButton" class="btn btn-success" :disabled="form.busy">
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

<script>
import Vue from 'vue'
import vSelect from 'vue-select'
import 'vue-select/dist/vue-select.css';
import { QUESTION_1, QUESTION_2, QUESTION_3 } from '../constants';
Vue.component('v-select', vSelect)
export default {
    data: () => ({
        form: new Form({
            recovery_email: '',
            enable_recovery: false, // Initial value of the constant
            is_logo_enable: false, // Initial value of the constant
            category_id: '',
            email: '',
            plain_password: '',
            formId: '',
            userButton: 'Update Google User',
        }),
        getUserList: [],
        category_id: '',
        categories: [],
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

        async get_user_to_update() {
            const profile_id = { profile_id: this.$route.params.profile_id };
            await axios.post('/api/get-google-user-single', profile_id).then(response => {
                this.getUserList = response.data;
                this.form.category_id = this.getUserList.category_id;
                this.form.plain_password = this.getUserList.plain_password;
                this.form.recovery_email = this.getUserList.recovery_email;
                this.form.enable_recovery = this.getUserList.is_recovery_enable;
                this.form.is_logo_enable = this.getUserList.is_logo_enable;
                this.form.email = this.getUserList.email;
                this.form.formId = this.getUserList.id;
            });

            this.form.userButton = 'Update Google User';
            // this.form.fill(this.getUserList[$id]);

        },

    },
    created() {
        this.fetchCategory();
        this.get_user_to_update();
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
