<template>
    <div >
        <div v-if="showAdd" class="col-12 mb-3">
            <form @submit.prevent="addProperty" id="add-form" class="form-inline">

                <div class="row justify-content-between">
                <div class="col-md-2 form-group mr-2">
                    <label for="name" class="control-label">Property Name</label>
                    <input v-model="property.name" type="text" class="form-control"  id="name" name="name" placeholder="Name" value="">
                </div>

                <div class="col-md-2 form-group">
                    <label for="price" class="control-label ">Property Price</label>
                    <input v-model="property.price" type="number"  min="1" max="10000000" class="form-control" id="price" name="price" placeholder="Price" value="">
                </div>

                <div class="col-md-2 form-group">
                    <label for="bedrooms" class="control-label">Bedrooms</label>
                    <input v-model="property.bedrooms" type="number" min="1" max="255" class="form-control" id="bedrooms" name="bedrooms" placeholder="Bedrooms" value="">
                </div>

                <div class="col-md-1 form-group">
                    <label for="bathrooms" class="control-label">Bathrooms</label>
                    <input v-model="property.bathrooms" type="number" min="1" max="255" class="form-control" id="bathrooms" name="bathrooms" placeholder="Bathrooms" value="">
                </div>

                <div class="col-md-1 form-group">
                    <label for="storeys" class="control-label">Storeys</label>
                    <input v-model="property.storeys" type="number" min="1" max="255" class="form-control" id="storeys" name="storeys" placeholder="Stors" value="">
                </div>

                <div class="col-md-1 form-group">
                    <label for="garages" class="control-label">Garages</label>
                    <input v-model="property.garages" type="number" min="1" max="255" class="form-control" id="garages" name="garages" placeholder="Gar" value="">
                </div>


                <div class="col-md-2 form-group pt-3">
                    <button type="submit" id="submit-add" name="submit-add" class="btn btn-info btn-sm mt5 ml5" title="Save data" > <i class="fas fa-save" ></i>&nbsp;&nbsp;Save</button>
                    <a @click="hideAdd" class="btn btn-danger btn-sm mt5"  name="cancel-edit"  title="Cancel Add Data ">&times;</a>
                </div>
                </div>

            </form>
        </div>

    </div>
</template>

<script>
    export default {
        data() {
            return {
                property: {
                    id: '', name: '', price: '',
                    bedrooms: '', bathrooms: '',
                    storeys: '', garages: ''
                },
                property_id: '',
                showAdd: true,
            }
        },

        methods: {
            addProperty() {
                fetch('api/prop', {
                    method: 'post',
                    body: JSON.stringify(this.property),
                    headers: {
                        'content-type': 'application/json'
                    }
                })
                    .then(res => res.json())
                    .then(data => {
                        for(var key in this.property) this.property[key] = '';
                        alert('Data was Added');
                        this.$emit('added');
                    })
                    .catch(err => console.log(err))
            },
            hideAdd() {
                this.$emit('added');
                this.showAdd = false;
            },
        }
    }
</script>