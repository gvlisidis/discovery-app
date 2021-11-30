import {usePage} from "@inertiajs/inertia-vue3";
import { computed } from 'vue';

export default function userRoles() {
    const authUser = usePage().props.value.auth.user;

    const isAdmin = computed(() => {
        return authUser.role_id === 1;
    });

    const isPartnerAdmin = computed(() => {
        return authUser.role_id === 2;
    })

    const isPartnerMember = computed(() => {
        return authUser.role_id === 3;
    })

    return {
        isAdmin, isPartnerAdmin, isPartnerMember
    }
}
