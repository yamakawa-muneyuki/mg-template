<template>
  <create-update :id="id"/>
</template>

<script>
import CreateUpdate from '~/components/forms/employees/CreateUpdate.vue'
export default {
  computed: {
    id() {
      return this.$route.params.id
    },
  },
  components: {
      CreateUpdate,
  }
}
</script>