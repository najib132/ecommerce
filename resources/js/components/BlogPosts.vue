<template>
	
  
  
  
   <div class="blog-section">
   	<div class="container">
	 <h1 class="text-center">From Our Blog d1</h1>
	  <p class="section-description">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>


	   <div class="blog-posts">
        <div v-for="post in posts" :key="post.id" class="blog-post">
        <!--<a :href="post.link"><img src="/img/posts/post1.jpg" alt="Blog Image"></a> -->
        	<a :href="post.link">
        	  <blog-image 
               :url="post._links['wp:featuredmedia'][0].href">
        	   </blog-image>
        	</a>
        	<a :href="post.link"><h2 class="blog-title">{{ post.title.rendered }}</h2></a>
            <div class="blog-description">{{ stripTags(post.excerpt.rendered) }}</div>
        </div>
      </div>

  </div>
</div>

</template>
<script>
	import BlogImage from './BlogImage'
	import sanitizeHtml from 'sanitize-html'

	export default {
          components: {
               BlogImage,
                         },

		created() {
        axios.get('https://blog.laravelecommerceexample.ca/wp-json/wp/v2/posts?per_page=3')
            .then(response => {
                this.posts = response.data
               //console.log(response);
            })
    },
    data() {
        return {
            posts: []
        }
    },
    methods: {
        stripTags(html) {
            return sanitizeHtml(html, {
                allowedTags: []
            }).substring(0, html.indexOf('&hellip;'))
        }
    }
	}
</script>
