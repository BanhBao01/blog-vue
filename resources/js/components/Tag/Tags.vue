<template>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div v-if="isLoading" class="text-center">
                <h1 class="mt-5">Loading...</h1>
            </div>
            <div v-if="!isLoading" class="card">
                <div class="card-header header-custom">
                    <h5>Tags</h5>
                    <div>
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#modelId">
                            New Tag
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="modelId" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                            <div class="modal-dialog modal-md" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">New Tag</h5>
                                        <button type="button" class="close" @click="hideModal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="">Name Tag</label>
                                            <input type="text" v-model="tag.name" class="form-control"  name="" id="" aria-describedby="helpId" placeholder="">
                                        </div>
                                        <div class="form-group">
                                            <label for="">Status</label>
                                            <select class="form-control" v-model="tag.status" name="" id="">
                                                <option value="1">Show</option>
                                                <option value="0">Hide</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="modal-footer" v-if="isDelete">
                                        <button type="button" class="btn btn-secondary" @click="hideModal">Close</button>
                                        <button type="button" class="btn btn-danger" @click="remove">Delete</button>
                                        <button type="button" class="btn btn-primary" @click="update">Save</button>
                                    </div>
                                    <div class="modal-footer" v-if="!isDelete">
                                        <button type="button" class="btn btn-secondary" @click="hideModal()">Close</button>
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
                                    <th scope="col">Name</th>
                                    <th scope="col">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(t,idx) in listTags" :key="idx" @click="edit(idx,t)">
                                    <th scope="row">{{ idx+1 }}</th>
                                    <td>{{ t.name }}</td>
                                    <td v-if="t.status = 1">Public</td>
                                    <td v-if="t.status = 0">Not Public</td>
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
    data () {
        return {
            isLoading: true,
            listTags: [],
            tag: {
                name: '',
                status: 1
            },
            isDelete: false,
            idTag: '',
            idx: ''
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
        hideModal () {
            this.tag = {
                        name: '',
                        status: 1
                    }
            this.isDelete = false
            $('.modal').modal('hide')
            $('.modal-backdrop').removeAttr('class')
        },
        showModal () {
            $('.modal').modal('show')
        },
        create () {
            this.$http.post('/api/tags',this.tag)
                .then(response=>{
                    this.listTags.push(response.body)
                    this.hideModal()
                    this.showAlert('Success', 'success', 'Add New Tag Success')
                })
        },
        edit (idx,t) {
            this.showModal()
            this.isDelete = true
            this.idx = idx
            this.idTag = t.id
            this.tag = {
                'name': t.name,
                'status': 1
            }
        },
        update () {
            this.$http.put('/api/tags/' + this.idTag , this.tag)
                .then(response => {
                    this.listTags.splice(this.idx, 1)
                    this.listTags.splice(this.idx, 0 ,response.body)
                    this.hideModal()
                    this.showAlert('Success', 'success', 'Update Tag Success')
                })
        },
        remove () {
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
                    this.listTags.splice(this.idx,1)
                    this.$http.delete('/api/tags/' + this.idTag)
                    .then(response => {
                        this.showAlert('Success', 'success', 'Delete Tag Success')
                        this.hideModal()
                    })   
                }
            })
             
        },
        getData () {
            this.$http.get('/api/tags')
                .then(response=>{
                    this.listTags = response.body
                })
                .finally(response=>{
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
</style>
