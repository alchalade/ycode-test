<template>
  <ul class="divide-y divide-gray-200">
    <li class="py-4 flex" v-for="(member, idx) in memberList" :key="idx">
      <img class="h-10 w-10 rounded-full" :src="member.avatar" alt="" />
      <div class="ml-3">
        <p class="text-sm font-medium text-gray-900" v-text="member.name"></p>
        <p class="text-sm text-gray-500">{{ member.email }}</p>
      </div>
    </li>
  </ul>
</template>

<script>
import { MemberService } from "../services/MemberService";

export default {
  name: "MemberList",
  data: function () {
    return {
      memberService: new MemberService(),
      memberList: [],
    };
  },
  created() {
    this.getMembers();
  },
  methods: {
    getMembers() {
      this.memberService.list().then((list) => {
        this.memberList = list.data;
      });
    },
  },
};
</script>

<style scoped>
</style>
