<template>
    <Head title="Companies" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Companies
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div v-if="$page.props.flash.message" class="bg-green-100 px-2 py-1 font-semibold text-sm rounded-xl">
                            {{ $page.props.flash.message }}
                        </div>

                        <!-- This example requires Tailwind CSS v2.0+ -->

                        <div class="flex flex-col">
                            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                                    <div class="m-5"  v-if="isAdmin">
                                        <Link :href="route('companies.create')"
                                              class="bg-green-300 px-4 py-2 rounded-xl">
                                            Create
                                        </Link>
                                    </div>
                                    <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                        <table class="min-w-full divide-y divide-gray-200">
                                            <thead class="bg-gray-50">
                                            <tr>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Name
                                                </th>
                                                <th scope="col" class="relative px-6 py-3"></th>
                                            </tr>
                                            </thead>
                                            <tbody class="bg-white divide-y divide-gray-200">
                                            <tr v-for="company in companies.data" :key="company.id">
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="flex items-center">
                                                        <div class="ml-4">
                                                            <div class="text-sm font-medium text-gray-900">
                                                                {{ company.name }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td
                                                    v-if="(isAdmin ||isPartnerAdmin)"
                                                    class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                    <Link :href="route('companies.edit', { company: company.id })"
                                                          class="text-green-700 font-semibold">
                                                        Edit
                                                    </Link>
                                                    |
                                                    <Link :href="route('companies.users', { company: company.id })"
                                                          class="text-blue-700 font-semibold">
                                                        Users
                                                    </Link>
                                                    |
                                                    <Link :href="route('companies.delete', { company: company.id })"
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
import {Head, Link} from '@inertiajs/inertia-vue3';
import userRoles from "@/Composables/roles";

export default {
    components: {
        BreezeAuthenticatedLayout,
        Head,
        Link,
    },
    props: {
        companies: Object
    },

    setup(props) {
        const {isAdmin, isPartnerAdmin} = userRoles()

        return {
             isAdmin, isPartnerAdmin
        }
    },
}
</script>
