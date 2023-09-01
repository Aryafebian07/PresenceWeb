<template>
    <div>
        <Head :title="form.nama" />
        <h1 class="mb-8 text-3xl font-bold">
            <Link class="text-indigo-400 hover:text-indigo-600" href="/matkuls">Mata Kuliah</Link>
            <span class="text-indigo-400 font-medium">/</span>
            {{ form.nama }}
        </h1>
        <div class="max-w-3xl bg-white rounded-md shadow overflow-hidden">
            <form @submit.prevent="update">
                <div class="flex flex-wrap -mb-8 -mr-6 p-8">
                    <select-input v-model="form.prodi_id" :options="prodiOptions" :error="form.errors.prodi_id" class="pb-8 pr-6 w-full lg:w-1/2" label="Program Studi" required>
                        <option v-for="option in prodiOptions" :key="option.value" :value="option.value">{{ option.label }}</option>
                    </select-input>
                    <text-input v-model="form.kode" :error="form.errors.kode" class="pb-8 pr-6 w-full lg:w-1/2" label="Kode" />
                    <text-input v-model="form.nama" :error="form.errors.nama" class="pb-8 pr-6 w-full lg:w-1/2" label="Nama" />
                    <text-input v-model="form.sks" :error="form.errors.sks" class="pb-8 pr-6 w-full lg:w-1/2" label="SKS" />

                </div>
                <div class="flex items-center px-8 py-4 bg-gray-50 border-t border-gray-100">
                    <button v-if="!matkul.deleted_at" class="text-red-600 hover:underline" tabindex="-1" type="button" @click="destroy">Hapus</button>
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
            matkul: Object,
        },
        remember: 'form',
        data() {
            return {
                form: this.$inertia.form({
                    id: this.matkul.id,
                    nama: this.matkul.nama,
                    kode: this.matkul.kode,
                    sks: this.matkul.sks,
                    prodi_id: this.matkul.prodi_id,
                }),
                prodiOptions:[],
            }
        },
        methods: {
            update() {
                this.form.put(`/matkuls/${this.matkul.id}`)
            },
            destroy() {
                if (confirm('Are you sure you want to delete this Mata Kuliah?')) {
                    this.$inertia.delete(`/matkuls/${this.matkul.id}`)
                }
            },
            restore() {
                if (confirm('Are you sure you want to restore this Mata Kuliah?')) {
                    this.$inertia.put(`/matkuls/${this.matkul.id}/restore`)
                }
            },
            fetchProdiOptions() {
                this.prodiOptions = this.$page.props.prodiOptions;
            },
        },
        mounted() {
            this.fetchProdiOptions()
        },
    }
</script>
