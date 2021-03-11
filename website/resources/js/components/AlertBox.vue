<template>

</template>

<script>
import {EventBus} from "../EventBus";

export default {
    name: "AlertBox",
    created() {
        EventBus.$on('showAlert', this.showAlert);
    },
    data: function () {
        return {
            type: null,
            title: null,
            message: null,
            duration: null,
            toast: null,
            position: null,
        }
    },

    methods: {
        showAlert(alertData) {
            this.parseData(alertData);
            this.$swal({
                position: this.position,
                icon: this.type,
                title: this.title,
                showConfirmButton: false, // there is no use case where the buttons should be displayed
                toast: this.toast,
                timer: this.duration,
            });
        },
        parseData(data) {
            this.type = this.validateData('type', data, 'success');
            this.title = this.validateData('title', data);
            this.message = this.validateData('message', data);
            this.duration = this.validateData('duration', data, 1000);
            this.toast = this.validateData('toast', data, true);
            this.position = this.validateData('position', data, 'top-end');

        },
        validateData(key, data, defaultVal = '') {
            return key in data ? data[key] : defaultVal;
        }

    }

}
</script>

<style scoped>

</style>
