<script setup>
    import { useRouter } from 'vue-router';
    // const props = defineProps({
    //     post: {
    //         type: Object,
    //         required: true
    //     }
    // });

    const props = defineProps(["post"]);
    const post = props.post;
    console.log(typeof(post));
    const router = useRouter();

    const onFocus = () => {
        // router.push({ path: `/post/${ post.id }`, state: { postData: post }});
    }
</script>

<!--
    無限スクロールもVuetifyで実装できそうです
    https://vuetifyjs.com/ja/components/infinite-scroller/#section-4f7f304465b9 
-->

<template>
    <div>
        <!-- {{ post }} -->
        <v-card
            class="ma-5 my-2"
            elevation="2"
            @click="onFocus"
            :to="{ path: `/post/${ post.id }`, params: { id: post.id }}"
        >
        <!-- :to="{ path: `/post/${ post.id }`, query: { post: post.content }}" -->
        <!-- :to="{ path: `/post/${ post.id }`, params: { post: post }}" -->

            <!-- <router-link
                :to="{ path: `/post/${ post.id }`, params: { id: post.id }}"
            > -->
                <!-- 投稿 -->  
                <div>
                    <v-card-item>
                    <v-card-title>
                        Card title {{ post.id }}
                    </v-card-title>
        
                    <v-card-subtitle>
                        {{ post.userName }}さん
                    </v-card-subtitle>
                    </v-card-item>
                </div>           
    
                <v-card-text>
                    {{ post.content }}
                </v-card-text>
                <hr v-if="post.replies">
    
                <!-- 返信 -->
                <div v-for="rep in post.replies" :key="rep.id">
                    <v-card-item>
                    <v-card-title>
                        Reply title {{ rep.id }}
                    </v-card-title>
        
                    <v-card-subtitle>
                        {{ rep.userName }}さん
                    </v-card-subtitle>
                    </v-card-item>
        
                    <v-card-text>
                        {{ rep.content }}
                    </v-card-text>
                </div>
            <!-- </router-link> -->
        </v-card>
    </div>
</template>

<style>
</style>