<template>

  <div class="d-flex flex-column" style="height: calc(85vh - 100px);">
    <div id="chatArea" style="overflow-y: auto; height: 100%">
    <div class="d-grid rounded gap-2" style="background: #dfdfdf;padding: 10px; align-content: end; grid-template-rows: 1fr;">
      <template v-if="messages.length">
        <Message v-for="message in messages" :key="message.id" :message="message" />
      </template>
      <div v-else style="padding: 10px; color: #787878;text-align: center;">
        Your chats will appear here
      </div>
    </div>
    </div>
    <div style="height: 50px; background: #dfdfdf;" class="p-1 d-flex gap-2 rounded pb-2" v-on:keyup.enter="send()">
        <input v-model="userInput" type="text" style="outline: none; border: none; padding: 10px 20px !important;" class="px-2 h-100 rounded-pill flex-fill" placeholder="Type Message...">
        <button :disabled="isLoading" v-on:click="send()" class="btn rounded-pill btn-primary px-4">
        <svg v-show="isLoading" style="height: 32px;width: 32px;" version="1.1" id="L9" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
          viewBox="0 0 100 100" enable-background="new 0 0 0 0" xml:space="preserve">
            <path fill="#fff" d="M73,50c0-12.7-10.3-23-23-23S27,37.3,27,50 M30.9,50c0-10.5,8.5-19.1,19.1-19.1S69.1,39.5,69.1,50">
              <animateTransform 
                attributeName="transform" 
                attributeType="XML" 
                type="rotate"
                dur="1s" 
                from="0 50 50"
                to="360 50 50" 
                repeatCount="indefinite" />
          </path>
        </svg>
        Send
        </button>
    </div>
  </div>

</template>

<script>
import Message from "./Message.vue";

export default {
  created: function () {
    this.from_date = document.getElementById("from_date").value;
    this.to_date = document.getElementById("to_date").value;
    this.user_id = document.getElementById("user_id").value;
    this.student_id = document.getElementById("student_id").value;
    this.fetchMessages();
    this.pollMessages();
  }, beforeDestroy () {
    clearInterval(this.polling)
  },
  updated: function() {
    const a= document.getElementById('chatArea');
    a.scrollTop = a.scrollHeight;
  },
  methods: {
    pollMessages: function () {
      this.polling = setInterval(() => {
        this.fetchMessages();
      }, 10000);
    },
    fetchMessages: function () {
      fetch(
        `/api/chats?teacher=${this.user_id}&student=${this.student_id}`
      )
      .then((res) => res.json())
      .then((res) => {
        this.messages = res.data;
      });
    },
    send: function () {
      this.isLoading = true;
      axios.post("/api/chats", {
        body: this.userInput,
        teacher: this.user_id,
        student: this.student_id,
        is_teacher: true,
      }).then((res) => {
        this.fetchMessages();
        this.isLoading = false;
        this.userInput = '';
      }).catch(err => {
        alert(err.message)
        this.isLoading = false;
        this.userInput = '';
      });
    },
  },
  data: function () {
    return {
      messages: [],
      from_date: null,
      to_date: null,
      user_id: null,
      student_id: null,
      userInput: '',
      isLoading: false,
      polling: null
    };
  },
  components: {
    Message,
  },
};
</script>