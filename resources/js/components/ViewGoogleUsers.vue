<template>
    <div>
        <div class="row">
            <div class="col-12">

                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">View Google Users</h4>
                    <div class="page-title-box d-sm-flex">

                        <b-button v-b-modal.modal-center class="btn btn-success mr-1">Filters</b-button>
                        <b-button @click="clearFilter" class="btn btn-danger mr-1">Clear Filters</b-button>

                        <router-link to="addgoogleuser"><b-button class="btn btn-primary">Add Google
                                User</b-button></router-link>
                    </div>
                    <b-modal id="modal-center" size="xl" no-close-on-backdrop centered title="Filters" hide-footer
                        v-model="showModal">
                        <form @submit.prevent="submitForm" @keydown="form.onKeydown($event)">
                            <div class="row">

                                <div class="col-sm-12 col-md-6 col-lg-6 mb-4">
                                    <label class="form-label" for="id">Serial No</label>
                                    <input id="profile_id" name="profile_id" v-model="form.profile_id" type="text"
                                        class="form-control">
                                </div>

                                <div class="col-sm-12 col-md-6 col-lg-6 mb-3">
                                    <label class="form-label" for="category_id">Office</label>
                                    <v-select v-model="form.category_id" :options="categories"
                                        :reduce="category => category.id" label="category_name"></v-select>

                                    <!-- <select id="category_id" name="category_id" v-model="form.category_id" type="text"
                                        class="form-control" select2>
                                        <option value="">Select a category</option>
                                        <option v-for="(category, index) in categories" :key="index" :value="category.id">
                                            {{ category.category_name }}
                                             Assuming each category has an 'id' and 'name' property
                                        </option>
                                    </select> -->
                                    <small v-if="form.errors.has('category_id')" v-html="form.errors.get('category_id')"
                                        class="text-danger"></small>
                                </div>

                                <div class="col-sm-12 col-md-6 col-lg-6 mb-4">
                                    <label class="form-label" for="from">Created From</label>
                                    <input id="from" name="from" v-model="form.from" type="date" class="form-control">
                                </div>


                                <div class="col-sm-12 col-md-6 col-lg-6 mb-4" style="margin-bottom: 10px;">
                                    <label class="form-label" for="to">Created To</label>
                                    <input id="to" name="to" v-model="form.to" type="date" class="form-control">
                                </div>

                            </div>
                            <input type="submit" value="Filter" id="userButton" name="userButton" v-model="userButton"
                                class="btn btn-success" :disabled="form.busy">
                            <!-- <input type="button" value="Clear" @click="clearFilter" id="clearButton" name="clearButton"
                                v-model="clearButton" class="btn btn-danger" :disabled="form.busy"> -->

                        </form>

                    </b-modal>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div>
                    <div class="row mt-3">
                        <div class="col-lg-12">
                            <div v-if="allReadySelectedRows.length" slot="selected-row-actions"
                                style="margin-bottom: 10px;">
                                <button class="btn btn-info btn-sm" @click="exportData">Export to Excel</button>
                                <button class="btn btn-primary btn-sm" @click="exportQR">Export QR Codes</button>
                                <button class="btn btn-danger btn-sm" @click="bulkDeleteGoogleUser">Bulk Delete</button>
                                {{ allReadySelectedRows.length }} selected rows <button class="btn btn-warning btn-sm"
                                    @click="clearArray()"> clear</button>
                            </div>

                            <div class="input-group">
                                <!-- Search Icon -->
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                                </div>
                                <!-- Full Width Input Field -->
                                <input class="form-control" type="text" v-model="searchTerm" @keyup="handleKeyUp"
                                    placeholder="Search...">
                            </div>
                        </div>
                    </div>
                    <vue-good-table mode="remote" :line-numbers="true" @on-page-change="onPageChange"
                        @on-sort-change="onSortChange" @on-selected-rows-change="selectionChanged"
                        @on-column-filter="onColumnFilter" @on-per-page-change="onPerPageChange" :totalRows="totalRecords"
                        :pagination-options="paginationOption" :rows="rows" :columns="columns" :select-options="{
                            enabled: true,
                            clearSelectionText: 'clear',
                        }" :selected-rows.sync="selectedRows" :search-options="{ enabled: false }">

                        <!-- <div slot="selected-row-actions">
                            <button class="btn btn-info btn-sm" @click="exportData">Export to Excel</button>
                            <button class="btn btn-primary btn-sm" @click="exportQR">Export QR Codes</button>
                            <button class="btn btn-danger btn-sm" @click="bulkDeleteGoogleUser">Bulk Delete</button>
                        </div> -->

                        <template slot="table-row" slot-scope="props">

                            <td v-if="props.column.field === 'category_name'"
                                style="border: 0px;padding: 0;width: 80px;margin: 0;">
                                <label>{{ props.row.category_name }}</label>
                            </td>
                            <td v-if="props.column.field === 'email'" style="border: 0px;padding: 0;width: 80px;margin: 0;">
                                <label>{{ props.row.email }}</label>
                            </td>
                            <td v-if="props.column.field === 'recovery_email'"
                                style="border: 0px;padding: 0;width: 80px;margin: 0;">
                                <label>{{ props.row.recovery_email }}
                                    <span v-if="props.row.is_recovery_enable == 1" style="color: green;">
                                        <i class="bi bi-bookmark-check text-primary"></i></span>
                                </label>
                            </td>
                            <td v-if="props.column.field === 'page_url'"
                                style="border: 0px; padding: 0; width: 80px; margin: 0;">
                                <i class="bi bi-link btn btn-sm btn-primary"
                                    @click="copyUrlToClipboard(props.row.page_url)"></i>
                            </td>
                            <td v-if="props.column.field === 'barcode_url'"
                                style="border: 0px;padding: 0;width: 80px;margin: 0;">
                                <img :src="img" style="cursor: pointer;" @click="downloadQRCode(props.row.barcode_url)"
                                    width="50" />
                            </td>
                            <td v-if="props.column.field === 'profile_id'"
                                style="border: 0px;padding: 0;width: 80px;margin: 0;">
                                <label>{{ props.row.profile_id }}</label>
                            </td>
                            <td v-if="props.column.field === 'created_at'"
                                style="border: 0px;padding: 0;width: 80px;margin: 0;">
                                <label>{{ props.row.created_at }}</label>
                            </td>
                            <td v-if="props.column.field === 'action'"
                                style="border: 0px;padding: 0;width: 80px;margin: 0;">
                                <router-link
                                    :to="{ name: 'updategoogleuser', params: { profile_id: props.row.profile_id } }"
                                    class="text-dark">
                                    <button class="btn btn-primary d-block w-50" style="float:left">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                </router-link>
                                <button class="btn btn-danger d-block w-50" style="float:right;"
                                    @click="deleteUser(props.row.id)">
                                    <i class="bi bi-trash3"></i>
                                </button>
                            </td>
                            <!-- ... other columns -->
                        </template>
                    </vue-good-table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Vue from 'vue'
import vSelect from 'vue-select'
import 'vue-select/dist/vue-select.css';
Vue.component('v-select', vSelect)
export default {
    data() {
        return {
            isLoading: false,
            form: new Form({
                from: '',
                category_id: '',
                to: '',
                profile_id: '',
            }),
            userButton: 'Filter',
            img: '/storage/app/qr-code.png',
            clearButton: 'Clear',
            showModal: false,
            totalRecords: 0,
            // img: '/storage/app/qr-code.png',
            searchTerm: '',
            paginationOption: {
                enabled: true,
                mode: 'records',
                perPage: 10,
                position: 'top',
                perPageDropdown: [10, 20, 50, 100, 200, 500, 1000],
                dropdownAllowAll: true,
                setCurrentPage: 1,
                jumpFirstOrLast: true,
                firstLabel: 'First Page',
                lastLabel: 'Last Page',
                nextLabel: 'next',
                prevLabel: 'prev',
                rowsPerPageLabel: 'Rows per page',
                ofLabel: 'of',
                pageLabel: 'page', // for 'pages' mode
                allLabel: 'All',
            },
            columnFilters: {
                recovery_email: '',
                email: '',
                page_url: '',
                id: '',
                profile_id: '',
            },
            from: '',
            to: '',
            category_id: '',
            profile_id: '',
            exportUrl: '',
            categories: [],
            category_id: '',
            file: null,
            selectedRows: [],
            selectAllRows: [],
            serverParams: [],
            rows: [],
            columns: [
                {
                    label: 'Office',
                    field: 'category_name',
                },
                {
                    label: 'Email',
                    field: 'email',
                },
                {
                    label: 'Recovery Email',
                    field: 'recovery_email',
                },
                {
                    label: 'Page Url',
                    field: 'page_url',
                    sortable: false,
                },
                {
                    label: 'Qr Code',
                    field: 'barcode_url',
                    sortable: false,
                },
                {
                    label: 'Serial No',
                    field: 'profile_id',
                },
                {
                    label: 'Created At',
                    field: 'created_at',
                },
                {
                    label: 'Action',
                    field: 'action',
                    sortable: false,
                },
                // Add more columns as needed
            ],

            searchOptions: {
                enabled: true,
            },
            pageChanged: {
                type: Function,
            },
            perPageChanged: {
                type: Function,
            },
            allReadySelectedRows: []
        };
    },
    methods: {

        async fetchCategory() {
            try {
                const response = await axios.post('/api/get-category');
                this.categories = response.data.data;
            } catch (error) {
                console.error(error);
            }
        },

        openModal() {
            this.form.from = '';
            this.form.to = '';
            this.form.category_id = '';
            this.form.profile_id = '';
            this.showModal = true;
        },
        closeModal() {
            this.showModal = false;
        },
        async submitForm() {
            await this.form.post('/api/get-google-user', {
                params: {
                    page: 1,
                    perPage: this.paginationOption.perPage,
                    search: this.searchTerm,
                },
            }).then(response => {
                this.rows = response.data.data;
                this.paginationOption.setCurrentPage = response.data.current_page;
                this.totalRecords = response.data.total;
                this.$Progress.finish();
                this.closeModal();
            });
        },

        getIdWithUrl(id) {
            return `url_${id}`;
        },
        getTargetWithUrl(id) {
            return `url_${id}`;
        },
        copyUrlToClipboard(page_url) {
            const url = page_url;
            const tempInput = document.createElement("input");
            tempInput.value = url;
            document.body.appendChild(tempInput);
            tempInput.select();
            document.execCommand("copy");
            document.body.removeChild(tempInput);
            Swal.fire({
                icon: 'success',
                title: 'Url Copied!',
                showConfirmButton: false,
                timer: 1500
            });
        },

        handleKeyUp() {
            const inputValue = this.searchTerm;
            this.paginationOption.setCurrentPage = 1;
            console.log(this.selectedData);
            this.fetchData();
        },

        customPageChange(customCurrentPage) {
            this.pageChanged({ currentPage: customCurrentPage });
        },
        customPerPageChange(customPerPage) {
            this.perPageChanged({ currentPerPage: customPerPage });
        },
        updateParams(newProps) {
            this.serverParams = Object.assign({}, this.serverParams, newProps);
        },

        onPageChanges(params) {
            this.updateParams({ page: params.currentPage });
            this.fetchData();
        },

        onPerPageChange(params) {
            this.paginationOption.setCurrentPage = 1;
            this.paginationOption.perPage = params.currentPerPage;
            this.fetchData();
        },

        selectionChanged(params) {
            this.selectedRows = params.selectedRows.map((row) => row.id);
            if (this.selectedRows.length) {
                this.allReadySelectedRows.push(...this.selectedRows);
                this.allReadySelectedRows = Array.from(new Set(this.allReadySelectedRows));
                this.selectedRows = this.allReadySelectedRows
            }
        },
        clearArray() {
            this.allReadySelectedRows = []
            this.selectedRows = []
        },

        onSortChange(params) {
            const sortParams = [{
                type: params[0].type,
                field: params[0].field,
            }];

            this.updateParams({ sort: sortParams });
            // Call the method to fetch data if needed
            this.fetchData();
        },

        onColumnFilter(params) {

            this.updateParams(params);
            this.fetchData();
            this.closeModal();
        },

        clearFilter() {
            // Clear all form fields by resetting the form object
            this.form.profile_id = '';
            this.form.from = '';
            this.form.to = '';
            this.form.category_id = '';
            this.paginationOption.perPage = 10;
            this.paginationOption.setCurrentPage = 1;
            this.fetchData();
            this.closeModal();
        },

        // load items is what brings back the rows from server
        async fetchData() {
            try {
                const response = await this.form.post('/api/get-google-user', {
                    params: {
                        page: this.paginationOption.setCurrentPage,
                        perPage: this.paginationOption.perPage,
                        search: this.searchTerm,
                        serverParams: this.serverParams,

                    },
                });

                this.rows = response.data.data;
                this.paginationOption.setCurrentPage = response.data.current_page;
                this.totalRecords = response.data.total;
            } catch (error) {
                console.error(error);
            }
        },

        // load items is what brings back the rows from server
        async bulkDeleteGoogleUser() {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    axios
                        .post("/api/googleUser/bulk-delete", this.selectedRows)
                        .then(response => {
                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted!',
                                showConfirmButton: false,
                                timer: 2500
                            });

                            this.fetchData();
                            this.clearArray();
                        })
                        .catch(error => {
                            console.error(error);
                        });

                }
            })
            // try {
            //     const response = await axios.post('/api/get-google-user', {
            //         params: {
            //             page: this.paginationOption.setCurrentPage,
            //             perPage: this.paginationOption.perPage,
            //             search: this.searchTerm,
            //         },
            //     });
            //     this.rows = response.data.data;
            //     this.paginationOption.setCurrentPage = response.data.current_page;
            //     this.totalRecords = response.data.total;
            // } catch (error) {
            //     console.error(error);
            // }
        },

        onPageChange(page) {
            this.paginationOption.setCurrentPage = page.currentPage;
            this.paginationOption.perPage = page.currentPerPage;
            this.fetchData();
        },
        async exportData() {
            try {

                const response = await axios.post("/api/googleUser/export", this.selectedRows);
                const downloadLink = response.data.return_array.downloadLink;
                const fileName = response.data.return_array.fileName;

                // Trigger the download using JavaScript
                const newWindow = window.open(downloadLink, '_blank');
                if (newWindow) {
                    newWindow.addEventListener('load', () => {
                        newWindow.document.title = fileName;
                    });
                }
                this.clearArray();
            } catch (error) {
                console.error(error);
                alert("Error exporting data");
            }
        },

        async exportQR() {
            try {

                const response = await axios.post("/api/googleUser/exportQr", this.selectedRows);
                const downloadLink = response.data.downloadLink;
                const fileName = response.data.fileName;

                // Trigger the download using JavaScript
                const newWindow = window.open(downloadLink, '_blank');
                if (newWindow) {
                    newWindow.addEventListener('load', () => {
                        newWindow.document.title = fileName;
                    });
                }
                this.clearArray();
            } catch (error) {
                console.error(error);
                alert("Error exporting data");
            }
        },

        async downloadQRCode(data) {
            this.$Progress.start();
            try {

                // const response = await axios.post("/api/download/google-qr-code", data);
                // const downloadLink = response.data.return_array.downloadLink;
                // const fileName = response.data.return_array.fileName;

                const url = data;
                const tempInput = document.createElement("input");
                tempInput.value = url;
                document.body.appendChild(tempInput);
                tempInput.select();
                document.execCommand("copy");
                document.body.removeChild(tempInput);
                Swal.fire({
                    icon: 'success',
                    title: 'Qr Code Url Copied!',
                    showConfirmButton: false,
                    timer: 1500
                });
            } catch (error) {
                console.error(error);
                alert("Error exporting data");
            }
            this.$Progress.finish();
            this.fetchData();
        },

        async deleteUser(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then(async (result) => { // Mark this callback function as async
                if (result.isConfirmed) {
                    try {
                        // Show loading state
                        Swal.fire({
                            title: 'Deleting user...',
                            icon: 'info',
                            showConfirmButton: false
                        });

                        // Send delete request
                        await axios.post('/api/delete-google-user', { id: id });

                        // Show success message
                        Swal.fire({
                            icon: 'success',
                            title: 'User deleted successfully!',
                            showConfirmButton: false,
                            timer: 2500
                        });

                        // Refresh data (assuming this method exists)
                        this.fetchData();
                    } catch (error) {
                        console.error(error);
                        // Handle errors here (e.g., display an error message)
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops... Something went wrong!',
                            text: 'Unable to delete the user.',
                        });
                    }
                }
            });
        },

        toggleRowSelected(row) {
            this.selectedRows.push(row.id);
        },
        toggleAllRowsSelected(val) {
            this.selectedRows = val ? this.items.map((item) => item.id) : [];
            this.showHeader = !val;
        },
        // You can add more methods as needed
    },
    created() {
        this.fetchData();
        this.fetchCategory();
    },
};
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

.input-group {
    width: 100%;
}

.copy-icon::before {
    content: "\f0c5";
    /* Unicode for the copy icon (Font Awesome) */
}

.form-control {
    border-top-right-radius: 0;
    border-bottom-right-radius: 0;
}

.input-group-prepend {
    border-top-left-radius: 0;
    border-bottom-left-radius: 0;
}

.vgt-selection-info-row {
    display: none;
}
</style>
