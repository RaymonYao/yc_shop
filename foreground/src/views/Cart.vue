<template>
  <div>
    <Header>购物车</Header>
    <div class="clear"></div>
    <div class="cart">
      <ul v-if="goodsList">
        <li v-for="(goods,index) in goodsList" :key="index">
          <div class="radio" @click="chkCart(index,$event)">
            <input type="checkbox" v-if="goods.checked=='true'" checked=""/>
            <input type="checkbox" v-else/>
          </div>
          <div class="goods-img"><img :src="domain+goods.goods_img"></div>
          <div class="goods-info">
            <p> {{ goods.goods_name }}</p>
            <div class="goods-price">
              <strong> {{ goods.goods_price }} </strong>
              <div class="cart-num">
                <span @click="subNum(index)">-</span>
                <input type="text" :value="goods.num"/>
                <span @click="addNum(index)">+</span>
              </div>
            </div>
            <div @click="delCart(index)" class="delCart">删除</div>


          </div>
        </li>

      </ul>
      <p class="cart-p" v-else>购物车空的</p>
    </div>

    <div class="cart-footer">
      <div class="cart-total">
        <strong>总计:</strong>
        <span> ¥ {{ totalPrice }}</span>
      </div>
      <div class="cart-pay">
        <button @click="toPay">去结算</button>
      </div>

    </div>

  </div>
</template>

<script>
import Header from '../components/Header.vue'

export default {
  beforeRouteEnter: function (to, from, next) {
    if (!localStorage.getItem('token')) {
      next('/login')
    } else {
      next()
    }
  },
  created: function () {
    this.domain = process.env.VUE_APP_DOMAIN
    this.goodsList = JSON.parse(localStorage.getItem('cartList'))

    if (this.goodsList) {
      this.sumPrice(this.goodsList);
    }

  },
  components: {
    Header
  },

  data: function () {
    return {
      goodsList: '',
      totalPrice: 0,
      domain: ''
    }
  },
  methods: {
    delCart: function (index) {
      this.goodsList.splice(index, 1)
      this.saveCart(this.goodsList)
    },

    saveCart: function (goods) {

      let cartGoods = JSON.stringify(goods)
      localStorage.setItem('cartList', cartGoods)
    },
    subNum: function (index) {

      if (this.goodsList[index].num <= 1) {
        return
      }
      this.goodsList[index].num--
      this.sumPrice(this.goodsList)
      this.saveCart(this.goodsList)
    },
    addNum: function (index) {
      this.goodsList[index].num++
      this.sumPrice(this.goodsList)
      this.saveCart(this.goodsList)
    },
    sumPrice: function (goods) {
      this.totalPrice = 0
      for (let i = 0; i < goods.length; i++) {

        if (goods[i].checked == 'true') {
          this.totalPrice = ((this.totalPrice * 100) + (((goods[i].goods_price) * 100) * goods[i].num)) / 100
        }
      }

    },
    chkCart: function (index, $event) {
      if ($event.target.checked) {
        this.goodsList[index].checked = 'true'
      } else {
        this.goodsList[index].checked = 'false'
      }
      this.saveCart(this.goodsList)
      this.sumPrice(this.goodsList)
    },
    toPay: function () {
      //选中商品存到数据库订单表

      let cart = JSON.parse(localStorage.getItem('cartList'))
      let goodsList = new Array;
      for (let i = 0; i < cart.length; i++) {
        if (cart[i].checked == 'true') {

          let goods = {goods_id: cart[i].id, goods_price: cart[i].goods_price, num: cart[i].num};
          goodsList.push(goods)
        }
      }

      let data = this.qs.stringify(goodsList);
      let token = localStorage.getItem('token')
      this.axios.post('/api/order', data, {headers: {token: token}}).then(res => {

        if (res.data.code == 450) {
          localStorage.setItem('token', res.data.token)
          this.axios.post('/api/order', data, {headers: {token: res.data.token}}).then(res => {
            if (res.data.code == 200) {
              localStorage.setItem('orderId', JSON.stringify(res.data.data))
              this.$router.push('/toPay')
            } else if (res.data.code == 460) {
              this.$router.push('/user/addr')
            }

          })

        } else if (res.data.code == 200) {
          localStorage.setItem('orderId', JSON.stringify(res.data.data))
          this.$router.push('/toPay')
        } else if (res.data.code == 460) {
          this.$router.push('/user/addr')
        }


      })


      //this.$router.push('/toPay')
    }
  }
}

</script>

<style scoped="scoped">
.clear {
  clear: both;
}

.cart {
  position: relative;
}

.cart li {
  height: 25vh;
  border-bottom: 1px solid #F0F0F0;
}

.radio {
  position: absolute;
  line-height: 20vh;
}

.goods-img {
  position: absolute;
  margin-left: 10%;
  padding-top: 3vh;
}

.goods-img img {
  width: 25vw;
}

.goods-info {
  margin-left: 33%;
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

.cart-footer {
  position: fixed;
  bottom: 0;
  background-color: #F0F0F0;
  height: 50px;
  width: 100%;
}

.cart-total {
  float: left;
  line-height: 50px;
  margin-left: 25%;
}

.cart-total strong {
  font-size: 20px;
  font-weight: bold;
}

.cart-total span {
  color: #f2270c;
  font-size: 16px;
  font-weight: bold;

}

.cart-pay {
  float: left;
}

.cart-pay button {
  margin: 5px 5px 0 10px;
  font-weight: 700;
  display: block;
  width: 110px;
  height: 40px;
  line-height: 40px;
  text-align: center;
  font-size: 20px;
  border-radius: 20px;
  background-color: #f2270c;
  color: #fff;
  border-style: none;
}

.delCart {
  margin-top: 3vh;
  margin-left: 88%;
  color: #999;
  cursor: pointer;
}

.cart-p {
  width: 30vw;
  margin: 0 auto;
  font-size: 20px;
  font-weight: bold;
  margin-top: 20vh;
}
</style>
