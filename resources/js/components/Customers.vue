<template>
    <div class="container">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">customer Table</h3>

                <div class="card-tools">
                  <button class="btn btn-primary" data-toggle="modal">Add &nbsp;<i class="fas fa-user-plus fa-fw"></i></button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                  <tbody>
                    <tr>
                      <th>ID</th>
                      <th>NIK</th>
                      <th>Name</th>
                      <th>Jenis Kelamin</th>
                      <th>Tempat Lahir</th>
                      <th>Tgl Lahir</th>
                      <th>Phone</th>
                      <th>Alamat</th>
                      <th>Modify</th>
                    </tr>
                  
                    <tr v-for="customer in customers.data" :key="customer.id">
                      <td>{{customer.id}}</td>
                      <td>{{customer.nik}}</td>
                      <td>{{customer.name|upText}}</td>
                      <td>{{customer.gender}}</td>
                      <td>{{customer.birth_place}}</td>
                      <td>{{customer.birth|myDate}}</td>
                      <td>{{customer.phone}}</td>
                      <td>{{customer.alamat}}</td>
                      <td>
                          <a href="#">
                              <i class="fa fa-edit text-grey"></i>
                          </a>
                          -
                          <a href="#">
                              <i class="fa fa-trash text-soft-red"></i>
                          </a>
                      </td>
                    </tr>

                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                <pagination :data="customers" 
                @pagination-change-page="getResults"></pagination>

              </div>
            </div>
            <!-- /.card -->
          </div>
        </div>
        <!-- Modal -->
            <!-- <div class="modal fade" id="newModal" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 v-show="!editmode" class="modal-title" id="addNewLabel">Add New User</h5>
                    <h5 v-show="editmode" class="modal-title" id="addNewLabel">Edit User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form @submit.prevent="editmode ? updateUser() : createUser()">
                  <div class="modal-body">
                          <div class="form-group">
                              <input v-model="form.name" type="text" name="name"
                                placeholder="Name"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                              <has-error :form="form" field="name"></has-error>
                          </div>
                          <div class="form-group">
                              <input v-model="form.email" type="text" name="email"
                                placeholder="Email Addrees"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('email') }">
                              <has-error :form="form" field="email"></has-error>
                          </div>

                          <div class="form-group">
                            <label>User Type</label>
                            <select name="type" v-model="form.type" id="type"
                            class="form-control" :class="{'isInvalid': form.errors.has('type')}">
                              <option value="">Select User Role</option>
                              <option value="admin">Admin</option>
                              <option value="user">User</option>
                              <option value="author">Author</option>
                            </select>
                            <has-error :form="form" field="type"></has-error>

                          </div>

                          <div v-show="!editmode" class="form-group">
                              <input v-model="form.password" type="password" name="password"
                                placeholder="Password"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('password') }">
                              <has-error :form="form" field="password"></has-error>
                          </div>
                  </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                      <button v-show="!editmode" type="submit" class="btn btn-primary" >Save</button>
                      <button v-show="editmode" type="submit" class="btn btn-primary" >Update</button>
                      
                  </div>
                </form>
                </div>
            </div>
            </div> -->
    </div>
</template>

<script>
    export default {
        data(){
            return{
              //editmode : false,
              customers :{},
              form: new Form({
                    id :'',
                    nik :'',
                    name :'',
                    gender:'',
                    birth_place:'',
                    birth:'',
                    phone :'',
                    alamat :''
              })
            }
        },

            methods:{
                loadCustomers(){
                this.$Progress.start();
                axios.get("api/customer").then(({data}) => (this.customers = data));
                this.$Progress.finish();
                },

                getResults(page = 1) {
                axios.get('api/customer?page=' + page)
                .then(response => {
                    this.customers = response.data;
                });
                },

            },

        created() {
            this.loadCustomers();
            Fire.$on('RefreshTable',()=>{
              this.loadCustomers();
            });
            //setInterval(()=>this.loadUsers(), 3000);
        }
    }

    
</script>
