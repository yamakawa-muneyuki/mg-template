<template>
  <create-update
    mode="create"
    :employee="employee"
    @store="onCreate"
    @cancel="onBack"
    @back="onBack"
  />
</template>

<script>
import CreateUpdate from "~/components/forms/employees/CreateUpdate.vue"
export default {
  components: {
    CreateUpdate
  },
  data() {
    return {
      employee: {
        id: "",
        first_name: "",
        last_name: "",
        first_phonetic_name: "",
        last_phonetic_name: "",
        email: "",
        user_name: "",
        password: "",
        is_admin: false
      }
    }
  },
  computed: {
    //
  },
  methods: {
    async onCreate() {
      this.$store.dispatch("loading/add")
      const resp = await this.$axios.$post("/api/employee", {
        employee: this.employee
      })
      if (resp.result) {
        alert("登録しました。")
        this.onBack()
      } else {
        this.errorMessage = resp.errorMessage
        this.invalid = true
      }
      this.$store.dispatch("loading/sub")
    },
    onBack() {
      this.$router.go(-1)
    }
  }
}
</script>
