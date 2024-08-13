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
        { id: postId.value++, userName: "Taro", content: "Hello1\nこんにちは", replies: 
            [
                {id: repId.value++, userName: "Taro", content: "返信"}, 
                {id: repId.value++, userName: "Shimizu", content: "返信2"},
                {id: repId.value++, userName: "Kakimura", content: "返信3"}
            ] 
        },
        { id: postId.value++, userName: "Yumi", content: "Hello2", replies:
            [
                {id: repId.value++, userName: "Tomita", content: "返信1"},
                {id: repId.value++, userName: "Sasaki", content: "返信2"}
            ]
         },
        { id: postId.value++, userName: "Kimura", content: "Good Morning 3" },

        { id: postId.value++, userName: "Taro", content: "Hello1", replies: 
            [
                {id: repId.value++, userName: "Taro", content: "返信"}, 
                {id: repId.value++, userName: "Shimizu", content: "返信2"},
                {id: repId.value++, userName: "Kakimura", content: "返信3"}
            ] 
        },
        { id: postId.value++, userName: "Taro", content: "Hello1", replies: 
            [
                {id: repId.value++, userName: "Taro", content: "返信"}, 
                {id: repId.value++, userName: "Shimizu", content: "返信2"},
                {id: repId.value++, userName: "Kakimura", content: "返信3"}
            ] 
        },
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
                replies: null
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

    const onSearch = (word) => {
        console.log(`${ word }の投稿を表示`);

        // axiosでリクエスト送る?
    }

</script>

<template>
    <div>
        <div>
            あとで見た目は整えます。とりあえず架空のD大学(D University)にしておきます
            <v-card
                class="ma-5 my-2"
                elevation="2"
            >
                <input type="text" v-model="chatContent" placeholder="検索" class="input">
            </v-card>

            <div class="trend flex ml-5 mt-3 mb-3">
                <h4>今のトレンド</h4>
                <p class="ml-5 tag">#研究室</p>
                <p class="ml-5 tag">#ランチ</p>
                <p class="ml-5 tag">#期末</p>
            </div>

            <v-card>
                <v-tabs
                    bg-color="deep-purple-darken-4"
                    center-active
                >
                <v-tab @click="onSearch('ALL')">ALL</v-tab>
                <v-tab @click="onSearch('授業')">授業</v-tab>
                <v-tab @click="onSearch('サークル')">サークル</v-tab>
                <v-tab @click="onSearch('研究室')">研究室</v-tab>
                <v-tab @click="onSearch('就活')">就活</v-tab>
                <v-tab @click="onSearch('その他')">その他</v-tab>
                <v-tab @click="onSearch('イベント')">イベント</v-tab>
                <v-tab @click="onSearch('記事')">記事</v-tab>
                </v-tabs>
            </v-card>
        </div>

        <!-- <router-link to="/articles">これはロード無しで飛べる</router-link><br>
        <router-link to="/post/1">これもいけるID 1　でも他のサイドバーが効かなくなる FocusPostでroute周りをコメントアウトしたら解消</router-link><br>
        <router-link :to="{ path: '/post/1', state: { post : samplePost}}">ID 1 OBJ リロードあり</router-link><br>
        <router-link :to="{ path: `/post/1`, query: { post: samplePost }}">ID 1 query</router-link> -->

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

<style scoped>
.flex {
    display: flex;
}

input {
    width: 100%;
}

.tag {
    color: blue;
    cursor: pointer;
}
</style>