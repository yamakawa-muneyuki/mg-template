import { required } from "vuelidate/lib/validators"

export const validations = {
  report: {
    construction: {
      name: {
        required
      }
      // from_period: {
      //   required
      // },
      // to_period: {
      //   required
      // },
      // contents: {
      //   maxLength: maxLength(100)
      // }
      //   checks: [
      //     { value: "", contents: "継続作業" },
      //     { value: "", contents: "開放作業" },
      //     { value: "", contents: "クレーン作業" },
      //     { value: "", contents: "毒性/高所作業" },
      //     { value: "", contents: "メカニカルLOTO" }
      //   ],
      //   permission: {
      //     check1: [
      //       { value: "", contents: "放射線使用許可願" },
      //       { value: "", contents: "仮設電気使用許可願" },
      //       { value: "", contents: "道路使用許可願" }
      //     ],
      //     check2: [
      //       { value: "", contents: "電気通電禁止タグ" },
      //       { value: "", contents: "プロット図" },
      //       { value: "", contents: "作業確認表" }
      //     ],
      //     check3: [
      //       { value: "", contents: "エアーラインマスク使用許可願" },
      //       { value: "", contents: "ホットタップ許可願（危険作業）" }
      //     ],
      //     check4: [
      //       { value: "", contents: "バキュームカー使用点検表" },
      //       { value: "", contents: "消火栓使用許可願" },
      //       { value: "", contents: "掘削はつり許可願" }
      //     ]
      //   },
      //   measure: {
      //     check1: [
      //       {
      //         value: "",
      //         contents: "スチームホース準備",
      //         text: "",
      //         use_text: true
      //       },
      //       { value: "", contents: "計器配管", text: "", use_text: true },
      //       { value: "", contents: "立合", text: "", use_text: true }
      //     ],
      //     check2: [
      //       {
      //         value: "",
      //         contents: "熱中症対策",
      //         text: "",
      //         use_text: true
      //       },
      //       {
      //         value: "",
      //         contents: "水ホース準備",
      //         text: "",
      //         use_text: true
      //       },
      //       {
      //         value: "",
      //         contents: "仕切板入れ",
      //         text: "",
      //         use_text: true
      //       },
      //       { value: "", contents: " 立合", text: "", use_text: true }
      //     ]
      //   },
      //   protects: [
      //     { value: "", contents: "ハーネス" },
      //     { value: "", contents: "ゴーグル" },
      //     { value: "", contents: "シールド" },
      //     { value: "", contents: "ゴム手袋" },
      //     { value: "", contents: "耐薬品服" },
      //     { value: "", contents: "ゴム長" },
      //     { value: "", contents: "防塵マスク" },
      //     { value: "", contents: "エラーラインマスク" },
      //     { value: "", contents: "防毒マスク" },
      //     { value: "", contents: "ライフジャケット" },
      //     { value: "", contents: "耳栓" },
      //     { value: "", contents: "耳栓 + イヤーマフ" },
      //     { value: "", contents: "その他" }
      //   ],
      //   requests: [
      //     {
      //       value: "",
      //       contents: "関係配管遮断",
      //       text: "",
      //       use_text: true
      //     },
      //     { value: "", contents: "内部流体パージ" },
      //     { value: "", contents: "電源タグアウト" },
      //     {
      //       value: "",
      //       contents: "毒性/有害ｶﾞｽの雰囲気ガス検",
      //       text: "",
      //       use_text: true
      //     },
      //     { value: "", contents: "その他", text: "", use_text: true }
      //   ]
      // },
      // area: {
      //   is_show: false,
      //   is_readonly: false,
      //   permissionConditions: []
    },
    employee: {
      required
    }
    // employees: []
  }
}
