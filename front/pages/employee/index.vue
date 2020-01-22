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
                  <i class="fas fa-plus"></i> 新規追加
                </button>
              </div>
              <div class="align-self-center">
                <button type="button" class="btn btn-dark" @click="onBack">戻る</button>
              </div>
            </div>

            <table class="table" key="processes">
              <thead>
                <tr>
                  <th class="text-center">氏名</th>
                  <th class="text-center">ユーザID</th>
                  <th class="text-center">管理者権限</th>
                </tr>
              </thead>

              <tbody>
                <tr
                  v-for="employee in employees"
                  class="clickable"
                  :key="employee.id"
                  @click="onShow(employee.id)"
                >
                  <td class="text-center align-middle">{{employee.full_name}}</td>
                  <td class="text-center align-middle">{{employee.user_name}}</td>
                  <td class="text-center align-middle">{{employee.is_admin ? '〇' : ''}}</td>
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
  props: [],
  data() {
    return {
      employees: [],
      isLoading: false,
      inspected_on: ""
    };
  },
  mounted() {
    this.inspected_on = this.$moment().format("YYYY-MM-DD");
    this.getItems();
  },
  watch: {
    //
  },
  computed: {
    //
  },
  methods: {
    async getItems() {
      this.isLoading = true;
      this.$axios.setToken(localStorage.getItem("TOKEN"), 'Bearer')
      const {data} = await this.$axios.$get("/api/employee");
      this.employees = data;
      this.isLoading = false;
    },
    onCreate() {
      //   this.$router.push({ name: "employee.create" });
    },
    onShow(employee_id) {
      //   this.$router.push({
      //     name: "employee.show",
      //     params: { employee_id: employee_id }
      //   });
    },
    onBack() {
      //   this.$router.go(-1);
    }
  },
  components: {
    // Loading
  }
};
</script>

<style>
</style>