<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card" key="admin">
          <div class="card-body">
            <div class="d-flex justify-content-start mb-3">
              <div class="mr-auto">
                <span class="span-header">{{title}}</span>
              </div>
              <div class="align-self-center">
                <button type="button" class="btn btn-dark" @click="onBack">戻る</button>
              </div>
            </div>
            <form>
              <div class="form-group required-label row">
                <label for="last_name" class="col-sm-4 col-form-label text-md-right">姓</label>
                <div class="col-md-6">
                  <input
                    type="text"
                    class="form-control"
                    id="last_name"
                    v-model="$v.employee.last_name.$model"
                  />
                </div>
              </div>
              <div class="form-group row">
                <label for="first_name" class="col-sm-4 col-form-label text-md-right">名</label>
                <div class="col-md-6">
                  <input
                    type="text"
                    class="form-control"
                    id="first_name"
                    v-model="employee.first_name"
                  />
                </div>
              </div>
              <div class="form-group row">
                <label for="last_phonetic_name" class="col-sm-4 col-form-label text-md-right">カナ姓</label>
                <div class="col-md-6">
                  <input
                    type="text"
                    class="form-control"
                    id="last_phonetic_name"
                    v-model="employee.last_phonetic_name"
                  />
                </div>
              </div>
              <div class="form-group row">
                <label for="first_phonetic_name" class="col-sm-4 col-form-label text-md-right">カナ名</label>
                <div class="col-md-6">
                  <input
                    type="text"
                    class="form-control"
                    id="first_phonetic_name"
                    v-model="employee.first_phonetic_name"
                  />
                </div>
              </div>
              <div class="form-group row">
                <label for="email" class="col-sm-4 col-form-label text-md-right">Mail</label>
                <div class="col-md-6">
                  <input type="text" class="form-control" id="email" v-model="employee.email" />
                </div>
              </div>
              <div class="form-group required-label row">
                <label for="user_name" class="col-sm-4 col-form-label text-md-right">ユーザーID</label>
                <div class="col-md-6">
                  <input
                    type="text"
                    class="form-control"
                    id="user_name"
                    v-model="employee.user_name"
                  />
                </div>
              </div>
              <div class="form-group required-label row" v-if="mode=='create'">
                <label for="password" class="col-md-4 col-form-label text-md-right">パスワード</label>
                <div class="col-md-6">
                  <input
                    type="password"
                    class="form-control"
                    id="password"
                    v-model="employee.password"
                  />
                </div>
              </div>
              <div class="form-group row" v-else>
                <label for="password" class="col-md-4 col-form-label text-md-right">パスワード</label>
                <div class="col-md-6">
                  <input
                    type="password"
                    class="form-control"
                    id="password"
                    v-model="employee.password"
                  />
                  <div class="text-muted">
                    <small>※変更する場合は入力してください。</small>
                  </div>
                </div>
              </div>
              <div class="form-group row">
                <div class="col-md-4 text-md-right">
                  <label for="is_admin" class="col-form-label">権限の選択</label>
                </div>
                <div class="col-md-8 pt-1">
                  <div class="custom-control custom-checkbox mt-1">
                    <input
                      type="checkbox"
                      class="custom-control-input"
                      id="is_admin"
                      v-model="employee.is_admin"
                    />
                    <label class="custom-control-label" for="is_admin">管理者権限を付与する</label>
                  </div>
                </div>
              </div>
              <div class="row-line">
                <transition name="fade" mode="out-in">
                  <div class="alert alert-danger" role="alert" v-if="invalid">{{errorMessage}}</div>
                </transition>
              </div>
            </form>
            <div class="d-flex justify-content-start mt-4">
              <div class="mr-auto">
                <button
                  type="button"
                  class="btn btn-outline-danger"
                  v-if="enable_delete"
                  @click="onDelete"
                >この従業員を削除する</button>
              </div>
              <div class="mr-3">
                <button type="button" class="btn btn-dark" @click="onBack">キャンセル</button>
              </div>
              <div v-if="mode!='create'">
                <button type="button" class="btn btn-primary" @click="onStore">保存する</button>
              </div>
              <div v-else>
                <button type="button" class="btn btn-primary" @click="onStore">登録する</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- <loading :active.sync="isLoading" :is-full-page="fullPage"></loading> -->
  </div>
</template>

<script>
import { required, requiredIf, minLength } from 'vuelidate/lib/validators'

const validations = {
  employee: {
    last_name: { required },
    user_name: { required },
    password: {
      required: requiredIf(function() {
        return this.isCreate || this.password
      }),
      minLength: minLength(4),
    }
  },
}

export default {
  components: {
    // Loading
  },
  props: {
    employee: null,
    mode: null,
  },
  data() {
    return {
      roles: [],
      invalid: false,
      errorMessage: "",

      isLoading: false,
      fullPage: false
    };
  },
  computed: {
    own() {
      return this.$store.state.user;
    },
    title() {
      return this.isCreate ? "従業員の新規作成" : "従業員の編集";
    },
    enable_delete() {
      if (this.mode == "create") {
        return false;
      }
      return this.own.employee_id != this.employee.id;
    },
    isCreate() {
      return this.mode == "create"
    },
    isUpdate() {
      return this.mode == "update"
    },
  },
  watch: {
    //
  },
  methods: {
    onStore() {
      this.$v.$touch()
      if (this.$v.employee.$invalid) {
        alert("エラーです。")
      } else {
        this.$emit("store", this.employee)
      }
    },
    onBack() {
      this.$emit('back')
    },
    onDelete() {
      if (!confirm("削除してもよろしいですか？")) {
        return;
      }
      this.$emit('delete')
    }
  },
  validations
};
</script>

<style scoped>
.row-line {
  padding-left: 1.5rem;
  padding-right: 1.5rem;
  padding-bottom: 1rem;
}
.form-content {
  width: 12rem;
  padding-left: 1rem;
  padding-right: 1rem;
  display: inline-block;
}
.form-content-lg {
  width: 15rem;
  padding-left: 1rem;
  padding-right: 1rem;
  display: inline-block;
}
.required-label label:after {
  display: inline-block;
  margin-left: 5px;
  padding: 2px 4px;
  border-radius: 3px;
  background-color: #ec5d53;
  color: #fff;
  content: "必須";
  font-size: 9px;
  line-height: 10px;
}
</style>
