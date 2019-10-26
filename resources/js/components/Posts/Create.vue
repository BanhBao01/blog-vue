<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
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
                                    <input type="file" @change="changeImage" name="" id="" placeholder="" class="custom-file-input" aria-describedby="fileHelpId">
                                    <span class="custom-file-control">Select image</span>
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
                                    :options="editorOption"
                                    
                                />
                            </div>
                        </div>
                        
                        <div class="col-md-12 text-right">
                            <button class="btn btn-danger" @click="$router.push('/admin/posts')">Cancel</button>
                            <button class="btn btn-primary" @click="create">Save</button>
                        </div>
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
                tags: [],
                content: '',
                sub_title: '',
                status: 1
            },
            categories: [],
            tags: [],
            editorOption: {
                placeholder: '',
                readOnly: true,
                theme: 'snow'
            }
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
            }
            console.log(this.post);
        },
        onEditorChange(event) {
            console.log('onEditorChange')
        },
        create () {
            this.$http.post('/api/posts',this.post)
                .then(response => {
                    console.log(response.body)
                    if(response.body.message == 'true'){
                        this.alert('success','Success','Create Post Success')
                        this.$router.push('/admin/posts')
                    }else{
                        this.alert('error','error','Create Post Error')
                    }
                })
        }
    },
    mounted() {
        this.getCategories()
        this.getTags()
    },
}
</script>

<style lang="scss" scoped>
    
</style>