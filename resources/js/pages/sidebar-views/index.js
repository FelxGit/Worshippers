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

const sidebarRoutes = [
  {
    path: '/',
    component: Home,
    name: 'home',
    icon: 'fa fa-home'
  },
  {
    path: 'listing',
    component: Listing,
    name: 'listing',
    icon: 'fa-solid fa-list'
  },
  {
    path: 'favorites',
    component: Favorites,
    name: 'favorites',
    icon: 'fa-solid fa-star'
  },
  {
    path: 'team',
    component: Team,
    name: 'team',
    icon: 'fa-solid fa-people-group'
  },
  {
    path: 'faqs',
    component: FAQs,
    name: 'FAQs',
    icon: 'fa-solid fa-circle-question'
  },
  {
    path: 'about',
    component: About,
    name: 'about',
    icon: 'fa-solid fa-circle-info'
  },
  {
    path: 'guides',
    component: Guides,
    name: 'guides',
    icon: 'fa-regular fa-note-sticky'
  },
  {
    path: 'code-of-conduct',
    component: CodeOfConduct,
    name: 'CodeOfConduct',
    icon: 'fa-solid fa-thumbs-up'
  },
  {
    path: 'privacy-policy',
    component: PrivacyPolicy,
    name: 'PrivacyPolicy',
    icon: 'fa-solid fa-shield-halved'
  },
  {
    path: 'terms-of-use',
    component: TermsOfUse,
    name: 'TermsOfUse',
    icon: 'fa-solid fa-handshake-simple'
  }
];
export default sidebarRoutes
