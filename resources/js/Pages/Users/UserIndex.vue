<template>
    <Head title="Users"/>

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Users
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div v-if="$page.props.flash.message"
                             class="bg-green-100 px-2 py-1 font-semibold text-sm rounded-xl">
                            {{ $page.props.flash.message }}
                        </div>

                        <div class="flex flex-col">
                            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                                    <div class="flex items-center mb-2">
                                        <select v-model="company_id"
                                                class="w-64 text-sm text-gray-700 border border-gray-300 rounded bg-white text-base leading-snug outline-none">
                                            <option v-if="authUser.role_id === 1" value="0">All</option>
                                            <option v-for="company in companies" :key="company.id" :value="company.id">
                                                {{ company.name }}
                                            </option>
                                        </select>
                                        <div class="ml-2" v-if="isAdmin()">
                                            <a href="/users/create" class="bg-green-300 px-4 py-2 rounded-xl">Create</a>
                                        </div>
                                    </div>
                                    <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                        <table class="min-w-full divide-y divide-gray-200">
                                            <thead class="bg-gray-50">
                                            <tr>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Name
                                                </th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Email
                                                </th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Role
                                                </th>
                                                <th scope="col" class="relative px-6 py-3"></th>
                                            </tr>
                                            </thead>
                                            <tbody class="bg-white divide-y divide-gray-200">
                                            <tr v-for="user in users.data" :key="user.id">
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="flex items-center">
                                                        <div class="ml-4">
                                                            <div class="text-sm font-medium text-gray-900">
                                                                {{ user.name }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="flex items-center">
                                                        <div class="ml-4">
                                                            <div class="text-sm text-gray-500">
                                                                {{ user.email }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    {{ roleText(user) }}
                                                </td>
                                                <td v-if="((authUser.role_id === 1) || (authUser.role_id === 2 && user.role.id !== 1) )"
                                                    class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                    <Link :href="route('users.edit', { user: user.id })"
                                                          class="text-green-700 font-semibold">
                                                        Edit
                                                    </Link>
                                                    |
                                                    <Link :href="route('users.delete', { user: user.id })"
                                                          method="delete" as="button" type="button"
                                                          class="text-red-700 font-semibold">
                                                        Delete
                                                    </Link>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>

<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue'
import {Head, Link, usePage} from '@inertiajs/inertia-vue3';
import {Inertia} from '@inertiajs/inertia';
import {ref, watch} from 'vue';

export default {
    components: {
        BreezeAuthenticatedLayout,
        Link,
        usePage,
        Head,
    },

    props: {
        users: Object,
        session_message: null,
        companies: Array,
        company_id: String,
    },

    setup(props) {
        let authUser = usePage().props.value.auth.user;
        let company_id = ref(props.company_id);
        console.log(423423, company_id)

        watch(company_id, value => {
            Inertia.get('/users', {company_id: value});
        })

        function roleText(user) {
            return user.role.id === 1 ? 'MMC Member' : user.role.name;
        }

        function isAdmin() {
            return this.authUser.role_id === 1;
        }

        return {
            authUser, company_id, roleText, isAdmin
        }
    },
}
</script>
