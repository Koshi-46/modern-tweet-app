<template>
  <v-app id="inspire">
    <v-navigation-drawer app width="300px">
      <v-list-item>
        <v-list-item-content>
          <v-list-item-title class="text-h6"> SHARE </v-list-item-title>
        </v-list-item-content>
      </v-list-item>

      <v-divider></v-divider>

      <v-list dense nav>
        <v-list-item
          v-for="item in items"
          :key="item.title"
          link
          :to="item.path"
        >
          <v-list-item-icon>
            <v-icon>{{ item.icon }}</v-icon>
          </v-list-item-icon>

          <v-list-item-content>
            <v-list-item-title>{{ item.title }}</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
      </v-list>

      <!-- 投稿追加 -->
      <form class="spacing-playground pa-6">
        <v-textarea
          type="text"
          name="comment"
          id="comment"
          v-model="newComment"
          outlined
          :counter="120"
          :error-messages="errors"
          required
        ></v-textarea>
        <v-btn class="mr-4" type="submit" @click="insertComment">
          コメントする
        </v-btn>
      </form>
    </v-navigation-drawer>

    <template>
      <!-- {{ this.$route.params.id }}

     <v-row justify="center">
    <v-col cols="9">
      <h2>URLパラメータ取得結果:route.params</h2>
      {{ this.$route.params.name }}<br>
      {{ this.$route.params.content }}<br> -->

      <!-- {{ item.id }}

      <v-row justify="center">
        <v-col cols="9">
          <h2>URLパラメータ取得結果</h2>
          {{ item.name }}<br />
          {{ item.content }}<br />
        </v-col>
      </v-row> -->

      <v-card
        v-for="item in contactLists"
        :key="item.id"
        class="mx-auto spacing-playground mb-5"
        color="#26c6da"
        dark
        width="1000"
      >
        <v-row no-gutters>
          <v-col cols="12" sm="6" md="8">
            <v-card-text class="font-weight-bold spacing-playground pb-0">
              {{ item.content }}
            </v-card-text>
          </v-col>
        </v-row>
      </v-card>
    </template>

    <v-main> </v-main>
  </v-app>
</template>

<script>
export default {
  data() {
    return {
      items: [
        { title: "ホーム", icon: "mdi-home", path: "/" },
        // { title: 'ログアウト', icon: 'mdi-logout', path: '/logout' },
        // { title: 'ログイン', icon: 'mdi-login', path: '/login' },
        // { title: '新規登録', icon: 'mdi-wrench', path: '/register' },
      ],
      newName: "",
      newContent: "",
      contactLists: [],
      right: null,
    };
  },
  methods: {
    async getContact() {
      const resData = await this.$axios.get("http://127.0.0.1:8000/api/tweet/");
      this.contactLists = resData.data.data;
    },
    async getComment() {
      const resData = await this.$axios.get("http://127.0.0.1:8000/api/comment/");
      this.contactLists = resData.data.data;
    },
    async insertComment() {
      const sendData = {
        comment: this.newComment,
      };
      await this.$axios.post("http://127.0.0.1:8000/api/comment/", sendData);
      this.getComment();
    },
  },
  created() {
    this.getComment();
  },
};
</script>
