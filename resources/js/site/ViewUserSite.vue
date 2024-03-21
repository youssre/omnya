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
                                        style="text-align: right;direction: rtl;position: relative;font-size: smaller;font-weight: 900;height: 500px; white-space: pre-line;text-wrap: wrap;">
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
                                    <br>.Apple ما هو
                                </h3>
                                <!-- <video width="320" height="240" autoplay muted loop>
                                <source :src="img" type="video/mp4">
                                Error Message
                            </video> -->
                                <img :src="img" width="150" style="cursor: pointer; text-align: center;">
                                <!-- <p>
                                    <br>واحد وكلمة سر واحدة Apple ID
                                    <br>يمنحانك القدرة على الوصول إلى جميع
                                    <br>.Apple خدمات<br>
                                    يرجى تسجيل الدخول لإدارة حسابك
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
                                    <h4>APPLE ID USA</h4>
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


                                <!-- <div class="mb-4">
                                <label for="q1Input" class="form-label">Question 1</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="q1Input" style="border: 1px solid grey;"
                                        v-model="q1" ref="q1Input" />
                                    <i class="bi bi-clipboard" @click="copyToClipboard($refs.q1Input, q1)"
                                        style="border: 1px solid grey;padding: 6px; border-radius: 0px 5px 5px 0px;"></i>
                                </div>
                                <b-alert :show="q1DismissCountDown" dismissible fade variant="warning"
                                    @dismiss-count-down="countDownChanged">
                                    Text is copied!
                                </b-alert>
                            </div> -->

                                <div class="mb-4">
                                    <label for="a1Input" class="form-label">{{ q1 }}</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="a1Input" style="border: 1px solid grey;"
                                            v-model="a1" ref="a1Input" />
                                        <i class="bi bi-clipboard" @click="copyToClipboard($refs.a1Input, a1)"
                                            style="border: 1px solid grey;padding: 6px; border-radius: 0px 5px 5px 0px;"></i>
                                    </div>
                                    <b-alert :show="a1DismissCountDown" dismissible fade variant="warning"
                                        @dismiss-count-down="countDownChanged">
                                        Text is copied!
                                    </b-alert>
                                </div>

                                <!-- <div class="mb-4">
                                <label for="q2Input" class="form-label">Question 2</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="q2Input" style="border: 1px solid grey;"
                                        v-model="q2" ref="q2Input" />
                                    <i class="bi bi-clipboard" @click="copyToClipboard($refs.q2Input, q2)"
                                        style="border: 1px solid grey;padding: 6px; border-radius: 0px 5px 5px 0px;"></i>
                                </div>
                                <b-alert :show="q2DismissCountDown" dismissible fade variant="warning"
                                    @dismiss-count-down="countDownChanged">
                                    Text is copied!
                                </b-alert>
                            </div> -->

                                <div class="mb-4">
                                    <label for="a2Input" class="form-label">{{ q2 }}</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="a2Input" style="border: 1px solid grey;"
                                            v-model="a2" ref="a2Input" />
                                        <i class="bi bi-clipboard" @click="copyToClipboard($refs.a2Input, a2)"
                                            style="border: 1px solid grey;padding: 6px; border-radius: 0px 5px 5px 0px;"></i>
                                    </div>
                                    <b-alert :show="a2DismissCountDown" dismissible fade variant="warning"
                                        @dismiss-count-down="countDownChanged">
                                        Text is copied!
                                    </b-alert>
                                </div>

                                <!-- <div class="mb-4">
                                <label for="q3Input" class="form-label">Question 3</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="q3Input" style="border: 1px solid grey;"
                                        v-model="q3" ref="q3Input" />
                                    <i class="bi bi-clipboard" @click="copyToClipboard($refs.q3Input, q3)"
                                        style="border: 1px solid grey;padding: 6px; border-radius: 0px 5px 5px 0px;"></i>
                                </div>
                                <b-alert :show="q3DismissCountDown" dismissible fade variant="warning"
                                    @dismiss-count-down="countDownChanged">
                                    Text is copied!
                                </b-alert>
                            </div> -->

                                <div class="mb-4">
                                    <label for="a3Input" class="form-label">{{ q3 }}</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="a3Input" style="border: 1px solid grey;"
                                            v-model="a3" ref="a3Input" />
                                        <i class="bi bi-clipboard" @click="copyToClipboard($refs.a3Input, a3)"
                                            style="border: 1px solid grey;padding: 6px; border-radius: 0px 5px 5px 0px;"></i>
                                    </div>
                                    <b-alert :show="a3DismissCountDown" dismissible fade variant="warning"
                                        @dismiss-count-down="countDownChanged">
                                        Text is copied!
                                    </b-alert>
                                </div>


                                <div class="mb-4">
                                    <label for="dateOfBirthInput" class="form-label">Date Of Birth</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="dateOfBirthInput"
                                            style="border: 1px solid grey;" v-model="date_of_birth"
                                            ref="dateOfBirthInput" />
                                        <i class="bi bi-clipboard"
                                            @click="copyToClipboard($refs.dateOfBirthInput, date_of_birth)"
                                            style="border: 1px solid grey;padding: 6px; border-radius: 0px 5px 5px 0px;"></i>
                                    </div>
                                    <b-alert :show="birthDismissCountDown" dismissible fade variant="warning"
                                        @dismiss-count-down="countDownChanged">
                                        Text is copied!
                                    </b-alert>
                                </div>

                                <!-- <div class="mb-4">
                                <label for="firstNameInput" class="form-label">First Name</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="firstNameInput"
                                        style="border: 1px solid grey;" v-model="first_name" ref="firstNameInput" />
                                    <i @click="copyToClipboard($refs.firstNameInput, first_name)" class="bi bi-clipboard"
                                        style="border: 1px solid grey;padding: 6px; border-radius: 0px 5px 5px 0px;"></i>
                                </div>
                                <b-alert :show="firstNameDismissCountDown" dismissible fade variant="warning"
                                    @dismiss-count-down="countDownChanged">
                                    Text is copied!
                                </b-alert>
                            </div>

                            <div class="mb-4">
                                <label for="lastNameInput" class="form-label">Last Name</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="lastNameInput"
                                        style="border: 1px solid grey;" v-model="last_name" ref="lastNameInput" />
                                    <i @click="copyToClipboard($refs.lastNameInput, last_name)" class="bi bi-clipboard"
                                        style="border: 1px solid grey;padding: 6px; border-radius: 0px 5px 5px 0px;"></i>
                                </div>
                                <b-alert :show="lastNameDismissCountDown" dismissible fade variant="warning"
                                    @dismiss-count-down="countDownChanged">
                                    Text is copied!
                                </b-alert>
                            </div> -->


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

                                <div class="col-12 mb-2">
                                    <iframe width="100%" height="300" :src="`/generate-mailbox/v1n45aZvgOt2_j8751nwlFa50qD-wr3NQeuQpvAAPYAOFi7xe-XJfnbzGj01T?${email || 'omnea@uruk.uk'}`"></iframe>
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
        img: '/public/admin/assets/logo/omnya/appLogo.jpg',
        // img: '/admin/assets/logo/logo-video.mp4',
        // img: '/storage/app/public/logo/colorful-logo.png',
        // img: '/storage/app/public/logo/logo-video.mp4',
        category_img: '',
        category_img_path: '',
        category_description: '',
        email: '',
        recovery_email: '',
        is_recovery_enable: 0,
        note: SITE_NOTE,
        id: '',
        // first_name: '',
        // last_name: '',
        plain_password: '',
        date_of_birth: '',
        profile_id: '',
        recoveryEmailDismissSecs: 3,
        emailDismissSecs: 3,
        firstNameDismissSecs: 3,
        lastNameDismissSecs: 3,
        passwordDismissSecs: 3,
        birthDismissSecs: 3,
        q1DismissSecs: 3,
        q2DismissSecs: 3,
        q3DismissSecs: 3,
        a1DismissSecs: 3,
        a2DismissSecs: 3,
        a3DismissSecs: 3,
        profileIdDismissSecs: 3,
        emailDismissCountDown: 0,
        recoveryEmailDismissCountDown: 0,
        firstNameDismissCountDown: 0,
        lastNameDismissCountDown: 0,
        passwordDismissCountDown: 0,
        birthDismissCountDown: 0,
        q1DismissCountDown: 0,
        q2DismissCountDown: 0,
        q3DismissCountDown: 0,
        a1DismissCountDown: 0,
        a2DismissCountDown: 0,
        a3DismissCountDown: 0,
        profileIdDismissCountDown: 0,
        getUserList: [],
        q1: '',
        a1: '',
        q2: '',
        a2: '',
        q3: '',
        a3: '',
    }),

    methods: {
        acceptCondition() {
            this.termStatus = false;
        },

        get_user_to_update() {
            const profile_id = { profile_id: this.$route.params.profile_id };
            axios.post('/api/get-user-data', profile_id).then(response => {
                this.getUserList = response.data;
                this.id = this.getUserList.id;
                this.email = this.getUserList.email;
                this.recovery_email = this.getUserList.recovery_email;
                // this.first_name = this.getUserList.first_name;
                this.is_recovery_enable = this.getUserList.is_recovery_enable;
                this.plain_password = this.getUserList.plain_password;
                // this.last_name = this.getUserList.last_name;
                this.date_of_birth = this.getUserList.date_of_birth;
                this.q1 = this.getUserList.q1;
                this.a1 = this.getUserList.a1;
                this.q2 = this.getUserList.q2;
                this.a2 = this.getUserList.a2;
                this.q3 = this.getUserList.q3;
                this.a3 = this.getUserList.a3;
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
            } else if (element == 'firstNameInput') {
                this.firstNameDismissCountDown = this.firstNameDismissSecs
            } else if (element == 'lastNameInput') {
                this.lastNameDismissCountDown = this.lastNameDismissSecs
            } else if (element == 'passwordInput') {
                this.passwordDismissCountDown = this.passwordDismissSecs
            } else if (element == 'dateOfBirthInput') {
                this.birthDismissCountDown = this.birthDismissSecs
            } else if (element == 'q1Input') {
                this.q1DismissCountDown = this.q1DismissSecs
            } else if (element == 'q2Input') {
                this.q2DismissCountDown = this.q2DismissSecs
            } else if (element == 'q3Input') {
                this.q3DismissCountDown = this.q3DismissSecs
            } else if (element == 'a1Input') {
                this.a1DismissCountDown = this.a1DismissSecs
            } else if (element == 'a2Input') {
                this.a2DismissCountDown = this.a2DismissSecs
            } else if (element == 'a3Input') {
                this.a3DismissCountDown = this.q3DismissSecs
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
