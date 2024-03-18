<template>
    <div>
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Update User</h4>

                    <div class="page-title-box d-sm-flex">
                        <router-link to="../viewUser"><b-button class="btn btn-primary">View Users</b-button></router-link>
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

                                                <!--<select id="category_id" name="category_id" v-model="form.category_id"
                                                    type="text" class="form-control">
                                                    <option value="">Select a category</option>
                                                    <option v-for="(category, index) in categories" :key="index"
                                                        :value="category.id">
                                                        {{ category.category_name }}
                                                         Assuming each category has an 'id' and 'name' property
                                                    </option>
                                                </select> -->
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
            category_id: '',
            // first_name: '',
            // last_name: '',
            recovery_email: '',
            enable_recovery: false, // Initial value of the constant
            is_logo_enable: false, // Initial value of the constant
            email: '',
            password: '',
            // username: '',
            date_of_birth: '',
            q1: QUESTION_1,
            a1: '',
            q2: QUESTION_2,
            a2: '',
            q3: QUESTION_3,
            a3: '',
            formId: '',
            userButton: 'Create User',
        }),
        getUserList: [],
        categories: [],
        category_id: '',
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

        async get_user_to_update() {
            const profile_id = { profile_id: this.$route.params.profile_id };
            await axios.post('/api/get-user-single', profile_id).then(response => {
                this.getUserList = response.data;
                this.form.category_id = this.getUserList.category_id;
                this.form.first_name = this.getUserList.first_name;
                this.form.last_name = this.getUserList.last_name;
                // this.form.username = this.getUserList.username;
                this.form.date_of_birth = this.getUserList.date_of_birth;
                this.form.password = this.getUserList.plain_password;
                this.form.recovery_email = this.getUserList.recovery_email;
                this.form.enable_recovery = this.getUserList.is_recovery_enable;
                this.form.is_logo_enable = this.getUserList.is_logo_enable;
                this.form.email = this.getUserList.email;
                this.form.q1 = this.getUserList.q1;
                this.form.a1 = this.getUserList.a1;
                this.form.q2 = this.getUserList.q2;
                this.form.a2 = this.getUserList.a2;
                this.form.q3 = this.getUserList.q3;
                this.form.a3 = this.getUserList.a3;
                this.form.formId = this.getUserList.id;
            });

            this.form.userButton = 'Update User';
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
