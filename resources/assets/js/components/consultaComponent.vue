<template>
  <div>
    <div class="modal-content"> <br>
       <form @submit.prevent="editarNota(nota)" v-if="editarActivo">
          <h5 class="text-center"> Actualizar Información <i> (Tipos de Usuarios) </i> </h5> <br>
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
          <button class="btn btn-danger" type="submit" @click="cancelarEdicion()"> Cancelar </button>
          </center> <br>
      </form>  

      <form @submit.prevent="agregar" v-else>
          <h4 class="text-center"> Formulario Tipos de Usuarios  </h4> <br>
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
          </center><br>
      </form>  
    </div>

    <br>

    <div>
      <table class="table table-striped">
        <thead>
            <tr>
              <th scope="col"> Tipo de Usuario </th>
              <th scope="col"> Estatus de Usuario </th>
              <th scope="col"> Fecha de Registro</th>
            </tr>
            <tr v-for="(item, index) in notas" :key="index">
              <td>{{item.tipo_usuario}}</td>
              <td>{{item.estatus_usuario}}</td>
              <td> <span class="badge badge-primary"> {{item.created_at}} </span> </td>
              <td><button class="btn btn-primary" @click="editarFormulario(item)">Actualizar</button></td>
              <td><button class="btn btn-danger" data-toggle="modal" data-target="#exampleModal">Eliminar</button></td>
            </tr>
        </thead>
        <!-- Inicia Modal de eliminacion -->
          <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  ¿Estas seguro(a) de eliminar este registro?
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-danger" @click="eliminarNota(item, index)">Eliminar</button>
                </div>
              </div>
            </div>
          </div>   

          <nav aria-label="Page navigation example">
            <ul class="pagination">
              <li class="page-item"><a class="page-link" href="#">Previous</a></li>
              <li class="page-item"><a class="page-link" href="#">1</a></li>
              <li class="page-item"><a class="page-link" href="#">2</a></li>
              <li class="page-item"><a class="page-link" href="#">3</a></li>
              <li class="page-item"><a class="page-link" href="#">Next</a></li>
            </ul>
          </nav>
        <!-- Finaliza Modal -->
      </table>

      <center>
        <button type="button" class="btn btn-danger"> Exportar PDF </button>
        <button type="button" class="btn btn-success"> Exportar EXCEL </button>
      </center>

      <br>

    </div>   
  </div>            
</template>

<script>
    export default {
       data(){
            return{
                notas: [],
                nota: {tipo_usuario: '', estatus_usuario: ''},
                editarActivo: false
            }
       },
       created(){
            axios.get('/ejemploCrud/public/notas')
            .then(res => {
                this.notas = res.data;
            })
       },
       methods:{
            editarFormulario(item){
              this.editarActivo = true;
              this.nota.tipo_usuario = item.tipo_usuario;
              this.nota.estatus_usuario = item.estatus_usuario;
              this.nota.id = item.id;

            },
            editarNota(item){
              const params = {tipo_usuario: item.tipo_usuario, estatus_usuario: item.estatus_usuario};
              axios.put(`/ejemploCrud/public/notas/${item.id}`, params)
                .then(res =>{

                  this.editarActivo = false;
                  const index = this.notas.findIndex(
                    notaBuscar => notaBuscar.id === res.data.id)

                    this.notas[index] = res.data;

                    this.nota = {tipo_usuario: '', estatus_usuario: ''}

                     axios.get('/ejemploCrud/public/notas')
                      .then(res => {
                          this.notas = res.data;
                      })
                })
            },
            cancelarEdicion(){
              this.editarActivo = false;
              this.nota = {tipo_usuario: '', estatus_usuario: ''}
            },
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
            },
            eliminarNota(item, index){
              axios.delete(`/ejemploCrud/public/notas/${item.id}`)
                .then(()=>{
                    this.notas.splice(index, 1);
                })

            }
       }
    }
</script>

