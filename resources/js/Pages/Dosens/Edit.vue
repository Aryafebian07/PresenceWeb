<template>
    <div>
        <Head :title="form.nama" />
        <h1 class="mb-8 text-3xl font-bold">
            <Link class="text-indigo-400 hover:text-indigo-600" href="/dosens">Dosen</Link>
            <span class="text-indigo-400 font-medium">/</span>
            {{ form.nama }}
        </h1>
        <div class="max-w-3xl bg-white rounded-md shadow overflow-hidden">
            <form @submit.prevent="update">
                <div class="flex flex-wrap -mb-8 -mr-6 p-8">
                    <text-input v-model="form.nip" :error="form.errors.nip" class="pb-8 pr-6 w-full lg:w-1/2" label="NIP" />
                    <text-input v-model="form.nidn" :error="form.errors.nidn" class="pb-8 pr-6 w-full lg:w-1/2" label="NIDN" />
                    <text-input v-model="form.nama" :error="form.errors.nama" class="pb-8 pr-6 w-full lg:w-1/2" label="Nama" />
                    <text-input v-model="form.email" :error="form.errors.email" class="pb-8 pr-6 w-full lg:w-1/2" label="Email" />
                    <text-input v-model="form.notelp" :error="form.errors.notelp" class="pb-8 pr-6 w-full lg:w-1/2" label="No Telp" />
                    <text-input v-model="form.nohp" :error="form.errors.nohp" class="pb-8 pr-6 w-full lg:w-1/2" label="No Hp" />
                    <select-input v-model="form.gender" :error="form.errors.gender" class="pb-8 pr-6 w-full lg:w-1/2" label="Jenis Kelamin">
                        <option :value="'L'">Laki-laki</option>
                        <option :value="'P'">Perempuan</option>
                    </select-input>
                    <text-input v-model="form.agama" :error="form.errors.agama" class="pb-8 pr-6 w-full lg:w-1/2" label="Agama" />
                    <text-input v-model="form.tempat_lahir" :error="form.errors.tempat_lahir" class="pb-8 pr-6 w-full lg:w-1/2" label="Tempat Lahir" />
                    <date-input v-model="form.tanggal_lahir" :error="form.errors.tanggal_lahir" class="pb-8 pr-6 w-full lg:w-1/2" label="Tanggal Lahir" />
                    <select-input v-model="form.pendidikan" :error="form.errors.pendidikan" class="pb-8 pr-6 w-full lg:w-1/2" label="Pendidikan Terakhir" required>
                        <option :value="'-'">-</option>
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
                    <select-input v-model="form.prodi_id" :options="prodiOptions" :error="form.errors.prodi_id" class="pb-8 pr-6 w-full lg:w-1/2" label="Program Studi" required>
                        <option v-for="option in prodiOptions" :key="option.value" :value="option.value">{{ option.label }}</option>
                    </select-input>
                    <text-input v-model="form.jabatan" :error="form.errors.jabatan" class="pb-8 pr-6 w-full lg:w-1/2" label="Jabatan" />
                    <select-input v-model="form.sik" :error="form.errors.sik" class="pb-8 pr-6 w-full lg:w-1/2" label="Status Ikatan Kerja">
                        <option :value="'1'">Dosen Tetap</option>
                        <option :value="'2'">Dosen Tidak Tetap</option>
                        <option :value="'3'">Dosen Honorer</option>
                    </select-input>
                    <select-input v-model="form.status" :error="form.errors.status" class="pb-8 pr-6 w-full lg:w-1/2" label="Status">
                        <option :value="'0'">Aktif</option>
                        <option :value="'1'">Tidak Aktif</option>
                    </select-input>
                    <textarea-input v-model="form.alamat" :error="form.errors.alamat" class="pb-8 pr-6 w-full lg:w-1/2" label="Alamat" />
                </div>
                <div class="flex items-center px-8 py-4 bg-gray-50 border-t border-gray-100">
                    <button v-if="!dosen.deleted_at" class="text-red-600 hover:underline" tabindex="-1" type="button" @click="destroy">Hapus</button>
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
            dosen: Object,
        },
        remember: 'form',
        data() {
            return {
                form: this.$inertia.form({
                    id: this.dosen.id,
                    nip: this.dosen.nip,
                    nidn: this.dosen.nidn,
                    nama: this.dosen.nama,
                    email: this.dosen.email,
                    notelp: this.dosen.notelp,
                    nohp: this.dosen.nohp,
                    gender: this.dosen.gender,
                    agama: this.dosen.agama,
                    tempat_lahir: this.dosen.tempat_lahir,
                    tanggal_lahir: this.dosen.tanggal_lahir,
                    pendidikan: this.dosen.pendidikan,
                    jabatan: this.dosen.jabatan,
                    sik: this.dosen.sik,
                    status: this.dosen.status,
                    alamat: this.dosen.alamat,
                    prodi_id: this.dosen.prodi_id,
                }),
                prodiOptions:[],
            }
        },
        methods: {
            update() {
                this.form.put(`/dosens/${this.dosen.id}`)
            },
            destroy() {
                if (confirm('Are you sure you want to delete this Dosen?')) {
                    this.$inertia.delete(`/dosens/${this.dosen.id}`)
                }
            },
            restore() {
                if (confirm('Are you sure you want to restore this Dosen?')) {
                    this.$inertia.put(`/dosens/${this.dosen.id}/restore`)
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
