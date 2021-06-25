<template>
	<div>
		<Header>商品分类</Header>
		<div class="clear"></div>
		<div class="cat-left">
			<ul>
				<router-link  v-for="(cat,index) in cats" 
				:key="index"  tag="li" :to="{path:'/cat/subCat',query:{id:cat.id}}" >
					{{cat.cat_name}} 
				</router-link>
			</ul>
		</div>
		
		<div >
			<router-view></router-view>
		</div>
	</div>
</template>

<script>
	import Header from '../components/Header.vue'
	export default{
		created:function(){
			this.axios.get('/api/cats').then(res=>{
				
				if(res.data.code==200){
					this.cats = res.data.data
				}
			})
		},
		components:{
			Header
		},
		data:function(){
			return {
				cats:[]
			}
		}
	}
</script>

<style>
	.clear{
		clear: both;
	}
	
	.router-link-exact-active{
		color: #CC0000;
	}
	
	.cat-left{
		width: 20%;
		background-color: #F0F0F0;
		height: 80vh;
		float: left;
	}
	.cat-left li{
		height: 5vh;
		line-height: 5vh;
		text-align: center;
		font-size: 14px;
	}
</style>
