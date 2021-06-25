<template>
	<div>
		<div class="addr-list">
			<ul>
				<li  v-for="(addr,index) in addrList" :key="index">
					<p>{{addr.name}}  {{addr.mobile}}</p>
					<span>{{addr.address}}</span>
					<button @click="delAddr(addr.id)">删除</button>
					<hr/>
				</li>

			</ul>
		</div>
		<div class="addr-but">
			<button @click="addAddr">添加收货地址</button>
		</div>
	</div>
</template>

<script>
	export default{
		created:function(){
			
			
			let token = localStorage.getItem('token')
			
			this.axios.get('/api/addr',{headers:{token:token}}).then(res=>{
				
				
				
				if(res.data.code==450){
					
					localStorage.setItem('token',res.data.token)
					this.axios.get('/api/addr',{headers:{token:res.data.token}}).then(res=>{
						if(res.data.code==200){
							this.addrList=res.data.data
						}
						
					})
					
				}else if(res.data.code==200){

					this.addrList=res.data.data
				}
				
				
				
			})
			
			
			
		},
		data:function(){
			return {
				addrList:[]
			}
		},
		methods:{
			addAddr:function(){
				this.$router.push('/user/addAddr')
			},
			
			
			
			delAddr:function(id){
				    let token = localStorage.getItem('token')
					let layid = this.$layer.confirm('确定删除？',()=>{
						this.$layer.close(layid)
						
						
						this.axios.delete('/api/addr/'+id,{headers:{token:token}}).then(res=>{
							
							
							if(res.data.code==450){
								localStorage.setItem('token',res.data.token)
								this.axios.delete('/api/addr/'+id,{headers:{token:res.data.token}}).then(res=>{
									if(res.data.code==200){
											let layerid = this.$layer.msg(res.data.msg,()=>{
												this.$layer.close(layerid)
												this.$router.go(0)
											})
									}
									
								})
								
							}else if(res.data.code==200){
									let layerid = this.$layer.msg(res.data.msg,()=>{
										this.$layer.close(layerid)
										this.$router.go(0)
									})
								
							}
							
							// let ret = {"status":"success","msg":"删除成功"}
							// if(ret.status=='success'){
							// 	let layerid = this.$layer.msg(ret.msg,()=>{
							// 		this.$layer.close(layerid)
							// 		this.$router.go(0)
							// 	})
							// }
							
							
						})
						
						
						
						
					})
					
					
					
					// this.axios.delete('http://192.168.1.3:3000/saveAddr/'+id).then(res=>{
					// 	let ret = {"status":"success","msg":"删除成功"}
					// 	if(ret.status=='success'){
					// 		alert(ret.msg)
					// 	}
					// })
					
			

				
			}
		}
	}
</script>

<style scoped="scoped">
	.addr-but button{
		width: 90%;
		margin-left: 5%;
		height: 14vw;
		background-color: #CC0000;
		color: #FFFFFF;
		border-radius: 7vw;
		outline: none;
		border-style: none;
		margin-top: 10vw;
	}
	
	.addr-list p{
		font-size: 5vw;
		font-weight: bold;
		padding: 2vw;
	}
	.addr-list span{
		padding: 2vw;
	}
	.addr-list button{
		background-color: #CC0000;
		color: #FFFFFF;
		border-style: none;
		outline: none;
		float: right;
	}
</style>
