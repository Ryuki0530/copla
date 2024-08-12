<script setup>
    import { computed, ref, onMounted } from "vue";
    import { useRoute } from "vue-router";

    const route = useRoute();
    console.log(route.params.id + "の投稿を抽出");
    const post = ref(null);

    // const post = route.state.post;
    // console.log("GET state post");
    // console.log(post);

    // const props = defineProps(["post"]);

    // 本来はリンクに投稿オブジェクトを渡したかったけど
    // 上手くできなかったから...再度投稿取得をリクエスト
    onMounted(() => {
        const id = route.params.id;

        // axiosでそのidの投稿と返信を取得
        
        // イメージ
        post.value = { id: 1, userName: "Taro", content: "Hello1", replies: 
            [
                {id: 1, userName: "Taro", content: "返信"}, 
                {id: 2, userName: "Shimizu", content: "返信2"}
            ] 
        };
    })

    console.log(post);

    const testFlag = ref(true);
</script>

<template>
    <div>
        <h1>HELLO</h1>
        <!-- {{ post.replies }} -->
        <v-card
            class="ma-5 my-2"
            elevation="2"
            v-if="post"
        >
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
        </v-card>
    </div>
</template>

<style>
</style>