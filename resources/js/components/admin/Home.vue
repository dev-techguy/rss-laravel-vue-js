<template>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h2 class="text-center">Vacancies</h2>
            <form @submit.prevent="addVacancy()" class="mb-3">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Vacancy Name" v-model="vacancy.name" required>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Company Name" v-model="vacancy.company"
                           required>
                </div>
                <div class="form-group">
                <textarea class="form-control" rows="10" placeholder="Vacancy Description" required
                          v-model="vacancy.description"></textarea>
                </div>
                <button type="submit" class="btn btn-outline-primary btn-block mb-2">Save</button>
            </form>
            <nav aria-label="Page navigation example">
                <ul class="pagination">
                    <li v-bind:class="[{disabled: !pagination.prev_page_url}]" class="page-item"><a class="page-link"
                                                                                                    href="#"
                                                                                                    @click="fetchVacancies(pagination.prev_page_url)">Previous</a>
                    </li>
                    <li class="page-item disabled"><a class="page-link text-dark" href="#">Page {{
                        pagination.current_page }} of {{ pagination.last_page }}</a></li>
                    <li v-bind:class="[{disabled: !pagination.next_page_url}]" class="page-item"><a class="page-link"
                                                                                                    href="#"
                                                                                                    @click="fetchVacancies(pagination.next_page_url)">Next</a>
                    </li>
                </ul>
            </nav>
            <div class="card card-body mb-2" v-for="vacancy in vacancies" v-bind:key="vacancy.id">
                <h3>{{ vacancy.name }}</h3>
                <h6><i><b>Company</b></i> <i class="text-primary">{{ vacancy.company }}</i></h6>
                <p>{{ vacancy.description }}</p>
                <hr>
                <p class="text-muted text-right"><b>Posted {{ vacancy.updated_at | diffForHumans }}</b></p>
                <hr>
                <button @click="editVacancy(vacancy)" class="btn btn-warning mb-2">Edit</button>
                <button @click="deleteVacancy(vacancy.id)" class="btn btn-danger">Delete</button>
            </div>
        </div>
    </div>
</template>

<script>
    import dayjs from "dayjs";
    import relativeTime from "dayjs/plugin/relativeTime";
    import Vue from 'vue';
    import 'sweetalert2/dist/sweetalert2.min.css';
    import VueSweetalert2 from "vue-sweetalert2";

    Vue.use(VueSweetalert2);

    export default {
        name: "Home",
        filters: {
            diffForHumans: (date) => {
                if (!date) {
                    return null;
                }

                return dayjs(date).fromNow();
            }
        },
        data() {
            return {
                secret: '6H1H7W80jqXhBa4XTC81wgqkpsgWQfld3RqvgEzFy0awDSPACxpfYkfj6nUGULv3',
                vacancies: [],
                vacancy: {
                    id: '',
                    name: '',
                    company: '',
                    description: '',
                    updated_at: '',
                },
                vacancy_id: '',
                pagination: {},
                edit: false
            }
        },
        created() {
            this.fetchVacancies();
            dayjs.extend(relativeTime);
        },
        methods: {
            /**
             * function to fetch all items with
             * pagination
             * */
            fetchVacancies(page_url) {
                let vm = this;
                page_url = page_url || '/api/vacancies';
                fetch(page_url, {
                    headers: {
                        'Authorization': this.secret,
                        'content-type': 'application/json'
                    }
                })
                    .then(res => res.json())
                    .then(res => {
                        this.vacancies = res.data;
                        vm.makePagination(res.meta, res.links);
                    })
                    .catch(err => console.log(err))
            },
            /**
             * function to set pagination
             * */
            makePagination(meta, links) {
                let pagination = {
                    current_page: meta.current_page,
                    last_page: meta.last_page,
                    next_page_url: links.next,
                    prev_page_url: links.prev,
                };
                this.pagination = pagination;
            },
            /**
             * function to delete
             * an vacancy
             * */
            deleteVacancy(id) {
                this.$swal({
                    title: 'Are you sure?',
                    text: 'You can\'t revert your action',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes Delete it!',
                    cancelButtonText: 'No, Keep it!',
                    showCloseButton: true,
                    showLoaderOnConfirm: true
                }).then((result) => {
                    if (result.value) {
                        fetch(`/api/vacancy/${id}`, {
                            method: 'delete',
                            headers: {
                                'Authorization': this.secret,
                                'content-type': 'application/json'
                            }
                        })
                            .then(res => res.json())
                            .then(data => {
                                this.$swal('Delete Vacancy', 'Vacancy Removed.', 'success');
                                this.fetchVacancies();
                            })
                            .catch(err => this.$swal('Subscribe', 'Deletion failed. Kindly check and try again.', 'error'))
                    } else {
                        this.$swal('Cancelled', 'Your data is still intact', 'info')
                    }
                });
            },
            /**
             * function to add
             * an vacancy
             * */
            addVacancy() {
                if (this.edit === false) {
                    this.$swal({
                        title: 'Are you sure?',
                        text: 'You can\'t revert your action',
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Yes Add it!',
                        cancelButtonText: 'No, Ignore it!',
                        showCloseButton: true,
                        showLoaderOnConfirm: true
                    }).then((result) => {
                        if (result.value) {
                            fetch('/api/vacancy', {
                                method: 'post',
                                body: JSON.stringify(this.vacancy),
                                headers: {
                                    'Authorization': this.secret,
                                    'content-type': 'application/json'
                                }
                            })
                                .then(res => res.json())
                                .then(data => {
                                    this.vacancy.name = '';
                                    this.vacancy.company = '';
                                    this.vacancy.description = '';
                                    this.$swal('New Vacancy', 'Vacancy Added.', 'success');
                                    this.fetchVacancies();
                                })
                                .catch(err => this.$swal('Subscribe', 'Creation failed. Kindly check and try again.', 'error'))
                        } else {
                            this.$swal('Cancelled', 'Your data is still intact', 'info')
                        }
                    });
                } else {
                    this.$swal({
                        title: 'Are you sure?',
                        text: 'You can\'t revert your action',
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Yes Update it!',
                        cancelButtonText: 'No, Keep it!',
                        showCloseButton: true,
                        showLoaderOnConfirm: true
                    }).then((result) => {
                        if (result.value) {
                            fetch('/api/vacancy', {
                                method: 'put',
                                body: JSON.stringify(this.vacancy),
                                headers: {
                                    'Authorization': this.secret,
                                    'content-type': 'application/json',
                                }
                            })
                                .then(res => res.json())
                                .then(data => {
                                    this.vacancy.name = '';
                                    this.vacancy.company = '';
                                    this.vacancy.description = '';
                                    this.$swal('Update Vacancy', 'Vacancy Updated.', 'success');
                                    this.fetchVacancies();
                                })
                                .catch(err => this.$swal('Subscribe', 'Updating failed. Kindly check and try again.', 'error'))
                        } else {
                            this.$swal('Cancelled', 'Your data is still intact', 'info')
                        }
                    });
                }
            },
            /**
             * function to ser
             * the edit to true
             * */
            editVacancy(vacancy) {
                this.edit = true;
                this.vacancy.id = vacancy.id;
                this.vacancy.vacancy_id = vacancy.id;
                this.vacancy.name = vacancy.name;
                this.vacancy.company = vacancy.company;
                this.vacancy.description = vacancy.description;

            }
        }
    }
</script>
