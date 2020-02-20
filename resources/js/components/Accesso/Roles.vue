<template>
    <main class="form-group animated fadeIn">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Listado</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive table-responsive-sm table-responsive-md">
                                    <table class="table table-sm table-striped table-hover">
                                        <thead class="bg-info text-center text-uppercase text-white">
                                            <tr>
                                                <th>Roles</th>
                                                <th>Descripcion</th>
                                                <th>Estado</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <template>

                                        </template>
                                        <template>

                                        </template>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</template>

<script>
    export  default{
        data(){
            return{
                listaArray:[],
            }
        },
        computed:{
            isActived:function () {

            }
        },
        methods:{
            all(){
                axios.get("/admin/roles")
            }
        },
        mounted(){

        }
    }
</script>

<style scoped>

</style>
