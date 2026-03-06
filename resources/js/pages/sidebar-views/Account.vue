<template>
  <main class="main">
    <br/>
    <p class="text-danger">By clicking this button, your account's data will be remove by the system.</p>
    <button @click="removeAccount()" type="button" class="btn btn-danger">
        Remove your account data
    </button>
  </main>
</template>

<script>
import { getters, mutations, actions } from "../../store";

export default {
  props: ['data'],
  computed: {
    ...getters
  },
  methods: {
    ...mutations,
    ...actions,
    removeAccount() {
        this.$http.delete('api/users/' + this.user.id)
        .then((response) => {
          localStorage['community.jwt'] = null
          localStorage['community.user'] = null
          mutations.setUser(null)
          mutations.setIsLoggedIn(false)

          let alertData = {
            showAlert: true,
            type: "success",
            message:
              "The system has successfully removed your account data.",
          };
          mutations.setAlert(alertData);
        })
    }
  }
}
</script>

<style scoped>
.main {
  width: 100%;
}
</style>