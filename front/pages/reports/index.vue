<template>
  <div v-if="own" class="container">
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-start mb-3">
          <div class="mr-auto">
            <span class="span-header">作業日報一覧</span>
          </div>
          <div class="align-self-center mr-2">
            <button type="button" class="btn btn-success" @click="downloadCSV">
              <i class="fa fa-download" /> CSV
            </button>
          </div>
          <div class="align-self-center mr-2">
            <button
              v-if="!disabled"
              type="button"
              class="btn btn-info"
              @click="onCreate"
            >
              <i class="fas fa-plus" /> 新規追加
            </button>
          </div>
          <div class="align-self-center">
            <button type="button" class="btn btn-dark" @click="onBack">
              戻る
            </button>
          </div>
        </div>
        <div class="card-block mb-3">
          <form class="form-inline">
            <div class="form-group mr-sm-2">
              <!-- <date-picker-from-to
                label="作業日"
                :from_dt.sync="started_from"
                :to_dt.sync="started_to"
              />-->
            </div>
            <div class="align-self-center ml-3">
              <button type="button" class="btn btn-primary" @click="onSearch">
                検索
              </button>
            </div>
          </form>
          <form class="form-inline d-flex mt-3">
            <div class="form-group">
              <label class="mr-sm-2">担当者</label>
              <select v-model="selectedEmployee" class="form-control">
                <option />
                <option
                  v-for="employee in employees"
                  :key="employee.id"
                  :value="employee.name"
                >
                  {{ employee.name }}
                </option>
              </select>
            </div>
            <div class="form-group">
              <label class="mr-sm-2 ml-sm-4">得意先名</label>
              <select v-model="selectedCustomer" class="form-control">
                <option />
                <option
                  v-for="customer in customers"
                  :key="customer.id"
                  :value="customer.name"
                >
                  {{ customer.name }}
                </option>
              </select>
            </div>
          </form>
        </div>
        <!-- <div class="card-block mb-3">
          <form class="form-inline">
            <div class="form-group">
              <label class="mr-sm-2">商品名</label>
              <select class="form-control" v-model="selectedItem">
                <option></option>
                <option v-for="item in filteredItems" :key="item.id">{{item}}</option>
              </select>
            </div>
            <div class="form-group" v-show="!disabled">
              <label class="mr-sm-2 ml-sm-4">入力状態</label>
              <select class="form-control" v-model="selectedFinish">
                <option></option>
                <option value="0">未完了</option>
                <option value="1">完了</option>
              </select>
            </div>
          </form>
        </div> -->
        <table key="processes" class="table-custom">
          <thead>
            <tr>
              <th class="text-center bg-primary text-white" style="width:7rem;">
                作業日
              </th>
              <th class="text-center bg-primary text-white">
                担当者
              </th>
              <th class="text-center bg-primary text-white">
                得意先名
              </th>
              <th class="text-center bg-primary text-white">
                商品名
              </th>
            </tr>
          </thead>

          <tbody>
            <tr
              v-for="report in paginateReports"
              :key="report.id"
              class="clickable"
              :class="classObject(report.status)"
              @click="onShow(report.id)"
            >
              <td class="text-center">
                {{ report.started_on }}
              </td>
              <td class="text-center">
                {{ report.employees }}
              </td>
              <td class="text-center">
                <div
                  v-for="(report_detail, index) in report.report_details"
                  :key="index"
                >
                  {{ report_detail.customer_name }}
                </div>
              </td>
              <td class="text-center">
                <div
                  v-for="(report_detail, index) in report.report_details"
                  :key="index"
                >
                  {{ report_detail.item_name }}
                </div>
              </td>
            </tr>
          </tbody>
        </table>
        <div class="mt-2">
          <!-- <mg-paginate
            :data="filterReports"
            :count-per-page="countPerPage"
            @change="paginateReports=$event"
          ></mg-paginate>-->
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import vuex from "vuex"
export default {
  components: {
    //
  },
  props: [
    //
  ],
  data() {
    return {
      started_from: "",
      started_to: "",
      selectedEmployee: "",
      selectedCustomer: "",
      selectedItem: "",
      selectedFinish: "",
      reports: [],
      employees: [],
      customers: [],
      items: [],

      paginateReports: [],
      countPerPage: 20
    }
  },
  watch: {
    //
  },
  async mounted() {
    await this.$store.dispatch("user/relogin")
    this.getInit()
    this.started_from = this.$moment().subtract(14, "days")
    this.started_to = this.$moment()
  },
  computed: {
    ...vuex.mapState("user", { own: "user" }),
    disabled() {
      return !this.own.is_admin
    },
    filterReports() {
      if (this.disabled) {
        this.selectedFinish = "0"
      }
      let list = this.reports.slice()
      if (
        !this.selectedCustomer &&
        !this.selectedItem &&
        !this.selectedEmployee &&
        !this.selectedFinish
      )
        return list
      let filterWord = this.selectedCustomer
      if (filterWord) {
        list = list.filter(row => {
          let find = false
          row.report_details.forEach(elem => {
            if (elem.customer_name.indexOf(filterWord) > -1) {
              find = true
              return false
            }
          })
          return find
        })
      }
      filterWord = this.selectedItem
      if (filterWord) {
        list = list.filter(row => {
          let find = false
          row.report_details.forEach(elem => {
            if (elem.item_name.indexOf(filterWord) > -1) {
              find = true
              return false
            }
          })
          return find
        })
      }
      filterWord = this.selectedEmployee
      if (filterWord) {
        list = list.filter(row => {
          return row.employees.indexOf(filterWord) > -1
        })
      }
      filterWord = this.selectedFinish
      if (filterWord) {
        list = list.filter(row => {
          return row.is_finished == filterWord
        })
      }
      return list
    },
    classObject() {
      return status => {
        if (status == 0) return "todo-color"
        if (status == 1) return "doing-color"
        if (status == 2) return "done-color"
      }
    },
    filteredItems() {
      let list = this.reports.slice()
      let selectItemList = []
      list.forEach(v1 => {
        v1.report_details.forEach(v2 => {
          if (selectItemList.indexOf(v2.item_name) == -1) {
            selectItemList.push(v2.item_name)
          }
        })
      })
      selectItemList.sort()
      return selectItemList
    }
  },
  methods: {
    async getInit() {
      this.$store.dispatch("loading/add")
      const emp = await this.$axios.$get("/api/employee/selector")
      this.employees = emp.data
      // const cus = await this.$axios.$get("/api/customer/selector");
      // this.customers = cus.data;
      // const item = await this.$axios.$get("/api/item/selector");
      // this.items = item.data;
      this.$store.dispatch("loading/sub")
    },
    getItems() {
      this.isLoading = true
      const api = axios.create()
      axios
        .all([
          api.get("/api/report", {
            params: {
              started_on: this.started_from,
              finished_on: this.started_to
              // customer_id: this.selectedCustomer,
              // item_id: this.selectedItem,
            }
          })
        ])
        .then(
          axios.spread((res1, res2, res3, res4) => {
            this.reports = res1.data
            this.isLoading = false
          })
        )
    },
    onCreate() {
      this.$router.push({ name: "report.create" })
    },
    onShow(report_id) {
      this.$router.push({
        name: "report.show",
        params: { report_id: report_id }
      })
    },
    onBack() {
      this.$router.go(-1)
    },
    onSearch() {
      this.getItems()
    },
    showCustomers(details) {
      var text = ""
      for (let i = 0; i < details.length; i++) {
        text = text + details[i].customer + "\n"
      }
      return text
    },
    showItems(details) {
      var text = ""
      for (let i = 0; i < details.length; i++) {
        text = text + details[i].item + " " + details[i].status + "\n"
      }
      return text
    },
    showEmployees(employees) {
      var text = ""
      for (let i = 0; i < employees.length; i++) {
        text = text + employees[i].full_name + "\n"
      }
      return text
    },
    downloadCSV() {
      var csv =
        "\ufeff" +
        "作業開始日,作業終了日,担当者,得意先コード,得意先名,商品コード,商品名,機械,設備,製造指示数,段取り時間,製造完了数,作業時間"
      csv += "\n"
      this.reports.forEach(el => {
        el.report_details.forEach(detail => {
          var line = '"' + el.started_on + '",'
          line += '"' + el.finished_on + '",'
          line += '"' + el.employees + '",'
          line += '"' + detail.customer_code + '",'
          line += '"' + detail.customer_name + '",'
          line += '"' + detail.item_code + '",'
          line += '"' + detail.item_name + '",'
          line += '"' + detail.category_name + '",'
          line += '"' + detail.facility_name + '",'
          line += '"' + detail.instruction_num + '",'
          line += '"' + detail.setup_time + '",'
          line += '"' + detail.finish_num + '",'
          line += '"' + detail.work_time + '",'
          line += "\n"
          csv += line
        })
      })
      let blob = new Blob([csv], { type: "text/csv" })
      let link = document.createElement("a")
      link.href = window.URL.createObjectURL(blob)
      link.download = "download.csv"
      link.click()
    }
  }
}
</script>

<style lang="scss" scoped>
// @import "resources/sass/variables";
// .clickable:hover {
//     background-color: #fff8e1 !important;
// }
// .clickable {
//     cursor: pointer;
// }
.todo-color {
  background-color: #ffcdd2 !important;
}
.doing-color {
  background-color: #b2dfdb !important;
}
.done-color {
  background-color: #ffffff !important;
}
</style>
