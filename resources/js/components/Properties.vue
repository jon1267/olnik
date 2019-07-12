<template>
    <div>
        <div class="row align-items-center mt-4">
            <div class="col-md-8">
                <h2>Properties</h2>
            </div>
            <div class="col-md-4 text-right">
                <a href="#" @click="showAddForm"  v-show="showButtons" class="btn btn-primary btn-sm" title="Add New Data "> <i class="fas fa-plus"></i>&nbsp;&nbsp; Add </a>
                <a href="#" @click="showFindForm" v-show="showButtons" class="btn btn-info btn-sm" title="Show search form" type=""> <i class="fas fa-search"></i> &nbsp;&nbsp;Find</a>
            </div>
        </div>

        <div v-if="showFind">
            <search-form v-on:searched="showSearchResult"
                         v-on:hide-table="showTable = false"
                         v-on:show-table="showTable = true">
            </search-form>
        </div>

        <add-form v-if="showAdd" v-on:added="afterAddProperty"></add-form>

        <edit-form v-if="showEdit" v-on:updated="afterAddProperty"
                   :id = property.id
                   :name = property.name
                   :price = property.price
                   :bedrooms = property.bedrooms
                   :bathrooms = property.bathrooms
                   :storeys = property.storeys
                   :garages = property.garages>
        </edit-form>

        <div v-show="showTable">
            <table class="table table-bordered table-striped" >
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th class="tac">Price</th>
                    <th class="tac">Bedrooms</th>
                    <th class="tac">Bathrooms</th>
                    <th class="tac">Storeys</th>
                    <th class="tac">Garages</th>
                    <th class="tac">Actions</th>
                </tr>
                </thead>

                <tbody>
                <tr v-for="property in properties" v-bind:key="property.id">
                    <td>{{ property.id }}</td>
                    <td>{{ property.name }}</td>
                    <td class="tac">{{ property.price }}</td>
                    <td class="tac">{{ property.bedrooms }}</td>
                    <td class="tac">{{ property.bathrooms }}</td>
                    <td class="tac">{{ property.storeys }}</td>
                    <td class="tac">{{ property.garages }}</td>
                    <td class="tac">
                        <form action="" class="form-inline " method="POST">
                            <div class="form-group mx-auto">
                                <a href="#" @click="editProperty(property)" v-show="showButtons" class="btn btn-primary btn-sm mr-1" title="Edit data"> <i class="fas fa-pencil-alt"></i> </a>
                                <a href="#" @click="deleteProperty(property.id)" v-show="showButtons" class="btn btn-danger btn-sm" title="Delete data" > <i class="fas fa-trash-alt"></i> </a>
                            </div>
                        </form>
                    </td>
                </tr>
                </tbody>
            </table>


            <!-- пагинация... (пока закомментил бо шось не те)
            <div class="pull-left">
                <ul class="pagination">
                    <li>Page {{ pagination.current_page}}
                        of {{ pagination.last_page}} </li>
                </ul>
            </div>

            <div class="pull-right">
                <nav aria-label="Page navigation">
                    <ul class="pagination">
                        <li v-bind:class="[{disabled: !pagination.prev_page_url}]" >
                            <a href="#" aria-label="Previous" @click="fetchProperties(pagination.prev_page_url)">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>

                        <li v-bind:class="[{disabled: !pagination.next_page_url}]">
                            <a href="#" aria-label="Next" @click="fetchProperties(pagination.next_page_url)">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>-->

        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                properties: [],
                property: {
                    id: '', name: '', price: '',
                    bedrooms: '', bathrooms: '',
                    storeys: '', garages: ''
                },
                property_id: '',
                pagination: {},
                showFind: false,
                showAdd: false,
                showEdit: false,
                showButtons: true,
                showTable: true,
            }
        },

        created() {
            this.fetchProperties();
        },

        methods: {
            fetchProperties(page_url) {
                let vm = this;
                page_url = page_url || 'api/prop';
                fetch(page_url)
                    .then(res => res.json())
                    .then(res => {
                        //console.log(res.data);
                        this.properties = res.data;
                        //vm.makePagination(res.meta, res.links);
                    })
                    .catch(err => console.log(err));
            },

            makePagination(meta, links) {
                let pagination = {
                    current_page: meta.current_page,
                    last_page: meta.last_page,
                    next_page_url: links.next,
                    prev_page_url: links.prev,
                };

                this.pagination = pagination;
            },

            deleteProperty(id) {
                if(confirm('Are you sure you want to delete this ?')) {
                    fetch(`api/prop/${id}`, {
                        method: 'delete'
                    })
                        .then(res => res.json())
                        .then(data => {
                            alert('Property Removed');
                            this.fetchProperties();
                        })
                        .catch(err => console.log(err))
                }
            },

            editProperty(property) {
                this.property.property_id = property.id;
                this.property.id = property.id;
                this.property.name = property.name;
                this.property.price = property.price;
                this.property.bedrooms = property.bedrooms;
                this.property.bathrooms = property.bathrooms;
                this.property.storeys = property.storeys;
                this.property.garages = property.garages;
                this.showEditForm();
            },

            showSearchResult(page_params) {
                if(page_params === false) {
                    this.fetchProperties();
                    this.showButtons = true;
                    this.showTable = true;
                    this.showFind = false;
                    this.showAdd = false;
                    this.showEdit =false;
                } else {
                    this.fetchProperties(page_params);
                    this.showTable = true;
                }
            },

            afterAddProperty() {
                this.fetchProperties();
                this.showButtons = true;
                this.showTable = true;
                this.showFind = false;
                this.showAdd = false;
                this.showEdit =false;
            },

            showAddForm() {
                this.showAdd = true;
                this.showFind = false;
                this.showButtons = false;
            },

            showFindForm() {
                this.showFind = true;
                this.showAdd = false;
                this.showButtons = false;
            },

            showEditForm() {
                this.showEdit = true;
                this.showFind = false;
                this.showButtons = false;
            },

        }
    };
</script>



