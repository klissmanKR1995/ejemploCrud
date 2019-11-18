<template>
  <div>
    <div class="modal-content"> <br>
       <form @submit.prevent="editarNota(nota)" v-if="editarActivo">
          <h5 class="text-center"> Actualizar Información <i> (Juzgados) </i> </h5> <br>
          <input type="text" class="form-control mb-2" placeholder="Nombre_Juzgado" v-model="nota.nombre_juzgado"></input><br>

          <div class="col-xs-4">
              <select id="inputState" class="form-control" v-model="nota.estatus_juzgado">
                    <option value="">Elige una opción de estatus</option>
                    <option value="Activo">Activo</option>
                    <option value="No-activo">No-activo</option>
                    <option value="Suspendido">Suspendido</option>
              </select>
          </div>


          <br>

          <div class="form-group">
            <select id="distrito_id" class="form-control" v-model="nota.distrito_id">
              <option value="">Distrito Perteneciente</option>
              <option v-for="(item, index) in distritos" :value="item.id">{{item.nombre_distrito}}</option>
            </select>
          </div>

          <center>    
          <button class="btn btn-primary" type="submit"> Actualizar </button>
          <button class="btn btn-danger" type="submit" @click="cancelarEdicion()"> Cancelar </button>
          </center> <br>
      </form>  

      <form @submit.prevent="agregar" v-else>
          <h4 class="text-center"> Formulario Juzgados  </h4> <br>
          <input type="text" class="form-control mb-2" placeholder="Nombre_Juzgado" v-model="nota.nombre_juzgado"></input><br>
          <div class="col-xs-4">
            <select id="inputState" class="form-control" v-model="nota.estatus_juzgado">
                  <option value="">Elige una opción de estatus</option>
                  <option value="Activo">Activo</option>
                  <option value="No-activo">No-activo</option>
                  <option value="Suspendido">Suspendido</option>
            </select>
          </div>


          <br> 

          <div class="form-group">
            <select id="distrito_id" class="form-control" v-model="nota.distrito_id">
              <option value="">Distrito Perteneciente</option>
              <option v-for="(item, index) in distritos" :value="item.id">{{item.nombre_distrito}}</option>
            </select>
          </div>

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
              <th scope="col"> Nombre Juzgado </th>
              <th scope="col"> Estatus Juzgado </th>
              <th scope="col"> Distrito Perteneciente </th>
              <th scope="col"> Fecha de Registro</th>
            </tr>
            <tr v-for="(item, index) in notas" :key="index">
              <td>{{item.nombre_juzgado}}</td>
              <td>{{item.estatus_juzgado}}</td>
              <td>{{item.distrito_id}}</td>
              <td> <span class="badge badge-primary"> {{item.created_at}} </span> </td>
              <td><button class="btn btn-primary" @click="editarFormulario(item)">Actualizar</button></td>
              <td><button class="btn btn-danger" @click="eliminarNota(item, index)">Eliminar</button></td>
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
                  <button type="button" class="btn btn-danger">Eliminar</button>
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
                distritos: [],
                notas: [],
                nota: {nombre_juzgado: '', estatus_juzgado: '', distrito_id: ''},
                editarActivo: false
            }
       },
       created(){
            axios.get('/ejemploCrud/public/juzgados')
            .then(res => {
                this.notas = res.data;
            }),
            axios.get('/ejemploCrud/public/distritos')
            .then(res => {
                this.distritos = res.data;
            })
       },
       methods:{
            editarFormulario(item){
              this.editarActivo = true;
              this.nota.nombre_juzgado = item.nombre_juzgado;
              this.nota.estatus_juzgado = item.estatus_juzgado;
              this.nota.distrito_id = item.distrito_id;
              this.nota.id = item.id;

            },
            editarNota(item){
              const params = {nombre_juzgado: item.nombre_juzgado, estatus_juzgado: item.estatus_juzgado, distrito_id: item.distrito_id };
              axios.put(`/ejemploCrud/public/juzgados/${item.id}`, params)
                .then(res =>{

                  this.editarActivo = false;
                  const index = this.notas.findIndex(
                    notaBuscar => notaBuscar.id === res.data.id)

                    this.notas[index] = res.data;

                    this.nota = {nombre_juzgado: '', estatus_juzgado: '', distrito_id: ''}

                     axios.get('/ejemploCrud/public/juzgados')
                      .then(res => {
                          this.notas = res.data;
                      })
                })
            },
            cancelarEdicion(){
              this.editarActivo = false;
              this.nota = {nombre_juzgado: '', estatus_juzgado: '', distrito_id: ''}
            },
            agregar(){
                  console.log(this.nota.nombre_juzgado);
                  console.log(this.nota.estatus_juzgado);
                  console.log(this.nota.distrito_id);
                //Validacion de formularios
                 if(this.nota.nombre_juzgado.trim() === '' || this.nota.estatus_juzgado.trim() === ''){
                    alert('Debes completar todos los campos antes de guardar');
                    return;
                  }

                //console.log(this.nota.nombre, this.nota.descripcion); 
                const params = {
                nombre_juzgado: this.nota.nombre_juzgado, 
                estatus_juzgado: this.nota.estatus_juzgado,
                distrito_id: this.nota.distrito_id
                }
                //Accion para limpiar los campos

                this.nota.nombre_juzgado = '';
                this.nota.estatus_juzgado = '';
                this.nota.distrito_id = '';

                console.log(params)
                
                axios.post('/ejemploCrud/public/juzgados', params)     
                    .then(res => {
                        this.notas.push(res.data)
                        console.log(res)
                    })     
            },
            eliminarNota(item, index){
              axios.delete(`/ejemploCrud/public/juzgados/${item.id}`)
                .then(()=>{
                    this.notas.splice(index, 1);
                })

            }
       }
    }
</script>

