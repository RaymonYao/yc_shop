<template>
	<div class="cat-right">
		<ul>
			
			<li @click="GoodsList(sub.id)" v-for="(sub,index) in subCats" :key="index">
				<img :src="domain+sub.cat_img" />
				<p>{{sub.cat_name}}</p>
			</li>
			
			
		</ul>
	</div>
</template>

<script>
	export default{
		created:function(){
			this.getCats(null)
			this.domain = process.env.VUE_APP_DOMAIN
		},
		
		beforeRouteUpdate:function(to,from,next){
			let id = to.query.id
			this.getCats(id)
			next()
		},
		data:function(){
			return {
				subCats:[],
				domain:''
			}
		},
		methods:{
			getCats:function(id){
				
				this.axios.get('/api/subcats/'+id).then(res=>{
					
					if(res.data.code==200){
						this.subCats = res.data.data
					}
				})
			},
			GoodsList:function(id){
				this.$router.push('/goodsList/'+id)
			}
		}
	}
</script>

<style>
	.cat-right{
		margin-left: 12%;
		
	}
	.cat-right img{
		width: 20vw
	}
	.cat-right li{
		float: left;
		padding: 2vw;
		text-align: center;
	}
	.cat-right p{
		padding: 2vw;
	}
</style>
