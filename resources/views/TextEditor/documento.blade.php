<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Documento</title>
</head>
<body>
    <style>
        h1 { font-family: TimesNewRoman; font-size: 16px; font-style: normal; font-variant: normal; font-weight: 400; line-height: 18px; } h3 { font-family: TimesNewRoman, Times New Roman, Times, Baskerville, Georgia, serif; font-size: 14px; font-style: normal; font-variant: normal; font-weight: 700; line-height: 15.4px; } p { font-family: TimesNewRoman, Times New Roman, Times, Baskerville, Georgia, serif; font-size: 14px; font-style: normal; font-variant: normal; font-weight: 400; line-height: 20px; } blockquote { font-family: TimesNewRoman, Times New Roman, Times, Baskerville, Georgia, serif; font-size: 21px; font-style: normal; font-variant: normal; font-weight: 400; line-height: 30px; } pre { font-family: TimesNewRoman, Times New Roman, Times, Baskerville, Georgia, serif; font-size: 13px; font-style: normal; font-variant: normal; font-weight: 400; line-height: 18.5667px; }
         /** Define the margins of your page **/
         @page {
                margin: 113,44px 113,44px;
            }

            header {
                position: fixed;
                top: -113,44px;
                left: -113,44px;
                right: -113,44px;
                height: 113,44px;

                /** Extra personal styles **/
                background-color: #03a9f4;
                color: white;
                text-align: center;
                line-height: 35px;
            }

            footer {
                
                position: fixed; 
                bottom: 113,44px; 
                left: 0px; 
                right: 0px;
                height: 100px; 
                display:inline-block;
                /** Extra personal styles **/
               
                text-align: center;
                line-height: 35px;
            }
            .para{

                display:inline-block; 
                position: relative;
                
                left: 96px;
               
            }
            .receptor
            {
                display:inline-block; 
                position: relative;
                top: 10px;
                left: 596px;  
            }
    </style>
    <header>
        <img class="img-thumbnail img-fluid rounded" style="width: 100%;" src="images/header.jpg" alt="Error Imagen no encontrada"/>    
    </header>
    <br>
    <br>
    <h1 class="para"><b> PARA : </b></h1>
    @if (@isset($receptores))
        
    
       @foreach ($receptores as $receptor )
       <h1 class="receptor">     {{ $receptor->name }} {{ $receptor->lastname }}</h1>    <br>
       
       @endforeach 
    @endif

    @if (@isset($receptores_departamentos))
        
    
       @foreach ($receptores_departamentos as $receptor_departamento )
       <h1 class="receptor">  Departamento de {{ $receptor_departamento->name }}</h1>    <br>
       
       @endforeach 
    @endif
    
    
    <h1><b> OBJETO : {{ $objeto }}</b></h1>
    <br>
    <br>
    <h1>{{ $cuerpo }}</h1>
    <footer>
        <h1>Atentamente</h1>
    <h1>______________</h1>
    <h1>{{ $apellido }} {{ $nombre }} </h1>
    </footer>
    
</body>
</html>