<script setup>
    import { computed, ref, onMounted } from "vue";
    import { useRoute } from "vue-router";
    import { mdiHeartOutline } from "@mdi/js";

    const route = useRoute();

    // クエリに渡されたidの値を取得
    console.log(route.params.id + "の投稿を抽出");

    const post = ref(null);
    const isLoading = ref(false);

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
        post.value = { id: 1, userName: "Taro", content: "Hello1\nこんにちは", replies: 
            [
                {id: 1, userName: "Taro", content: "返信"}, 
                {id: 2, userName: "Shimizu", content: "返信2"}
            ] 
        };

        isLoading.value = true;
    })

    console.log(post);

    const testFlag = ref(true);
</script>

<template>
    <!-- 
        冗長的です...
        本来はPostContentからこのコンポーネントに該当する投稿をオブジェクトで
        渡したかったのですが、上手くできなかったのでとりあえず投稿のidだけ
        渡して、再度そのデータを取得する形になるかもしれません
    -->
    <div>
        <h1>ID = {{ route.params.id }} の投稿と返信抽出イメージ</h1>

        <!-- {{ post.replies }} -->
        <v-card
            class="ma-5 my-2"
            elevation="2"
            v-if="post"
        >
            <div>
                <v-card-item>
                    <!-- ユーザのカラーコードまたはアイコン画像パスとか -->
                    <div class="flex">
                        <p class="icon" :style="{  }"></p>
                        <v-card-title>
                            <!-- Card title {{ post.id }} -->
                        </v-card-title>
            
                        <v-card-subtitle class="mt-2 font-weight-bold">
                            <!-- {{ post.userName }}さん -->
                        </v-card-subtitle>
                        <p class="mt-2 font-weight-bold">
                            {{ post.userName }}さん
                        </p>
                        <p class="mt-2 ml-2 sub-info">
                            M-D h:m
                        </p>
                    </div>
                </v-card-item>

                <v-card-item class="pt-0">
                    <v-card-text class="pt-0" style="white-space: pre-wrap;">
                        {{ post.content }}
                    </v-card-text>
                </v-card-item>

                <v-card-item class="pt-0">
                    <div class="ml-3 flex">
                        <v-icon size="20" @click.stop="" color="red" class="on-good rounded-circle">{{ mdiHeartOutline }}</v-icon>
                        <p>5</p>
                    </div>
                </v-card-item>

                <v-card-item>
                    <div class="flex">
                        <v-textarea 
                            placeholder="返信"
                            rows="1"
                            auto-grow
                            class="ml-2"
                        ></v-textarea>
                        <v-btn @click.stop="" class="rounded-xl ml-2" color="blue">Reply</v-btn>
                    </div>
                </v-card-item>
            </div>           

            <hr v-if="post.replies">

            <!-- 返信 -->
            <div v-for="(rep) in post.replies" :key="rep.id">
                <v-card-item>
                    <div class="flex">
                        <p class="icon" :style="{  }"></p>
                        <p class="mt-2 font-weight-bold">
                            {{ rep.userName }}さん
                        </p>
                        <p class="mt-2 ml-2 sub-info">
                            M-D h:m
                        </p>
                    </div>
                </v-card-item>
    
                <v-card-item class="pt-0">
                    <v-card-text class="pt-0" style="white-space: pre-wrap;">
                        {{ rep.content }}
                    </v-card-text>
                </v-card-item>

                <v-card-item class="pt-0">
                    <div class="ml-3 flex">
                        <v-icon size="20" @click.stop="" color="red" class="on-good rounded-circle">{{ mdiHeartOutline }}</v-icon>
                        <p>5</p>
                    </div>
                </v-card-item>
            </div>
        </v-card>
    </div>
</template>

<style scoped>
.flex {
    display: flex;
}

.on-good:hover {
    background-color: rgb(249, 181, 181);
}

.icon {
  width: 35px;
  height: 35px;
  border-radius: 50%;
  margin: 10px;
  flex-shrink: 0;
  background: #ff8888;
}

.sub-info {
    color: rgb(161, 161, 161);
}
</style>