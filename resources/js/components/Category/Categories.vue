<template>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div v-if="isLoading">

            </div>
            <div v-if="!isLoading" class="card">
                <div class="card-header header-custom">
                    <h5>Categories</h5>
                    <div>
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#modelId">
                            New Category
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="modelId" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                            <div class="modal-dialog modal-md" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">New Category</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="">Name Category</label>
                                            <input type="text" class="form-control" v-model="category.name" name="" id="" aria-describedby="helpId" placeholder="">
                                        </div>
                                        <div class="form-group">
                                            <label for="">Description Category</label>
                                            <textarea type="text" class="form-control" v-model="category.description" name="" id="" aria-describedby="helpId" placeholder=""></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Status</label>
                                            <select class="form-control" v-model="category.status" name="" id="">
                                                <option value="1">Show</option>
                                                <option value="0">Hide</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="modal-footer" v-if="isDelete">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-danger" @click="remove">Delete</button>
                                        <button type="button" v-if="category.name != '' & category.description != ''" class="btn btn-primary" @click="update">Save</button>
                                    </div>
                                    <div class="modal-footer" v-if="!isDelete">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="button" v-if="category.name != '' & category.description != ''" class="btn btn-primary" @click="create">Save</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">First</th>
                                    <th scope="col">Last</th>
                                    <th scope="col">Handle</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr @click="edit(idx,category)" v-for="(category,idx) in listCategories" :key="idx">
                                    <th scope="row">{{ idx +1 }}</th>
                                    <td>{{ category.name }}</td>
                                    <td>{{ category.description }}</td>
                                    <td v-if="category.status == 1">Public</td>
                                    <td v-if="category.status == 0">Not Public</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script>
export default {
    data() {
        return {
            category: {
                name: '',
                description: '',
                status: 1
            },
            listCategories: [],
            isLoading: true,
            isDelete: false,
            index: '',
            idCategory: ''
        }
    },
    methods: {
        showAlert(title, type, message) {
            this.$swal({
                title: title,
                text: message,
                type: type,
                confirmButtonText: 'Ok'
            });
        },
        hideModal() {
            this.isDelete = false
            $('.modal').modal('hide')
            $('.modal-backdrop').removeAttr('class')
        },
        showModal() {
            $('.modal').modal('show');
        },
        create() {
            this.$http.post('/api/categories', this.category)
                .then(response => {
                    this.listCategories.push(response.body)
                    this.hideModal()
                    this.category = {
                        name: '',
                        description: '',
                        status: 1
                    }
                    this.showAlert('Success', 'success', 'Add New Category Success')
                })
        },
        edit(idx, category) {
            this.showModal()
            this.category = category
            this.isDelete = true
            this.index = idx
            this.idCategory = category.id
        },
        update() {
            this.listCategories.splice(this.index, 1)
            this.listCategories.splice(this.index, 0, this.category)
            this.$http.put('/api/categories/' + this.idCategory, this.category)
                .then(response => {
                    this.hideModal()
                    this.showAlert('Success', 'success', 'Update Category Success')
                    this.category = {
                        name: '',
                        description: '',
                        status: 1
                    }
                })
        },
        remove() {
            this.$swal({
                title: 'Are you sure?',
                text: "You want to delete this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.value) {
                    this.listCategories.splice(this.index, 1)
                    this.hideModal()
                    this.category = {
                        name: '',
                        description: '',
                        status: 1
                    }
                    this.$http.delete('/api/categories/' + this.idCategory)
                        .then(response => {
                            this.showAlert('Success', 'success', 'Delete Category Success')
                        })
                }
            })
        },
        getData() {
            this.$http.get('/api/categories')
                .then(response => {
                    this.listCategories = response.body
                })
                .finally(response => {
                    this.isLoading = false
                })
        }
    },
    mounted() {
        this.getData()
    },
}
</script>

<style lang="scss" scoped>
.header-custom {
    display: flex;
    justify-content: space-between;
}

.modal-content {
    border-radius: unset;
}
</style>
