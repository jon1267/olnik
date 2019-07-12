<template>
    <div class="row">
        <div v-if="showEdit" class="col-md-12 mb-3">
            <form @submit.prevent="editProperty" id="edit-form" class="form-inline">

                <div class="col-md-2 form-group mr-3">
                    <label for="name" class="control-label">Property Name</label>
                    <input v-model="property.name" type="text" class="form-control"  id="name" name="name" placeholder="Name" value="">
                </div>

                <div class="col-md-2 form-group">
                    <label for="price" class="control-label">Property Price</label>
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

                <div class="col-md-1 ">
                    <label for="storeys" class="control-label">Storeys</label>
                    <input v-model="property.storeys" type="number" min="1" max="255" class="form-control" id="storeys" name="storeys" placeholder="Stors" value="">
                </div>

                <div class="col-md-1 form-group">
                    <label for="garages" class="control-label">Garages</label>
                    <input v-model="property.garages" type="number" min="1" max="255" class="form-control" id="garages" name="garages" placeholder="Gar" value="">
                </div>

                <div class="col-md-2 pt-3">
                    <button type="submit" id="submit-edit" class="btn btn-info mt5 ml5 btn-sm" title="Update data" > <i class="fa fa-save" aria-hidden="true"></i>&nbsp;&nbsp;Save</button>
                    <a @click="hideEdit" class="btn btn-danger mt5 btn-sm" name="showEdit" title="Cancel Update Data ">&times;</a>
                </div>
            </form>
        </div>

    </div>
</template>

<script>
    export default {
        props: [
            'id','name', 'price', 'bedrooms', 'bathrooms', 'storeys', 'garages'
        ],

        data() {
            return {
                property: {
                    id: this.id,
                    name: this.name,
                    price: this.price,
                    bedrooms: this.bedrooms,
                    bathrooms: this.bathrooms,
                    storeys: this.storeys,
                    garages: this.garages
                },
                property_id: this.id,
                showEdit: true,
            }
        },

        methods: {
            editProperty() {
                //fetch('api/prop', {
                fetch(`api/prop/${this.id}`, {
                    method: 'put',
                    body: JSON.stringify(this.property),
                    headers: {
                        'content-type': 'application/json'
                    }
                })
                    .then(res => res.json())
                    .then(data => {
                        for(var key in this.property) this.property[key] = '';
                        alert('Data was Updated');
                        this.$emit('updated');
                        this.showEdit = false;
                    })
                    .catch(err => console.log(err))
            },
            hideEdit() {
                this.$emit('updated')
                this.showEdit = false;
            },
        }
    }
</script>
