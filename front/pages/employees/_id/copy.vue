<template>
  <create-update mode="copy" :employee="employee" @store="onCreate" @cancel="onBack" @back="onBack"/>
</template>

<script>
import CreateUpdate from '~/components/forms/employees/CreateUpdate.vue'

export default {
  components: {
      CreateUpdate,
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
      },
    }
  },
  computed: {
    id() {
      return this.$route.params.id
    },
  },
  async mounted() {
    await this.$store.dispatch("user/relogin");
    this.getItems()
  },
  methods: {
    async getItems() {
      this.$store.dispatch("loading/add");
      const { data } = await this.$axios.$get("/api/employee/" + this.id);
      this.employee = data;
      this.employee.user_name = null;
      this.$store.dispatch("loading/sub");
    },
    async onCreate() {
      this.$store.dispatch("loading/add");
      const resp = await this.$axios.$post("/api/employee", {
        employee: this.employee,
      });
      if (resp.result) {
        alert("登録しました。");
        this.$router.go(-1);
      } else {
        this.errorMessage = resp.errorMessage;
        this.invalid = true;
      }
      this.$store.dispatch("loading/sub");
    },
    onBack() {
      this.$router.go(-1);
    }
  },
}
</script>
