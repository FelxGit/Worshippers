<template>
  <div id="errorInputComponent" class="error-input">
    <!-- First Name -->
    <div v-if="_.get($parent.errors, name, false)">
        <span v-for="(message, key, index) in $parent.errors[name]" :key="key" :class="[
            'error-text',
            { 'block': _.get($parent.errors, name, false) }
        ]">{{ message }}</span>
    </div>
    <div v-else>
        <div v-for="(condition, index) in validations" :key="index" class="error-text">
            <!-- custom additional messages -->
            <span v-if="cond(condition) == 'same'
            && $parent.$v.form[name].$model != $parent.$v.form['password'].$model
            && $parent.$v.form[name].$anyDirty" class="error-text">{{ errorMessage(condition, name) }}</span>

            <span v-else-if="cond(condition) == 'date'
            && !$parent.$v.form[name].required
            && !$parent.$v.form[name].checked
            && $parent.$v.form[name].$anyDirty" class="error-text">{{ errorMessage(condition, name) }}</span>

            <span v-else-if="cond(condition) == 'accepted'
            && !$parent.$v.form[name].$model
            && $parent.$v.form[name].$anyDirty" class="error-text">{{ errorMessage(condition, name) }}</span>

            <span v-else-if="!$parent.$v[`form`][name][cond(condition)]
            && anyDirty
            && cond(condition) != 'same'
            && cond(condition) != 'date'">{{ errorMessage(condition, name) }}</span>
        </div>
    </div>
  </div>
</template>

<script>
import { getters, mutations, actions } from '../store'

export default {
    name: 'error-input',
    props: {
        name: {
            type: String,
            default: ''
        },
        validations: {
            type: Array,
            default: []
        }
    },
    data() {
        return {
            isDirty: false
        }
    },
    methods: {
        errorMessage (condition, name) {
            // laravel keyword to vuelidate
            let validationVal;
            let cond = condition.split('.')[0];
            let capName = name.replace('_', ' ');

            if (cond == 'max') {
                validationVal = this.$parent.$v.form[name].$params[`${cond}Length`].max;
            } else if(cond == 'min') {
                validationVal = this.$parent.$v.form[name].$params[`${cond}Length`].min;
            } else {
                let type = this._.get(this.$parent.$v.form[name].$params[cond], 'type')
                validationVal = type

                if(!type) {
                    validationVal = cond;
                }
            }

            return this.lang.get(`validation.${condition}`)
            .replace(':attribute', name.replace('_', ' '))
            .replace(':value', validationVal)
            .replace(':max', validationVal)
            .replace(':min', validationVal)
            .replace(':other', name.replace('_confirmation', ''))
        },
        cond(condition) {
            return condition.split('.')[0] == 'max' || condition.split('.')[0] == 'min'? condition.split('.')[0] + 'Length' : condition.split('.')[0];
        }
    },
    computed: {
        ...getters,
        // register() {
        //     console.log(this.$props);
        //     return {
        //         name: this.name,
        //         email: this.email,
        //         password: this.password,
        //         password_confirmation: this.password_confirmation,
        //         address: this.address,
        //         zip_code: this.zip_code,
        //         tel: this.tel,
        //         nick_name: this.nick_name,
        //         birth_date: this.birth_date,
        //         gender: this.gender
        //     }
        // }
        anyDirty() {
            let anyDirty = this.$parent.$v[`form`][this.name].$anyDirty;
            if(this.name == 'plain_description' && anyDirty && !this.isDirty) {
                this.isDirty = true // set to dirty on load
                anyDirty = false
            }
            return anyDirty;
        }
    },
    watch: {
    }
}
</script>

<style scoped lang="scss">
@import '../../sass/imports';
.error-text {
    color: red
}

</style>