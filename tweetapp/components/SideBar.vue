<template>
  <v-navigation-drawer app width="300px">
    <v-list-item>
      <v-list-item-content>
        <v-list-item-title class="text-h6"> SHARE </v-list-item-title>
      </v-list-item-content>
    </v-list-item>

    <v-divider></v-divider>

    <v-list dense nav>
      <v-list-item v-for="item in items" :key="item.title" link :to="item.path">
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
      <v-text-field
        type="text"
        name="name"
        id="name"
        v-model="newName"
        :counter="10"
        label="Name"
        required
      ></v-text-field>
      <validation-provider
        v-slot="{ errors }"
        name="投稿内容"
        rules="required|max:120"
      >
        <v-textarea
          type="text"
          name="content"
          id="content"
          v-model="newContent"
          outlined
          :counter="120"
          :error-messages="errors"
          required
        ></v-textarea>
      </validation-provider>
      <v-btn class="mr-4" type="submit" @click="insertContact">
        シェアする
      </v-btn>
    </form>
  </v-navigation-drawer>
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
    async insertContact() {
      const sendData = {
        name: this.newName,
        content: this.newContent,
      };
      await this.$axios.post("http://127.0.0.1:8000/api/tweet/", sendData);
      this.getContact();
    },
    async deleteContact(id) {
      await this.$axios.delete("http://127.0.0.1:8000/api/tweet/" + id);
      this.getContact();
    },
  },
  created() {
    this.getContact();
  },
};
</script>


