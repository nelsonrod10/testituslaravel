<template>
    <div>
        <div v-if="isRunning" v-cloak class="text-center">
            <h1 class="text-xl font-semibold mb-3">DEMASIADOS INTENTOS</h1>
            <div class="text-sm mb-2">Ha tenido 3 intentos fallidos de ingresar</div>
            <div class="text-sm mb-3">Puede intentar nuevamente en: </div>
            <div class="text-3xl font-bold text-red-600">
                {{ pretty_time }}
            </div>       
        </div>
        <div v-else class="text-center items-center">
            <h1 class="text-xl font-semibold mb-3">LOGIN DISPONIBLE</h1>
            <a :href="route_login" class="bg-green-600 hover:bg-green-500 w-full justify-center rounded-md border border-transparent shadow-sm px-4 py-2 text-base font-medium text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                Intentar ingresar nuevamente
            </a>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';

    export default {
        props:{
            route_login:{
                type:String
            }
        },
        data(){
            return {
                time:0,
                isRunning: false,
                timer:null,
            }
        },
        computed:{
            pretty_time: function(){
                let time = this.time / 60
                let minutes = parseInt(time)
                let seconds = Math.round((time - minutes) * 60)
                if (minutes < 10) {
					minutes = "0"+minutes
                }
                if (seconds < 10) {
                        seconds = "0"+seconds
                }
                return minutes+":"+seconds
            }
        },
        created(){
            this.setTime();
        },
        
        methods: {
            setTime () {
                axios.get('get-timer').then(response => {
                    this.time = parseInt(response.data);
                    this.start();
                })    
                .catch(error => {
                    console.log(error)
                })
            },
            start () {
                this.isRunning = true
                
                if (!this.timer) {
                    this.timer = setInterval( () => {
                        if (this.time > 0) {
                            this.time--
                            this.updateTime()
                        } else {
                            this.reset()
                        }
                    }, 1000 )
                }
                
            },
            stop () {
                axios.get('reset-timer').then(response => {
                    this.isRunning = false
                    this.timer = null
                })    
                .catch(error => {
                    console.log(error)
                })
            },
            reset () {
                this.stop()
                this.time = 0
            },          

            updateTime () {
                axios.get('update-timer/').then(response => {
                })
            }
            
        },
        mounted() {
            console.log('Component mounted.')
        }

    }
</script>
