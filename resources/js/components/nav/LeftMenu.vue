<template>
    <AppModeratorAccess>
        <div class="mt-2">
            <AppAuthAccess>
                <AppAdminPanel />
            </AppAuthAccess>
        </div>
    </AppModeratorAccess>
    <div class="mt-2">
        <AppAuthAccess>
            <AppUserPanel />
        </AppAuthAccess>
    </div>
</template>

<script>
import AppUserPanel from "@/components/auth/UserPanel.vue";
import AppAdminPanel from "@/components/admin/AdminPanel.vue";
export default {
    components: {
        AppUserPanel,
        AppAdminPanel
    },
};
</script>
