import {
  required,
  minLength,
  maxLength,
  email,
  requiredIf
} from "vuelidate/lib/validators"

export const validations = {
  employee: {
    first_name: {
      maxLength: maxLength(191)
    },
    last_name: {
      required,
      maxLength: maxLength(191)
    },
    first_phonetic_name: {
      maxLength: maxLength(191)
    },
    last_phonetic_name: {
      maxLength: maxLength(191)
    },
    email: {
      email
    },
    user_name: {
      required
    },
    password: {
      required: requiredIf(function() {
        return this.isCreate || this.password
      }),
      minLength: minLength(4)
    }
  }
}
