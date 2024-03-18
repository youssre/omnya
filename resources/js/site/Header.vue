<template>
    <div>
        <!-- ======= Top Bar ======= -->
        <section id="topbar" class="d-flex align-items-center" style="height: 60px !important;">
            <div class="container">
                <div class="row">
                    <div class="col-sm-9 col-md-9 col-lg-9 d-none d-md-block">
                        <i style="font-size: 27px;color: #aaaaaa;" class="bi bi-list"></i>
                    </div>
                    <div v-if="is_logo_enable === true" class="col-sm-3 col-md-3 col-lg-3" style="text-align: right;">
                        <img :src="logoSrc" alt="logo-sm-light" height="50">
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
export default {
    data() {
        return {
            // logoSrc: '/storage/app/public/logo/logo.png',
            logoSrc: '/storage/app/public/logo/omnya/omnyaLogo.jpg',
            is_logo_enable: false
        };
    },
    mounted() {

    },
    methods: {
        get_google_user_info() {
            const profile_id = { profile_id: this.$route.params.profile_id };
            axios.post('/api/get-google-user-data', profile_id).then(response => {
                console.log(response);
                if (response.data.is_logo_enable == 1) {
                    this.is_logo_enable = true;
                }
            });
        },
        get_user_info() {
            const profile_id = { profile_id: this.$route.params.profile_id };
            axios.post('/api/get-user-data', profile_id).then(response => {
                console.log(response);
                if (response.data.is_logo_enable == 1) {
                    this.is_logo_enable = true;
                }
            });
        },
    },

    created() {
        this.get_google_user_info();
        this.get_user_info();
    },
    watch: {},
};
</script>

<style scoped>
@media (max-width: 574px) {

    /* Adjustments for screens up to 374px */
    #topbar {
        height: auto;
        padding: 10px 0;
    }

    #topbar .row {
        justify-content: center;
        /* Center the content horizontally */
        align-items: center;
    }

    .col-md-9 {
        display: none;
    }
}
</style>
