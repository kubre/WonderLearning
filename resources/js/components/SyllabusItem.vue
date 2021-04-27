<template>
  <div>
    <div class="shadow rounded px-3 mb-2 d-flex" :class="item.type">
      <strong class="py-2 pe-2">{{ index + 1 }}</strong>
      <input
        type="text"
        class="form-control flex-fill my-1 me-2"
        v-model="item.name"
        :placeholder="'Enter a ' + item.type + ' title'"
      />
      <div class="d-flex flex-fill align-items-center">
        <template v-if="item.type != 'subtopic'">
          <button class="btn btn-sm rounded-pill btn-primary" @click="add()">
            + {{ addText }}
          </button>
          <button
            v-show="item.children && item.children.length > 0"
            class="btn btn-sm btn-dark rounded-pill ms-1"
            @click="isVisible = !isVisible"
          >
            {{ toggleText }}
          </button>
        </template>
        <button
          class="btn btn-sm btn-danger ms-auto rounded-pill"
          @click="$emit('deleteAt', index)"
        >
          - Delete
        </button>
      </div>
    </div>

    <transition name="smooth">
      <div
        v-show="isVisible"
        v-if="item.children && item.children.length > 0"
        class="ms-4 mb-2"
      >
        <syllabus-item
          v-for="(child, childIndex) in item.children"
          :key="child"
          :item="child"
          :index="childIndex"
          @deleteAt="deleteAt"
        ></syllabus-item>
      </div>
    </transition>
  </div>
</template>

<script>
const childType = {
  subject: "book",
  book: "chapter",
  chapter: "topic",
  topic: "subtopic",
};

export default {
  props: ["item", "index"],
  methods: {
    add: function () {
      this.item.children.push(
        JSON.parse(
          JSON.stringify({
            name: "",
            type: childType[this.item.type],
            children: [],
          })
        )
      );
    },
    deleteAt: function (index) {
      this.item.children.splice(index, 1);
    },
  },
  computed: {
    toggleText: function () {
      return this.isVisible ? "Hide" : "Show";
    },
  },
  data: function () {
    return {
      isVisible: true,
      addText: "Add " + childType[this.item.type],
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

.subject {
  background: #fff;
}
.book {
  background: #a8d3ff;
}
.chapter {
  background: #a9ffe9;
}
.topic {
  background: #ffd0a9;
}
.subtopic {
  background: #f0b6ff;
}
</style>