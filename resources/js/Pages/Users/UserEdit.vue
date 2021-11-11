<template>
    <Head title="Edit User"/>

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Edit User
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">

                        <BreezeValidationErrors class="mb-4" />

                        <form @submit.prevent="submit">
                            <div>
                                <BreezeLabel for="name" value="Name" />
                                <BreezeInput id="name" type="text" class="mt-1 block w-full" v-model="form.name"  autofocus autocomplete="name"/>
                            </div>

                            <div class="mt-4">
                                <BreezeLabel for="email" value="Email" />
                                <BreezeInput id="email" type="email" class="mt-1 block w-full" v-model="form.email"  autocomplete="email"/>
                            </div>

                            <div class="mt-4">
                                <label class="font-medium text-sm text-gray-700">Role</label>
                                <select id="role_id" v-model="form.role_id"  class="ml-4 rounded border-gray-300">
                                    <option disabled value="">Assign Role</option>
                                    <option v-for="role in roles.data" :key="role.id" :value="role.id" :selected="role.id === form.role_id">{{ role.name }}</option>
                                </select>
                            </div>

                            <div class="mt-4">
                                <BreezeLabel for="password" value="Password" />
                                <BreezeInput id="password" type="password" class="mt-1 block w-full" v-model="form.password"  autocomplete="new-password" />
                            </div>

                            <div class="mt-4">
                                <BreezeLabel for="password_confirmation" value="Confirm Password" />
                                <BreezeInput id="password_confirmation" type="password" class="mt-1 block w-full" v-model="form.password_confirmation" autocomplete="new-password" />
                            </div>

                            <div class="flex items-center justify-end mt-4">
                                <BreezeButton class="ml-4 bg-green-600" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                    Update
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

export default {
    components: {
        BreezeButton,
        BreezeInput,
        BreezeLabel,
        BreezeDropdown,
        BreezeValidationErrors,
        BreezeAuthenticatedLayout,
        Head,
    },
    props: {
        roles: Array,
        user: Object,
    },
    data() {
        return {
            form: this.$inertia.form({
                name: this.user.data.name,
                email: this.user.data.email,
                password: '',
                password_confirmation: '',
                role_id: this.user.data.role.id,
            })
        }
    },

    methods: {
        submit() {
            this.form.put(this.route('users.update', {user: this.user.data.id}), {
                onFinish: () => this.form.reset('password', 'password_confirmation'),
            })
        }
    }
}
</script>
