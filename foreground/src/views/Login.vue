<template>
  <div>


    <Header>京东登录注册</Header>


    <div class="clear"></div>

    <div class="login-main">

      <div class="mobile">
        <input type="text" v-model.lazy="mobile" placeholder="输入手机号"/>
      </div>


      <div class="code">
        <div class="code-text">
          <input type="text" v-model="code" placeholder="请输入验证码"/>
        </div>
        <div>
          <button @click="sendCode">{{ btnMsg }}</button>
        </div>
      </div>

    </div>
    <div class="clear"></div>
    <div class="tip" v-show="!isCheck">{{ errInfo }}</div>
    <div class="clear"></div>


    <div class="sub">
      <button @click="login">登录</button>
    </div>


  </div>
</template>

<script>
import Header from '../components/Header.vue'

export default {
  data: function () {
    return {
      mobile: '',
      errInfo: '',
      isCheck: false,
      btnMsg: '发送验证码',
      code: ''
    }
  },
  components: {
    Header
  },
  methods: {

    sendCode: function () {

      if (this.isCheck) {
        let data = this.qs.stringify({mobile: this.mobile})


        this.axios.post('/api/code', data).then(res => {

          console.log('asdfasd');
          let ret = res.data;
          if (ret.code == '200') {
            this.btnMsg = ret.msg
          } else {
            this.btnMsg = ret.msg
          }
        })


      }
    },
    login: function () {
      if (this.isCheck) {
        let data = this.qs.stringify({mobile: this.mobile, 'code': this.code})

        this.axios.post('/api/login', data).then(res => {
          let ret = res.data
          if (ret.code == 200) {
            localStorage.setItem('token', ret.token)

            let layerid = this.$layer.msg(ret.msg, () => {
              this.$router.push('/')
              this.$layer.close(layerid)
            })

          } else {
            let layerid = this.$layer.msg(ret.msg, () => {
              this.$layer.close(layerid)
            })
          }
        })


      }
    }
  },
  watch: {
    mobile: function () {

      let res = this.mobile.match(/^1(3|5|7|8|9)\d{9}$/)

      if (!res) {
        this.errInfo = "手机号码格式不正确"
        this.isCheck = false
      } else {
        this.isCheck = true
      }

    }
  }
}
</script>

<style scoped="scoped">
.clear {
  clear: both;
}


.mobile {
  margin-top: 15%;
  width: 80%;
  margin-left: 10%;
}

.mobile input {
  width: 100%;
  border: none;
  border-bottom: 1px solid #333333;
  height: 44px;
  outline: none;

}

.code {
  margin-top: 10%;
  width: 80%;
  margin-left: 10%;
}

.code div {
  float: left;
}

.code-text input {
  width: 100%;
  border: none;
  border-bottom: 1px solid #333333;
  height: 44px;
  outline: none;
}

.code button {
  height: 44px;
  background-color: #CC0000;
  color: #FFFFFF;
  border-style: none;
  border-radius: 15px;
  outline: none;
}

.sub {
  width: 80%;
  margin-left: 10%;
  margin-top: 20%;
}

.tip {
  width: 80%;
  margin-left: 10%;
  margin-top: 10%;
  color: red;
}

.sub button {
  width: 100%;
  height: 44px;
  border-radius: 20px;
  border-style: none;
  outline: none;
  background-image: linear-gradient(90deg, #fab3b3, #ffbcb3 73%, #ffcaba)

}
</style>
