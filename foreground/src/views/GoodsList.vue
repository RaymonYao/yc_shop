<template>
	<div>
		<Header>商品列表</Header>
		<div class="clear"></div>
		
		<div class="goods-list">
			<ul>

				<li @click="goodsDetail(goods.id)" v-for="(goods,index) in goodsList" :key="index" >
					<div class="goods-left">
						<img :src="domain+goods.goods_img">
					</div>
					<div class="goods-right">
						<p>{{goods.goods_name}}</p>
						<div> ¥ {{goods.goods_price}}</div>
					</div>
				</li>
				
				
			</ul>
		</div>
	</div>
</template>

<script>
	import Header from '../components/Header.vue'
	export default{
		created:function(){
			this.domain = process.env.VUE_APP_DOMAIN
			let cat_id = this.$route.params.id;
			
			this.axios.get('/api/cat_goods/'+cat_id).then(res=>{
				this.goodsList = res.data.data
				
			})
			
			
		},
		components:{
			Header
		},
		data:function(){
			return {
				goodsList:[],
				domain:''
			}
		},
		methods:{
			goodsDetail:function(id){
				this.$router.push('/goodsDetail/'+id)
			}
		}
		
	}
</script>

<style scoped="scoped">
	.clear{
		clear: both;
	}
	.goods-list{
		position: relative;
	}
	.goods-left img{
		width: 25vw;
		position: absolute;
		padding: 2vw;
	}
	.goods-list li{
		height: 16vh;
	}
	.goods-right{
		margin-left: 27vw;
		padding: 2vw;
	}
	.goods-right p{

		margin-top: 8px;
		color: #333;
		line-height: 1.36;
		overflow: hidden;
		text-overflow: ellipsis;

		height: 19px;
		font-size: 16px;
		font-weight: bold;
	}
	
	.goods-right div{
		color: #e93b3d;
		font-size: 20px;
		font-weight: bold;
		padding-top: 3vw;
	}
</style>
