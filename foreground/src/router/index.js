import Vue from 'vue'
import VueRouter from 'vue-router'
import Index from '../views/Index.vue'
import Cat from '../views/Cat.vue'
import Cart from '../views/Cart.vue'
import User from '../views/User.vue'
import Login from '../views/Login.vue'
import Order from '../components/Order.vue'
import Address from '../components/Address.vue'
import AddAddr from '../views/AddAddr.vue'
import GoodsDetail from '../views/GoodsDetail.vue'
import SubCat from '../components/SubCat.vue'
import GoodsList from '../views/GoodsList.vue'
import ToPay from '../views/ToPay.vue'


Vue.use(VueRouter)

const routes = [
    {
        path: "/",
        component: Index,
        meta: {
            isTab: true
        }
    },
    {
        path: "/cat",
        component: Cat,
        redirect: '/cat/subCat',
        meta: {
            isTab: true
        },
        children: [
            {
                path: "subCat",
                component: SubCat,
                meta: {
                    isTab: true
                },
            }
        ]
    },
    {
        path: "/cart",
        component: Cart,

    },
    {
        path: "/user",
        component: User,
        redirect: {path: '/user/order', query: {uri: 'allOrder'}},
        meta: {
            isTab: true
        },
        children: [
            {
                path: "order",
                component: Order,
                meta: {
                    isTab: true
                },
            },

            {
                path: "addr",
                component: Address,
                meta: {
                    isTab: true
                },
            }
        ]
    },
    {
        path: "/login",
        component: Login,
    },
    {
        path: "/toPay",
        component: ToPay,
    },

    {
        path: "/goodsDetail/:id",
        component: GoodsDetail,
    },

    {
        path: "/user/addAddr",
        component: AddAddr,
    },

    {
        path: "/goodsList/:id",
        component: GoodsList,
    },
]

const router = new VueRouter({
    routes
})

export default router
