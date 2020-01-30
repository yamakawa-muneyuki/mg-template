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
                <input id="name" type="name" class="form-control" v-model="$v.form.name.$model" autofocus>
              </div>
              <div v-if="$v.form.name.$dirty && $v.form.name.$invalid">
                ユーザ名を入力してください。
              </div>
            </div>
            <div class="form-group row">
              <label for="password" class="col-sm-4 col-form-label text-md-right">パスワード</label>
              <div class="col-md-6">
                <input id="password" type="password" class="form-control" v-model="$v.form.password.$model" >
              </div>
              <div v-if="$v.form.password.$dirty && $v.form.password.$invalid">
                パスワードを入力してください。
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
import { required } from 'vuelidate/lib/validators'

const validations = {
  form:{
    name : { required },
    password: { required },
  }
}

export default {
  layout: "guest",
  data () {
    return {
      form: {
        name: "",
        password: "",
      },
      token: '',
    }
  },
  methods: {
    async login () {
      this.$v.$touch()
      if(this.$v.form.$invalid){
        alert("エラーです。")
      }else{
        // this.$emit(this.form)
        await this.$store.dispatch("user/login",this.form)
        this.$router.replace("/")
      }

      // await this.$store.dispatch("user/login",this.form)
      // this.$router.replace("/")
    },
  },
  validations
}
</script>

<style lang="scss" scoped>


</style>
