new Vue({
    el:"#app-login",
    data:{
        usuario:'',
        password:'',
    },
    methods:{
        login:function () {
            axios.post("/iniciar-sesion",{
                usuario:this.usuario,
                password:this.password,
            }).then(response=>{
               swal({
                   titel:"Has Iniciado Sesión!",
                   text:"Datos Correctos!",
                   icon:"success",
                   closeOnClickOutside:false,
                   closeOnEsc:false,
               }).then(select=>{
                   if(select){
                      this.reload("/reload");
                   }
               });
            }).catch(error=>{

                if(error.response.status === 422){
                    console.clear();
                }

                let er = error.response.data.errors;
                let mensaje = "Error no Identificado";
                if(er.hasOwnProperty('usuario')){
                    mensaje  = er.usuario[0];
                }else if(er.hasOwnProperty('password')){
                    mensaje = er.password[0];
                }else if(er.hasOwnProperty('login')){
                    mensaje  =er.login[0];
                }
                swal("Error", mensaje,"error");
            })
        },
        reload(url) {
            axios.get(url)
                .then(r=>{
                    location.href = r.data;
                }).catch(e=>{
                    console.log(e);
            });
        }
    }
});
