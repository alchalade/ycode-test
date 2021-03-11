<template>
    <div>
        <img v-if="avatar" class="h-10 w-10 rounded-full" :src="avatar" alt=""/>
        <svg v-else class="h-10 w-10 rounded-full"
             xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M16 7a4 4 0 11-8 0 4 4 0 018 0zm-4 7a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
        </svg>
    </div>
</template>

<script>
export default {
    name: "MemberAvatar",
    props: {
        avatar: {
            required: true,
            validator: prop => typeof prop === 'string' || prop === null
        }
    }
}
</script>

<style scoped>

</style>
