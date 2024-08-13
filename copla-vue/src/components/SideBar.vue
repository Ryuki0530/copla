<script setup>
    import { 
            mdiHome
            ,mdiPencilOutline
            ,mdiAlertDecagramOutline
            ,mdiFileDocumentEditOutline
            ,mdiAccountSchoolOutline
            ,mdiCogOutline
            ,mdiLogin
            ,mdiLogout
            ,mdiExitRun
            ,mdiSilverwareForkKnife
            ,mdiBusClock
            } from '@mdi/js';

    import { ref, computed, onMounted, watch, inject } from 'vue';
    import { RouterLink, RouterView } from 'vue-router'
    import { useDisplay } from 'vuetify/lib/framework.mjs';
    
    const loginFlag = ref(true);

    // 画面サイズを監視
    // const device = inject("device");

    // PC画面の半分以下か判定
    const isLessHalf = inject("isLessHalf");
    // スマホ画面か判定
    const isMobile = inject("isMobile");

    const postFormFlag = ref(false);
    const postDialog = ref(false);

    const chatContent = ref("");

    // ログイン処理
    const onLogin = () => {
        loginFlag.value = !loginFlag.value;

        // isMobile.value = device.xs.value;
        // isLessHalf.value = device.smAndDown.value;
    }

    // リロード時に実行
    onMounted(() => {
        // console.log(device);
    })

    // 画面サイズ監視
    // watch(device.name, () => {
    //     isMobile.value = device.xs.value;
    //     isLessHalf.value = device.smAndDown.value;

    //     console.log("isMobile : " + isMobile.value + "Half : " + isLessHalf.value);
    // })

    const onPostForm = () => {
        console.log("open post form");
        postFormFlag.value = true;
    }

</script>

<template>
    <div class="back-body">
        <!-- PC版 -->
        <!-- PC画面の半分以下, タブレットなら左部でたたむ -->
        <v-navigation-drawer 
            :width="300" 
            :rail="isLessHalf"
            rail-width="100"
            permanent
            v-if="!isMobile"
        >
            <v-list>
                <v-list-item title="">
                <!-- <v-icon :icon="mdiAccount"></v-icon> -->
                <!-- 
                    to属性で移動するURLを指定します, 
                    router/index.jsでルーティング処理されて必要なコンポーネントが
                    App.vueの<RouterView />に挿入されます
                -->
                    <RouterLink to="/">
                        <div class="flex mouse topLogo">
                            <img src="../assets/logo.png" alt="">
                            <v-list-item title="Copla" subtitle="for all students at DU">
                                <!-- <img src="../assets/logo.png"> -->
                            </v-list-item>
                        </div>
                    </RouterLink>

                    <v-divider></v-divider>

                    <v-list-item link to="/" class="rounded-xl">
                        <div class="flex">
                            <v-icon size="40">{{ mdiHome }}</v-icon>
                            <p class="ml-5 v-center flex" v-if="!isLessHalf">ホーム</p>
                        </div>
                    </v-list-item>

                    <v-list-item link to="" class="rounded-xl" @click="postDialog = true">
                        <div class="flex">
                            <v-icon size="40">{{ mdiPencilOutline }}</v-icon>
                            <p class="ml-5 v-center flex" v-if="!isLessHalf">投稿</p>
                        </div>
                    </v-list-item>

                    <v-list-item link to="/event" class="rounded-xl">
                        <div class="flex">
                            <!-- <v-icon size="40">{{ mdiAlertDecagramOutline }}</v-icon>
                            <p class="ml-5 v-center flex" v-if="!isLessHalf">Event</p> -->
                            <v-icon size="40">{{ mdiSilverwareForkKnife }}</v-icon>
                            <p class="ml-5 v-center flex" v-if="!isLessHalf">学食</p>
                        </div>
                    </v-list-item>

                    <v-list-item link to="/bus" class="rounded-xl">
                        <div class="flex">
                            <!-- <v-icon size="40">{{ mdiAlertDecagramOutline }}</v-icon>
                            <p class="ml-5 v-center flex" v-if="!isLessHalf">Event</p> -->
                            <v-icon size="40">{{ mdiBusClock }}</v-icon>
                            <p class="ml-5 v-center flex" v-if="!isLessHalf">D大バス</p>
                        </div>
                    </v-list-item>

                    <v-list-item link to="/articles" class="rounded-xl">
                        <div class="flex">
                            <v-icon size="40">{{ mdiFileDocumentEditOutline }}</v-icon>
                            <p class="ml-5 v-center flex" v-if="!isLessHalf">記事</p>
                        </div>
                    </v-list-item>

                    <v-list-item link to="/mypage" class="rounded-xl">
                        <div class="flex">
                            <v-icon size="40">{{ mdiAccountSchoolOutline }}</v-icon>
                            <p class="ml-5 v-center flex" v-if="!isLessHalf">マイページ</p>
                        </div>
                    </v-list-item>

                    <v-list-item link to="settings" class="rounded-xl">
                        <div class="flex">
                            <v-icon size="40">{{ mdiCogOutline }}</v-icon>
                            <p class="ml-5 v-center flex" v-if="!isLessHalf">設定</p>
                        </div>
                    </v-list-item>

                    <v-list-item link to="" class="rounded-xl" @click="onLogin">
                        <div class="flex">
                            <v-icon size="40">{{ loginFlag ? mdiLogin : mdiLogout }}</v-icon>
                            <p class="ml-5 v-center flex" v-if="!isLessHalf">{{ loginFlag ? "ログイン" : "ログアウト" }}</p>
                        </div>
                    </v-list-item>
                </v-list-item>
            </v-list>
        </v-navigation-drawer>

        <!-- ブラウザでオーバレイで包まれるクラスにpost-formを適用したい -->
        <!-- <div class="text-center pa-4" :width="300" style="position: fixed;">

        </div> -->

        <v-dialog
            v-model="postDialog"
        >
            <div class="flex" style="justify-content: center;">
                <v-card
                    max-width="800px"
                    class="w-100p"
                >
                    <!-- focusでダイアログ開いたらフォームにカーソル当てた方がいいかも -->
                    <v-card-text>
                        <v-textarea variant="outlined" placeholder="投稿内容" class="area" v-model.trim="chatContent"></v-textarea>
                    </v-card-text>

                    <div class="flex end pa-4">
                        <v-btn
                            text="閉じる"
                            @click="postDialog = false"
                        ></v-btn>
    
                        <v-btn
                            text="送信"
                            @click="postDialog = false; "
                            class="ml-5"
                        ></v-btn>
                        <!-- @click="onPost(); postDialog = false; " -->
                    </div>
                </v-card>
            </div>
        </v-dialog>

        <!-- スマホ版 -->
        <!-- アイコンは多くて6つまで! -->
        <!-- <v-app-bar height="40" v-if="isMobile">
            <v-list-item link to="mypage" title="" class="pa-0 ma-1 rounded-circle">
                <v-icon size="40">{{ mdiAccountSchoolOutline }}</v-icon>
            </v-list-item>
            Copla for all students at DU
        </v-app-bar> -->
        <v-bottom-navigation
            v-if="isMobile"
            :height="50"
        >
            <div class="flex phoneMenu">
                <v-list-item link to="/" title="" class="pa-0 ma-1 rounded-circle">
                    <v-icon size="40">{{ mdiHome }}</v-icon>
                </v-list-item>

                <v-list-item link to="" title="" class="pa-0 ma-1 rounded-circle" @click="postDialog = true">
                    <v-icon size="40">{{ mdiPencilOutline }}</v-icon>
                </v-list-item>

                <v-list-item link to="/event" title="" class="pa-0 ma-1 rounded-circle">
                    <!-- <v-icon size="40">{{ mdiAlertDecagramOutline }}</v-icon> -->
                    <v-icon size="40">{{ mdiSilverwareForkKnife }}</v-icon>
                </v-list-item>

                <v-list-item link to="/articles" title="" class="pa-0 ma-1 rounded-circle">
                    <v-icon size="40">{{ mdiFileDocumentEditOutline }}</v-icon>
                </v-list-item>

                <v-list-item link to="/bus" title="" class="pa-0 ma-1 rounded-circle">
                    <v-icon size="40">{{ mdiBusClock }}</v-icon>
                </v-list-item>

                <!-- マイページはトップバーとかにする? -->
                <v-list-item link to="mypage" title="" class="pa-0 ma-1 rounded-circle">
                    <v-icon size="40">{{ mdiAccountSchoolOutline }}</v-icon>
                </v-list-item>

                <!-- クリック数が増えてしまうけど、マイページから設定に飛べるようにする? -->
                <!-- <v-list-item link to="settings" title="" class="pa-0 ma-1 rounded-circle">
                    <v-icon size="40">{{ mdiCogOutline }}</v-icon>
                </v-list-item> -->
    
                <v-list-item link to="" title="" @click="onLogin" class="pa-0 ma-1 rounded-circle">
                    <v-icon size="40">{{ loginFlag ? mdiLogin : mdiLogout }}</v-icon>
                </v-list-item>
            </div>
        </v-bottom-navigation>
    </div>
</template>

<style scoped>

.flex {
    display: flex;
}

.w-100p {
    width: 100%;
}

.end {
    justify-content: end;
}

.post-form {
    display: flex;
    align-items: center;
    width: 100%;
}

.pc-center {
    margin-left: 19.2%;
}

.v-center {
    align-items: center;
}

a {
    color: inherit;
    text-decoration: none;
}

.topLogo {
    margin: 15px;
}

.mouse:hover {
    /* background: rgb(240, 240, 240); */
    background: white;
    cursor: pointer;
    /* transition: 0.2s; */
}

img {
    width: 40px;
    height: 40px;
}

.phoneMenu {
    justify-content: space-between;
}
</style>