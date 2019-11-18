<template>
   <div>
      <form @submit.prevent="agregar" v-if="editarActivo">
          <h3> Actualizar </h3>
          <input type="text" class="form-control mb-2" placeholder="Tipo_usuario" v-model="nota.tipo_usuario"></input><br>

          <div class="col-xs-4">
              <select id="inputState" class="form-control" v-model="nota.estatus_usuario">
                    <option value="">Elige una opción de estatus</option>
                    <option value="Activo">Activo</option>
                    <option value="No-activo">No-activo</option>
                    <option value="Suspendido">Suspendido</option>
              </select>
          </div>

          <br> 
          <center>    
          <button class="btn btn-primary" type="submit"> Actualizar </button>
          </center>
      </form>  

      <form @submit.prevent="agregar" v-else>
          <h3> Agregar  </h3>
          <input type="text" class="form-control mb-2" placeholder="Tipo_usuario" v-model="nota.tipo_usuario"></input><br>

          <div class="col-xs-4">
              <select id="inputState" class="form-control" v-model="nota.estatus_usuario">
                    <option value="">Elige una opción de estatus</option>
                    <option value="Activo">Activo</option>
                    <option value="No-activo">No-activo</option>
                    <option value="Suspendido">Suspendido</option>
              </select>
          </div>

          <br> 
          <center>    
          <button class="btn btn-danger" type="submit"> Guardar </button>
          </center>
      </form>  
    </div>            
</template>

<script>
    export default {
       data(){
            return{
                notas: [],
                nota: {tipo_usuario: '', estatus_usuario: ''}
            }
       },
       created(){
            axios.get('/ejemploCrud/public/notas')
            .then(res => {
                this.notas = res.data;
            })
       },
       methods:{
            agregar(){

                //Validacion de formularios
                 if(this.nota.tipo_usuario.trim() === '' || this.nota.estatus_usuario.trim() === ''){
                    alert('Debes completar todos los campos antes de guardar');
                    return;
                  }

                //console.log(this.nota.nombre, this.nota.descripcion); 
                const params = {
                tipo_usuario: this.nota.tipo_usuario, 
                estatus_usuario: this.nota.estatus_usuario
                }
                //Accion para limpiar los campos

                this.nota.tipo_usuario = '';
                this.nota.estatus_usuario = '';

                console.log(params)
                
                axios.post('/ejemploCrud/public/notas', params)     
                    .then(res => {
                        this.notas.push(res.data)
                        console.log(res)
                    })
                    
            }
       }
    }
</script>

