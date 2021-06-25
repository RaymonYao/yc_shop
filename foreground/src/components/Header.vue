<template>
	<div class="login-header">
		<div class="login-pre" > 
			<img @click="goBack" src="../assets/img/icon/login-pre.png">
		</div>
		<div class="login-title"> 
			<span><slot></slot></span>
		</div>		
	</div>
</template>

<script>
	export default{
		methods:{
			goBack:function(){
				this.$router.back()
			},
		}
	}
</script>

<style>
	.login-header div{
		float: left;
		text-align: center;
		height: 44px;
	}
	
	.login-pre{
		width: 20%;
	}
	
	.login-title{
		width: 60%;
		height: 44px;
		line-height: 44px;
		font-size: 18px;
		font-weight: bold;
	}
</style>
