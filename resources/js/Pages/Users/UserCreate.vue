<template>
    <Head title="Create User"/>

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Create User
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">

                        <BreezeValidationErrors class="mb-4"/>

                        <form @submit.prevent="submit">
                            <div>
                                <BreezeLabel for="name" value="Name"/>
                                <BreezeInput id="name" type="text" class="mt-1 block w-full" v-model="form.name"
                                             required autofocus autocomplete="name"/>
                            </div>

                            <div class="mt-4">
                                <BreezeLabel for="email" value="Email"/>
                                <BreezeInput id="email" type="email" class="mt-1 block w-full" v-model="form.email"
                                             required autocomplete="username"/>
                            </div>

                            <div class="mt-4 flex w-full">
                                <div class="flex">
                                    <label class="w-24 my-auto font-medium text-sm text-gray-700">Assign Role</label>
                                    <Multiselect
                                        v-model="form.role_id"
                                        :options="roles"
                                        selected="2"
                                        :closeOnSelect="true"
                                        :classes="{
                                                container: 'relative mx-auto w-64 text-sm text-gray-700  flex items-center justify-end box-border cursor-pointer border border-gray-300 rounded bg-white text-base leading-snug outline-none',
                                                spacer: 'h-9 box-content',
                                                }"
                                    />
                                </div>
                                <div class="ml-12 flex w-full">
                                    <label class="mr-2 w-44 my-auto font-medium text-sm text-gray-700">Assign Companies</label>
                                    <Multiselect
                                        v-model="form.company_ids"
                                        :options="companies"
                                        mode="tags"
                                        searchable="true"
                                        :closeOnSelect="true"
                                        :classes="{
                                                container: 'relative mx-auto w-full flex items-center justify-end box-border cursor-pointer border border-gray-300 rounded bg-white text-base leading-snug outline-none',
                                                spacer: 'h-9 w-18 box-content',
                                                }"
                                    />
                                </div>
                            </div>

                            <div class="mt-4">
                                <BreezeLabel for="password" value="Password"/>
                                <BreezeInput id="password" type="password" class="mt-1 block w-full"
                                             v-model="form.password" required autocomplete="new-password"/>
                            </div>

                            <div class="mt-4">
                                <BreezeLabel for="password_confirmation" value="Confirm Password"/>
                                <BreezeInput id="password_confirmation" type="password" class="mt-1 block w-full"
                                             v-model="form.password_confirmation" required autocomplete="new-password"/>
                            </div>

                            <div class="flex items-center justify-end mt-4">
                                <BreezeButton class="ml-4 bg-green-600" :class="{ 'opacity-25': form.processing }"
                                              :disabled="form.processing">
                                    Create
                                </BreezeButton>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>

<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue'
import {Head} from '@inertiajs/inertia-vue3';
import BreezeButton from "@/Components/Button";
import BreezeInput from "@/Components/Input";
import BreezeDropdown from "@/Components/Dropdown";
import BreezeLabel from "@/Components/Label";
import BreezeValidationErrors from "@/Components/ValidationErrors";
import Multiselect from '@vueform/multiselect'

export default {
    components: {
        BreezeButton,
        BreezeInput,
        BreezeLabel,
        BreezeDropdown,
        BreezeValidationErrors,
        BreezeAuthenticatedLayout,
        Multiselect,
        Head,
    },
    props: {
        roles: Object,
        companies: Object,
    },
    data() {
        return {
            form: this.$inertia.form({
                name: '',
                email: '',
                password: '',
                password_confirmation: '',
                role_id: '',
                company_ids: [],
            }),
            options: [
                'Batman',
                'Robin',
                'Joker',
            ]
        }
    },

    methods: {
        submit() {
            this.form.post(this.route('users.store'), {
                onFinish: () => this.form.reset('password', 'password_confirmation'),
            })
        }
    }
}
</script>

<style src="@vueform/multiselect/themes/default.css"></style>
