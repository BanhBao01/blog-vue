<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div v-if="isLoading" class="text-center">
                    <h1 class="mt-5">Loading...</h1>
                </div>
                <div v-if="!isLoading" class="card">
                    <div class="card-header">New Post</div>
                    <div class="card-body row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Title</label>
                                <input type="text"
                                    class="form-control" v-model="post.title" name="" id="" aria-describedby="helpId" placeholder="">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">Category</label>
                                <select v-model="post.category_id" class="form-control">
                                    <option v-for="(c,i) in categories" :key="i" :value="c.id">{{ c.name }}</option>
                                </select>    
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="custom-file">
                                    <input type="file" disabled @change="changeImage" name="" id="" placeholder="" class="custom-file-input" aria-describedby="fileHelpId">
                                    <span class="custom-file-control" @click="showPhoto" >
                                        <span v-if="image_path == ''">Select image</span>  
                                        <img :src="image_path" v-if="image_path != ''" class="custom-img img-fluid img-thumbnail" width="100px"></span> 
                                </label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                              <label for="">Sub Title</label>
                              <input type="text"
                                class="form-control" v-model="post.sub_title" name="" id="" aria-describedby="helpId" placeholder="">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">Tags</label>
                                <select multiple v-model="post.tags" class="form-control form-control-sm" name="" id="">
                                    <option v-for="(t,i) in tags" :key="i" :value="t.id">{{ t.name }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                              <label for="">Status</label>
                              <select class="form-control" name="" v-model="post.status" id="">
                                <option value="1">Show</option>
                                <option value="0">Hide</option>
                                <option></option>
                              </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group class-area">
                                <label for="">Content</label>
                                <quill-editor
                                    v-model="post.content"
                                    ref="myQuillEditor"
                                />
                            </div>
                        </div>
                        <div class="col-md-12 text-right">
                            <button class="btn btn-secondary" @click="$router.push('/admin/posts')">Cancel</button>
                            <button class="btn btn-danger" @click="remove">Delete</button>
                            <button class="btn btn-primary" @click="update">Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modelId" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Select Image</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                    </div>
                    <div class="modal-body row">
                        <div class="col-md-12">
                            <div class="form-group p-1">
                                <input type="file" class="form-control-file" @change="changeImage" name="" id="" placeholder="" aria-describedby="fileHelpId">
                            </div>
                        </div>
                        <div class="col-md-12 row mx-auto">
                            <div class="col-sm-6 col-md-3 col-lg-2 col-xl-2 p-1" v-for="(photo,index) in photos" :key="index" >
                                <div class="card">
                                    <div class="row no-gutters">
                                        <div class="col-md-12">
                                            <img :src="photo.path" class="card-img" :alt="photo.name" @click="selectImage(photo.id, photo.path)">
                                        </div>
                                    </div>
                                </div>
                                <span class="top-right delete-img" @click="deleteImage(photo.id,index)" aria-hidden="true">&times;</span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import 'quill/dist/quill.snow.css'
import { quillEditor } from 'vue-quill-editor'
export default {
    data () {
        return {
            post: {
                id: 0,
                title: '',
                image: '',
                category_id: 0,
                photo: '',
                tags: [],
                content: '',
                sub_title: '',
                status: 1,
                photo_id: ''
            },
            categories: [],
            tags: [],
            editorOption: {
                placeholder: '',
                readOnly: true,
                theme: 'snow'
            },
            photos: [],
            image_path: '',
            id: this.$route.params.id,
            isLoading: true
        }
    },
    components: {
		quillEditor
	},
    methods: {
        alert (type,title,message) {
            this.$swal({
                type: type,
                title: title,
                text: message
            })  
        },
        getCategories () {
            this.$http.get('/api/categories')
                .then(response => {
                    this.categories = response.body
                })      
        },
        getTags () {
            this.$http.get('/api/tags')
                .then(response => {
                    this.tags = response.body
                })
        },
        changeImage (e) {
            var fileReader = new FileReader();
            fileReader.readAsDataURL(e.target.files[0])
            fileReader.onload = (e) => {
                this.post.image = e.target.result
                this.$http.post('/api/photos',this.post)
                    .then(response => {
                        console.log(response.body)
                        this.photos.unshift(response.body)
                    })
            }
        },
        hideModal () {
            $('.modal').modal('hide')
            $('.modal-backdrop').removeAttr('class')
        },
        showPhoto () {
            $('.modal').modal('show')
        },
        selectImage (id,path) {
            this.post.photo_id = id
            this.image_path = path
            this.hideModal()
        },
        deleteImage (id,index) {
            this.$http.delete('/api/photos/' + id)
                .then(response => {
                    this.photos.splice(index,1);
                })
        },
        getPhotos () {
            this.$http.get('/api/photos')
                .then(response => {
                    this.photos = response.body
                })
        },
        update () {
            this.$http.put('/api/posts/' + this.id , this.post)
                .then(response => {
                    //console.log(response.body)
                    if(response.body.message == 'true'){
                        this.alert('success','Success','Update Post Success')
                        this.$router.push('/admin/posts')
                    }else{
                        this.alert('error','error','Update Post Error')
                    }
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
                    this.$http.delete('/api/posts/' + this.id)
                        .then(response => {
                            if(response.body.message == 'true'){
                                this.alert('success','Success','Delete Post Success')
                                this.$router.push('/admin/posts')
                            }else{
                                this.alert('error','error','Delete Post Error')
                            }
                        })
                }
            })
        },
        getData () {
            this.$http.get('/api/posts/' + this.id + '/edit')
                .then(response => {
                    this.post.id = response.body.id
                    this.post.title = response.body.title
                    this.post.sub_title = response.body.sub_title
                    this.post.content = response.body.content
                    this.post.status = response.body.status,
                    this.post.category_id = response.body.category.id,
                    this.post.tags = response.body.tags_id
                    this.post.photo_id = response.body.photo.id
                    this.image_path = response.body.photo.path
                })
                .finally(response => {
                    this.isLoading = false
                })
        }
    },
    mounted() {
        this.getCategories()
        this.getTags()
        this.getPhotos()
        this.getData()
    },
}
</script>

<style lang="scss" scoped>
    .modal {
        height: 100%;
    }
    .custom-img {
        position: absolute;
        top: 50%;
        right: 40%;
    }
    .delete-img {
        position: absolute;
            top: 0;
            right: 0;
            color: white;
            background: #a29292;
            border-radius: 100%;
            padding: 0 6px;
            font-size: 12px;
            z-index: 100;
        }
</style>