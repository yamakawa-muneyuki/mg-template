<template>
  <div>
    <nav class="navbar navbar-expand-lg navbar-light bg-light mb-3">
      <div class="container">
        <a class="navbar-brand" href="/">LP SITE</a>
      </div>
    </nav>
    <div class="container">
      <nuxt />
    </div>
  </div>
</template>

<script>
export default {
  async mounted() {
    // axios module で $axios が使える
    this.$axios.setToken(localStorage.getItem("TOKEN"), 'Bearer')
    try {
      const {data} = await this.$axios.get("/api/whoami")
      // page 側では user を store 経由で取得
      this.$store.commit("user/setUser", data.user)
    } catch (e) {
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