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
                                    <th scope="col">Name</th>
                                    <th scope="col">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th scope="row"></th>
                                    <td></td>
                                    <td></td>
                                    <td></td>
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
            isLoading: false
        }
    }
}
</script>

<style lang="scss" scoped>
    .header-custom {
        display: flex;
        justify-content: space-between;
    }
</style>