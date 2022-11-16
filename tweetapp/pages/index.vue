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

    <template>
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
          <v-col cols="6" md="4">
            <v-card-actions>
              <v-list-item class="grow">
                <v-list-item-content>
                  <v-list-item-title class="text-right">{{
                    item.name
                  }}</v-list-item-title>
                </v-list-item-content>
                <v-row align="center" justify="end">
                  <v-icon class="mr-1"> mdi-heart </v-icon>
                  <span class="subheading mr-3">256</span>
                  <button @click="deleteContact(item.id)">
                    <v-icon class="mr-3"> mdi-close-circle-outline </v-icon>
                  </button>
                  <button @click="movePage">
                    <v-icon class="mr-1" > mdi-share </v-icon>
                  </button>
                  <NuxtLink :to="`/${item.id}/comment`">
                    <v-icon class="mr-1"> mdi-share </v-icon>
                  </NuxtLink>
                </v-row>
              </v-list-item>
            </v-card-actions>
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
    movePage() {
     this.$router.push(`/${this.item.id}/comment`);
    },
  },
  created() {
    this.getContact();
  },
};
</script>
