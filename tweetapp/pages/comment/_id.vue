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
            <v-icon>{{ item.name }}</v-icon>
          </v-list-item-icon>

          <v-list-item-content>
            <v-list-item-title>{{ item.title }}</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
      </v-list>

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
      <!-- 投稿 -->
      <v-card
        v-for="item in contactLists"
        :key="item.id"
        class="mx-auto"
        color="#26c6da"
        dark
        width="1200"
      >
        <v-row no-gutters v-if="item.id == $route.params.id">
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
              </v-list-item>
            </v-card-actions>
          </v-col>
        </v-row>
      </v-card>
      <v-list-item>
        <v-list-item-content v-for="comment in commentLists" :key="comment.id">
          <v-list-item-title>{{ comment.content }}</v-list-item-title>
        </v-list-item-content>
      </v-list-item>
    </template>
    <v-main> </v-main>
  </v-app>
</template>


<script>
export default {
  data() {
    return {
      items: [{ title: "ホーム", icon: "mdi-home", path: "/" }],
      newComment: "",
      contactLists: [],
      commentLists: [],
      right: null,
    };
  },
  methods: {
    async getContact() {
      const resData = await this.$axios.get("http://127.0.0.1:8000/api/tweet/");
      this.contactLists = resData.data.data;
    },
    async getComment() {
      const resData = await this.$axios.get(
        "http://127.0.0.1:8000/api/comment/"
      );
      this.commentLists = resData.data.data;
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
    this.getContact();
  },
};
</script>
