<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-body">
            <div class="form-group row my-3">
              <div class="col text-center text-primary">
                <h3>ログイン</h3>
              </div>
            </div>
            <div class="form-group row">
              <label for="name" class="col-sm-4 col-form-label text-md-right">ユーザID</label>
              <div class="col-md-6">
                <input id="name" type="name" class="form-control" :value="form.name" required autofocus>
              </div>
            </div>
            <div class="form-group row">
              <label for="password" class="col-sm-4 col-form-label text-md-right">パスワード</label>
              <div class="col-md-6">
                <input id="password" type="password" class="form-control" :value="form.password" required>
              </div>
            </div>
            <div class="form-group row mb-0">
              <div class="col-md-8 offset-md-4">
                <button type="button" class="btn btn-primary" @click="login">
                  ログイン
                </button>
              </div>
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
      form: {
        name: "admin",
        password: "1234",
      },
      token: '',
    }
  },
  methods: {
    login () {
      const api = this.$axios.create()
      const responce = api.post("/api/login", this.form)
      .then(({data}) => {
        console.log({data})
        // this.token = data.token.token
        localStorage.setItem("TOKEN", data.token.token)
        this.$router.replace("/")
      })
    },
  },
}
</script>

<style>

</style>