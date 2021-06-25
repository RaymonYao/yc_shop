<template>
  <div class="express">
    <ul>
      <li v-for="(ex,index) in express" :key="index">
        {{ ex.datetime }} {{ ex.remark }}
      </li>
    </ul>
  </div>
</template>

<script>
export default {

  props: ['order'],
  created: function () {
    this.id = this.order


    let token = localStorage.getItem('token')

    this.axios.get('/api/express/' + this.id, {headers: {token: token}}).then(res => {

      if (res.data.code == 450) {
        localStorage.setItem('token', res.data.token)
        this.axios.get('/api/express/' + this.id, {headers: {token: res.data.token}}).then(res => {
          if (res.data.code == 200) {
            this.express = res.data.data

          }
        })
      } else if (res.data.code == 200) {
        this.express = res.data.data

      }


    })


    // this.axios.get(process.env.VUE_APP_HOST+'/express').then(res=>{

    // 	if(res.data.resultcode==200){
    // 		this.express = res.data.result.list
    // 	}


    // })


  },
  data: function () {
    return {
      id: '',
      express: ''
    }
  }
}
</script>

<style scoped="scoped">
.express li {
  height: 3vh;
  padding: 2vw;
  border-bottom: 1px solid #F0F0F0;
}
</style>
