<template>
    <div>
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Change Password</h4>
                    <div class="page-title-box d-sm-flex">
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
                                            <div class="col-sm-6 col-md-6 col mb-6">
                                                <label class="form-label" for="password">Password</label>
                                                <input id="password" name="password" v-model="form.password" type="password"
                                                    class="form-control">
                                                <small v-if="form.errors.has('password')"
                                                    v-html="form.errors.get('password')" class="text-danger"> </small>
                                            </div>

                                            <div class="col-sm-6 col-md-6 col mb-6">
                                                <label class="form-label" for="confirmPassword">Confirm
                                                    Password</label>
                                                <input id="confirmPassword" name="confirmPassword" P
                                                    v-model="form.confirmPassword" type="password" class="form-control">
                                                <small v-if="form.errors.has('confirmPassword')"
                                                    v-html="form.errors.get('confirmPassword')" class="text-danger">
                                                </small>
                                            </div>

                                        </div>
                                        <input style="margin-top: 10px;" type="submit" value="Save Password"
                                            id="savePassword" name="savePassword" v-model="savePassword"
                                            class="btn btn-success" :disabled="form.busy || !passwordMatch">
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
            password: '',
            confirmPassword: '',
        }),
        savePassword: 'Save Password',
        passwordsMatch: false,
    }),
    computed: {
        // Compute if passwords match
        passwordMatch() {
            return this.form.password != '' && this.form.confirmPassword != '' && this.form.password === this.form.confirmPassword;
        }
    },
    methods: {

        async submitForm() {
            if (!this.passwordMatch) {
                return; // Don't submit if passwords don't match
            }
            this.$Progress.start()
            await this.form.post('/api/change-password').then(response => {
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












