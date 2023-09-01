<template>
    <div>
        <Head :title="form.name" />
        <h1 class="mb-8 text-3xl font-bold">
            <Link class="text-indigo-400 hover:text-indigo-600" href="/roles">Roles</Link>
            <span class="text-indigo-400 font-medium">/</span>
            {{ form.id }}
        </h1>
        <!-- <trashed-message v-if="roles.deleted_at" class="mb-6" @restore="restore"> This role has been deleted. </trashed-message> -->
        <div class="max-w-3xl bg-white rounded-md shadow overflow-hidden">
            <form @submit.prevent="update">
                <div class="flex flex-wrap -mb-8 -mr-6 p-8">
                    <text-input v-model="form.name" :error="form.errors.name" class="pb-8 pr-6 w-full lg:w" label="Name" />
                </div>
                <div class="flex items-center px-8 py-4 bg-gray-50 border-t border-gray-100">
                    <button v-if="!role.deleted_at" class="text-red-600 hover:underline" tabindex="-1" type="button" @click="destroy">Delete Role</button>
                    <loading-button :loading="form.processing" class="btn-indigo ml-auto" type="submit">Update Role</loading-button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    import { Head, Link } from '@inertiajs/vue3'
    import Icon from '@/Components/Icon.vue'
    import Layout from '@/Layouts/AppLayout.vue'
    import TextInput from '@/Components/TextInput2.vue'
    import SelectInput from '@/Components/SelectInput.vue'
    import LoadingButton from '@/Components/LoadingButton.vue'
    //   import TrashedMessage from '@/Components/TrashedMessage.vue'

    export default {
        components: {
            Head,
            Icon,
            Link,
            LoadingButton,
            SelectInput,
            TextInput,
            //   TrashedMessage,
        },
        layout: Layout,
        props: {
            role: Object,
        },
        remember: 'form',
        data() {
            return {
                form: this.$inertia.form({
                    id: this.role.id,
                    name: this.role.name,
                }),
            }
        },
        methods: {
            update() {
                this.form.put(`/roles/${this.role.id}`)
            },
            destroy() {
                if (confirm('Are you sure you want to delete this role?')) {
                    this.$inertia.delete(`/roles/${this.role.id}`)
                }
            },
            restore() {
                if (confirm('Are you sure you want to restore this role?')) {
                    this.$inertia.put(`/roles/${this.role.id}/restore`)
                }
            },
        },
    }
</script>
