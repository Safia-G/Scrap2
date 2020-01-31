<!doctype html>
<html>
  <head>
    <title>Import CSV Data to MySQL database with Laravel</title>
  </head>
  <body>
     <!-- Message -->
     @if(Session::has('message'))
        <p >{{ Session::get('message') }}</p>
     @endif
     <?php var_dump(realpath_cache_size()); ?>

     <!-- Form -->
     <form method='post' action='/uploadFile' enctype='multipart/form-data' >
       {{ csrf_field() }}
       <input type='file' name='file' >
       <input type='submit' name='submit' value='Import'>
     </form>
     <?php echo ini_get('post_max_size');
     phpinfo();

     ?>

  </body>
</html>
