<template>
    <div>
        <div class="w-full max-w-screen-xl mx-auto">
            <div class="flex justify-center">
                <div class="w-full max-w-md">
                    <div class="bg-white shadow-md rounded-lg px-3 py-2 mb-4">
                        <div class="block text-gray-700 text-lg font-semibold py-2 px-2">
                            Buscar un item
                        </div>
                        <div class="flex items-center bg-gray-200 rounded-md">
                            <div class="pl-2">
                                <svg class="fill-current text-gray-500 w-6 h-6" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 24 24">
                                    <path class="heroicon-ui"
                                        d="M16.32 14.9l5.39 5.4a1 1 0 0 1-1.42 1.4l-5.38-5.38a8 8 0 1 1 1.41-1.41zM10 16a6 6 0 1 0 0-12 6 6 0 0 0 0 12z" />
                                </svg>
                            </div>
                            <input
                                class="w-full rounded-md bg-gray-200 text-gray-700 leading-tight focus:outline-none py-2 px-2"
                                id="search" type="text" placeholder="Search teams or members"
                                v-model="textSearchItem" v-on:keyup="searchItem"
                            >
                        </div>
                        <div :class="hideListSearch" class="absolute z-40 bg-gray-100 rounded-sm w-1/4">
                            <div class="text-sm">
                                <div v-for="(search,index) in searchList" :key="index" @click="selectSearchItem(search)" class="flex justify-start cursor-pointer text-gray-700 hover:text-blue-400 hover:bg-blue-100 rounded-md px-2 py-2 my-2">
                                    <div class="flex-grow font-medium px-2">{{search.name}}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex z-1 py-2 md:p-4 text-center font-medium text-lg md:text-2xl">
            <div class="w-1/4 md:w-1/4 text-justify">Name</div>
            <div class="w-1/4 md:w-1/3">Year</div>
            <div class="w-1/4 md:w-1/6">Color</div>
            <div class="w-1/4 md:w-1/3">Pantone Value</div>
        </div>
        
        <div v-for="(item, index) in list" :key="index" class="flex md:px-4 py-2 text-center items-center justify-between">
            <div class="w-1/4 md:w-1/4 text-justify">{{item.name}}</div>
            <div class="w-1/4 md:w-1/3">{{item.year}}</div>
            <!--""-->
            <div class="w-1/4 md:w-1/6" :style="backColorItem(item.color)" >{{item.color}}</div>
            <div class="w-1/4 md:w-1/3">{{item.pantone_value}}</div>
        </div>
        
        
        <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
            <div class="flex-1 flex justify-between">
                <div>
                    <a @click="orderList()" class="bg-blue-700 hover:bg-blue-500 px-3 py-2 rounded-sm text-white cursor-pointer">Ordenar {{sort}}</a>
                    <a @click="reset()" class="bg-red-700 hover:bg-red-500 px-3 py-2 rounded-sm text-white cursor-pointer">Reset</a>
                </div>
            </div>
            <div class="flex-1 flex justify-between sm:hidden">
                <a @click="getList(current_page-1)" class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:text-gray-500 cursor-pointer">
                    Anterior
                </a>
                <a @click="getList(current_page+1)" class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:text-gray-500 cursor-pointer">
                    Siguiente
                </a>
            </div>
            <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                <div>
                    <p class="text-sm text-gray-700">
                    Mostrando
                    <span class="font-medium">1</span>
                    de
                    <span class="font-medium">{{paginate.per_page}}</span>
                    de
                    <span class="font-medium">{{paginate.total_items}}</span>
                    items
                    </p>
                </div>
                <div>
                    <nav class="relative z-0 inline-flex shadow-sm -space-x-px" aria-label="Pagination">
                    <a v-if="paginate.prev_page > 0" @click="getList(current_page-1)" class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 cursor-pointer">
                        <span class="sr-only">Previous</span>
                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                    </a>

                    <a v-for="(item, index) in paginate.total_pages" :key="index" @click="getList(index+1)" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 cursor-pointer">
                        {{index+1}}
                    </a>    
                    
                    <a v-if="paginate.next_page == paginate.total_pages" @click="getList(current_page+1)" class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 cursor-pointer">
                        <span class="sr-only">Next</span>
                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                        </svg>
                    </a>
                    </nav>
                </div>
            </div>
        </div>
    </div>    
</template>

<script>
    import axios from 'axios';

    export default {
        props:{
            
        },
        data(){
            return {
                list:[],
                searchList:[],
                paginate:{},
                current_page:null,
                sort:'',
                hideListSearch:'invisible',
                textSearchItem:''
            }
        },
        created(){
            this.getList(this.current_page)
        },
        computed:{
            
        },
        methods: {
            getList(index)
            {
                axios.get('/resource-list/'+index)
                .then(response => {
                    this.list=[];
                    response.data.list.forEach(element => {
                        this.list.push(element)
                    });
                    this.paginate = response.data.paginate;
                    this.current_page = this.paginate.current_page;
                    this.sort='DESC';    
                    this.orderList();
                })    
                .catch(error => {
                    console.log(error)
                })
            },
            
            orderList(){
                if(this.sort == 'DESC'){
                    this.list.sort(function(a, b) {
                        var nameA = a.name.toUpperCase(); // ignora upper and lowercase
                        var nameB = b.name.toUpperCase(); // ignora upper and lowercase
                        if (nameA < nameB) {
                            return 1;
                        }
                        if (nameA > nameB) {
                            return -1;
                        }
                        // nombres iguales
                        return 0;
                    });
                    this.sort='ASC';

                    return;
                }

                this.list.reverse();
                this.sort='DESC';
            },

            backColorItem(color){
                return "background-color:" +color;
            },

            reset(){
                this.list=[];
                this.textSearchItem=null;
                this.hideListSearch='invisible';
            },

            searchItem(){
                if(this.textSearchItem.length > 0){
                    axios.get('/resource-search/'+this.current_page+'/'+this.textSearchItem)
                    .then(response =>  {
                        this.hideListSearch='';
                        this.searchList=response.data;
                    })
                    .catch(error => {
                        console.log(error);
                    })
                }
                
                this.hideListSearch='invisible';
                this.getList(this.current_page);
            },

            selectSearchItem(item){
                this.hideListSearch='invisible';
                this.list=[];
                this.list.push(item)
            }
        },
        mounted() {
            console.log("component mounted");
        }   

    }
</script>
