<template>
  <div class="container">
    <div v-if="own" class="card text-center">
      <div class="card-body">
        <h3 class="title-margin mt-3 mb-5">
          メニュー
        </h3>
        <div v-if="show" class="d-flex justify-content-center mb-2">
          <nuxt-link to="/reports" class="btn btn-primary btn-menu mr-3 mb-3">
            作業日報
          </nuxt-link>
          <nuxt-link
            v-if="own.is_admin"
            to="/setting"
            class="btn btn-dark btn-menu mr-3 mb-3"
          >
            設定管理
          </nuxt-link>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import vuex from "vuex"

export default {
  data() {
    return {
      show: false
    }
  },
  computed: {
    ...vuex.mapState("user", { own: "user" })
    // own() {
    //   return this.$store.state.user.user;
    // }
  },
  mounted() {
    setTimeout(() => {
      this.show = true
    }, 500)
  },
  methods: {
    ...vuex.mapActions("user", ["login"])
  }
}
</script>

<style>
.btn-menu {
  height: 6rem;
  width: 9rem;
  font-size: 1rem;
  display: flex;
  align-items: center;
  justify-content: center;
}
</style>
