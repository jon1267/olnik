<template>
    <div class="row">

        <!--<bootstrap-alert v-if="showAlert"></bootstrap-alert>-->

        <div v-if="showSpinner" class="col-md-1 col-md-offset-5">
            <i class="fa fa-spinner fa-spin fa-3x fa-fw"></i>
            <span class="sr-only">Loading...</span>
        </div>

        <div v-if="showSearch" class="col-md-12 ml-0 mb-3">
                <form @submit.prevent="searchProperties" id="search-form" method="get" class="form-inline">

                    <div class="col-md-2 form-group ml-0">
                        <label for="name" class="control-label">Name</label>
                        <input v-model="searchProps.name" type="text" class="form-control" id="name" name="name" placeholder="Name" value="">
                    </div>

                    <div class="col-md-2 ">
                        <label for="price_min" class="control-label">Price From</label>
                        <input v-model="searchProps.price_min" type="number"  min="100000" max="1000000" class="form-control" id="price_min" name="price_min" placeholder="Price From" value="">
                    </div>

                    <div class="col-md-2 form-group">
                        <label for="price_max" class="control-label">Price To</label>
                        <input v-model="searchProps.price_max" type="number"  min="100000" max="1000000"  class="form-control" id="price_max" name="price_max" placeholder="Price To" value="">
                    </div>

                    <div class="col-md-1 ">
                        <label for="bedrooms" class="control-label">Bedrooms</label>
                        <input v-model="searchProps.bedrooms" type="number" min="1" max="255" class="form-control" id="bedrooms" name="bedrooms" placeholder="Bedrooms" value="">
                    </div>

                    <div class="col-md-1 form-group">
                        <label for="bathrooms" class="control-label">Bathrs</label>
                        <input v-model="searchProps.bathrooms" type="number" min="1" max="255" class="form-control" id="bathrooms" name="bathrooms" placeholder="Bat" value="">
                    </div>

                    <div class="col-md-1 form-group">
                        <label for="storeys" class="control-label">Storeys</label>
                        <input v-model="searchProps.storeys" type="number" min="1" max="255" class="form-control" id="storeys" name="storeys" placeholder="Stors" value="">
                    </div>

                    <div class="col-md-1 form-group">
                        <label for="garages" class="control-label">Garages</label>
                        <input v-model="searchProps.garages" type="number" min="1" max="255" class="form-control" id="garages" name="garages" placeholder="Gar" value="">
                    </div>

                    <div class="col-md-2 form-group pt-2">
                        <button type="submit" id="submit-search" class="btn btn-info btn-sm" title="Search data" > <i class="fa fa-search" aria-hidden="true"></i> &nbsp;&nbsp;Find </button>
                        <a @click="hideSearch" class="btn btn-danger btn-sm"  name="cancel-search"  title="Cancel Search Data ">&times;</a>
                    </div>

                </form>
            </div>


    </div>
</template>

<script>
    export default {
        data() {
            return {
                searchProps: {
                    id: '', name: '', price_min: '',price_max: '',
                    bedrooms: '', bathrooms: '',
                    storeys: '', garages: ''
                },
                showSearch: true,
                showAlert: false,
                showSpinner: false,
            }
        },
        methods: {
            searchProperties() {
                this.showSpinner = true;
                this.showSearch = false;
                this.showAlert = false;
                this.$emit('hide-table');

                let url_string = '?' + 'name='+this.searchProps.name+
                    '&price_min='+this.searchProps.price_min+
                    '&price_max='+this.searchProps.price_max+
                    '&bedrooms='+this.searchProps.bedrooms+
                    '&bathrooms='+this.searchProps.bathrooms+
                    '&storeys='+this.searchProps.storeys+
                    '&garages='+this.searchProps.garages;
                fetch('api/search'+url_string, {
                    method: 'get',
                })
                    .then(res => res.json())
                    .then(res => {
                        //console.log(res.data);
                        if(res.data) {
                            // что то найдено -
                            this.$emit('searched','api/search'+url_string);
                            this.showAlert = false;
                            this.showSpinner = false;
                            this.showSearch = true;
                        } else {
                            // ничего не найдено, показыв форму,
                            // показыв. алерт: ничего не найдено, скрыли таблицу
                            this.showAlert = true;
                            this.showSpinner = false;
                            this.showSearch = true;
                        }
                    })
            },
            hideSearch() {
                // Нажата кнопа выхода из поиска.
                // вывели все имеющ properties скрыли кн поиск и алерт
                this.$emit('searched', false);
                this.showSearch = false;
                this.showAlert = false;
            }
        }
    }
</script>
