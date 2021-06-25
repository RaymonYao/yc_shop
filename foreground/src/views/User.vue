<template>
  <div>
    <Header>我的京东</Header>
    <div class="clear"></div>
    <div class="user-info">
      <div>
        <img src="../assets/img/icon/user.png">
      </div>
      <div class="user-mobile">
        {{ mobile }}
      </div>
      <div class="logout" @click="logout">
        退出登录
      </div>
    </div>
    <div class="clear"></div>
    <div class="gray-line"></div>

    <div>
      <ul class="user-nav">

        <router-link tag="li" :to="{path:'/user/order',query:{uri:'allOrder'}}">全部订单</router-link>
        <router-link tag="li" :to="{path:'/user/order',query:{uri:'waitPay'}}">待付款</router-link>
        <router-link tag="li" :to="{path:'/user/order',query:{uri:'waitRec'}}">待收货</router-link>
        <router-link tag="li" to="/user/addr">地址管理</router-link>
      </ul>

    </div>
    <div class="clear"></div>
    <div class="gray-line"></div>

    <div>
      <router-view></router-view>
    </div>
  </div>
</template>

<script>
import Header from '../components/Header.vue'

export default {

  created: function () {
    let token = localStorage.getItem('token')
    if (!token) {
      this.$router.push('/login')
      return;
    }

    this.axios.get('/api/user', {headers: {token: token}}).then(res => {

      if (res.data.code == 450) {
        localStorage.setItem('token', res.data.token)

        this.axios.get('/api/user', {headers: {token: res.data.token}}).then(res => {
          if (res.data.code == 200) {
            this.mobile = res.data.mobile
          }

        })

      } else if (res.data.code == 440) {

        this.$router.push('/login')
        return;
      } else if (res.data.code == 200) {
        this.mobile = res.data.mobile
      }

    })

    //
  },
  components: {
    Header
  },
  data: function () {
    return {
      mobile: ''
    }
  },

  methods: {
    logout: function () {
      //this.axios
      localStorage.clear()
      this.$router.push('/')
    }
  }
}
</script>

<style scoped="scoped">
.clear {
  clear: both;
}

.user-info {
  background: linear-gradient(90deg, #dd9b4c, #ffd787);
  height: 25vw;
}

.user-info div {
  float: left;
}

.user-info img {
  width: 18vw;
  padding: 3vw;
}

.user-mobile {
  font-size: 5vw;
  font-weight: bold;
  color: #FFFFFF;
  line-height: 25vw;
}

.logout {
  font-weight: bold;
  color: #CC0000;
  font-size: 4vw;
  margin-left: 15vw;
  padding: 2vw;
}

.gray-line {
  height: 3vw;
  background-color: #f0f0f0;
}

.user-nav li {
  float: left;
  width: 25%;
  text-align: center;
  height: 44px;
  line-height: 44px;

}

.router-link-exact-active {
  background-color: #F0F0F0;
}
</style>
