<template>
  <div class="vld-parent">
    <loading :active="isLoading" />

    <nav class="navbar navbar-expand-lg navbar-light bg-light mb-3">
      <div class="container">
        <a class="navbar-brand" href="/">LP SITE</a>
      </div>
    </nav>
    <!-- <div v-if="$store.state.loading.count !== 0" class="loading">
      loading
    </div> -->
    <div class="container">
      <nuxt />
    </div>
  </div>
</template>

<script>
import Loading from "vue-loading-overlay"
import "vue-loading-overlay/dist/vue-loading.css"

export default {
  components: {
    Loading
  },
  computed: {
    isLoading() {
      return this.$store.state.loading.count !== 0
    }
  },
  async mounted() {
    const result = await this.$store.dispatch("user/relogin")
    if (!result) {
      alert("認証エラーです。")
      this.$router.push("/login")
    }
  }
}
</script>

<style>
/* .container{
    max-width: 640px;
  } */
</style>
