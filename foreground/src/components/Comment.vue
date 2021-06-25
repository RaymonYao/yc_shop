<template>
	<div class="comment">
		<div v-if="!isComment">
			<textarea rows="5" cols="30" v-model="content"></textarea><br/>
			<button @click="saveComment">提交评价</button>
		</div>
		<div v-else>
			<p>评价成功</p>
		</div>
	</div>
</template>

<script>
	export default{
		props:['order'],
		created:function(){
			this.id = this.order
			
		},
		data:function(){
			return {
				id:'',
				content:'',
				isComment:false
			}
		},
		methods:{
			saveComment:function(){
				
			
				let data = this.qs.stringify({content:this.content,order_id:this.id})
				
				// this.axios.post(process.env.VUE_APP_HOST+'/comments',data).then(res=>{
				// 	let ret = {status:'success',msg:'评价成功'}
				// 	if(ret.status=='success'){
				// 		this.isComment=true
				// 	}
				// })
				
				
				
				let token = localStorage.getItem('token')
				
				this.axios.post('/api/comment',data,{headers:{token:token}}).then(res=>{
				
					if(res.data.code==450){
						localStorage.setItem('token',res.data.token)
						this.axios.post('/api/comment',data,{headers:{token:res.data.token}}).then(res=>{
							
							if(res.data.code==200){
								this.isComment=true
							}
							
						})
					}else if(res.data.code==200){
						this.isComment=true
						
					}
					
					
				})
				
				
				
				
			}
		}
	}
</script>

<style scoped="scoped">
	.comment{
		margin: 5vh auto;
	}
	
	.comment button{
		float: right;
		height: 30px;
		background-color: #CC0000;
		color: #FFFFFF;
		border-radius: 10px;
		border-style: none;
		outline: none;
		margin-top: 5vh;
		width: 100%;
	}
	
	.comment p{
		font-size: 20px;
		color: #00C250;
		font-weight: bold;
	}
	
</style>
