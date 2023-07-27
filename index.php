<?php
error_reporting(E_ALL);
$_version = 'Parse Protocol Version 1.0';
require('./class/Parse.factory.php');
$hprim = new ParseFactory('./datas/messages/', 10, 4);


?>
<!doctype html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $_version;?></title>
  </head>
  <link href="assets/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/dist/css/bootstrap-icons.css" rel="stylesheet">

  
  <link href="assets/dashboard.css" rel="stylesheet">
</head>
<body data-spy="scroll" data-target="#navbar-typehprim">
  <header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
    <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 fs-6" href="#"><?php echo $_version;?></a>
    
    
    <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="navbar-nav">
      <div class="nav-item text-nowrap">
          <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="mr-2 d-none d-lg-inline text-gray-600 small">option</span>
          </a>
          <!-- Dropdown - User Information -->
          <div class="dropdown-menu dropdown-menu" aria-labelledby="userDropdown">
            <a class="dropdown-item" href=""><span class="oi oi-person"></span> </a>
            <a class="dropdown-item" href=""><span class="oi oi-account-logout"></span> </a>
          </div>
      </div>
    </div>
  </header>

  <div class="container-fluid">
    <div class="row">
      <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
        <div class="position-sticky pt-3 sidebar-sticky d-flex p-3 bg-body-tertiary d-flex flex-column align-items-stretch flex-shrink-0 bg-white">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
              <li class="nav-item">
                <a class="nav-link active" id="Files-tab" data-toggle="tab" href="#Files" role="tab" aria-controls="profile" aria-selected="false">Files</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="Parsed-tab" data-toggle="tab" href="#Parsed" role="tab" aria-controls="Parsed" aria-selected="true">Parsed</a>
              </li>
            </ul>
            <div class="tab-content" id="myTabContent">
              <div class="tab-pane fade show active" id="Files" role="tabpanel" aria-labelledby="Files-tab">          
                <?php 
                    $hprim->showPageItems();
                ?>
                <br/>
                <?php
                    $hprim->showPagination();
                ?>
              </div>
              <div class="tab-pane fade" id="Parsed" role="tabpanel" aria-labelledby="Parsed-tab">
                <div  id="navbar-typehprim">
                  <div id="list-typehprim" class="list-group">
                    <?php 
                    $datas = $hprim->GetParsed();
                    foreach($datas AS $key=>$data){
                      echo '<a class="list-group-item list-group-item-action" href="#list-item-'.$key.'">'.$data[0]->value.'</a>';
                    }
                    ?>
                  </div>
                </div>
              </div>
            </div>            
        </div>
      </nav>
      <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">  
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-1 mb-1 border-bottom">
          <div data-spy="scroll" data-target="#list-example" data-offset="0" class="scrollspy-example">
              <?php
              $datas = $hprim->GetParsed();
              foreach($datas AS $key=>$data){
                echo '<div  id="list-item-'.$key.'" class="row align-items-start border-bottom">';
                foreach($data AS $key=>$obj){
                  //if ($obj->value)
                  echo '<div class="col-2">'.$obj->descr.'<br/>'.(($obj->error) ? '<span class="badge bg-warning" data-toggle="tooltip" data-placement="top" title="'.implode(',', $obj->desc_error).'"><i class="bi bi-exclamation-triangle-fill"></i></span>':'').'<b> '.utf8_encode($obj->value).'</b></div>';
                }
                echo '</div>';
              } ?>
          </div>
        </div>
      </main>
      <script src="assets/dist/js/bootstrap.bundle.min.js"></script>
      <script src="assets/dist/js/code.jquery.com_jquery-3.7.0.min.js"></script>
      <script type="text/javascript">
      $(function () {
        $('[data-toggle="tooltip"]').tooltip();

        $('#myTab a').on('click', function (e) {
          e.preventDefault()
          $(this).tab('show')
        });
      })
      </script>
    </div>
  </div>
</body>
</html>
