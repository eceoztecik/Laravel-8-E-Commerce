@extends('layouts.admin')

@section('title', 'Category List')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h3>Categories</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Category</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">

            <!-- Default box -->
            <div class="card">
                <div class="card-header">
                    <a href="{{route('admin_category_add')}}"  type="button" class="btn btn-block btn-info" style="width: 200px">Add Category</a>
                </div>
                <div class="card">

                    <!-- /.card-header -->
                    <div class="card-body">
                        #  $parentCategories = Category::where('parent_id', '=', 0)->with('children')->get();
                        @foreach($parentCategories as $rs)
                            <ul>
                                <li><a href="#">{{$rs->title}}</a></li>
                                @if(count($rs->subcategory))
                                    @include('admin.categorytree',['subcategories' => $rs->subcategory])
                                @endif
                            </ul>
                        @endforeach

                        <select>
                            @foreach($parentCategories as $categories)
                                <optgroup label="{{ $categories->title }}">
                                    @foreach($categories->children as $category)
                                        <option value="{{ $category->id }}">{{ $category->title }}</option>
                                    @endforeach
                                </optgroup>
                            @endforeach
                        </select>

                         Son ??al????an kod a????lan kutu select
                        $datalist = Category::with('children')->get();
                        <select class="form-control select2" name="parent_id" style="width: 100%;">
                            <option value="0" selected="selected">Main Category</option>
                            @foreach($datalist as $rs)
                                {{ \App\Http\Controllers\Admin\CategoryController::getParentsTree($rs, $rs->title) }}
                                <option value="{{ $rs->id }}">{{ $rs->title }}</option>
                                @foreach($rs->children as $rs)
                                    <option value="{{ $rs->id }}"> -- {{ $rs->title }}</option>
                                @endforeach

                            @endforeach
                        </select>

                        A????l??r menu
                        $categories = Category::where('parent_id', '=', 0)->with('children')->get();
                        @foreach($categories as $rs)
                            <ul>
                                <li><a href="#">{{$rs->title}}</a></li>
                                @if(count($rs->children))
                                    @include('admin.categorytree',['subcategories' => $rs->children])
                                @endif
                            </ul>
                        @endforeach







                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Id</th>
                                <th>Parent</th>
                                <th>Title(s)</th>
                                <th>Status</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ( $datalist  as $rs)
                                <tr>
                                    <td> {{ $rs->id}}</td>
                                    <td>
                                        {{ $rs->parent_id}}

                                        @if(count($rs->parents))
                                            {{$rs->parent->title }} {{ $rs->parents->implode('-') }} <strong>-></strong> {{ $rs->title }}
                                        @else
                                            {{ $rs->title }}
                                        @endif

                                    </td>

                                    <td>{{ $rs->title}}</td>
                                    <td>{{ $rs->status}}</td>
                                    <td><a href="{{route('admin_category_edit', ['id' => $rs->id])}}"> Edit</a></td>
                                    <td><a href="{{route('admin_category_delete', ['id' => $rs->id])}}" onclick="return confirm('Delete ! Are you sure?')"  >Delete</a></td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->



                <!-- /.card-body -->
                <div class="card-footer">
                    Footer
                </div>
                <!-- /.card-footer-->
            </div>
            <!-- /.card -->

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

@endsection

@section('footer')
    <script src="{{ asset('assets')}}/admin/plugins/jquery-knob/jquery.knob.min.js"></script>
    <script src="{{ asset('assets')}}/admin/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="{{ asset('assets')}}/admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="{{ asset('assets')}}/admin/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="{{ asset('assets')}}/admin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script>
        $(function () {
            $("#example1").DataTable({
                "responsive": true,
                "autoWidth": false,
            });
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        });
    </script>
@endsection
