<template>
  <create-update
    v-if="report"
    mode="update"
    :report="report"
    @store="onUpdate"
    @delete="onDelete"
    @cancel="onBack"
    @back="onBack"
  />
</template>

<script>
import CreateUpdate from "~/components/forms/reports/r0001/CreateUpdate.vue"

export default {
  components: {
    CreateUpdate
  },
  data() {
    return {
      report: null
    }
  },
  computed: {
    id() {
      return this.$route.params.id
    }
  },
  async mounted() {
    await this.$store.dispatch("user/relogin")
    this.getItems()
  },
  methods: {
    async getItems() {
      this.$store.dispatch("loading/add")
      const { data } = await this.$axios.$get("/api/report/" + this.id)
      this.report = data.body
      console.log(this.report)
      this.$store.dispatch("loading/sub")
    },
    async onUpdate() {
      this.$store.dispatch("loading/add")
      const resp = await this.$axios.$put("/api/report/" + this.id, {
        report: this.report
      })
      if (resp.result) {
        alert("更新しました。")
        this.onBack()
      } else {
        this.errorMessage = resp.data.errorMessage
        this.invalid = true
      }
      this.$store.dispatch("loading/sub")
    },
    async onDelete() {
      this.$store.dispatch("loading/add")
      const resp = await this.$axios.$delete("/api/report/" + this.id)
      if (resp.result) {
        alert("削除しました。")
        this.onBack()
      } else {
        this.errorMessage = resp.data.errorMessage
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
