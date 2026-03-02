
<template>
  <div id="resetPasswordComponent" class="flex content-center justify-center my-24">
    <form class="h-auto w-[600px] m-auto bg-bt-secondary shadow-gray-900 shadow-xl relative rounded-md border border-white">
      <div v-show="loading" class="absolute w-full h-full bg-form-overlay"></div>
      <div v-show="reset_type == RESET.sendEmail" class="m-10 text-center">
        <h3 class="text-center font-bold">Forgot Password?</h3>
        <p>{{ lang.get('words.EnterYourRegisteredEmailAddressToThisAmazingCommunity.') }}</p>
      </div>
      <div v-show="reset_type == RESET.resetPass" class="m-10 text-center">
        <h3 class="font-bold">Reset Password</h3>
        <p> {{ lang.get('words.SubmitTheFormToGetYourNewPassword.') }}</p>
      </div>
      <!-- SEND MAIL FORM -->
      <div v-show="reset_type == RESET.sendEmail" class="r-field flex flex-col gap-6 m-10">
        <div class="r-field-required grid gap-y-5">
          <div>
            <label class="grid gap-y-2">
              <span class="font-bold">{{ lang.get("words.Email") }}</span>
              <input
                v-model="$v.form.email.$model"
                class="h-14 w-full rounded-lg bg-b-input border-b-input focus:placeholder:opacity-0"
                type="email"
                placeholder="someemail@domain.com"
              />
            </label>
            <error-input :email="true"></error-input>
          </div>
          <div>
            <p class="horizontal-line text-center">
              <span class="horizontal-line-text px-10">
                <span class="text-b-mute">{{ lang.get("words.NoAccount") }} <router-link :to="{ name: 'register' }" class="text-b-link">{{ lang.get('words.CreateAnAccount') }}</router-link></span>
              </span>
            </p>
          </div>
        </div>
        <div class="grid gap-6">
          <ui-button v-show="!requested"
            @click.prevent="submit"
            :type="'create'"
            :size="'full'"
            :withLoading="loading"
            :disabled="anyError"
            class="text-white">
            <span>{{ lang.get('words.SendMeResetPasswordInstructions') }}</span>
          </ui-button>
          <router-link :to="{ name: 'login' }" class="text-b-link text-center">{{ lang.get('words.BackToLogin') }}</router-link>
        </div>
      </div>
      <!-- RESET PASS FORM -->
      <div v-show="reset_type == RESET.resetPass" class="r-field flex flex-col gap-6 m-10">
        <div class="r-field-required grid gap-y-5">
          <div>
            <label class="grid gap-y-2">
              <span class="font-bold">{{ lang.get("words.NewPassword") }}</span>
              <input
                v-model="$v.form.new_password.$model"
                class="h-14 w-full rounded-lg bg-b-input border-b-input focus:placeholder:opacity-0"
                type="password"
                placeholder="New Password"
              />
            </label>
            <error-input :new_password="true"></error-input>
          </div>
          <div>
            <label class="grid gap-y-2">
              <span class="font-bold">{{ lang.get("words.PasswordConfirmation") }}</span>
              <input
                v-model="$v.form.password_confirmation.$model"
                class="h-14 w-full rounded-lg bg-b-input border-b-input focus:placeholder:opacity-0"
                type="password"
                placeholder="Confirm Password"
              />
            </label>
            <error-input :password_confirmation="true"></error-input>
          </div>
        </div>
        <div class="grid gap-6">
          <ui-button v-show="!requested"
            @click.prevent="submit"
            :type="'create'"
            :size="'full'"
            :withLoading="loading"
            :disabled="anyError"
            class="text-white font-bold">
            <span>{{ lang.get('words.Confirm') }}</span>
          </ui-button>
          <router-link v-show="reset_success" :to="{ name: 'login' }" class="text-b-link text-center">{{ lang.get('words.BackToLogin') }}</router-link>
        </div>
      </div>
    </form>
  </div>
</template>
<script>
import Vue from "vue";
import { getters, mutations, actions } from "../../store";
import { required, minLength, sameAs, email, helpers } from "vuelidate/lib/validators";

export default {
  data() {
    return {
      requested: false,
      reset_type: 'send-email', // send-email, reset-password
      reset_success: false,
      form: {
        email: "",
        new_password: "",
        password_confirmation: ""
      },
      errors: {},
    };
  },
  created() {
    this.RESET = {
      sendEmail: 'send-email',
      resetPass: 'reset-password'
    }

    let isResetPassword = this._.get(this.$route.params, 'type') == 'reset-password';
    if (isResetPassword) {
      this.reset_type = this.RESET.resetPass;
    }
  },
  validations: {
    form: {
      email: {
        required,
        email,
        minLength: minLength(4),
        maxLength: 50,
      },
      new_password: {
        required, minLength: minLength(4), maxLength: 60
      },
      password_confirmation: {
        required
        // isPassword: () => {
        //   console.log(this.$v.form.password);
        //   return this.$v.form.password.$model == this.$v.form.password_confirmation.$model
        // }
      }
    },
  },
  methods: {
    ...mutations, ...actions,
    submit() {
      this.errors = null;
      let formData = this.form;
      let url = (this.reset_type == this.RESET.sendEmail) ? 'api/password/email' : 'api/password/reset';

      if (this.reset_type == this.RESET.sendEmail)
        this.sendEmail(url, formData)
      else // reset password
        this.resetPass(url, formData)
    },
    sendEmail: function (url, formData) {
      mutations.setLoading(true)

      this.$http
        .post(url, formData)
        .then((response) => {
          if (_.has(response, "data.errors")) {
            this.errors = response.data.errors;
          } else if (_.has(response, "data.exception")) {
            let alertData = {
              showAlert: true,
              type: "error",
              message:
                "Sorry our server has problem at the moment. Please come back later. Thank you.",
            };
            mutations.setAlert(alertData);
          } else {
            // SUCCESS

            localStorage.setItem(
            "community.reset_password",
              JSON.stringify(response.data)
            );
            this.requested = true
          }
        })
        .catch(function (error) {
          console.log(error);
        })
        .finally(() => {
          mutations.setLoading(false);
        });
    },
    resetPass(url, formData) {
      mutations.setLoading(true)
      let form_data = this._.merge(formData, JSON.parse(localStorage['community.reset_password']))

      this.$http
        .post(url, form_data)
        .then((response) => {
          if (_.has(response, "data.errors")) {
            this.errors = response.data.errors;
          } else if (_.has(response, "data.exception")) {
            let alertData = {
              showAlert: true,
              type: "error",
              message:
                "Sorry our server has problem at the moment. Please come back later. Thank you.",
            };
            mutations.setAlert(alertData);
          } else {
            // SUCCESS
            this.resetForm();
            localStorage.removeItem('community.reset_password')
            this.reset_success = true;
            let alertData = {
              showAlert: true,
              type: "success",
              message:
                "You have successfully changed your password.",
            };
            mutations.setAlert(alertData);
          }
        })
        .catch(function (error) {
          console.log(error);
        })
        .finally(() => {
          mutations.setLoading(false);
        });
    },
    resetForm() {
      this.form = {
        email: '',
        new_password: '',
        password_confirmation: '',
      }
    }
  },
  computed: {
    ...getters,
    inputEmail: function () {
      return this.$v.form.email.$error;
    },
    inputNewPassword: function () {
      return this.$v.form.new_password.$error;
    },
    inputPasswordC: function() {
      return this.$v.form.password_confirmation.$error;
    },
    anyError: function() {
      return this.$v.form.$anyError || !this.$v.form.$anyDirty || this.form.new_password != this.form.password_confirmation
    }
  },
  watch: {
    inputEmail: {
      handler(value) {
        this.errors.email = null;
      },
    },
    inputNewPassword: {
      handler(value) {
        this.errors.new_password = null;
      },
    },
    inputPasswordC: {
      handler(value) {
        this.errors.password_confirmation = null;
      },
    },
    immediate: true,
    deep: true,
  },
};
</script>
<style scoped lang="scss">
@import "../../../sass/imports";
</style>
