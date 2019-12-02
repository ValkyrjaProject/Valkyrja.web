<template>
    <div class="columns">
        <b-message
            v-for="(errorObj, key) in errors"
            :key="key"
            :title="key"
            type="is-warning"
            aria-close-label="Close message">
            <ul>
                <li
                    v-for="(error, index) in errorObj"
                    :key="key+index">
                    {{ error }}
                </li>
            </ul>
        </b-message>
    </div>
</template>

<script>
export default {
    name: "ValidationErrorsBar",
    props: {
        errorObject: {
            type: Object,
            required: true,
        },
    },
    computed: {
        message() {
            return this.errorObject.message;
        },
        errors() {
            return this.errorObject.errors;
        }
    },
};
</script>

<style lang="scss">
    .image{
        background-color: #7a7a7a;
    }
</style>
