<template>
  <div>
    <nav class="navbar navbar-expand-lg navbar-light bg-light mb-3">
      <div class="container">
        <a class="navbar-brand" href="/">LP SITE</a>
      </div>
    </nav>
    <div v-if="$store.state.loading.count !== 0" class="loading">
      loading
    </div>
    <div class="container">
      <nuxt />
    </div>
  </div>
</template>

<script>
export default {
  async mounted() {
    const result = await this.$store.dispatch("user/relogin")
    if(!result){
      alert("認証エラーです。")
      this.$router.push("/login")
    }
  },
}
</script>

<style>
  /* .container{
    max-width: 640px;
  } */
</style>
