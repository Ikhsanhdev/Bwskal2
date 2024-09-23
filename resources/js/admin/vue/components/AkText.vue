<template>
    <div class="form-group">
        <label v-if="label">{{ label }}</label>
        <div class="form-control h-auto">{{ value ? value : '-' }}</div>
    </div>
</template>

<script>
export default {
    name: 'ak-text',
    props: [
        'label',
        'value'
    ]
}
</script>