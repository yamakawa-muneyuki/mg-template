<template>
  <div class="container-fluid">
    <div v-show="own" class="card item-center">
      <div class="card-body">
        <div class="d-flex justify-content-start mb-4">
          <div class="mr-auto">
            <span class="span-header">火なし作業許可願（証）</span>
          </div>
          <div class="ml-3">
            <button type="button" class="btn btn-dark" @click="onBack">
              戻る
            </button>
          </div>
        </div>

        <div class="h4 span-title">
          工事担当Ｇ記入
        </div>
        <hr />
        <div class="span-title mb-1">
          工事名称
        </div>
        <div class="d-flex justify-content-start mb-2">
          <div class="align-self-center flex-fill">
            <input
              v-if="!is_readonly"
              v-model="report.construction.name"
              type="text"
              class="form-control"
            />
            <span v-else>{{ report.construction.name }}</span>
          </div>
        </div>
        <div class="span-title mb-1">
          工事期間
        </div>
        <div class="d-flex justify-content-start mb-3">
          <div class="align-self-center w-100">
            <client-only>
              <date-picker-from-to
                :from_dt.sync="report.construction.from_period"
                :to_dt.sync="report.construction.to_period"
              />
            </client-only>
          </div>
        </div>
        <div class="span-title mb-1">
          工事内容（具体的に）
        </div>
        <div class="mb-3">
          <textarea
            v-model="report.construction.contents"
            class="form-control"
            rows="4"
          ></textarea>
        </div>
        <div class="d-flex flex-wrap mb-3">
          <template v-for="(check, index) in report.construction.checks">
            <div :key="index" class="mr-2">
              <div class="custom-control custom-checkbox custom-control-inline">
                <input
                  :id="'construction' + index"
                  v-model="check.value"
                  type="checkbox"
                  class="custom-control-input"
                />
                <label
                  class="custom-control-label"
                  :for="'construction' + index"
                >
                  {{ check.contents }}
                </label>
              </div>
            </div>
          </template>
        </div>
        <div class="span-title mb-1">
          工事場所（装置名・機器番号）
        </div>
        <div class="d-flex justify-content-start mb-3">
          <div class="align-self-center flex-fill">
            <input v-model="report.place" type="text" class="form-control" />
          </div>
        </div>
        <div class="span-title mb-2">
          添付作業許可願＆ﾁｪｯｸﾘｽﾄ＆プロット（この要否は区域担当班長が受付時最終決定する）
        </div>
        <div class="d-flex flex-wrap mb-3">
          <div class="mr-5">
            <template
              v-for="(check, index) in report.construction.permission.check1"
            >
              <div :key="index" class="custom-control custom-checkbox mb-2">
                <input
                  :id="'permission-check1' + index"
                  v-model="check.value"
                  type="checkbox"
                  class="custom-control-input"
                />
                <label
                  class="custom-control-label"
                  :for="'permission-check1' + index"
                >
                  {{ check.contents }}
                </label>
              </div>
            </template>
          </div>
          <div class="mr-5">
            <template
              v-for="(check, index) in report.construction.permission.check2"
            >
              <div :key="index" class="custom-control custom-checkbox mb-2">
                <input
                  :id="'permission-check2' + index"
                  v-model="check.value"
                  type="checkbox"
                  class="custom-control-input"
                />
                <label
                  class="custom-control-label"
                  :for="'permission-check2' + index"
                >
                  {{ check.contents }}
                </label>
              </div>
            </template>
          </div>
          <div class="mr-5">
            <template
              v-for="(check, index) in report.construction.permission.check3"
            >
              <div :key="index" class="custom-control custom-checkbox mb-2">
                <input
                  :id="'permission-check3' + index"
                  v-model="check.value"
                  type="checkbox"
                  class="custom-control-input"
                />
                <label
                  class="custom-control-label"
                  :for="'permission-check3' + index"
                >
                  {{ check.contents }}
                </label>
              </div>
            </template>
          </div>
          <div class="mr-5">
            <template
              v-for="(check, index) in report.construction.permission.check4"
            >
              <div :key="index" class="custom-control custom-checkbox mb-2">
                <input
                  :id="'permission-check4' + index"
                  v-model="check.value"
                  type="checkbox"
                  class="custom-control-input"
                />
                <label
                  class="custom-control-label"
                  :for="'permission-check4' + index"
                >
                  {{ check.contents }}
                </label>
              </div>
            </template>
          </div>
        </div>
        <div class="span-title mb-2">
          安全対策（工事担当ｸﾞﾙｰﾌﾟで実施する）
        </div>
        <div class="d-flex flex-wrap mb-3">
          <div class="mr-5">
            <div
              v-for="(check, index) in report.construction.measure.check1"
              :key="index"
              class="d-flex mb-2"
            >
              <div
                class="custom-control custom-checkbox align-self-center mr-auto"
              >
                <input
                  :id="'measure-check1' + index"
                  v-model="check.value"
                  type="checkbox"
                  class="custom-control-input"
                />
                <label
                  class="custom-control-label"
                  :for="'measure-check1' + index"
                >
                  {{ check.contents }}
                </label>
              </div>
              <div v-if="check.use_text" class="ml-3">
                <input v-model="check.text" type="text" class="form-control" />
              </div>
            </div>
          </div>
          <div class="mr-5">
            <div
              v-for="(check, index) in report.construction.measure.check2"
              :key="index"
              class="d-flex mb-2"
            >
              <div
                class="custom-control custom-checkbox align-self-center mr-auto"
              >
                <input
                  :id="'measure-check2' + index"
                  v-model="check.value"
                  type="checkbox"
                  class="custom-control-input"
                />
                <label
                  class="custom-control-label"
                  :for="'measure-check2' + index"
                >
                  {{ check.contents }}
                </label>
              </div>
              <div v-if="check.use_text" class="ml-3">
                <input v-model="check.text" type="text" class="form-control" />
              </div>
            </div>
          </div>
        </div>
        <div class="span-title mb-2">
          保護具
          基本保護具以外に要求される保護具にﾁｪｯｸﾏｰｸを入れる（基本保護具：ヘルメット、安全めがね、革手、安全靴、）
        </div>
        <div class="d-flex flex-wrap mb-3">
          <template v-for="(protect, index) in report.construction.protects">
            <div :key="index" class="d-flex mr-3 mb-2">
              <div
                class="custom-control custom-checkbox align-self-center mr-2"
              >
                <input
                  :id="'protect' + index"
                  v-model="protect.value"
                  type="checkbox"
                  class="custom-control-input"
                />
                <label class="custom-control-label" :for="'protect' + index">
                  {{ protect.contents }}
                </label>
              </div>
            </div>
          </template>
        </div>
        <div class="span-title mb-2">
          許可条件依頼内容（区域に依頼する作業にチェックマークを入れる）
        </div>
        <div class="d-flex flex-wrap mb-2">
          <template v-for="(request, index) in report.construction.requests">
            <div :key="index" class="d-flex mr-3 mb-2">
              <div
                class="custom-control custom-checkbox align-self-center mr-2"
              >
                <input
                  :id="'request' + index"
                  v-model="request.value"
                  type="checkbox"
                  class="custom-control-input"
                />
                <label class="custom-control-label" :for="'request' + index">
                  {{ request.contents }}
                </label>
              </div>
              <div v-if="request.use_text">
                <input
                  v-model="request.text"
                  type="text"
                  class="form-control"
                />
              </div>
            </div>
          </template>
        </div>
        <hr />
        <div class="h4 span-title">
          区域担当Ｇ記入
        </div>
        <div class="mb-2">
          <client-only>
            <table class="table table-sm">
              <thead>
                <tr>
                  <th style="width:7rem;"></th>
                  <th style="width:30rem;">
                    （特記なき場合は区域担当ｸﾞﾙｰﾌﾟで実施する）
                  </th>
                  <th>確認結果</th>
                </tr>
              </thead>
              <tbody>
                <tr
                  v-for="(condition, index) in report.area.permissionConditions"
                  :key="index"
                >
                  <td>
                    <toggle-selector
                      v-model="condition.require"
                      left_text="要"
                      right_text="否"
                    />
                  </td>
                  <td class="align-middle">
                    {{ condition.contents }}
                  </td>
                  <td>
                    <input
                      v-if="condition.require == '要'"
                      v-model="condition.result"
                      type="text"
                      class="form-control"
                    />
                  </td>
                </tr>
              </tbody>
            </table>
          </client-only>
        </div>
        <div class="span-title mb-2">
          担当者
        </div>
        <div class="mb-3">
          <select v-model="report.employee" class="form-control">
            <option></option>
            <option
              v-for="(employee, index) in report.employees"
              :key="index"
              :value="employee"
            >
              {{ employee.name }}
            </option>
          </select>
        </div>

        <div class="d-flex justify-content-center">
          <button
            type="button"
            class="btn btn-info"
            style="width:15rem;"
            @click="onStore"
          >
            登録
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
// import { validations } from "~/service/validations/reports/r0001"

export default {
  components: {
    // Loading
  },
  props: {
    report: {
      type: Object,
      required: true
    },
    mode: {
      type: String,
      required: true
    }
  },
  data() {
    return {
      roles: []
    }
  },
  computed: {
    own() {
      return this.$store.state.user
    },
    isCreate() {
      return this.mode == "create" || this.mode == "copy"
    },
    isUpdate() {
      return this.mode == "update"
    },
    disabled() {
      if (!this.own.employee) return true
      if (this.isCreate) return false
      return false
    },
    is_readonly() {
      return this.report.construction.is_readonly
    }
  },
  watch: {
    //
  },
  methods: {
    onStore() {
      // this.$v.$touch()
      // if (this.$v.employee.$invalid) {
      //   alert("エラーです。")
      // } else {
      //   this.$emit("store", this.employee)
      // }
      this.$emit("store", this.report)
    },
    onBack() {
      this.$emit("back")
    },
    onDelete() {
      if (!confirm("削除してもよろしいですか？")) {
        return
      }
      this.$emit("delete")
    },
    onCopy() {
      this.$emit("copy")
    }
  }
  // validations
}
</script>

<style scoped>
.span-title {
  font-weight: bold;
}
.span-item {
  font-weight: bold;
}
</style>
