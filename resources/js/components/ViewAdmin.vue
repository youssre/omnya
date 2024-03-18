<template>
    <div>
        <div class="row">
            <div class="col-12">

                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">View Admin</h4>
                    <div class="page-title-box d-sm-flex">
                        <router-link to="addAdmin"><b-button class="btn btn-primary">Add
                                Admin</b-button></router-link>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div>
                    <div class="row mt-3">
                        <div class="col-lg-12">
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
                        :pagination-options="paginationOption" :rows="rows" :columns="columns"
                        :select-options="{ enabled: true }" :search-options="{
                            enabled: true,
                            externalQuery: searchTerm
                        }">


                        <template slot="table-row" slot-scope="props">
                            <td v-if="props.column.field === 'name'" style="border: 0px;padding: 0;margin: 0;">
                                <label>{{ props.row.name }}</label>
                            </td>
                            <td v-if="props.column.field === 'email'" style="border: 0px;padding: 0;margin: 0;">
                                <label>{{ props.row.email }}</label>
                            </td>
                            <td v-if="props.column.field === 'created_at'" style="border: 0px;padding: 0;margin: 0;">
                                <label>{{ props.row.created_at }}</label>
                            </td>
                            <td v-if="props.column.field === 'action'"
                                style="border: 0px;padding: 0;width: 100px;margin: 0;">
                                <button class="btn btn-danger d-block w-50" style="float:right;"
                                    @click="deleteAdmin(props.row.id)">
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
export default {
    data() {
        return {
            isLoading: false,
            form: new Form({
                name: '',
                email: '',
            }),
            totalRecords: 0,
            searchTerm: '',
            paginationOption: {
                enabled: true,
                mode: 'records',
                perPage: 10,
                position: 'top',
                perPageDropdown: [5, 10, 20],
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
                name: '',
                email: '',
            },
            selectedRows: [],
            selectAllRows: [],
            serverParams: [],
            rows: [],
            columns: [
                {
                    label: 'Name',
                    field: 'name',
                },
                {
                    label: 'Email',
                    field: 'email',
                },
                {
                    label: 'Created At',
                    field: 'created_at',
                },
                {
                    label: 'Action',
                    field: 'action',
                    sortable: false,
                }
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
        };
    },
    methods: {

        async fetchAdmin() {
            try {
                const response = await axios.post('/api/get-admin', {
                    params: {
                        page: this.paginationOption.setCurrentPage,
                        perPage: this.paginationOption.perPage,
                        search: this.searchTerm,
                    },
                });
                this.rows = response.data.data;
                this.paginationOption.setCurrentPage = response.data.current_page;
                this.totalRecords = response.data.total;
            } catch (error) {
                console.error(error);
            }
        },


        async submitForm() {
            await this.form.post('/api/get-admin', {
                params: {
                    page: this.paginationOption.setCurrentPage,
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

        handleKeyUp() {
            const inputValue = this.searchTerm;
            this.fetchData();
        },

        customPageChange(customCurrentPage) {
            this.pageChanged({ currentPage: customCurrentPage });
        },
        customPerPageChange(customPerPage) {
            this.perPageChanged({ currentPerPage: customPerPage });
        },

        onPageChanges(params) {
            this.updateParams({ page: params.currentPage });
            this.fetchData();
        },

        onPerPageChange(params) {
            this.paginationOption.setCurrentPage = params.currentPage;
            this.paginationOption.perPage = params.currentPerPage;
            this.fetchData();
        },

        selectionChanged(params) {
            this.selectedRows = params.selectedRows.map((row) => row.id);
        },

        updateParams(newProps) {
            this.serverParams = Object.assign({}, this.serverParams, newProps);
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
        },

        // load items is what brings back the rows from server
        async fetchData() {
            try {
                const response = await axios.post('/api/get-admin', {
                    params: {
                        page: this.paginationOption.setCurrentPage,
                        perPage: this.paginationOption.perPage,
                        serverParams: this.serverParams,
                        search: this.searchTerm,
                    },
                });
                this.rows = response.data.data;
                this.paginationOption.setCurrentPage = response.data.current_page;
                this.totalRecords = response.data.total;
            } catch (error) {
                console.error(error);
            }
        },

        onPageChange(page) {
            this.paginationOption.setCurrentPage = page.currentPage;
            this.paginationOption.perPage = page.currentPerPage;
            this.fetchData();
        },

        async deleteAdmin(id) {
            try {
                await axios.post('/api/delete-admin', { id: id });
                Swal.fire({
                    icon: 'success',
                    title: 'Admin deleted successfully!',
                    showConfirmButton: false,
                    timer: 2500
                });
                this.fetchData();
            } catch (error) {
                console.error(error);
            }
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
</style>
