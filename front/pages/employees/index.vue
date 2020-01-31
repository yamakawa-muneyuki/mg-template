<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-10">
        <div class="card">
          <div class="card-body">
            <div class="d-flex justify-content-start mb-3">
              <div class="mr-auto">
                <span class="span-header">従業員一覧</span>
              </div>
              <div class="align-self-center mr-3">
                <button type="button" class="btn btn-primary" @click="onCreate">
                  <i class="fas fa-plus" /> 新規追加
                </button>
              </div>
              <div class="align-self-center">
                <button type="button" class="btn btn-dark" @click="onBack">
                  戻る
                </button>
              </div>
            </div>

            <table key="processes" class="table-custom">
              <thead>
                <tr>
                  <th class="text-center">
                    氏名
                  </th>
                  <th class="text-center">
                    ユーザID
                  </th>
                  <th class="text-center">
                    管理者権限
                  </th>
                </tr>
              </thead>

              <tbody>
                <tr
                  v-for="employee in employees"
                  :key="employee.id"
                  class="clickable"
                  @click="onShow(employee.id)"
                >
                  <td class="text-center align-middle">
                    {{ employee.full_name }}
                  </td>
                  <td class="text-center align-middle">
                    {{ employee.user_name }}
                  </td>
                  <td class="text-center align-middle">
                    {{ employee.is_admin ? "〇" : "" }}
                  </td>
                </tr>
              </tbody>
              <!-- <loading :active.sync="isLoading"></loading> -->
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  components: {
    //
  },
  props: [],
  data() {
    return {
      employees: [],
      isLoading: false,
      inspected_on: ""
    }
  },
  computed: {
    //
  },
  watch: {
    //
  },
  async mounted() {
    await this.$store.dispatch("user/relogin")
    this.getItems()
  },
  methods: {
    async getItems() {
      this.$store.dispatch("loading/add")
      this.isLoading = true
      const { data } = await this.$axios.$get("/api/employee")
      this.employees = data
      this.$store.dispatch("loading/sub")
    },
    onCreate() {
      this.$router.push("employees/create")
    },
    onShow(employee_id) {
      this.$router.push("employees/" + employee_id)
    },
    onBack() {
      this.$router.go(-1)
    }
  }
}
</script>

<style></style>
