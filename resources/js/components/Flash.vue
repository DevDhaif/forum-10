<template>
    <div class="p-4 bg-yellow-100 text-yellow-800 rounded-md shadow-md fixed bottom-20 right-20" v-show="show">
             {{ body }}
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
                this.flash(this.message);
        }
        window.flash = this.flash;
        window.hide = this.hide;
        // add event listener to window
        window.addEventListener('flash', (e) => {
            this.flash(e.detail.message);
        });
    },

    methods: {
        flash(message){
            this.show = true;
            this.body = message;
            this.hide();
            },
        hide(){
            setTimeout(()=>{
                this.show = false;
            },3000);
        }
    }
}
</script>
