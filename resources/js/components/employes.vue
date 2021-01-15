<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        Empleados&nbsp;&nbsp;&nbsp;&nbsp;

                        <button @click="modalTitle = 'Agregar Empleado'" type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addModal">
                            Agregar Empleado
                        </button>
                    </div>

                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Codigo</th>
                                <th>Nombre</th>
                                <th>Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="emp in employesArray" :key="emp.id">
                                <td>{{emp.code}}</td>
                                <td>{{emp.full_name}}</td>
                                <td>
                                    <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#addModal"
                                        @click="modalTitle = 'Editar Empleado', editEmployeModal(emp)" title="Editar">
                                        <i class="fa fa-pencil"></i>
                                    </button>
                                    <button type="button" class="btn btn-danger btn-sm"
                                        @click="deactivate(emp.id)" title="Desactivar">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                    <button type="button" class="btn btn-warning btn-sm"
                                        @click="deactivate(emp.id)" title="Editar">
                                        <i class="fa fa-power-off"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div id="addModal" class="modal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{modalTitle}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body container">
                    <div class="row">
                        <label for="code" class="col-sm-4">Código <span class="text-danger" v-if="!code">(*)</span></label><br>
                        <input id="code" type="text" v-model="code" class="form-control col-sm-7">
                    </div>
                    <br>
                    <div class="row">
                        <label for="name" class="col-sm-4">Nombre <span class="text-danger" v-if="name.length<=4">(*)</span></label><br>
                        <input id="name" type="text" v-model="name" class="form-control col-sm-7">
                    </div>
                    <br>
                    <div class="row">
                        <label for="first_name" class="col-sm-4">Apellido Paterno  <span class="text-danger" v-if="first_name.length<=4">(*)</span></label>
                        <input id="first_name" type="text" v-model="first_name" class="form-control col-sm-7">
                    </div>
                    <br>
                    <div class="row">
                        <label for="second_first_name" class="col-sm-4">Apellido Materno</label>
                        <input id="second_first_name" type="text" v-model="second_first_name" class="form-control col-sm-7">
                    </div>
                    <br>
                    <div class="row">
                        <label for="email" class="col-sm-4">
                            Correo Electrónico <span class="text-danger" v-if="!/^[-\w.%+]{1,64}@(?:[A-Z0-9-]{1,63}\.){1,125}[A-Z]{2,63}$/i.test(email)">(*)</span>
                        </label>
                        <input id="email" type="mail" v-model="email" class="form-control col-sm-7">
                    </div>
                    <br>
                    <div class="row">
                        <label for="contract_type" class="col-sm-4">Tipo de Contrato <span class="text-danger" v-if="contract_type.length<=4">(*)</span></label>
                        <input id="contract_type" type="text" v-model="contract_type" class="form-control col-sm-7">
                    </div>
                    <br>
                    <div class="row">
                        <label for="status" class="col-sm-4">Estatus</label>
                        <select v-model="status" class="form-control col-sm-7">
                            <option value="1">Activo</option>
                            <option value="0">Inactivo</option>
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <br>
                            <div v-for="error in errorsArray" :key="error" class="alert alert-warning" role="alert">
                                {{error}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-primary" @click="validateForm()">Guardar</button>
                    <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Cerrar</button>
                </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Swal from 'sweetalert2'
    export default {
        data(){
            return{
                employesArray:[],
                code:'',
                name:'',
                first_name:'',
                second_first_name:'',
                email:'',
                contract_type:'',
                status:1,
                modalTitle:'',
                sName:'',
                errorsArray:[],
                alertSuccsess:function(title){
                    Swal.fire({
                        type:'successs',
                        title:title,
                        timer:500,
                    })
                }
            }
        },
        methods:{
            getEmployes(){
                axios.get('/employes/get?name='+this.sName).then(
                    response => this.employesArray = response.data
                ).catch(error => console.log(error));
            },
            addEmploye(){
                
                if(this.validateForm()) return false;

                axios.post('/employes/storage',{
                    'code':this.code,
                    'name':this.name,
                    'first_name':this.first_name,
                    'second_first_name':this.second_first_name,
                    'email':this.email,
                    'contract_type':this.contract_type,
                    'status':this.status,
                }).then(
                    response => {
                        console.log(response.data);

                        this.alertSuccsess('Guardado correctamente');

                        this.code='';
                        this.name='';
                        this.first_name='';
                        this.second_first_name='';
                        this.email='';
                        this.contract_type='';
                        this.status='';
                    }
                ).catch(error => console.log(error));
            },
            editEmployeModal(employee){
                
                this.code= employee.code;
                this.name= employee.name;
                this.first_name= employee.first_name;
                this.second_first_name= employee.second_first_name;
                this.email= employee.email;
                this.contract_type= employee.contract_type;
                this.status= employee.status;

            },
            editEmploye(){
                
                axios.put('/employes/update?id='+this.genericId
                    +'&code='+this.code
                    +'&name='+this.name
                    +'&first_name='+this.first_name
                    +'&second_first_name='+this.second_first_name
                    +'&email='+this.email
                    +'&contract_type='+this.contract_type
                    +'&status='+this.status
                ).then(
                    response => {
                        console.log(response.data);

                        this.code='';
                        this.name='';
                        this.first_name='';
                        this.second_first_name='';
                        this.email='';
                        this.contract_type='';
                        this.status='';
                    }
                ).catch(error => console.log(error));
            },
            deactivate(id){
                Swal.fire({
                    type: 'warning',
                    title: 'Desactivar?',
                    text: 'Este cambio no se puede revertir',
                    showCancelButton: true,
                    confirmButtonText: 'Si',
                    cancelButtonText: 'Cancelar',
                }).then(
                    result => {
                        if(result.value){
                            axios.put('/employes/deactivate').then(
                                response => console.log(response.data)
                            ).catch(error => console.log(error));
                        }
                    }
                );
            },
            async validateForm(){
                
                let emailRegEx = /^[-\w.%+]{1,64}@(?:[A-Z0-9-]{1,63}\.){1,125}[A-Z]{2,63}$/i;
                this.errorsArray = [];
                
                if(this.code.length <= 0) this.errorsArray.push('ingrese un código valido');
                if(this.name.length <= 3) this.errorsArray.push('ingrese un nombre valido');
                if(this.first_name.length <= 3) this.errorsArray.push('ingrese un apellido paterno valido');
                if(!emailRegEx.test(this.email)) this.errorsArray.push('Ingrese un correo valido');
                if(this.contract_type.length <= 0) this.errorsArray.push('ingrese un tipo de contrto valido');
                
                let registeredCode = await this.getEmployeCode();

                if(registeredCode) this.errorsArray.push('El código ya fue registrado');

                if(this.errorsArray.length == 0 )
                    return false;
                else
                    return true;
                

               /*
               let exist = false;

                axios.get('/employes/get/code?code='+this.code).then(
                    response => {exist =  response.data; console.log(response.data);}
                ).then(() => {

                    let emailRegEx = /^[-\w.%+]{1,64}@(?:[A-Z0-9-]{1,63}\.){1,125}[A-Z]{2,63}$/i;
                    this.errorsArray = [];
                    
                    if(exist) this.errorsArray.push('El código ya fue registrado');
                    if(this.code.length <= 0) this.errorsArray.push('ingrese un código valido');
                    if(this.name.length <= 3) this.errorsArray.push('ingrese un nombre valido');
                    if(this.first_name.length <= 3) this.errorsArray.push('ingrese un apellido paterno valido');
                    if(!emailRegEx.test(this.email)) this.errorsArray.push('Ingrese un correo valido');
                    if(this.contract_type.length <= 0) this.errorsArray.push('ingrese un tipo de contrto valido');

                    if(this.errorsArray.length == 0 ) addEmploye();

                }).catch(error => console.log(error));
                */
            },
            //getEmployeCode(){
            getEmployeCode:async()=>{

                let me = this;

                let exist = false;
                axios.get('/employes/get/code?code='+me.code).then(
                    response => {exist =  response.data; console.log(response.data);}
                ).catch(error => console.log(error));

                return exist;
            },
        },
        mounted() {
            this.getEmployes();
        }
    }
</script>
