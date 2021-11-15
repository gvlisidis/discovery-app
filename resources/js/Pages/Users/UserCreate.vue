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

                            <div class="mt-4 flex">
                                <div class="flex">
                                    <label class="mr-6 my-auto font-medium text-sm text-gray-700">Assign Role</label>
                                    <Multiselect
                                        v-model="form.role_id"
                                        :options="roles"
                                        selected="2"
                                        :closeOnSelect="true"
                                        :classes="{
                                                container: 'relative mx-auto w-36 flex items-center justify-end box-border cursor-pointer border border-gray-300 rounded bg-white text-base leading-snug outline-none',
                                                spacer: 'h-10 py-px box-content',
                                                }"
                                    />
<!--                                    <select id="role_id" v-model="form.role_id" required-->
<!--                                            class="ml-4 h-10 rounded border-gray-300">-->
<!--                                        <option v-for="role in roles.data" :key="role.id" :value="role.id" :selected="role.id === 1">{{-->
<!--                                                role.name-->
<!--                                            }}-->
<!--                                        </option>-->
                                </div>
                                <div class="ml-24 flex">
                                    <label class="mr-6 my-auto font-medium text-sm text-gray-700">Assign to Companies</label>
                                    <Multiselect
                                        v-model="form.company_id"
                                        :options="companies"
                                        mode="tags"
                                        :closeOnSelect="true"
                                        :classes="{
                                                container: 'relative mx-auto w-96 flex items-center justify-end box-border cursor-pointer border border-gray-300 rounded bg-white text-base leading-snug outline-none',
                                                spacer: 'h-10 py-px box-content',
                                                }"
                                    />


                                    <!--                                    <select id="company_id" v-model="form.company_id" multiple class="ml-4 rounded border-gray-300">-->
                                    <!--                                        <option value="">Assign Companies</option>-->
                                    <!--                                        <option v-for="company in companies.data" :key="company.id" :value="company.id">{{ company.name }}</option>-->
                                    <!--                                    </select>-->
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
                company_id: [],
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
