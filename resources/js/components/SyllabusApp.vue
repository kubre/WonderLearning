<template>
  <div>
    <syllabus-item
      v-for="(subject, index) in syllabus"
      :key="subject"
      :item="subject"
      :index="index"
      @deleteAt="deleteAt"
    >
    </syllabus-item>
    <div class="bg-white px-4 py-2 mt-3 d-flex justify-content-between">
      <button class="btn btn-dark" @click="addSubject()">Add Subject</button>
      <button :disabled="disableSave" class="btn btn-primary" @click="store()">
        Save
      </button>
    </div>
  </div>
</template>

<script>
import SyllabusItem from "./SyllabusItem.vue";

export default {
  created: function () {
    this.from_date = document.getElementById("from_date").value;
    this.to_date = document.getElementById("to_date").value;
    this.fetchSyllabus();
  },
  methods: {
    fetchSyllabus: function () {
      this.disableSave = true;
      fetch(
        `/api/getSyllabus?from_date=${this.from_date}&to_date=${this.to_date}`
      )
        .then((res) => res.json())
        .then((res) => {
          this.syllabus = res;
          this.disableSave = false;
        })
        .catch(() => (this.disableSave = false));
    },
    store: function () {
      this.disableSave = true;
      axios
        .post("syllabus/save", this.syllabus)
        .then((res) => {
          this.fetchSyllabus();
        })
        .catch(() => (this.disableSave = false));
    },
    addSubject: function () {
      this.syllabus.push(
        JSON.parse(
          JSON.stringify({
            name: "",
            type: "subject",
            children: [],
            program: 'Playgroup',
          })
        )
      );
    },
    deleteAt: function (index) {
      this.syllabus.splice(index, 1);
    },
  },
  data: function () {
    return {
      disableSave: false,
      syllabus: [],
      from_date: null,
      to_date: null,
    };
  },
  components: {
    SyllabusItem,
  },
};
</script>