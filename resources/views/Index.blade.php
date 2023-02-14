<!doctype html>
<html lang="en">
  <head>
    <title>Index</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <script src="{{asset("js/vue.global.js")}}"></script>
    <script src="{{asset("js/axios.min.js")}}"></script>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  </head>
  <body>
<div class="container" id="app">
<div class="col-md-6 offset-3">
    <h1 class="text-center">Enter Your Car Details</h1>

    {{-- BS Alert --}}

    <div class="modal-body">
        <div class="alert alert-warning" role="alert" v-for="error in errors" id="err-title" :key="error">
            <i class="mdi mdi-block-helper mr-2"></i>
            <span>@{{error}}</span>
        </div>
        {{-- BS Alert End --}}

    <div class="form-group">
        <input type="text" class="form-control" v-model="item.car_name" name="" id="" placeholder="Enter Car Name">
    </div>
      <div class="form-group">
          <input type="number" class="form-control" v-model="item.car_price" name="" id="" placeholder="Enter Car Price">
        </div>
      <div class="form-group">
          <input type="text" class="form-control" v-model="item.car_model" name="" id="" placeholder="Enter Car Model">
        </div>
      <button class="btn btn-primary" @click="save" >Save</button>
</div>
</div>
<table class="table">
    <thead>
        <tr>
            <th>Id</th>
            <th>Car Name</th>
            <th>Car Price</th>
            <th>Car Model</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <tr v-for="list in cars">
            <td>@{{list.id}}</td>
            <td>@{{list.car_name}}</td>
            <td>@{{list.car_price}} .$</td>
            <td>@{{list.car_model}}</td>
            <td><button class="btn btn-success" data-toggle="modal" data-target="#modelId" @click="edit(list)">Edit</button>
            &nbsp;    <button class="btn btn-danger" type="button" @click="delData(list.id)">X</button>
            </td>
        </tr>
    </tbody>
</table>

<!-- Modal -->
<div class="modal fade" id="modelId" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
                <div class="modal-header">
                        <h5 class="modal-title">Update Cars Details</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                    </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="form-group">
                        <input type="text" class="form-control" v-model="item.car_name_u" name="" id="" placeholder="Enter Car Name">
                    </div>
                      <div class="form-group">
                          <input type="number" class="form-control" v-model="item.car_price_u" name="" id="" placeholder="Enter Car Price">
                        </div>
                      <div class="form-group">
                          <input type="text" class="form-control" v-model="item.car_model_u" name="" id="" placeholder="Enter Car Model">
                        </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" @click="update()">Save</button>
            </div>
        </div>
    </div>
</div>
<script src="{{asset("js/jQuery.js")}}"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</div>
<script>

   let App = ({
    created(){
this.LoadData();
    },
    data(){
    return {
        errors:[],
        cars:[],
        item:{
            car_name: "",
            car_price:"",
            car_model:""
        },
    }
    },
methods:{
        LoadData(){
            axios.get("/show").then((response) => {
                    this.cars = response.data.cars;
                })
        },
    save(){
        this.errors = [];
        if(!this.item.car_name){
            this.errors.push("Car Name Is Requied");
        }
        if(!this.item.car_price){
            this.errors.push("Car Price Is Requied");
        }
        if(!this.item.car_model){
            this.errors.push("Car Model Is Requied");
        }
        if(this.errors.length == 0){
            axios.post('/Index',this.item).then((response) => {
            if(response.status == 200){
                alert("Data Added Successfully");
                this.LoadData();
            }}).catch((response) => {
            console.log(response);
        })
        }
    },
    edit(list){
        this.item = {
            id:list.id,
            car_name_u: list.car_name,
            car_price_u:list.car_price,
            car_model_u:list.car_model
        }
    },
    update(){
        axios.post('/update',this.item).then((response)=> {
            if(response.status == 200){
                $("#modelId").modal("hide");
                this.LoadData();
            }
        })
    },
    delData(id){
        if(confirm("Are Sure To Delete")){
            axios.get("/delete/"+id).then((response)=>{
    if(response.status == 200){
        this.LoadData();
    }
})
        }
    }

},
 })
   Vue.createApp(App).mount('#app');
   
</script>
  </body>
</html>