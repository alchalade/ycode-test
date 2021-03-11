<template>
  <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <h1 class="text-5xl font-bold text-y_code mb-20">My Team</h1>
    <div class="grid grid-cols-2 gap-20">
      <member-form />
      <div>
        <member-list />
      </div>
    </div>
  </div>
</template>

<script>
import memberForm from "../components/MemberForm";
import MemberList from "../components/MemberList";

export default {
  components: { MemberList, memberForm },
  props: [],
  data() {
    return {};
  },
  mounted() {},
  watch: {},

  methods: {},
};
</script>
