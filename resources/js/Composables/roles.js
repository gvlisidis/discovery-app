import {usePage} from "@inertiajs/inertia-vue3";
import { computed } from 'vue';

export default function userRoles() {
    const authUser = usePage().props.value.auth.user;

    const isAdmin = computed(() => {
        return authUser.role_id === 1;
    });

    const isPartner = computed(() => {
        return authUser.role_id === 2;
    })

    return {
        isAdmin, isPartner
    }
}
