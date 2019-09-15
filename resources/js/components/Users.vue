<template>
    <div class="container">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Users Table</h3>

                <div class="card-tools">
                  <button class="btn btn-primary" data-toggle="modal" @click="newModal">Add &nbsp;<i class="fas fa-user-plus fa-fw"></i></button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                  <tbody>
                    <tr>
                      <th>ID</th>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Register</th>
                      <th>Modify</th>
                    </tr>
                  
                    <tr v-for="user in users" :key="user.id">
                      <td>{{user.id}}</td>
                      <td>{{user.name|upText}}</td>
                      <td>{{user.email}}</td>
                      <td>{{user.created_at| myDate}}</td>
                      <td>
                          <a href="#" @click="editModal(user)">
                              <i class="fa fa-edit text-grey"></i>
                          </a>
                          -
                          <a href="#" @click="deleteUsers(user.id)">
                              <i class="fa fa-trash text-soft-red"></i>
                          </a>
                      </td>
                    </tr>

                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
        <!-- Modal -->
            <div class="modal fade" id="newModal" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
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
            </div>
    </div>
</template>

<script>
    export default {
        data(){
            return{
              editmode : false,
              users :{},
              form: new Form({
                    id :'',
                    name :'',
                    email:'',
                    password:''
              })
            }
        },

        methods:{
          newModal(){
            this.editmode = false;
            this.form.reset();
            $('#newModal').modal('show');
          },

          editModal(user){
            this.editmode = true;
            this.form.reset();
            $('#newModal').modal('show');
            this.form.fill(user);
          },

          updateUser(){
            //Console.log('edit data');
            this.$Progress.start();
            this.form.put('api/user/'+this.form.id)
            .then(()=>{
              Fire.$emit('RefreshTable');
                    $('#newModal').modal('hide')
                    toast.fire({
                      type: 'success',
                      title: 'User Create in successfully'
                    })
                    this.$Progress.finish();
            })
            .catch(()=>{
              toast.fire({
                        type: 'error',
                        title: 'Ooops Update Fail, Somethings error'
                      })
            this.$Progress.fail();
            });

          },

          deleteUsers(id){
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: 'rgb(206, 206, 206)',
                confirmButtonText: 'Yes, delete it!'
              }).then((result) => {


                //send request to server
                if (result.value) {
                    this.$Progress.start();
                    this.form.delete('api/user/'+id)
                    .then(()=>{
                      Swal.fire(
                        'Deleted!',
                        'Your file has been deleted.',
                        'success'
                      )
                      Fire.$emit('RefreshTable');
                    this.$Progress.finish();                    
                  }).catch(()=>{
                      Swal.fire(
                        'Failed!',
                        'There was somethng wrongs.',
                        'warning'
                      )
                  });
                
                }
              })
          },

          loadUsers(){
            axios.get("api/user").then(({data}) => (this.users = data.data));
          },

          createUser()
          {
            this.$Progress.start();
            this.form.post('api/user')


                .then(()=>{
                    Fire.$emit('RefreshTable');
                    $('#newModal').modal('hide')
                    toast.fire({
                      type: 'success',
                      title: 'User Create in successfully'
                    })
        
                    this.$Progress.finish();
                    

                })
                .catch(()=>{
                    toast.fire({
                        type: 'error',
                        title: 'Ooops Somethings error'
                      })
                })
          }
        },

        created() {
            this.loadUsers();
            Fire.$on('RefreshTable',()=>{
              this.loadUsers();
            });
            //setInterval(()=>this.loadUsers(), 3000);
        }
    }
</script>
