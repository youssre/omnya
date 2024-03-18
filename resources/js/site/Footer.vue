<template>
    <div>
        <!-- ======= Footer ======= -->
        <footer id="footer">

            <div class="row" style="margin: 0px;">
                <div class="col-sm-12 col-md-2 col-lg-2" style="text-align: center;padding-top: 30px;float: left;">
                    <img :src="logoSrc" alt="logo-sm-light" height="40">
                </div>

                <div class="col-sm-12 col-md-3 col-lg-3 hide-on-mobile"
                    style="text-align: center;padding-top: 30px;float: left;">
                    <i style="font-size: 17px;color: #037EB2;" class="bi bi-telephone-fill"></i>
                    <i style="font-size: 17px;color: #00860D;" class="bi bi-whatsapp"></i>
                    <span> +964-07504540021</span>
                </div>
                <div class="col-sm-12 col-md-2 col-lg-2 hide-on-mobile"
                    style="text-align: center;padding-top: 30px;float: left;">
                    <i style="font-size: 17px;color: #00A8E5;" class="bi bi-telegram"></i>
                    <span> livaid</span>
                </div>
                <div class="col-sm-12 col-md-2 col-lg-2 hide-on-mobile"
                    style="text-align: center;float: left;padding-top: 30px;">
                    <i style="font-size: 17px;color: #39559A;" class="bi bi-facebook"></i>
                    <span> appleidliva</span>
                </div>
                <div class="col-sm-12 col-md-3 col-lg-3 hide-on-mobile" style="text-align: right;float: left;">
                    <span>بغداد - شارع الربيعي - بناية الزيتون </span>
                    <i style="font-size: 17px;color: #F0D830;" class="bi bi-geo-alt-fill"></i>
                    <br>
                    <span>اربيل - كوتري سلام عمارة جهان </span>
                    <i style="font-size: 17px;color: #F0D830;" class="bi bi-geo-alt-fill"></i>
                    <br>
                    <span>دهوك - تناهي </span>
                    <i style="font-size: 17px;color: #F0D830;" class="bi bi-geo-alt-fill"></i>

                </div>

            </div>
        </footer>
        <!-- End Footer -->
    </div>
</template>

<style>
#footer {
    background-color: #fff6f6 !important;
    padding: 15px !important;
}

@media (max-width: 767px) {
    .hide-on-mobile {
        display: none;
    }
}
</style>
<script>
export default {
    data() {
        return {
            // logoSrc: '/storage/app/public/logo/logo.png',
            logoSrc: '/storage/app/public/logo/omnya/omnyaLogo.jpg',
            // logoSrc: '/admin/assets/logo/logo.png',
        };
    },
    mounted() {
        console.log("Component mounted.");
    },
    methods: {},
    created() { },
    watch: {},
};
</script>
