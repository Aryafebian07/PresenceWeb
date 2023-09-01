<template>
    <div>
        <Head title="Create Users" />
        <h1 class="mb-8 text-3xl font-bold">
            <Link class="text-indigo-400 hover:text-indigo-600" href="/users">User   Admin</Link>
            <span class="text-indigo-400 font-medium">/</span> Create
        </h1>
        <div class="max-w-3xl bg-white rounded-md shadow overflow-hidden">
            <form @submit.prevent="update">

                <div class="flex flex-wrap -mb-8 -mr-6 p-8">
                    <text-input v-model="form.name" :error="form.errors.name" class="pb-8 pr-6 w-full lg:w-1/2" label="Name" />
                    <text-input v-model="form.username" :error="form.errors.username" class="pb-8 pr-6 w-full lg:w-1/2" label="Username" />
                    <text-input v-model="form.email" :error="form.errors.email" class="pb-8 pr-6 w-full lg:w-1/2" label="Email" />
                    <text-input v-model="form.password" :error="form.errors.password" class="pb-8 pr-6 w-full lg:w-1/2" label="Password" disabled/>
                </div>
                <div class="flex items-center px-8 py-4 bg-gray-50 border-t border-gray-100">
                    <button v-if="!user.deleted_at" class="text-red-600 hover:underline" tabindex="-1" type="button" @click="destroy">Hapus</button>
                    <loading-button :loading="form.processing" class="btn-indigo ml-auto" type="submit">Update</loading-button>
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
    import DateInput from '@/Components/DateInput.vue'
    import TextareaInput from '@/Components/TextareaInput.vue'


    //   import TrashedMessage from '@/Components/TrashedMessage.vue'

    export default {
        components: {
            Head,
            Icon,
            Link,
            LoadingButton,
            SelectInput,
            TextInput,
            DateInput,
            TextareaInput,
            //   TrashedMessage,
        },
        layout: Layout,
        props: {
            user: Object,
        },
        remember: 'form',
        data() {
            return {
                form: this.$inertia.form({
                    id: this.user.id,
                    name: this.user.name,
                    username: this.user.username,
                    email: this.user.email,
                    password: this.user.password,
                }),
            }
        },
        methods: {
            update() {
                this.form.put(`/user/${this.user.id}`)
            },
            destroy() {
                if (confirm('Are you sure you want to delete this Program Studi?')) {
                    this.$inertia.delete(`/user/${this.user.id}`)
                }
            },
            restore() {
                if (confirm('Are you sure you want to restore this Program Studi?')) {
                    this.$inertia.put(`/user/${this.user.id}/restore`)
                }
            },
        },
    }
</script>
