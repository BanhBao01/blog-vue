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
                                <label for="">Content</label>
                                <textarea v-model="post.content" class="form-control" name="" id="" rows="15"></textarea>
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
                        <div class="col-md-12 text-right">
                            <button class="btn btn-danger" @click="$router.push('/admin/posts')">Cancel</button>
                            <button class="btn btn-primary">Save</button>
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
            post: {
                id: 0,
                title: '',
                photo: '',
                category_id: 0,
                tags: [],
                content: ''
            },
            categories: [],
            tags: []
        }
    },
    methods: {
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
                this.post.photo = e.target.result
            }
            console.log(this.post);
        }
    },
    mounted() {
        this.getCategories()
        this.getTags()
    },
}
</script>

<style>

</style>