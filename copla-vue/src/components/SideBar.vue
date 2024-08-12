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
            } from '@mdi/js';

    import { ref, computed, onMounted, watch } from 'vue';
    import { RouterLink, RouterView } from 'vue-router'
    import { useDisplay } from 'vuetify/lib/framework.mjs';
    
    const loginFlag = ref(true);

    // 画面サイズを監視
    const device = useDisplay();

    // PC画面の半分以下か判定
    const isLessHalf = ref(false);
    // スマホ画面か判定
    const isMobile = ref(false);

    // ログイン処理
    const onLogin = () => {
        loginFlag.value = !loginFlag.value;
    }

    // リロード時に実行
    onMounted(() => {
        console.log(device);
        isMobile.value = device.xs.value;
        isLessHalf.value = device.smAndDown.value;
    })

    // 画面サイズ監視
    watch(device.name, () => {
        isMobile.value = device.xs.value;
        isLessHalf.value = device.smAndDown.value;

        console.log("isMobile : " + isMobile.value + "Half : " + isLessHalf.value);
    })

</script>

<template>
    <div>
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
                    <RouterLink to="/">
                        <div class="flex mouse topLogo">
                            <img src="../assets/logo.png" alt="">
                            <v-list-item title="Copla" subtitle="for all students">
                                <!-- <img src="../assets/logo.png"> -->
                            </v-list-item>
                        </div>
                    </RouterLink>
                    <v-divider></v-divider>
                    <v-list-item link to="/" class="rounded-xl">
                        <v-icon size="40">{{ mdiHome }}</v-icon>
                        <v-title class="ml-5" v-if="!isLessHalf">HOME</v-title>
                    </v-list-item>

                    <v-list-item link to="" class="rounded-xl">
                        <v-icon size="40">{{ mdiPencilOutline }}</v-icon>
                        <v-title class="ml-5" v-if="!isLessHalf">Post</v-title>
                    </v-list-item>

                    <v-list-item link to="/event" class="rounded-xl">
                        <v-icon size="40">{{ mdiAlertDecagramOutline }}</v-icon>
                        <v-title class="ml-5" v-if="!isLessHalf">Event</v-title>
                    </v-list-item>

                    <v-list-item link to="/articles" class="rounded-xl">
                        <v-icon size="40">{{ mdiFileDocumentEditOutline }}</v-icon>
                        <v-title class="ml-5" v-if="!isLessHalf">Articles</v-title>
                    </v-list-item>

                    <v-list-item link to="/mypage" class="rounded-xl">
                        <v-icon size="40">{{ mdiAccountSchoolOutline }}</v-icon>
                        <v-title class="ml-5" v-if="!isLessHalf">My page</v-title>
                    </v-list-item>

                    <v-list-item link to="settings" class="rounded-xl">
                        <v-icon size="40">{{ mdiCogOutline }}</v-icon>
                        <v-title class="ml-5" v-if="!isLessHalf">Settings</v-title>
                    </v-list-item>

                    <v-list-item link to="/login" class="rounded-xl" @click="onLogin">
                        <v-icon size="40">{{ loginFlag ? mdiLogin : mdiLogout }}</v-icon>
                        <v-title class="ml-5" v-if="!isLessHalf">{{ loginFlag ? "Login" : "Logout" }}</v-title>
                    </v-list-item>
                </v-list-item>
            </v-list>
        </v-navigation-drawer>

        <!-- スマホ版 -->
        <v-bottom-navigation
            v-if="isMobile"
            :height="50"
        >
            <div class="flex phoneMenu">
                <v-list-item link to="/" title="" class="pa-0 ma-1 rounded-circle">
                    <v-icon size="40">{{ mdiHome }}</v-icon>
                </v-list-item>

                <v-list-item link to="" title="" class="pa-0 ma-1 rounded-circle">
                    <v-icon size="40">{{ mdiPencilOutline }}</v-icon>
                </v-list-item>

                <v-list-item link to="/event" title="" class="pa-0 ma-1 rounded-circle">
                    <v-icon size="40">{{ mdiAlertDecagramOutline }}</v-icon>
                </v-list-item>

                <v-list-item link to="/articles" title="" class="pa-0 ma-1 rounded-circle">
                    <v-icon size="40">{{ mdiFileDocumentEditOutline }}</v-icon>
                </v-list-item>

                <v-list-item link to="mypage" title="" class="pa-0 ma-1 rounded-circle">
                    <v-icon size="40">{{ mdiAccountSchoolOutline }}</v-icon>
                </v-list-item>

                <v-list-item link to="settings" title="" class="pa-0 ma-1 rounded-circle">
                    <v-icon size="40">{{ mdiCogOutline }}</v-icon>
                </v-list-item>
    
                <v-list-item link to="/login" title="" @click="onLogin" class="pa-0 ma-1 rounded-circle">
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

a {
    color: inherit;
    text-decoration: none;
}

.topLogo {
    margin: 15px;
}

.mouse:hover {
    /* background: rgb(240, 240, 240); */
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