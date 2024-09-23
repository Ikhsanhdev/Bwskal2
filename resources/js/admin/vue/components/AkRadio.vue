
<template>
    <div class="ak-checkbox">
        <input
            type="checkbox"
            :id="name"
            :name="name"
            :checked="value"
            :disabled="disabled"
            value="1"
            @change="inputChange"
        >
        <label
            v-bind:for="name"
            class="cb"
        ></label>
        <label
            v-if="label"
            v-bind:for="name"
            class="label"
            :class="labelClass"
            v-html="label"
        ></label>
    </div>
</template>

<script>
export default {
    name: "ak-checkbox",
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
        value: {
            default: false,
        },
    },
    methods: {
        inputChange(e) {
            this.$emit("input", e.target.checked);
            this.$emit("change", e.target.checked);
        },
    },
};
</script>

<style>
</style>