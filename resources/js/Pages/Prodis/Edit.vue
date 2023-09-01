<template>
    <div>
        <Head :title="form.nama" />
        <h1 class="mb-8 text-3xl font-bold">
            <Link class="text-indigo-400 hover:text-indigo-600" href="/prodis">Program Studi</Link>
            <span class="text-indigo-400 font-medium">/</span>
            {{ form.nama }}
        </h1>
        <div class="max-w-3xl bg-white rounded-md shadow overflow-hidden">
            <form @submit.prevent="update">
                <div class="flex flex-wrap -mb-8 -mr-6 p-8">
                    <text-input v-model="form.kode" :error="form.errors.kode" class="pb-8 pr-6 w-full lg:w-1/2" label="Kode" />
                    <text-input v-model="form.nama" :error="form.errors.nama" class="pb-8 pr-6 w-full lg:w-1/2" label="Nama" />
                    <select-input v-model="form.jenjang" :error="form.errors.jenjang" class="pb-8 pr-6 w-full lg:w-1/2" label="Jenjang">
                        <option :value="''"></option>
                        <option :value="'D1'">D1</option>
                        <option :value="'D2'">D2</option>
                        <option :value="'D3'">D3</option>
                        <option :value="'D4'">D4</option>
                        <option :value="'S1'">S1</option>
                        <option :value="'S2'">S2</option>
                        <option :value="'S3'">S3</option>
                        <option :value="'Profesi'">Profesi</option>
                        <option :value="'Spesialis'">Spesialis</option>
                    </select-input>
                    <select-input v-model="form.akreditasi" :error="form.errors.akreditasi" class="pb-8 pr-6 w-full lg:w-1/2" label="Akreditasi">
                        <option :value="'-'">-</option>
                        <option :value="'A'">A</option>
                        <option :value="'B'">B</option>
                        <option :value="'C'">C</option>
                        <option :value="'Unggul'">Unggul</option>
                        <option :value="'Baik Sekali'">Baik Sekali</option>
                        <option :value="'Baik'">Baik</option>
                    </select-input>
                    <date-input v-model="form.tanggal_berdiri" :error="form.errors.tanggal_berdiri" class="pb-8 pr-6 w-full lg:w-1/2" label="Tanggal Berdiri" />
                    <select-input v-model="form.status" :error="form.errors.status" class="pb-8 pr-6 w-full lg:w-1/2" label="Status">
                        <option :value="'0'">Aktif</option>
                        <option :value="'1'">Tidak</option>
                    </select-input>
                    <textarea-input v-model="form.visi" :error="form.errors.visi" class="pb-8 pr-6 w-full lg:w-1/2" label="Visi" />
                    <textarea-input v-model="form.misi" :error="form.errors.misi" class="pb-8 pr-6 w-full lg:w-1/2" label="Misi" />
                    <textarea-input v-model="form.deskripsi" :error="form.errors.deskripsi" class="pb-8 pr-6 w-full lg:w-1/2" label="Deskripsi" />
                    <textarea-input v-model="form.kompetensi" :error="form.errors.kompetensi" class="pb-8 pr-6 w-full lg:w-1/2" label="Kompetensi" />
                </div>
                <div class="flex items-center px-8 py-4 bg-gray-50 border-t border-gray-100">
                    <button v-if="!prodi.deleted_at" class="text-red-600 hover:underline" tabindex="-1" type="button" @click="destroy">Hapus</button>
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
            prodi: Object,
        },
        remember: 'form',
        data() {
            return {
                form: this.$inertia.form({
                    id: this.prodi.id,
                    nama: this.prodi.nama,
                    kode: this.prodi.kode,
                    jenjang: this.prodi.jenjang,
                    akreditasi: this.prodi.akreditasi,
                    tanggal_berdiri: this.prodi.tanggal_berdiri,
                    status: this.prodi.status,
                    visi: this.prodi.visi,
                    misi: this.prodi.misi,
                    deskripsi: this.prodi.deskripsi,
                    kompetensi: this.prodi.kompetensi,
                }),
            }
        },
        methods: {
            update() {
                this.form.put(`/prodis/${this.prodi.id}`)
            },
            destroy() {
                if (confirm('Are you sure you want to delete this Program Studi?')) {
                    this.$inertia.delete(`/prodis/${this.prodi.id}`)
                }
            },
            restore() {
                if (confirm('Are you sure you want to restore this Program Studi?')) {
                    this.$inertia.put(`/prodis/${this.prodi.id}/restore`)
                }
            },
        },
    }
</script>
