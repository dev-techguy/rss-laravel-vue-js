<template>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h2 class="text-center">Vacancies</h2>
            <nav aria-label="Page navigation example">
                <ul class="pagination">
                    <li v-bind:class="[{disabled: !pagination.prev_page_url}]" class="page-item"><a class="page-link"
                                                                                                    href="#"
                                                                                                    @click="fetchVacancies(pagination.prev_page_url)">Previous</a>
                    </li>
                    <li class="page-item disabled"><a class="page-link text-dark" href="#">Page {{
                        pagination.current_page
                        }} of {{ pagination.last_page }}</a></li>
                    <li v-bind:class="[{disabled: !pagination.next_page_url}]" class="page-item"><a class="page-link"
                                                                                                    href="#"
                                                                                                    @click="fetchVacancies(pagination.next_page_url)">Next</a>
                    </li>
                </ul>
            </nav>
            <div class="card card-body mb-2" v-for="vacancy in vacancies" v-bind:key="vacancy.id">
                <h3>{{ vacancy.name }}</h3>
                <h6>{{ vacancy.company }}</h6>
                <p>{{ vacancy.description }}</p>
                <hr>
                <p class="float-right">
                    <vue-moments-ago prefix="posted" suffix="ago" v-bind:date="vacancy.updated_at"></vue-moments-ago>
                </p>
                <hr>
            </div>
        </div>
    </div>
</template>

<script>
    import VueMomentsAgo from 'vue-moments-ago'

    export default {
        name: "Home",
        components: {
            VueMomentsAgo
        },
        data() {
            return {
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
        },
        methods: {
            /**
             * function to fetch all items with
             * pagination
             * */
            fetchVacancies(page_url) {
                let vm = this;
                page_url = page_url || '/api/vacancies';
                fetch(page_url)
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
        }
    }
</script>
