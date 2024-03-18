<template>
    <div>
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Add Office</h4>
                    <div class="page-title-box d-sm-flex">
                        <router-link to="../viewcategory"><b-button class="btn btn-primary">View
                                Office</b-button></router-link>
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
                                            <div class="col-sm-6 col-md-6 col mb-3">
                                                <label class="form-label" for="category_name">Office Name</label>
                                                <input id="category_name" name="category_name" v-model="form.category_name"
                                                    type="text" class="form-control">
                                                <small v-if="form.errors.has('category_name')"
                                                    v-html="form.errors.get('category_name')" class="text-danger"> </small>
                                            </div>
                                            <div class="col-sm-6 col-md-6 col mb-3">
                                                <label class="form-label" for="image">Office Image</label><br>
                                                <input type="file" ref="fileInput" id="image" @change="handleFileChange" />
                                            </div>
                                            <div class="col-sm-12 col-md-12 col mb-3">
                                                <label class="form-label" for="description">Description</label>
                                                <textarea name="description" id="description" v-model="form.description"
                                                    class="form-control">
                                                </textarea>
                                            </div>

                                        </div>
                                        <input type="submit" value="Update Office" id="categoryButton" name="categoryButton"
                                            v-model="categoryButton" class="btn btn-success" :disabled="form.busy">
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
            category_name: '',
            description: '',
        }),
        categoryButton: 'Update Office',
        file: null,
    }),

    methods: {
        handleFileChange(event) {
            this.file = event.target.files[0];
        },
        async submitForm() {
            this.$Progress.start()
            const formData = new FormData();
            formData.append("description", this.form.description);
            formData.append("image", this.file); // Append the selected file
            formData.append("category_name", this.form.category_name);

            await axios.post('/api/add-category', formData, {
                headers: {
                    "Content-Type": "multipart/form-data",
                },
            }).then(response => {

                this.$Progress.finish()
                Swal.fire({

                    icon: 'success',
                    title: 'Operation Successfully Done!',
                    showConfirmButton: false,
                    timer: 2500
                })
            });
        },

        async get_category_to_update() {
            const id = { id: this.$route.params.id };
            await axios.post('/api/get-category-single', id).then(response => {
                this.getUserList = response.data;
                this.form.category_name = this.getUserList.category_name;
                this.form.description = this.getUserList.description;
            });

            this.form.userButton = 'Update Office';
            // this.form.fill(this.getUserList[$id]);

        },

    },
    created() {
        this.get_category_to_update();
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












