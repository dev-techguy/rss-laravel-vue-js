<template>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h2 class="text-center">Vacancies</h2>
            <div v-if="loading">
                <center>
                    <p class="vertical-center">
                        <circle10></circle10>
                    </p>
                </center>
            </div>
            <nav aria-label="Page navigation example">
                <ul class="pagination">
                    <li v-bind:class="[{disabled: !pagination.prev_page_url}]" class="page-item"><a class="page-link"
                                                                                                    href="#"
                                                                                                    @click="fetchVacancies(pagination.prev_page_url)">Previous</a>
                    </li>
                    <li class="page-item disabled"><a class="page-link text-dark" href="#">
                        Page {{ pagination.current_page }} of {{ pagination.last_page }}</a></li>
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
            </div>
        </div>
    </div>
</template>

<script>
    import dayjs from 'dayjs';
    import relativeTime from 'dayjs/plugin/relativeTime';
    import {Circle10} from 'vue-loading-spinner';

    export default {
        name: "Home",
        components: {
            Circle10
        },
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
                loading: false,
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
                this.loading = true;
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
                        this.loading = false;
                        vm.makePagination(res.meta, res.links);
                    })
                    .catch(err => {
                        this.loading = false;
                        this.$swal('Loading Failed', 'Failed to load data.', 'error');
                        console.log(err);
                    })
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
        }
    }
</script>
