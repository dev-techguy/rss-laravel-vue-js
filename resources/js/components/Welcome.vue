<template>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h2 class="text-center">To get daily job posting, kindly subscribe with us.</h2>
            <form @submit.prevent="subscribeUser()" class="mb-3">
                <div class="form-group">
                    <input type="email" class="form-control" placeholder="Enter your e-mail address"
                           v-model="subscribe.email"
                           required>
                </div>
                <button type="submit" class="btn btn-outline-primary btn-block mb-2">Subscribe</button>
            </form>
        </div>
    </div>
</template>

<script>
    import Vue from 'vue';
    import 'sweetalert2/dist/sweetalert2.min.css';
    import VueSweetalert2 from "vue-sweetalert2";

    Vue.use(VueSweetalert2);

    export default {
        name: "Welcome",
        data() {
            return {
                subscribe: {
                    email: ''
                }
            }
        },
        methods: {
            subscribeUser() {
                this.$swal({
                    title: 'Are you sure?',
                    text: 'You can\'t revert your action',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes Subscribe it!',
                    cancelButtonText: 'No, Ignore it!',
                    showCloseButton: true,
                    showLoaderOnConfirm: true
                }).then((result) => {
                    if (result.value) {
                        fetch('/api/subscribe', {
                            method: 'post',
                            body: JSON.stringify(this.subscribe),
                            headers: {
                                'content-type': 'application/json'
                            }
                        })
                            .then(res => res.json())
                            .then(data => {
                                this.subscribe.email = '';
                                this.$swal('Subscribe', 'You have successfully subscribed, we will keep you updated on job search. Thank you.', 'success');
                            })
                            .catch(err => this.$swal('Subscribe', 'Subscription failed. Kindly check your email.', 'error'))
                    } else {
                        this.$swal('Cancelled', 'Your have canceled subscription', 'info')
                    }
                });
            }
        }
    }
</script>

<style scoped>

</style>
