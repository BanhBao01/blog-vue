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
                        <button type="button" class="btn btn-secondary" @click="$router.push('posts/create')" data-target="#modelId">
                            New Post
                        </button>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Title</th>
                                    <th scope="col">Sub Title</th>
                                    <th scope="col">Category</th>
                                    <th scope="col">Tags</th>
                                    <th scope="col">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(post,i) in listPosts" :key="i" @click="$router.push('posts/' + post.id + '/edit')">
                                    <th scope="row">{{ i + 1 }}</th>
                                    <td>{{ post.title }}</td>
                                    <td>{{ post.sub_title }}</td>
                                    <td>{{ post.category.name }}</td>
                                    <td>
                                        <code v-for="(tag,idx) in post.tags" :key="idx">{{ tag.tag }} </code>
                                    </td>
                                    <td v-if="post.status = 1">Public</td>
                                    <td v-if="post.status = 0">Not Public</td>
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
            listPosts: [],
        }
    },
    methods: {
        getData () {
            this.$http.get('/api/posts')
                .then(response => {
                    this.listPosts = response.body
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
</style>