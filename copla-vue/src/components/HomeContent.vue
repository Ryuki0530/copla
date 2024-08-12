<script setup>
    import { ref, onMounted } from "vue";
    import PostContent from './PostContent.vue';
    import axios from "axios";

    // 画面読み込み時
    onMounted(() => {
        // 投稿を取得
        getDatas();
    });

    // 投稿をaxiosで送ります
    // https://axios-http.com/ja/docs/example

    // Proxyとかでデータが受け取りたいです
    // username, content, titleとか

    const chatContent = ref("");
    const postId = ref(1);
    const repId = ref(1);

    // const postsImageData = ref([]);

    // データの取得はこんなイメージ?
    // 各投稿の中で返信を入れ子で持つ
    const postsImageData = ref([
        { id: postId.value++, userName: "Taro", content: "Hello1", replies: 
            [
                {id: repId.value++, userName: "Taro", content: "返信"}, 
                {id: repId.value++, userName: "Shimizu", content: "返信2"}
            ] 
        }
        ,{ id: postId.value++, userName: "Yumi", content: "Hello2" }
        ,{ id: postId.value++, userName: "Kimura", content: "Good Morning 3" }
    ]);

    const samplePost = ref({ id: postId.value++, userName: "Taro", content: "Hello1", replies: 
            [
                {id: repId.value++, userName: "Taro", content: "返信"}, 
                {id: repId.value++, userName: "Shimizu", content: "返信2"}
            ] 
        });

    const onSubmit = () => {
        if (chatContent.value !== "") {
            const post = {
                id: postId.value++,
                userName: "Taro Yamada",
                content: chatContent.value,
                replies: []
            }

            console.log(post);

            postsImageData.value.unshift(post);
            console.log(postsImageData);

            chatContent.value = "";
        }
        else {
            alert("Write something");
        }
    }

    // 投稿を取得
    // 画面読み込み時, 一定間隔, ソケットイベント検知などのタイミングで呼出
    const getDatas = () => {
        // 以下のURLに投稿取得リクエストをします
        axios.get("/get")
            .then((res) => {
                // 処理が成功した場合
                // postImageDataに入れてPostContentコンポーネントに渡します
            })
            .catch((err) => {
                console.error(err);
            });
    }
</script>

<template>
    <div>
        <div>
            あとで見た目は整えます
            <v-card
                class="ma-5 my-2"
                elevation="2"
            >
                <input type="text" v-model="chatContent" placeholder="投稿内容を入力">
                <v-btn @click="onSubmit">Post</v-btn>
            </v-card>
        </div>

        <router-link to="/articles">これはロード無しで飛べる</router-link><br>
        <router-link to="/post/1">これもいけるID 1　でも他のサイドバーが効かなくなる FocusPostでroute周りをコメントアウトしたら解消</router-link><br>
        <router-link :to="{ path: '/post/1', state: { post : samplePost}}">ID 1 OBJ リロードあり</router-link><br>
        <router-link :to="{ path: `/post/1`, query: { post: samplePost }}">ID 1 query</router-link>

        <div v-for="post in postsImageData" :key="post.id">
            <!-- Flagで投稿コンポーネントと記事コンポーネントを区別する? -->

            <!-- 投稿の場合 -->
            <PostContent
                :key="post.id"
                :post="post"
            />

            <!-- 記事の場合 -->
        </div>
    </div>
</template>

<style>
</style>