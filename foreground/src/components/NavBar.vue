<template>
	<div class="index-nav">
		<ul>
			<router-link tag="li" to="/"> 
				<img src="../assets/img/icon/icon-index.png">
			</router-link>
			<router-link active-class="active" tag="li" to="/cat">
				<img src="../assets/img/icon/icon-cat.png">
			</router-link>
			<router-link tag="li" to="/cart">
				<img src="../assets/img/icon/icon-cart.png">
			</router-link>
			<router-link active-class="active" tag="li" to="/user">
				<img src="../assets/img/icon/icon-user.png">
			</router-link>
		</ul>
	</div>
</template>

<script>
</script>

<style scoped="scoped">
	.router-link-exact-active,.active{
		background-color: #f2270c !important;
	}
	.index-nav{
		width: 100%;
		text-align: center;
		bottom: 0;
		position: fixed;
	}
	.index-nav li{
		float: left;
		width: 25%;
		background-color: #FFFFFF;
	}
	.index-nav li img{
		width: 25vw;
	}
</style>
