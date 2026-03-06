import Home from '../../pages/sidebar-views/Home.vue'
import Listing from '../../pages/sidebar-views/Listing.vue'
import Favorites from '../../pages/sidebar-views/Favorites.vue'
import Team from '../../pages/sidebar-views/Team.vue'
import FAQs from '../../pages/sidebar-views/FAQs.vue'
import About from '../../pages/sidebar-views/About.vue'
import Guides from '../../pages/sidebar-views/Guides.vue'
import CodeOfConduct from '../../pages/sidebar-views/CodeOfConduct.vue'
import PrivacyPolicy from '../../pages/sidebar-views/PrivacyPolicy.vue'
import TermsOfUse from '../../pages/sidebar-views/TermsOfUse.vue'
import Account from '../../pages/sidebar-views/Account.vue'

const sidebarRoutes = [
  {
    path: '/',
    component: Home,
    name: 'home',
    icon: 'fa fa-home',
    class: 'flex items-center p-2 text-base font-normal rounded-lg text-white hover:bg-bt-secondary'
  },
  {
    path: 'listing',
    component: Listing,
    name: 'listing',
    icon: 'fa-solid fa-list',
    class: 'flex items-center p-2 text-base font-normal rounded-lg text-white hover:bg-bt-secondary'
  },
  {
    path: 'favorites',
    component: Favorites,
    name: 'favorites',
    icon: 'fa-solid fa-star',
    class: 'flex items-center p-2 text-base font-normal rounded-lg text-white hover:bg-bt-secondary'
  },
  {
    path: 'team',
    component: Team,
    name: 'team',
    icon: 'fa-solid fa-people-group',
    class: 'flex items-center p-2 text-base font-normal rounded-lg text-white hover:bg-bt-secondary'
  },
  {
    path: 'faqs',
    component: FAQs,
    name: 'FAQs',
    icon: 'fa-solid fa-circle-question',
    class: 'flex items-center p-2 text-base font-normal rounded-lg text-white hover:bg-bt-secondary'
  },
  {
    path: 'about',
    component: About,
    name: 'about',
    icon: 'fa-solid fa-circle-info',
    class: 'flex items-center p-2 text-base font-normal rounded-lg text-white hover:bg-bt-secondary'
  },
  {
    path: 'guides',
    component: Guides,
    name: 'guides',
    icon: 'fa-regular fa-note-sticky',
    class: 'flex items-center p-2 text-base font-normal rounded-lg text-white hover:bg-bt-secondary'
  },
  {
    path: 'code-of-conduct',
    component: CodeOfConduct,
    name: 'CodeOfConduct',
    icon: 'fa-solid fa-thumbs-up',
    class: 'flex items-center p-2 text-base font-normal rounded-lg text-white hover:bg-bt-secondary'
  },
  {
    path: 'privacy-policy',
    component: PrivacyPolicy,
    name: 'PrivacyPolicy',
    icon: 'fa-solid fa-shield-halved',
    class: 'flex items-center p-2 text-base font-normal rounded-lg text-white hover:bg-bt-secondary'
  },
  {
    path: 'terms-of-use',
    component: TermsOfUse,
    name: 'TermsOfUse',
    icon: 'fa-solid fa-handshake-simple',
    class: 'flex items-center p-2 text-base font-normal rounded-lg text-white hover:bg-bt-secondary'
  },
  {
    path: 'account',
    component: Account,
    name: 'RemoveAccount',
    icon: 'fa fa-trash',
    class: 'flex items-center p-2 text-base font-normal rounded-lg text-b-danger hover:bg-bt  -secondary'
  }
];
export default sidebarRoutes
