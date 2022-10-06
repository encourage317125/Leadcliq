    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="">
    <link rel="shortcut icon" href="">

	<link rel="stylesheet" href="/assets/css/bootstrap-yeti.css">

    <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css">
    <link rel="stylesheet" href="/assets/css/bootstrap-tagsinput.css">
    <link rel="stylesheet" href="/assets/css/leadcliq.default.css">
    
    
    {{ HTML::style('css/selectize.bootstrap3.css') }}
        
    <!-- load angular files-->
  
    <!--START Angualr JS INCLUDES-->
    <!--TODO: This should be managed via bower/grunt-->
    <script src="{{asset('js/vendors/angular.min.js')}}"></script>
    <script src="/assets/js/app.js"></script>
    
    <script src="/assets/js/services/global.js"></script>   
    <script src="/assets/js/controllers/headercontroller.js"></script>   
    <script src="/assets/js/controllers/territoriesctrlnew.js"></script>

    <!--End Angualr JS INCLUDES-->
    
    <!--Start jQuery JS INCLUDES-->
    <script src="/assets/js/vendors/jquery.min.js"></script>
    <script src="/assets/js/vendors/jqueryui.js"></script>
    <script src="/assets/js/vendors/jquery.tablesorter.min.js"></script>
    <script src="/assets/js/vendors/tablePagination.js"></script> 
    <!--End jQuery JS INCLUDES-->
    
    <!--Start Bootstrap JS INCLUDES-->
    <script src="/assets/js/vendors/bootstrap.min.js"></script>
    <script src="/assets/js/vendors/bootstrap-tagsinput.js"></script>  
    <!--End Bootstrap JS INCLUDES-->
    
    <!--Start Nod JS INCLUDES-->
    <script src="/assets/js/vendors/nod.js"></script>   
    <!--End Nod JS INCLUDES-->
    
    <!--Start Typeahead JS INCLUDES-->
    <script src="/assets/js/vendors/typeahead.bundle.js"></script>
    <!--End Typeahead JS INCLUDES-->
    
    <!--Start Custom JS INCLUDES--> 
    <script src="/assets/js/leadcliq.default.js"></script>
    <script src="/assets/js/alert.js"></script>
    <!--End Custom JS INCLUDES--> 
    
    
    {{ HTML::script('plugins/select2/select2.js') }}
    
   
    {{ HTML::script('js/selectize.min.js') }}

     @yield('styles')

	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="js/html5shiv.js"></script>
      <script src="js/respond.min.js"></script>
    <![endif]-->