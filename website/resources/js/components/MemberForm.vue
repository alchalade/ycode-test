<template>
    <div>
        <h2 class="text-xl mb-5">Add new team member</h2>
        <form class="space-y-5">
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700"
                >Name</label
                >
                <div class="mt-1">
                    <input
                        type="text"
                        name="name"
                        id="name"
                        v-model="user.name"
                        class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 p-3 border rounded-md"
                        placeholder="Calvin Hawkins"
                    />
                    <span class="text-red-500 text-sm" v-if="!$v.user.name.required && $v.user.name.$dirty"/>
                    <span class="text-red-500 text-sm" v-if="!$v.user.name.minLength && $v.user.name.$dirty">
                        Name should contain at least {{ $v.user.name.$params.minLength.min }} characters!
                    </span>
                </div>
            </div>
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">
                    Email
                </label>
                <div class="mt-1">
                    <input
                        type="text"
                        name="email"
                        id="email"
                        class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 p-3 border rounded-md"
                        placeholder="you@example.com"
                        v-model="user.email"
                    />
                    <span class="text-red-500 text-sm"
                          v-if="(!$v.user.email.required || !$v.user.email.email) && $v.user.email.$dirty">
            It's not a valid E-mail
          </span>
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                    Photo
                </label>
                <div class="mt-1">
                    <div
                        v-if="!previewImage"
                        @dragover.prevent
                        @drop="processFile"
                        class="w-full flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md"
                    >
                        <div class="space-y-1 text-center">
                            <svg
                                class="mx-auto h-12 w-12 text-gray-400"
                                stroke="currentColor"
                                fill="none"
                                viewBox="0 0 48 48"
                                aria-hidden="true"
                            >
                                <path
                                    d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                    stroke-width="2"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                />
                            </svg>
                            <div class="flex text-sm text-gray-600">
                                <label
                                    for="file-upload"
                                    class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500"
                                >
                                    <span>Upload a file</span>
                                    <input
                                        id="file-upload"
                                        name="file-upload"
                                        type="file"
                                        class="sr-only"
                                        @change="processFile"
                                    />
                                </label>
                                <p class="pl-1">or drag and drop</p>
                            </div>
                            <p class="text-xs text-gray-500">PNG, JPG, GIF up to 100MB</p>
                        </div>
                    </div>
                    <div
                        class="relative w-full h-64 bg-contain bg-no-repeat bg-center"
                        :style="backgroundStyle"
                        @click="reSelectImage"
                        v-else
                    >
                        <div
                            class="absolute w-full h-full cursor-pointer opacity-0 bg-gray-500 hover:opacity-40"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                width="36px"
                                height="36px"
                                viewBox="0 0 24 24"
                                stroke="white"
                                class="relative left-2/4 top-2/4"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"
                                />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <button
                type="button"
                class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                @click="submitForm"
            >
                Submit
            </button>
        </form>
    </div>
</template>

<script>
import {MemberService} from "../services/MemberService";
import {required, minLength, email} from "vuelidate/lib/validators";
import {EventBus} from "../EventBus";

export default {
    name: "MemberForm",
    data() {
        return {
            previewImage: null,
            memberService: new MemberService(),
            name: "",
            user: {
                name: "",
                email: "",
                image: null,
            },
        };
    },

    computed: {
        backgroundStyle: function () {
            return this.previewImage !== null
                ? `background-image:url('${this.previewImage}')`
                : "";
        },
    },

    methods: {
        reSelectImage() {
            this.previewImage = null;
            this.user.image = null;
        },
        processFile(e) {
            e.preventDefault();
            let image = null;
            try {
                image = this.memberService.validateEvent(e);
                this.user.image = this.memberService.validateImage(image);
            } catch (ex) {
                EventBus.$emit('showAlert', {type: 'error', title: ex.message, 'duration': 1500, position: 'center'})
                return;
            }
            const reader = new FileReader();
            reader.onload = (e) => {
                this.previewImage = e.target.result;
            };
            reader.readAsDataURL(image);
        },
        submitForm() {
            this.$v.$touch();
            if (this.$v.$invalid) {
                return;
            }
            EventBus.$emit('showAlert', {
                type: 'info',
                title: 'Sending Data',
                message: 'Please wait...',
                duration: 1500,
                position: 'center'
            })
            this.memberService
                .create(this.user)
                .then((result) => {
                    EventBus.$emit('showAlert', {
                        type: 'success',
                        title: 'New Team member added!',
                        message: 'The list will be synced in few minutes',
                        duration: 2500,
                        position: 'center',
                    })
                })
                .catch((e) => {
                    console.log('Error is ', e)
                    // TODO : log error on backend
                });

            this.memberService.addFakeMember(this.user);
            this.resetForm();
        },
        resetForm() {
            this.user = {
                name: "",
                email: "",
            };
            this.reSelectImage();
            this.$v.$reset();
        }
    },
    validations: {
        user: {
            name: {
                required,
                minLength: minLength(3),
            },
            email: {
                required,
                email,
            },
        },
    },
};
</script>

<style>
</style>
