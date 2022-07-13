@extends("layouts.admin")
@section('title','Product Import | ')
@section('breadcrumb')
<li class="breadcrumb-item active">{{__("Product Import")}}</li>
@endsection
@section('css')
  
@endsection
@section('js')

<script>
  
  $(function () {
    
  });

</script>
@endsection
@section("content")
<div class="container-fluid">
    @include('flash-message')
    <div class="card">
        <div class="card-header">
            
            <div class="row">
            
                <div class="col-md-10">
                    <h4 class="m-0">{{__("Product Import")}}</h4>
                </div>
            </div>
        </div>
        <div class="card-body">
            <a href="{{ asset('files/ProductCSV.xlsx') }}" class="btn btn-md btn-dark"> Download Example For xls/csv File</a>
			 <hr>
            <form id="demo-form2" method="post" enctype="multipart/form-data" action="{{url('admin/products/import')}}" data-parsley-validate class="form-horizontal form-label-left">
            {{csrf_field()}}
                <div class="mt-3">
                    <div class="form-group col-md-6">
                        <label for="file">Choose your xls/csv File :</label>
                        <input required="" type="file" name="file" class="form-control">
                        @if ($errors->has('file'))
                            <span class="invalid-feedback text-danger" role="alert">
                                <strong>{{ $errors->first('file') }}</strong>
                            </span>
                        @endif
                        
                        
                    </div>
                    <div class="col-md-12">
                    <button type="submit" class="btn btn-md bg-dark">Import</button>
                    </div>
                </div>
                
                
            </form>

            <div class="col-md-12 mt-5">
                <div class="box-header with-border">
                    <h4 class="box-title">Instructions</h4>
                </div>

                <div class="box-body">
                    <p><b>Follow the instructions carefully before importing the file.</b></p>
                    <p>The columns of the file should be in the following order.</p>

                    <table class="table table-striped ">
                        <thead>
                            <tr>
                                <th>Column No</th>
                                <th>Column Name</th>
                                <th>Description</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr>
                                <td>1</td>
                                <td><b>Product Name</b> (Required)</td>
                                <td>Name of product</td>

                                
                            </tr>
                            <tr>
                                <td>2</td>
                                <td><b>Price</b> (Required)</td>
                                <td>Your Product price [<b>Note:</b> Price must entered in this format eg. 50000 (No comma and character).]</td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td><b>Old Price</b></td>
                                <td>Old Product price to show offer [<b>Note:</b> Price must entered in this format eg. 50000 (No comma and character).]</td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td><b>Category</b> (Required)</td>
                                <td>Name of category</td>

                                
                            </tr>

                            <tr>
                                <td>5</td>
                                <td><b>Subcategory</b> (Required)</td>
                                <td>Name of subcategory</td>
                            </tr>

                            <tr>
                                <td>6</td>
                                <td><b>Childcategory</b> (Optional)</td>
                                <td>Name of childcategory</td>
                            </tr>

                            <tr>
                                <td>7</td>
                                <td><b>Product Description</b> (Optional)</td>
                                <td>Detail of your product</td>
                            </tr>
                            <tr>
                                <td>8</td>
                                <td><b>Product Specification</b> (Optional)</td>
                                <td>Detail of your product</td>
                            </tr>
                            <tr>
                                <td>9</td>
                                <td><b>Product Quantity</b> (Required)</td>
                                <td>Quantity of your product</td>
                            </tr>

                            <tr>
                                <td>10</td>
                                <td><b>Tax</b> (Required)</td>
                                <td>Enter 0 if no tax want to be added</td>
                            </tr>


                            <tr>
                                <td>11</td>
                                <td><b>Cancel Available</b> (Required)</td>
                                <td><p>Enable Cancel available on your product.</p>
                                <p>(Yes = 1, No = 0)</p>
                                </td>
                            </tr>

                            <tr>
                                <td>12</td>
                                <td><b>Featured</b> (Required)</td>
                                <td><p>Want to feature product.</p>
                                <p>(Yes = 1, No = 0)</p>
                                </td>
                            </tr>

                           
                            <tr>
                                <td>13</td>
                                <td><b>Status</b> (Required)</td>
                                <td><p>Product is active or not.</p>
                                <p>(Yes = 1, No = 0)</p>
                                </td>
                            </tr>

                            <tr>
                                <td>14</td>
                                <td><b>Return Available</b> (Required)</td>
                                <td><p>Enable Return available on your product.</p>
                                <p>(Yes = 1, No = 0)</p>
                                </td>
                            </tr>

                            <tr>
                                <td>15</td>
                                <td><b>Return Policy</b> (Required if)</td>
                                <td>If you set return available = 1, than enter return policy name (must created before entering name here).</td>
                            </tr>

                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
     
        
@endsection
