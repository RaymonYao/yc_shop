<template>
  <div>
    <div class="orders-list">
      <ul>

        <li v-for="(order,index) in orders" :key="index">
          <div class="orders-left">
            <img :src="domain+order.goods_img">
          </div>
          <div class="orders-right">
            <p>{{ order.goods_name }}</p>
            <div> ¥ {{ order.total }}</div>
            <div class="orders-but">
              <button v-if="order.is_pay==0" @click="toBuy(order.id)">去支付</button>
              <button v-if="order.is_exp==1 && order.is_rec==0 " @click="receive(order.id)">确认收货</button>
              <button v-if="order.is_exp==0 && order.is_pay==1 ">待发货</button>
              <button v-if="order.is_comment==1 ">已评价</button>
              <button v-if="order.is_rec==1 && order.is_comment==0" @click="comment(order.id)">评价</button>
              <button v-if="order.is_exp==1" @click="getExpress(order.id)">物流信息</button>
            </div>
          </div>
        </li>


      </ul>
    </div>

  </div>
</template>

<script>
import Express from './Express.vue'
import Comment from './Comment.vue'

export default {
  created: function () {
    this.domain = process.env.VUE_APP_DOMAIN

    this.getOrders(this.$route.query.uri)
  },
  beforeRouteUpdate: function (to, from, next) {
    this.getOrders(to.query.uri)

    next()
  },
  components: {
    Express,
    Comment
  },

  methods: {
    getOrders: function (order_type) {


      let token = localStorage.getItem('token')

      this.axios.get('/api/order/' + order_type, {headers: {token: token}}).then(res => {

        if (res.data.code == 450) {
          localStorage.setItem('token', res.data.token)
          this.axios.get('/api/order/' + order_type, {headers: {token: res.data.token}}).then(res => {
            if (res.data.code == 200) {
              this.orders = res.data.data

            }
          })
        } else if (res.data.code == 200) {
          this.orders = res.data.data

        }


      })


      // if(order_type=='allOrder'){
      // 	this.axios.get(process.env.VUE_APP_HOST+'/orders').then(res=>{
      // 		this.orders = res.data
      // 	})
      // }
      // if(order_type=='waitPay'){
      // 	this.axios.get(process.env.VUE_APP_HOST+'/orders?is_pay=0').then(res=>{
      // 		this.orders = res.data
      // 	})
      // }
      // if(order_type=='waitRec'){
      // 	this.axios.get(process.env.VUE_APP_HOST+'/orders?is_pay=1&is_pay=2').then(res=>{
      // 		this.orders = res.data
      // 	})
      // }

    },
    toBuy: function (id) {
      this.$router.push({'path': '/toPay', 'query': {'id': id}})
    },

    getExpress: function (id) {
      this.$layer.open({
        type: 2,
        title: '物流信息查询',
        area: ['360px', '500px'],
        skin: 'layui-layer-rim', //加上边框
        content: {content: Express, data: {order: id}}
      })
    },

    comment: function (id) {
      this.$layer.open({
        type: 2,
        title: '商品评价',
        area: ['360px', '300px'],
        skin: 'layui-layer-rim', //加上边框
        content: {content: Comment, data: {order: id}}
      })
    },

    receive: function (id) {
      let token = localStorage.getItem('token')

      this.axios.get('/api/order/receive/' + id, {headers: {token: token}}).then(res => {

        if (res.data.code == 450) {
          localStorage.setItem('token', res.data.token)
          this.axios.get('/api/order/receive/' + id, {headers: {token: res.data.token}}).then(res => {


            if (res.data.code == 200) {
              this.$router.push('/user')

            }
          })
        } else if (res.data.code == 200) {

          this.$router.push('/user')

        }


      })

    }

  },

  data: function () {
    return {
      orders: '',
      domain: ''
    }
  }
}
</script>

<style scoped="scoped">
.orders-list {
  position: relative;
}

.orders-left img {
  width: 25vw;
  position: absolute;
  padding: 2vw;
}

.orders-list li {
  height: 16vh;
  border-bottom: 1px solid #F0F0F0;
}

.orders-right {
  margin-left: 27vw;
  padding: 2vw;
}

.orders-right p {

  margin-top: 8px;
  color: #333;
  line-height: 1.36;
  overflow: hidden;
  text-overflow: ellipsis;

  height: 19px;
  font-size: 16px;
  font-weight: bold;
}

.orders-right div {
  color: #e93b3d;
  font-size: 20px;
  font-weight: bold;
  padding-top: 3vw;
}

.orders-but button {
  float: right;
  height: 30px;
  background-color: #CC0000;
  color: #FFFFFF;
  border-radius: 10px;
  border-style: none;
  outline: none;
}

</style>
