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
                        alert('You have successfully subscribed, we will keep you updated on job search. Thank you.');
                    })
                    .catch(err => console.log(err))
            }
        }
    }
</script>

<style scoped>

</style>
