<template>
  <create-update @submit="update"/>
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
