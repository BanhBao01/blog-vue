<template>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
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
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary" @click="create">Save</button>
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
                                <tr>
                                    <th scope="row">1</th>
                                    <td>Mark</td>
                                    <td>Otto</td>
                                    <td>@mdo</td>
                                </tr>
                                <tr>
                                    <th scope="row">2</th>
                                    <td>Jacob</td>
                                    <td>Thornton</td>
                                    <td>@fat</td>
                                </tr>
                                <tr>
                                    <th scope="row">3</th>
                                    <td>Larry</td>
                                    <td>the Bird</td>
                                    <td>@twitter</td>
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
            listCategories: []
        }
    },
    methods: {
        create () {
            this.$http.post('/api/categories' ,this.category)
                .then(response => {
                    console.log(response)
                    this.listCategories.push(response.body)
                    $('.modal').modal('hide')
                    console.log()
                })
        }
    }
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
