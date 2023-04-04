<template>
    <div class="p-4 bg-yellow-100 text-yellow-800 rounded-md shadow-md fixed bottom-20 right-20" v-show="show">
            {{body}}
    </div>
</template>

<script>
export default {
    props:{
        message : String
    },
    data(){
        return {
            body: '',
            show:false
        }
    },
    created() {

        if (this.message ){
                this.body = this.message;
                this.show = true;
                setTimeout(()=>{
                    this.show = false;
                },2000);
        }
    }
}
</script>
