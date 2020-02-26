<template>
  <create-update
    mode="create"
    :report="report"
    @store="onCreate"
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
      report: {
        application_form_code: "R0001",
        apply_behavior: "0",
        id: "",
        construction: {
          is_show: true,
          is_readonly: false,
          name: "",
          from_period: "",
          to_period: "",
          contents: "",
          checks: [
            { value: "", contents: "継続作業" },
            { value: "", contents: "開放作業" },
            { value: "", contents: "クレーン作業" },
            { value: "", contents: "毒性/高所作業" },
            { value: "", contents: "メカニカルLOTO" }
          ],
          permission: {
            check1: [
              { value: "", contents: "放射線使用許可願" },
              { value: "", contents: "仮設電気使用許可願" },
              { value: "", contents: "道路使用許可願" }
            ],
            check2: [
              { value: "", contents: "電気通電禁止タグ" },
              { value: "", contents: "プロット図" },
              { value: "", contents: "作業確認表" }
            ],
            check3: [
              { value: "", contents: "エアーラインマスク使用許可願" },
              { value: "", contents: "ホットタップ許可願（危険作業）" }
            ],
            check4: [
              { value: "", contents: "バキュームカー使用点検表" },
              { value: "", contents: "消火栓使用許可願" },
              { value: "", contents: "掘削はつり許可願" }
            ]
          },
          measure: {
            check1: [
              {
                value: "",
                contents: "スチームホース準備",
                text: "",
                use_text: true
              },
              { value: "", contents: "計器配管", text: "", use_text: true },
              { value: "", contents: "立合", text: "", use_text: true }
            ],
            check2: [
              { value: "", contents: "熱中症対策", text: "", use_text: true },
              { value: "", contents: "水ホース準備", text: "", use_text: true },
              { value: "", contents: "仕切板入れ", text: "", use_text: true },
              { value: "", contents: " 立合", text: "", use_text: true }
            ]
          },
          protects: [
            { value: "", contents: "ハーネス" },
            { value: "", contents: "ゴーグル" },
            { value: "", contents: "シールド" },
            { value: "", contents: "ゴム手袋" },
            { value: "", contents: "耐薬品服" },
            { value: "", contents: "ゴム長" },
            { value: "", contents: "防塵マスク" },
            { value: "", contents: "エラーラインマスク" },
            { value: "", contents: "防毒マスク" },
            { value: "", contents: "ライフジャケット" },
            { value: "", contents: "耳栓" },
            { value: "", contents: "耳栓 + イヤーマフ" },
            { value: "", contents: "その他" }
          ],
          requests: [
            { value: "", contents: "関係配管遮断", text: "", use_text: true },
            { value: "", contents: "内部流体パージ" },
            { value: "", contents: "電源タグアウト" },
            {
              value: "",
              contents: "毒性/有害ｶﾞｽの雰囲気ガス検",
              text: "",
              use_text: true
            },
            { value: "", contents: "その他", text: "", use_text: true }
          ]
        },
        area: {
          is_show: false,
          is_readonly: false,
          permissionConditions: [
            { required: false, contents: "関係配管遮断", result: "" },
            { required: false, contents: "内部流体パージ", result: "" },
            {
              required: false,
              contents: "プロセス開放チェックリスト",
              result: ""
            },
            {
              required: false,
              contents: "電源タグアウト 回転機は現場スイッチにて起動不可確認",
              result: ""
            },
            {
              required: false,
              contents: "H2S検査　　 　 5ppm以下",
              result: ""
            },
            {
              required: false,
              contents: "ベンゼン検査 　 0.5ppm以下",
              result: ""
            },
            {
              required: false,
              contents: "トルエン検査　    20ppm以下　　",
              result: ""
            },
            {
              required: false,
              contents: "キシレン検査　    100ppm以下",
              result: ""
            },
            {
              required: false,
              contents: "アンモニア検査 　  25ppm以下",
              result: ""
            },
            {
              required: false,
              contents: "別紙作業確認書（計器またはスタティック）",
              result: ""
            },
            { required: false, contents: "SCDバイパス", result: "" },
            {
              required: false,
              contents: "立合（区域担当グループ）",
              result: ""
            },
            { required: false, contents: "その他", result: "" }
          ]
        },
        employees: []
      }
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
    this.getInit()
  },
  methods: {
    async getInit() {
      this.$store.dispatch("loading/add")
      const { data } = await this.$axios.$get("/api/employee/selector")
      this.report.employees = data
      this.$store.dispatch("loading/sub")
    },
    async onCreate() {
      this.$store.dispatch("loading/add")
      const resp = await this.$axios.$post("/api/report", {
        report: this.report
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
