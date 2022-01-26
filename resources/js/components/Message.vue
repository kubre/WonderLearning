<template>
<div style="display: flex; flex-direction: column;margin-bottom: 5px" :class="{'message-wrap': true, 'align-right': message.is_teacher }">
  <div  :class="{ 'teacher' : message.is_teacher, common: true }">
    {{ message.body }}
  </div>
  <div style="font-size: 0.7rem; padding: 2px;" :class="{ 'align-right' : message.is_teacher }">{{ message.sent_at }}</div>
</div>
</template>

<script>
export default {
  props: ["message", "index"],
  methods: {
  },
  computed: {

  },
  data: function () {
    return {
      
    };
  },
};
</script>

<style scoped>
.smooth-enter-active,
.smooth-leave-active {
  transition: opacity 0.5s;
}
.smooth-enter,
.smooth-leave-to {
  opacity: 0;
}

.common {
  padding: 8px 12px;
  border-radius: 50px;
  box-shadow: 2px 5px 10px 17px rgba(0,0,0, 0.16px);
  background: white;
  width: max-content;
}

.teacher {
  background: rgb(87, 157, 255);
  color: white;
  align-self: end;
  
}

.message-wrap {
  max-width: 60%;
  width: max-content;
  min-width: 20px;
  min-height: 30px;
  margin-top: 5px;
}

.align-right {
  justify-self: right;
  align-content: right;
  text-align: right;
}

</style>