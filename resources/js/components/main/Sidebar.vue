<template>
  <div id="sidebarComponent" class="sidebarComponent">
    <div v-show="isLoggedIn" class="sidebar-loggedin">
      <div class="listing">
        <aside class="" aria-label="Sidebar">
            <div class="overflow-y-auto rounded">
                <ul class="space-y-2">
                    <li v-for="(menu, index) in sidebar" :key="index">
                        <router-link :to="{ name: menu.name }" class="flex items-center p-2 text-base font-normal rounded-lg text-white hover:bg-bt-secondary">
                        <i :class="`${menu.icon}`" aria-hidden="true"></i>
                        <span class="ml-3">{{ lang.get(`words.${_.startCase(_.get(menu, 'name')).replaceAll(' ', '')}`) }}</span>
                        </router-link>
                    </li>
                    <li>
                        <a @click="signOut()" href="#" class="flex items-center p-2 text-base font-normal rounded-lg text-b-danger hover:bg-bt-secondary">
                        <i class="fa-solid fa-right-from-bracket"></i>
                        <span class="flex-1 ml-3 whitespace-nowrap">{{ lang.get('words.Logout') }}</span>
                        </a>
                    </li>
                </ul>
            </div>
        </aside>
      </div>
    </div>
  </div>
</template>
<script>
import { getters, mutations } from "../../store";
import sidebar from '../../pages/sidebar-views'

export default {
  name: 'sidebar',
  props: ['data'],
  data() {
    return {
      sidebar: sidebar
    }
  },
  methods: {
    ...mutations,
    signOut() {
      localStorage['community.jwt'] = null
      localStorage['community.user'] = null
      mutations.setUser(null)
      mutations.setIsLoggedIn(false)
    }
  },
  computed: {
    ...getters
  }
}
</script>

<style scoped lang="scss">
@import '../../../sass/imports';

.sidebarComponent {
  width: 300px;
  margin: $base-comp-gap-y 0rem 0rem $base-comp-gap-x;
  position: fixed;
}
</style>