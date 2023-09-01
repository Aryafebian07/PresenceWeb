<template>
    <div>
        <img :src="imageURL" alt="Example Image" :style="{ width: '100px', height: 'auto'}"/>
    </div>
</template>

<script>
export default {
    data() {
        return {
            imageURL: '/storage/images/logo.png' // Ubah sesuai dengan struktur folder Anda
        };
    }
};
</script>
