
<template>
    <div>
        <div v-if="termStatus === true">
            <section class="">
                <div class="container">
                    <div class="row">

                        <div class="col-sm-12 col-md-12 col-lg-12">
                            <div style="text-align: center;">
                                <div class="card p-5" style="border-radius: 1.25rem;box-shadow: grey 3px 0px 25px;">
                                    <div class="col-md-12" style=" text-align: center;">
                                        <h4>الشروط و الاحكام</h4>
                                    </div>
                                    <pre
                                        style="text-align: right;direction: rtl;position: relative;font-size:smaller;font-weight: 900;height: 500px; white-space: pre-line;text-wrap: wrap;">
                                        {{ term }}
                                    </pre>
                                    <button class="btn btn-success" @click="acceptCondition()">موافق على الشروط</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <div v-if="termStatus === false">
            <Header></Header>

            <!-- =======  Contact US Detail ======= -->
            <section class="">
                <div class="container">
                    <div class="row">

                        <div class="col-sm-12 col-md-12 col-lg-12">
                            <div style="text-align: center;">
                                <div v-if="category_img != '' && category_img != null">
                                    <img :src="category_img_path" width="150" style="cursor: pointer; text-align: center;">
                                    <p>
                                        {{ this.category_description }}
                                    </p>
                                </div>


                                <h3>حساب واحد خاص بكل
                                    <br>.Google ما هو
                                </h3>
                                <!-- <video width="320" height="240" autoplay muted loop>
                                <source :src="img" type="video/mp4">
                                Error Message
                            </video> -->
                                <img :src="img" width="150" style="cursor: pointer; text-align: center;">
                                <!-- <p>
                                <br>واحد وكلمة سر واحدة Google ID
                                <br>يمنحانك القدرة على الوصول إلى جميع
                                <br>.Google خدمات
                                يرجى تسجيل الدخول لإدارة حسابك.
                            </p> -->
                                <!-- <div style="padding-left: 45%;">
                                <p style="
                                    background: #3d6be7;
                                    border-radius: 20px;
                                    width: 130px;
                                    padding: 9px;
                                    color: aliceblue;
                                "> تسجيل الدخول</p>
                            </div> -->
                            </div>
                            <div class="card p-5" style="border-radius: 1.25rem;box-shadow: grey 3px 0px 25px;">
                                <!-- <h4><span
                                    style="color: aliceblue;position: absolute;border-radius: 0px 0px 10px 10px; top: -1px;"
                                    class="badge bg-success"># {{ id }}</span></h4> -->

                                <div class="col-md-12" style=" text-align: center;">
                                    <h4>Google Account</h4>
                                </div>
                                <div class="mb-4">
                                    <label for="emailInput" class="form-label">Email</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="emailInput"
                                            style="border: 1px solid grey;" v-model="email" ref="emailInput" />
                                        <i class="bi bi-clipboard"
                                            style="border: 1px solid grey;padding: 6px; border-radius: 0px 5px 5px 0px;"
                                            @click="copyToClipboard($refs.emailInput, email)"></i>
                                    </div>
                                    <b-alert :show="emailDismissCountDown" dismissible fade variant="warning"
                                        @dismiss-count-down="countDownChanged">
                                        Text is copied!
                                    </b-alert>
                                </div>


                                <div class="mb-4">
                                    <label for="passwordInput" class="form-label">Password</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="passwordInput"
                                            style="border: 1px solid grey;" v-model="plain_password" ref="passwordInput" />
                                        <i class="bi bi-clipboard"
                                            @click="copyToClipboard($refs.passwordInput, plain_password)"
                                            style="border: 1px solid grey;padding: 6px; border-radius: 0px 5px 5px 0px;"></i>
                                    </div>
                                    <b-alert :show="passwordDismissCountDown" dismissible fade variant="warning"
                                        @dismiss-count-down="countDownChanged">
                                        Text is copied!
                                    </b-alert>
                                </div>

                                <div class="mb-4" v-if="is_recovery_enable">
                                    <label for="recoveryEmailInput" class="form-label">Recovery Email</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="recoveryEmailInput"
                                            style="border: 1px solid grey;" v-model="recovery_email"
                                            ref="recoveryEmailInput" />
                                        <i class="bi bi-clipboard"
                                            style="border: 1px solid grey;padding: 6px; border-radius: 0px 5px 5px 0px;"
                                            @click="copyToClipboard($refs.recoveryEmailInput, recovery_email)"></i>
                                    </div>
                                    <b-alert :show="recoveryEmailDismissCountDown" dismissible fade variant="warning"
                                        @dismiss-count-down="countDownChanged">
                                        Text is copied!
                                    </b-alert>
                                </div>

                                <div class="mb-4">
                                    <label for="profileIdInput" class="form-label">Serial Number</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="profileIdInput"
                                            style="border: 1px solid grey;" v-model="profile_id" ref="profileIdInput" />
                                        <i @click="copyToClipboard($refs.profileIdInput, profile_id)"
                                            class="bi bi-clipboard"
                                            style="border: 1px solid grey;padding: 6px; border-radius: 0px 5px 5px 0px;"></i>
                                    </div>
                                    <b-alert :show="profileIdDismissCountDown" dismissible fade variant="warning"
                                        @dismiss-count-down="countDownChanged">
                                        Text is copied!
                                    </b-alert>
                                </div>

                                <div class="mb-4" style="text-align: center;">
                                    <p>
                                        {{ note }}
                                    </p>
                                </div>

                                <div class="col-12">
                                    <iframe width="100%" height="300" :src="`/api/generate-mailbox?${recovery_email || 'omnea@uruk.uk'}`"></iframe>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- ======= End Contact US Detail======= -->

            <!-- <Footer></Footer> -->
        </div>
    </div>
</template>

<script>
import Header from "../site/Header.vue";
import Footer from "../site/Footer.vue";
import { SITE_NOTE, SITE_TERMS, TERM_BTN } from '../constants';


export default {
    data: () => ({
        termStatus: true,
        term: SITE_TERMS,
        termBtn: TERM_BTN,
        // img: '/admin/assets/logo/logo.png',
        img: '/public/admin/assets/logo/omnya/googleLogo.jpg',
        // img: '/admin/assets/logo/logo-video.mp4',
        // img: '/storage/app/public/logo/colorful-logo.png',
        // img: '/storage/app/public/logo/logo-video.mp4',
        category_img: '',
        category_img_path: '',
        category_description: '',
        email: '',
        recovery_email: '',
        is_recovery_enable: 0,
        id: '',
        plain_password: '',
        profile_id: '',
        recoveryEmailDismissSecs: 3,
        emailDismissSecs: 3,
        passwordDismissSecs: 3,
        profileIdDismissSecs: 3,
        emailDismissCountDown: 0,
        recoveryEmailDismissCountDown: 0,
        passwordDismissCountDown: 0,
        profileIdDismissCountDown: 0,
        note: SITE_NOTE,
        getUserList: [],

    }),
    methods: {
        
        acceptCondition() {
            this.termStatus = false;
        },

        get_user_to_update() {
            const profile_id = { profile_id: this.$route.params.profile_id };
            axios.post('/api/get-google-user-data', profile_id).then(response => {
                this.getUserList = response.data;
                console.log(this.getUserList);
                this.id = this.getUserList.id;
                this.email = this.getUserList.email;
                this.recovery_email = this.getUserList.recovery_email;
                this.is_recovery_enable = this.getUserList.is_recovery_enable;
                this.plain_password = this.getUserList.plain_password;
                this.profile_id = this.getUserList.profile_id;
                this.formId = this.getUserList.id;

                this.category_description = this.getUserList.description;
                this.category_img_path = '/storage/app/public/' + this.getUserList.image;
                this.category_img = this.getUserList.image;
            });
        },

        copyToClipboard(inputElement, text) {
            // Select the text inside the input field
            inputElement.select();
            try {
                // Execute the copy command
                document.execCommand("copy");
                this.showAlert(inputElement.id);
            } catch (err) {
                console.error("Error copying text: ", err);
            }
        },
        countDownChanged(dismissCountDown) {
            this.dismissCountDown = dismissCountDown
        },
        showAlert(element) {
            if (element == 'emailInput') {
                this.emailDismissCountDown = this.emailDismissSecs
            } else if (element == 'recoveryEmailInput') {
                this.recoveryEmailDismissCountDown = this.recoveryEmailDismissSecs
            } else if (element == 'passwordInput') {
                this.passwordDismissCountDown = this.passwordDismissSecs
            } else if (element == 'profileIdInput') {
                this.profileIdDismissCountDown = this.profileIdDismissSecs
            } else { }
        }

    },

    created() {
        this.get_user_to_update();
    },
    components: {
        Header,
        Footer,
    },
    mounted() {
        // console.log('Component mounted.')
    }
};
</script>
