<template>
    <div id="app">
        <div class="py-4 container">
            <div class="scroll-bar mx-auto">
                <h1>Home</h1>
                <button type="button" @click="login" class="btn btn-secondary">Local store</button>
                <button type="button" @click="logout" class="btn btn-danger">Remove local store</button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data () {
        return {

        }
    },
    components: {
    },
    methods: {
        login () {
            this.$auth.setToken('eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6ImQ4OWUwODliMGE2ZjgxODUxNWNiNTZmY2M0MjNjZjMyNjljYTNiMzQwOGUwZDY2ZjU1N2Q1MmFiYzk0YWM1ZjdlM2ZkYzM3ZTNiNmU1ZGQxIn0.eyJhdWQiOiIyIiwianRpIjoiZDg5ZTA4OWIwYTZmODE4NTE1Y2I1NmZjYzQyM2NmMzI2OWNhM2IzNDA4ZTBkNjZmNTU3ZDUyYWJjOTRhYzVmN2UzZmRjMzdlM2I2ZTVkZDEiLCJpYXQiOjE1NzIxNDkwNTYsIm5iZiI6MTU3MjE0OTA1NiwiZXhwIjoxNjAzNzcxNDU2LCJzdWIiOiIxIiwic2NvcGVzIjpbXX0.V2l2Hej4JqayJD1QN1aE0cXESzWrVvJ6sV_8DvFcIhvNw4hD5JdhTUZaI-U_Il-8t9JMfqh-beLxSaVV4zrb9-L-ElCV-d1g-KOZELu5J2M75VErKMqEN493msIC2-SL4WQYGTrzdMtB7T8S8-4QCJTSXaSPzrbwtVVx9VI7rK2VSqbX9jI012gFhgKRhLXaX0IpWh8uRoRjcZhXcBzwgYhTteyZGCHr4xew-aomqhAfDkBtRHzF7K-nKaY0AJE8qb45lXKGvcvpLOzn6zHH_srrrZ6ZL7dkaqFzRW7TxFV6BKaqf2U_OR7BPzEYnAjL68aAHxmT-eOngOnjaxGeEE8qf6kWycFiGQDbotQYo_uwWO1mGwon2WH4pp2WqVTB2d4SLIOwbNHoNAO0isFGgXXaFemxPFpfmyjK8Jf8uebtNPRnQa2B6ZFuKLtbNb6lhw_ualZBSJM4jRb2thIXBOeD2W5r48aGOOA84jhr5KPVQpFiG9jKpqD3q6DO_ZPJVcGRQm9J2u-Jsi-m_2nevMHX5aCN-IN66VR2A4bmYGtblVsEd4zqQt16Sb4VnxmGjdfDomeyfjIv3rAosoDFwTAtCBJtpJusW4fbIrCSj__-0witgyTtkUVgF74BrYYCAplIyMsZrTX8Ep2sUfO4dvSFWtXxKpG55z3HfiD3pQQ','1572180679966')
            this.$store.commit('checkLogin')
        },
        logout () {
            this.$auth.destroyToken()
            this.$store.commit('checkLogin')
            this.$router.push('/admin/login')
        }
    }
}
</script>

<style>

</style>