<template>
    <ul class="divide-y divide-gray-200">
        <li class="py-4 flex" v-for="(member, idx) in memberList" :key="idx">
            <member-avatar :avatar="member.avatar"/>
            <div class="ml-3">
                <p class="text-sm font-medium text-gray-900" v-text="member.name"></p>
                <p class="text-sm text-gray-500">{{ member.email }}</p>
            </div>
        </li>
    </ul>
</template>

<script>
import {MemberService} from "../services/MemberService";
import {EventBus} from "../EventBus";
import MemberAvatar from "./MemberAvatar";

export default {
    name: "MemberList",
    components: {MemberAvatar},
    data: function () {
        return {
            memberService: new MemberService(),
            memberList: [],
        };
    },
    created() {
        EventBus.$on('addMember', this.addFakeMember)
        this.getMembers();
    },
    methods: {
        getMembers() {
            this.memberService.list().then((list) => {
                this.memberList = list.data;
            });
        },
        addFakeMember(member) {
            if (member.avatar !== null) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    member.avatar = e.target.result;
                };
                reader.readAsDataURL(member.avatar);
            }
            this.memberList.unshift(member);
        }
    },
};
</script>

<style scoped>
</style>
