<template>
  <div>
    <div class="index-header">
      <ul>
        <li @click="toCat" class="header-cat">
          <img src="../assets/img/icon/cat.png">
        </li>
        <li class="header-search">
          <input type="text"/>
        </li>
        <li class="header-user">
          <img @click="toUser" v-if="isLogin" src="../assets/img/icon/login-user.png">
          <div @click="toLogin" v-else>登录</div>
        </li>
      </ul>
    </div>

    <div class="clear"></div>

    <div class="swiper">
      <swiper ref="mySwiper" :options="swiperOptions">

        <swiper-slide v-for="(swiper,index) in swipers" :key="index">
          <img :src="domain+swiper.img_url"/>
        </swiper-slide>
        <div class="swiper-pagination" slot="pagination"></div>
      </swiper>
    </div>


    <div class="index-goods">
      <ul>
        <li @click="goodsDetail(goods.id)" v-for="(goods,index) in goods_list" :key="index">
          <div><img :src="domain+goods.goods_img"></div>
          <div class="goods-name">{{ goods.goods_name }}</div>
          <div class="goods-price">¥ {{ goods.goods_price }}</div>
        </li>
      </ul>
    </div>


  </div>
</template>

<script>

import {Swiper, SwiperSlide, directive} from 'vue-awesome-swiper'
import 'swiper/css/swiper.css'

export default {
  created: function () {
    if (localStorage.getItem('token')) {
      this.isLogin = true
    }


    this.domain = process.env.VUE_APP_DOMAIN
    // this.axios.get(process.env.VUE_APP_HOST+'/swiper').then(res=>{
    // 	this.swipers=res.data
    // })

    this.axios.get('/api/swipers').then(res => {
      //console.log(res.data.data)
      if (res.data.code == 200) {
        this.swipers = res.data.data
      }
    })


    this.getGoods()

    window.addEventListener('scroll', this.onScroll)

  },
  data: function () {
    return {
      isLogin: false,
      swiperOptions: {
        pagination: {
          el: '.swiper-pagination'
        },
        autoplay: true
      },
      swipers: [],
      goods_list: [],
      curIndex: 1,
      limit: 6,
      domain: ''

    }
  },
  methods: {
    toCat: function () {
      this.$router.push('/cat')
    },
    toUser: function () {
      this.$router.push('/user')
    },
    toLogin: function () {
      this.$router.push('/login')
    },
    onScroll: function () {
      let top = document.documentElement.scrollTop || window.pageYOfset || document.body.scrollTop
      let height = document.documentElement.scrollHeight
      let clientHeight = document.documentElement.clientHeight

      if (height - top - clientHeight <= 60) {
        this.getGoods()
      }
    },
    getGoods: function () {

      this.axios.get('/api/indexgoods?page=' + this.curIndex).then(res => {
        if (res.data.code == 200) {
          this.goods_list = this.goods_list.concat(res.data.data)
          //console.log(res.data);
        }
      })
      this.curIndex++
    },
    goodsDetail: function (id) {
      this.$router.push('/goodsDetail/' + id)
    }
  },
  components: {
    Swiper,
    SwiperSlide
  },
}

</script>

<style scoped="scoped">
.clear {
  height: 46px;
}

.index-header {
  background-color: #f2270c;
  height: 46px;
  width: 100%;
  text-align: center;
  position: fixed;
  z-index: 2;
}

.index-header li {
  float: left;
  line-height: 46px;
}

.index-header img {
  width: 6vw;
}

.header-cat, .header-user {
  width: 20%;
}

.header-search {
  width: 60%;
}

.header-search input {
  width: 100%;
  height: 26px;
  border-radius: 13px;
  border-style: none;
}

.header-user div {
  color: #fff;
  font-size: 18px;
  font-weight: bold;
}

.swiper img {
  width: 100%;
}

.index-goods li {
  width: 42%;
  float: left;
  margin-left: 2%;
  padding: 2vw;
}

.index-goods img {
  width: 42vw;
}

.goods-name {
  box-sizing: border-box;
  height: 31px;
  font-size: 13px;
  overflow: hidden;
  text-overflow: ellipsis;
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  word-break: break-all;
  color: #232326;
  margin-top: 5px;
  line-height: 16px;
  margin-bottom: 3px;
  padding: 0 4px;
}

.goods-price {
  color: #f23030;
  line-height: 25px;
  font-family: JDZhengHT-EN-Regular;
}
</style>
