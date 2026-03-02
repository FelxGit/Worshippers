<template>
  <div class="post-form-create">
    <PostForm></PostForm>
  </div>
</template>
<script>
import PostForm from '../../components/PostForm.vue'
import { getters, mutations, actions } from "../../store";

export default {
    components: { PostForm },
    data() {
        return {
        };
    },
    mounted() {
      console.log('mounted postcreate')
    },
    computed: {
      ...getters
    }
}
</script>
<style scoped lang="scss">
@import "../../../sass/_imports.scss";

.post-form-create {
  margin: $base-gap
}
</style>