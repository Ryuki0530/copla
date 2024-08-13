<script setup>
    import { ref } from "vue";
    import { useRouter } from 'vue-router';
    import { 
            mdiChatOutline,
            mdiHeartOutline
            } from "@mdi/js";
    // const props = defineProps({
    //     post: {
    //         type: Object,
    //         required: true
    //     }
    // });

    // propsを取得します
    // postという名前で渡されたので、それを指定しています
    const props = defineProps(["post"]);

    const post = props.post;
    console.log(typeof(post));

    const router = useRouter();

    const dispNum = ref(1);

    const openReplies = (rep) => {
        console.log(rep.length);
        dispNum.value = rep.length;
    }

    // シングルポストのページに遷移
    const onFocus = () => {
        // router.push({ path: `/post/${ post.id }`, state: { postData: post }});
        router.push({ path: `/post/${ post.id }`, params: { id: post.id }});
    }

    // textareaでEnterが押された時の処理
    // (他の動作と干渉しないように用意しただけです)
    const handleEnterKey = (event) => {
        event.target.value += "\n";
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
            class="ma-5 my-5"
            elevation="2"
            @click.stop="onFocus"
            v-ripple.stop
            :ripple="false"
        >
            <!-- 通常投稿 記事とはデザインを変える? タイトル有無とか -->  
            <div>
                <!-- ユーザ情報 -->
                <v-card-item>
                    <!-- ユーザのカラーコードまたはアイコン画像パスとか -->
                    <div class="flex">
                        <p class="icon" :style="{  }"></p>
                        <p class="mt-2 font-weight-bold">
                            {{ post.userName }}さん
                        </p>
                        <p class="mt-2 ml-2 sub-info">
                            M-D h:m
                        </p>
                        <p class="mt-2 ml-auto sub-info">ジャンル</p>
                    </div>
                </v-card-item>

                <!-- 投稿本文 -->
                <v-card-item class="pt-0">
                    <v-card-text class="pt-0" style="white-space: pre-wrap;">
                        {{ post.content }}
                    </v-card-text>
                </v-card-item>

                <!-- リアクション いいねとか -->
                <v-card-item class="pt-0">
                    <div class="ml-3 flex">
                        <v-icon size="20" @click.stop="" :ripple="false" color="red" class="on-good rounded-circle">{{ mdiHeartOutline }}</v-icon>
                        <p>5</p>
                    </div>
                </v-card-item>

                <!-- 返信フォーム -->
                <v-card-item>
                    <div class="flex">
                        <v-textarea 
                            placeholder="返信"
                            @click.stop="" 
                            @keydown.enter.stop.prevent="handleEnterKey"
                            rows="1"
                            auto-grow
                            class="ml-2"
                        ></v-textarea>
                        <v-btn @click.stop="" class="rounded-xl ml-2" color="blue">Reply</v-btn>
                    </div>
                </v-card-item>
            </div>           

            <!-- 
                v-ifは条件を満たすときだけ表示します 
                falseの時はブラウザから要素ごと削除します
                cssでdisplay:noneで非表示を使う場合は、開発者ツールで見えてしまいますが
                v-ifは要素が無いので見えません
            -->
            <hr v-if="post.replies">

            <!-- 返信 -->
            <div v-for="(rep, index) in post.replies" :key="rep.id">
                <!-- 
                    表示件数を指定します
                    初期値は1件で
                    「さらに表示」を押すと、全て表示します
                -->
                <div v-if="index < dispNum">
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
            </div>

            <hr v-if="dispNum <= 1 && post.replies">
            <!-- .stopで親カードのonFocusを作動させずに返信を開ける -->
            <p link v-if="dispNum <= 1 && post.replies" @click.stop="openReplies(post.replies)" class="top-layer mouse">さらに{{ post.replies.length - 1 }}件の返信</p>
        </v-card>
    </div>
</template>

<style scoped>
.mouse:hover {
    background-color: rgb(238, 255, 162);
}

.on-good:hover {
    background-color: rgb(249, 181, 181);
}

.good-icon {
    width: 30px;
    height: 30px;
    background-color: rgb(249, 181, 181);
}

.over {
    z-index: 10;
}

textarea {
    width: 100%;
    margin: 0px 5px;
}

.flex {
    display: flex;
}

.rep-area {
    margin: 2px 0px 10px 0px;
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