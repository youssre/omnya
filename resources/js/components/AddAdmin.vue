<template>
    <div>
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Add Admin</h4>
                    <div class="page-title-box d-sm-flex">
                        <router-link to="viewAdmin"><b-button class="btn btn-primary">View
                                Admin</b-button></router-link>
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
                                            <div class="col-sm-4 col-md-4 col mb-4">
                                                <label class="form-label" for="name">Name</label>
                                                <input id="name" name="name" v-model="form.name" type="text"
                                                    class="form-control">
                                                <small v-if="form.errors.has('name')" v-html="form.errors.get('name')"
                                                    class="text-danger"> </small>
                                            </div>

                                            <div class="col-sm-4 col-md-4 col mb-4">
                                                <label class="form-label" for="email">Email</label>
                                                <input id="email" name="email" v-model="form.email" type="email"
                                                    class="form-control">
                                                <small v-if="form.errors.has('email')" v-html="form.errors.get('email')"
                                                    class="text-danger"> </small>
                                            </div>

                                            <div class="col-sm-4 col-md-4 col mb-4">
                                                <label class="form-label" for="password">Password</label>
                                                <input id="password" name="password" v-model="form.password" type="text"
                                                    class="form-control">
                                                <small v-if="form.errors.has('password')"
                                                    v-html="form.errors.get('password')" class="text-danger"> </small>
                                            </div>

                                        </div>
                                        <input type="submit" value="Add Admin" id="adminButton" name="adminButton"
                                            v-model="adminButton" class="btn btn-success" :disabled="form.busy">
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

export default {
    data: () => ({
        uploading: false, // Add this property to manage the loading state
        form: new Form({
            name: '',
            email: '',
            password: '',
        }),
        adminButton: 'Add Admin'
    }),

    methods: {
        async submitForm() {
            this.$Progress.start()
            await this.form.post('/api/add-admin').then(response => {
                this.$Progress.finish()
                Swal.fire({

                    icon: 'success',
                    title: 'Operation Successfully Done!',
                    showConfirmButton: false,
                    timer: 2500
                })
            });
        },

    },
    created() {

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












