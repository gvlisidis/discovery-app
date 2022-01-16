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
                                        :closeOnSelect=true
                                        :classes="{
                                                container: 'relative mx-auto w-64 text-sm text-gray-700  flex items-center justify-end box-border cursor-pointer border border-gray-300 rounded bg-white text-base leading-snug outline-none',
                                                spacer: 'h-9 box-content',
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
                            <div class="mt-8">
                                <div v-for="(company, index) in assignedCompanies"  :key="company.id">
                                    <div class="flex justify-between px-8">
                                        <div>Assigned to company <span class="text-red-700 font-semibold">{{companies.data[company.company_id - 1].name }}</span>
                                            as <span class="text-blue-700 font-semibold">{{companyRoleText(company.company_role_id) }}</span></div>
                                        <button @click.prevent="removeCompany(index)">X</button>
                                    </div>

                                </div>
                            </div>
                            <div id="companies_array">
                                <div class="mt-4 flex w-full" id="companies1">
                                    <div class="flex">
                                        <label class="w-72 my-auto font-medium text-sm text-gray-700">Role To
                                            Company</label>
                                        <select
                                            class="w-full border border-gray-300 rounded bg-white text-sm text-gray-700"
                                            v-model="company_role_id">
                                            <option value="0"></option>
                                            <option value="1">Company Member</option>
                                            <option value="2">Company Admin</option>
                                        </select>
                                    </div>
                                    <div class="ml-12 flex w-full">
                                        <label class="w-44 my-auto font-medium text-sm text-gray-700">Assign
                                            Companies</label>
                                        <select
                                            class="w-full border border-gray-300 rounded bg-white text-sm text-gray-700"
                                            v-model="company_id">
                                            <option value="0"></option>
                                            <option v-for="company in companies.data" :key="company.id"
                                                    :value="company.id">{{ company.name }}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="ml-4">
                                <button class="py-2 px-4 rounded w-18 bg-blue-600 text-white"
                                        @click.prevent="addCompanyRow">Add
                                </button>
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
import {Head, useForm} from '@inertiajs/inertia-vue3';
import BreezeButton from "@/Components/Button";
import BreezeInput from "@/Components/Input";
import BreezeDropdown from "@/Components/Dropdown";
import BreezeLabel from "@/Components/Label";
import BreezeValidationErrors from "@/Components/ValidationErrors";
import Multiselect from '@vueform/multiselect'
import {ref} from "vue";


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
    setup(props) {
        const counter = ref(0);
        const company_id = ref('');
        const company_role_id = ref('');
        const assignedCompanies = ref([]);
        const form = useForm({
            name: null,
            email: null,
            password: null,
            password_confirmation: null,
            role_id: null,
            assignedCompanies: [],
        });

        function submit() {
            form.assignedCompanies = assignedCompanies.value;
            form.post('/users', {
                onFinish: () => form.reset('password', 'password_confirmation'),
            })
        }

        function isDuplicate() {
            return  assignedCompanies.value.some(el => el.company_id === company_id.value)
        }

        function companyRoleText(id) {
            if(id == 1){
                return 'Member';
            }
            if(id == 2){
                return 'Admin';
            }
        }

        function removeCompany(index) {
            assignedCompanies.value.splice(index, 1);
        }

        function addCompanyRow() {
            if ((company_id.value != 0 && company_role_id.value != 0) && !isDuplicate()) {
                assignedCompanies.value.push({
                    company_id: company_id.value,
                    company_role_id: company_role_id.value
                });
            }
        }

        return {counter, company_id, company_role_id, form, assignedCompanies, companyRoleText, submit, removeCompany, addCompanyRow}
    }
}
</script>

<style src="@vueform/multiselect/themes/default.css"></style>
