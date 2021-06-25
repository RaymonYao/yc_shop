<template>
	<div>
		<Header>商品详情</Header>
		<div class="clear"></div>
		
		
		<div class="goods-main">
			<div class="goods-info">
				<div>
					<img :src="domain+goods_detail.goods_img">
				</div>
				<div class="goods-price">
					¥ {{goods_detail.goods_price}}
				</div>
				<div class="goods-name">
					<h1>{{goods_detail.goods_name}}</h1>
				</div>
				
			</div>

			<div class="comments">
				<p class="tit">评价</p>
				<ul>
					<li v-for="(comm,index) in comments" :key="index">
						<div> <em>{{doMobile(comm.mobile)}}</em>  <span>{{comm.create_time}}</span></div>
						<p>{{comm.content}}</p>
					</li>
					
				</ul>
			</div>
			
			<div class="goods-introduce">
				<p class="tit">商品介绍</p>
				<div v-html="goods_detail.goods_introduce">
					
				</div>
				
			</div>
		</div>
		
		<div class="goods-footer">
			<div>
				<span @click="toCart"> <span v-show="cart_num" class="cart-num">{{cart_num}}</span><img src="../assets/img/icon/cart.png"></span>
				<span @click="addCart(goods_detail)" class="add-cart"><button>加入购物车</button></span>
				<span @click="toBuy(goods_detail.id)" class="to-buy"><button>立即购买</button></span>
			</div>
		</div>
		
	</div>
</template>

<script>
	
	import Header from '../components/Header.vue'
	export default{
		created:function(){
			
			let id = this.$route.params.id
			this.domain = process.env.VUE_APP_DOMAIN

			this.axios.get('/api/comment/'+id).then(res=>{
				this.comments = res.data.data
			})

			this.axios.get('/api/goods/'+id).then(res=>{
				this.goods_detail = res.data.data
			})
			
			
			this.cart_num = JSON.parse(localStorage.getItem('cartList')).length
		},
		components:{
			Header
		},
		data:function(){
			return {
				comments:[],
				goods_detail:'',
				cart_num:0,
				domain:''
			}
		},
		methods:{
			doMobile:function(mobile){
				let str = mobile.slice(3,7)
				return mobile.replace(str,'****')
			},
			addCart:function(goods){
				if(!localStorage.getItem('token')){
					this.$router.push('/login')
				}
				
				//cartList = [
					//{}
					//{}
					//{}
			    //]
				let cartGoods = {"checked":"true","id":goods.id,"goods_name":goods.goods_name,"goods_img":goods.goods_img,"goods_price":goods.goods_price,"num":1}
				
				var cart = localStorage.getItem('cartList')
				
				if(cart){
					cart = JSON.parse(cart)
				//判断  当购物车里 已经有这个商品  num+1  如果没有 push
				
					var ret = this.inArray(cart,cartGoods);
						
					if(ret.status){
						cart[ret.index].num +=1;
					}else{
						cart.push(cartGoods)
					}
					
					
				}else{
					var  cart = []
					cart.push(cartGoods)

				}
				
				this.cart_num  = cart.length
				
				cartGoods = JSON.stringify(cart)
				localStorage.setItem('cartList',cartGoods)
			},
			
			inArray:function(cart,cartGoods){
				for(let i=0;i<cart.length;i++){
					if(cart[i].id==cartGoods.id){
						return {"status":true,index:i}
					}
				}
				
				return {"status":false}
			},
			
			toCart:function(){
				this.$router.push('/cart')
			},
			
			
			
			
			toBuy:function(id){
				
				let goodsList = new Array;
				let goods = {goods_id:this.goods_detail.id,goods_price:this.goods_detail.goods_price,num:1};
				goodsList.push(goods)
				
				
				let data = this.qs.stringify(goodsList);
				let token = localStorage.getItem('token')
				this.axios.post('/api/order',data,{headers:{token:token}}).then(res=>{
					
					if(res.data.code==450){
						localStorage.setItem('token',res.data.token)
						this.axios.post('/api/order',data,{headers:{token:res.data.token}}).then(res=>{
							if(res.data.code==200){
								localStorage.setItem('orderId',JSON.stringify(res.data.data))
								this.$router.push({'path':'/toPay','query':{'id':id}})
							}else if(res.data.code==460){
								this.$router.push('/user/addr')
							}
							
						})
						
					}else if(res.data.code==200){
						localStorage.setItem('orderId',JSON.stringify(res.data.data))
						this.$router.push({'path':'/toPay','query':{'id':id}})
					}else if(res.data.code==460){
						this.$router.push('/user/addr')
					}
					
					
				})
				
				
				
				
				
				
			},
			
			
			
		}
	}
	
</script>

<style scoped="scoped">
	.clear{
		clear: both;
	}
	.goods-main{
		background-color: #F0F0F0;
	}
	.goods-info{
		background-color: #FFFFFF;
	}
	.goods-info img{
		width: 100vw;
	}
	.goods-price{
		font-family: JDZH-Regular;
		font-size: 25px;
		line-height: 30px;
		color: #f2270c;
		padding:3vw ;
		font-weight: bold;
	}
	.goods-name{
		padding: 3vw;
		font-size: 10px;
		font-weight: bold;
	}
	
	.comments{
		background-color: #FFFFFF;
		margin-top: 3vw;
		border-radius: 2vw;
	}
	
	.comments li{
		border-top: 1px solid #F0F0F0;
	}
	
	.tit{
		color: #262626;
		font-weight: 700;
		padding: 3vw;
	}
	.comments div{
		margin: 3vw;
	}
	.comments div span{
		float: right;
		color: #999;
	}
	.comments li p{
		padding: 3vw;
	}
	
	.goods-introduce{
		background-color: #FFFFFF;
		border-radius: 2vw;
		margin-top: 2vw;
		
	}
	
	.goods-introduce img{
		width: 100%;
	}
	.goods-footer{
		position: fixed;
		bottom: 0;
		height: 44px;
		background-color: #FFFFFF;
		width: 100%;
		
	}
	.add-cart button{
		background-image: linear-gradient(135deg,#f2140c,#f2270c 70%,#f24d0c);
		height: 35px;
		border-radius: 20px;
		outline: none;
		color: #FFFFFF;
		border-style: none;
		font-size: 14px;
		margin-left: 2%;
	}
	.to-buy button{
		height: 35px;
		border-radius: 20px;
		outline: none;
		color: #FFFFFF;
		border-style: none;
		background-image: linear-gradient(135deg,#ffba0d,#ffc30d 69%,#ffcf0d);
		font-size: 14px;
		margin-left: 2%;
	}
	.goods-footer img{
		width: 10vw;
	}
	.goods-footer div{
		margin-left: 40%;
		line-height: 44px;
	}
	
	.cart-num{
		position: absolute;
		top: 0;
		left: 40%;
		display: inline-block;
		background: #fff;
		color: #e4393c;
		font-size: 7px;
		margin-left: -10px;
		line-height: 9px;
		border: 1px solid #e4393c;
		border-radius: 10px;
		padding: 1px 3px;
		font-weight: 700;
	}
</style>
