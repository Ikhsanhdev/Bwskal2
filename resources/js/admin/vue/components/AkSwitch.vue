<template>
    <div class="ak-switch-wrap">
        <label
            class="ak-switch"
            :class="[(size ? 'ak-switch-' + size : '')]">
            <input
                type="checkbox"
                :id="name"
                :name="name"
                :checked="value"
                v-bind:disabled="disabled"
                value="1"
                @change="inputChange"
            >
            <span class="ak-switch-input"></span>
            <span
                class="ak-switch-label"
                :class="labelClass"
                v-if="label"
                v-html="label"
            ></span>
        </label>
    </div>
</template>

<script>
export default {
    name: "ak-switch",
    props: {
        name: String,
        label: String,
        labelClass: {
            type: String,
            default: "",
        },
        disabled: {
            type: Boolean,
            default: false,
        },
        size: {
            type: String,
            default: null,
        },
        value: {
            default: false,
        },
    },
    data() {
        return {};
    },
    methods: {
        inputChange(e) {
            this.$emit("input", e.target.checked);
            this.$emit("change", e.target.checked);
        },
    },
    mounted() {
        // this.isChecked = this.checked;
    },
};
</script>

<style>
</style>