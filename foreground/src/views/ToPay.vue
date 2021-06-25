<template>
  <div>
    <Header>订单结算</Header>
    <div class="clear"></div>
    <div class="addr">
      <strong>{{ address.name }} {{ address.mobile }}</strong>
      <p>{{ address.address }}</p>
    </div>


    <div class="cart">
      <ul>
        <li v-for="(goods,index) in goodsList" :key="index">

          <div class="goods-img"><img :src="domain+goods.goods_img"></div>
          <div class="goods-info">
            <p> {{ goods.goods_name }}</p>
            <div class="goods-price">
              <strong> {{ goods.goods_price }} </strong>
            </div>
            <div class="delCart">{{ goods.num }}</div>


          </div>
        </li>

      </ul>
    </div>


    <div class="pay-total">
      <strong>实付金额:</strong><span>¥ {{ totalPrice }}</span>
    </div>
    <div class="clear"></div>
    <div class="pay-btn">
      <button @click="toPay('wx')" class="wx-pay">微信支付</button>
      <button @click="toPay('zfb')" class="zfb-pay">支付宝支付</button>
    </div>
  </div>
</template>

<script>
import Header from '../components/Header.vue'

export default {
  components: {
    Header
  },
  created: function () {

    this.domain = process.env.VUE_APP_DOMAIN

    let token = localStorage.getItem('token')

    this.axios.get('/api/one_addr', {headers: {token: token}}).then(res => {

      if (res.data.code == 450) {
        localStorage.setItem('token', res.data.token)
        this.axios.get('/api/one_addr', {headers: {token: res.data.token}}).then(res => {
          if (res.data.code == 200) {
            this.address = res.data.data
          }
        })
      } else if (res.data.code == 200) {
        this.address = res.data.data
      }


    })


    if (!this.$route.query.id) {
      let cart = JSON.parse(localStorage.getItem('cartList'))

      for (let i = 0; i < cart.length; i++) {
        if (cart[i].checked == 'true') {
          this.goodsList.push(cart[i])
        }
      }
      this.sumPrice(this.goodsList)
    } else {


      this.axios.get('/api/goodss/' + this.$route.query.id, {headers: {token: token}}).then(res => {

        if (res.data.code == 450) {
          localStorage.setItem('token', res.data.token)
          this.axios.get('/api/goodss/' + this.$route.query.id, {headers: {token: res.data.token}}).then(res => {
            if (res.data.code == 200) {
              this.goodsList.push(res.data.data)
              this.totalPrice = res.data.data.goods_price
            }
          })
        } else if (res.data.code == 200) {
          this.goodsList.push(res.data.data)
          this.totalPrice = res.data.data.goods_price
        }


      })


    }


  },
  data: function () {
    return {
      address: '',
      goodsList: [],
      totalPrice: 0,
      domain: ''
    }
  },
  methods: {
    sumPrice: function (goods) {

      for (let i = 0; i < goods.length; i++) {

        if (goods[i].checked == 'true') {
          this.totalPrice = ((this.totalPrice * 100) + (((goods[i].goods_price) * 100) * goods[i].num)) / 100
        }
      }

    },
    toPay: function (type) {
      //请求后端接口

      let pay = new Array;
      pay['type'] = type;
      pay['orderId'] = localStorage.getItem('orderId')

      let data = this.qs.stringify(pay);
      let token = localStorage.getItem('token')

      this.axios.post('/api/pay', data, {headers: {token: token}}).then(res => {
        if (res.data.code == 450) {
          localStorage.setItem('token', res.data.token)
          this.axios.post('/api/pay', data, {headers: {token: res.data.token}}).then(res => {

            const form = res.data;
            const div = document.createElement('div')
            div.innerHTML = form;
            document.body.append(div)
            document.forms['alipaysubmit'].submit()
          })

        } else {

          const form = res.data;
          const div = document.createElement('div')
          div.innerHTML = form;
          document.body.append(div)
          document.forms['alipaysubmit'].submit()
        }

      })
      // let  ret = {'status':'success','msg':'支付成功'}

      // if(ret.status=='success'){
      // 	this.$router.push('/user')
      // }

    }
  }
}
</script>

<style scoped="scoped">
.clear {
  clear: both;
}

.addr {
  padding-bottom: 15px;
  background: #FFFFFF url(../assets/img/icon/address.png) -7px bottom repeat-x;
}

.addr strong {
  font-size: 20px;
  padding: 3vw;
}

.addr p {
  color: #666;
  padding: 3vw;
}

.cart {
  position: relative;
}

.cart li {
  height: 20vh;
  border-bottom: 1px solid #F0F0F0;
}

.radio {
  position: absolute;
  line-height: 20vh;
}

.goods-img {
  position: absolute;
  margin-left: 5%;
  padding-top: 3vh;
}

.goods-img img {
  width: 25vw;
}

.goods-info {
  margin-left: 30%;
  padding: 3vh;
}

.goods-info p {
  font-size: 16px;
  height: 5vh;
  overflow: hidden;
  text-overflow: ellipsis;
}

.cart-num {
  float: right;
}

.goods-price {
  margin-top: 5vh;
}

.goods-price strong {
  color: #CC0000;
  font-size: 20px;
}

.cart-num {
  background-color: #f7f7f7;
}

.cart-num span {
  font-size: 33px;
  cursor: pointer;

}

.cart-num input {
  width: 8vw;
  border: none;
  outline: none;
  background-color: #f7f7f7;
  margin-top: -30%;
  text-align: center;
}

.delCart {
  margin-top: -2vh;
  margin-left: 88%;
  color: #999;
  cursor: pointer;
}

.pay-total {
  float: right;
  padding: 3vw;
}

.pay-total strong {
  font-size: 18px;
}

.pay-total span {
  color: #CC0000;
  font-size: 18px;
}

.pay-btn {
  width: 100%;
  margin-top: 10%;
}

.wx-pay {
  width: 40%;
  height: 44px;
  border-radius: 22px;
  border-style: none;
  outline: none;
  background-color: #00c250;
  color: #FFFFFF;
  font-size: 18px;
  margin-left: 7%;
}

.zfb-pay {
  width: 40%;
  height: 44px;
  border-radius: 22px;
  border-style: none;
  outline: none;
  background-color: #00a3ee;
  color: #FFFFFF;
  font-size: 18px;
  margin-left: 7%;
}

</style>
