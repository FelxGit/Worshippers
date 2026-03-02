import Register from './Register.vue'
import Login from './Login.vue'
import ResetPassword from './ResetPassword.vue'

const auth = [
  {
    path: '/register',
    name: 'register',
    component: Register
  },
  {
    path: '/login',
    name: 'login',
    component: Login
  },
  {
    path: '/password/reset',
    name: 'reset-password',
    component: ResetPassword
  },
];
export default auth
