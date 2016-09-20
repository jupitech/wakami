@extends('layouts.app')
@extends('layouts.menu')
@section('content')
<div class="col-sm-12">
    @yield('menu')
</div>
   <div class="col-md-12 top_conte" ng-controller="ProductosCtrl">
	
	{{-- Productos --}}
	
	 <div class="header_conte">
              <h1>Agregar Imagen a {{ $producto->nombre}}-{{ $producto->codigo}}</h1>
                
     </div>

                <div class="caja_productos">
                <div class="col-sm-12">
                   {!! Form::open(['route'=> 'producto.imagen.create', 'method' => 'POST', 'files'=>'true', 'id' => 'my-dropzone' , 'class' => 'dropzone']) !!}
                    <div class="dz-message" style="height:200px;">
                        <h1>Subir archivos en JPG, PNG aqui!</h1>
                    </div>
                    <div class="dropzone-previews"></div>
                    {{ Form::hidden('id_producto', $producto->id) }}
                    <button type="submit" class="btn btn-success" id="submit">Subir Imagen</button>
                    {!! Form::close() !!}
                </div>
                      
              </div>

   </div>
@endsection
@push('scripts')
    <script src="/js/script.js"></script>
    <script src="/js/controller/ProductosCtrl.js"></script>
    <script>
        Dropzone.options.myDropzone = {
            autoProcessQueue: false,
            uploadMultiple: false,
            maxFilezise: 10,
            maxFiles: 1,
            acceptedFiles: 'image/*',
            
            init: function() {
                var submitBtn = document.querySelector("#submit");
                myDropzone = this;
                
                submitBtn.addEventListener("click", function(e){
                    e.preventDefault();
                    e.stopPropagation();
                    myDropzone.processQueue();
                });
                this.on("addedfile", function(file) {
                    alert("Archivo agregado");
                });
                
                this.on("complete", function(file) {
                    myDropzone.removeFile(file);
                });
 
                this.on("success", 
                    myDropzone.processQueue.bind(myDropzone)
                );
            }
        };
    </script>
@endpush