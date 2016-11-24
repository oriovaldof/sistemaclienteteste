<?php
session_start();
include_once('include_archives.php');
?>
<!DOCTYPE html>
<html lang="pt_br">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Sistema Gestor! | Cliente</title>
    <script>
        var URLSite = '<?php echo $_SESSION['UrlSite']?>';
    </script>

    <!-- Bootstrap -->
    <link href="assets/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="assets/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="assets/vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- iCheck -->
    <link href="assets/vendors/iCheck/skins/flat/green.css" rel="stylesheet">
    <!-- bootstrap-progressbar -->
    <link href="assets/vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">
    <!-- JQVMap -->
    <link href="assets/vendors/jqvmap/dist/jqvmap.min.css" rel="stylesheet"/>
    <!-- bootstrap-daterangepicker -->
    <link href="assets/vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="assets/build/css/custom.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <a href="index.php" class="site_title"><i class="fa fa-paw"></i> <span>Cadastro Cliente</span></a>
            </div>

            <div class="clearfix"></div>


            <br />

            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <h3>General</h3>
                <ul class="nav side-menu">
                  <li><a><i class="fa fa-user"></i> Cliente</span></a>
                    
                  </li>
                  
                </ul>
              </div>
              

            </div>
            <!-- /sidebar menu -->

            
          </div>
        </div>

        <!-- top navigation -->
        <div class="top_nav">
          <div class="nav_menu">
            <nav>
              <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
              </div>

              <ul class="nav navbar-nav navbar-right">
                <li class="">
                  <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <img src="assets/images/img.jpg" alt="">Usuário Logado
                    
                  </a>
                 
                </li>

              </ul>
            </nav>
          </div>
        </div>
        <!-- /top navigation -->

        <!-- page content -->
        <div class="right_col" role="main">


            <div id="contentForm" class="row" style="display: none;">


                <!--Inicio FORM-->

                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2 id="titleForm">Cadastra Cliente</h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>

                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <br />
                            <form id="formCrud" data-parsley-validate class="form-horizontal form-label-left">

                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="clientTipo">Tipo Cliente</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select class="form-control cleanField" id="clientTipo" name="clientTipo">
                                            <option value="">Selecione Tipo Cliente</option>
                                            <option value="PF">Pessoa Física</option>
                                            <option value="PJ">Pessoa Jurídica</option>
                                        </select>
                                    </div>
                                </div>

                                <div id="contentDados" style="display: none">
                                    <div class="" role="tabpanel" data-example-id="togglable-tabs">
                                        <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                                            <li role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Dados</a>
                                            </li>
                                            <li role="presentation" class=""><a href="#tab_content2" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">Contato</a>
                                            </li>
                                            <li role="presentation" class=""><a href="#tab_content3" role="tab" id="profile-tab2" data-toggle="tab" aria-expanded="false">Endereço</a>
                                            </li>
                                        </ul>

                                        <div id="myTabContent" class="tab-content">
                                            <!--INICIO Dados-->
                                            <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">

                                                <div class="form-group" >
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="clientNomeRazaoSocial"><span id="nameType">Razão Social</span> <span class="required">*</span>
                                                    </label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input type="text" id="clientNomeRazaoSocial" name="clientNomeRazaoSocial" required="required" class="cleanField form-control col-md-7 col-xs-12">
                                                        <input type="hidden" id="clientCod" name="clientCod"  class="cleanField form-control col-md-7 col-xs-12"  value="">
                                                    </div>
                                                </div>
                                                <div class="form-group" id="nameFantasy" style="display: none">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="clientNomeFantasia">Nome Fantasia<span class="required">*</span>
                                                    </label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input type="text" id="clientNomeFantasia" name="clientNomeFantasia" class="cleanField form-control col-md-7 col-xs-12">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="clientCpfCnpj" class="control-label col-md-3 col-sm-3 col-xs-12"><span id="nameDoc">CNPJ</span><span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input id="clientCpfCnpj" name="clientCpfCnpj" required="required"  class="cleanField form-control col-md-7 col-xs-12" type="text" onchange="validDoc()">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="clientInscricaoEstadual" class="control-label col-md-3 col-sm-3 col-xs-12">Inscrição Estadual</label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input id="clientInscricaoEstadual" name="clientInscricaoEstadual" class="cleanField form-control col-md-7 col-xs-12" type="text">
                                                    </div>
                                                </div>


                                            </div>
                                            <!--Fim Dados-->
                                            <!--INICIO Contato-->
                                            <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="profile-tab">
                                                <div class="row">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" >
                                                        Adicionar Contato
                                                    <span>
                                                        <img src="<?php echo $_SESSION['UrlSite']?>assets/images/add.png" style="margin-left: 10px;cursor: pointer;" onclick="addContact()" alt="Adicionar Contato"  title="Adicionar Contato">
                                                    </span>
                                                    </label>
                                                </div>
                                                <div id="contentContact" class="row" ></div>

                                            </div>
                                            <!--Fim Contato-->

                                            <!--INICIO Endereço-->
                                            <div role="tabpanel" class="tab-pane fade" id="tab_content3" aria-labelledby="profile-tab">
                                                <div class="row">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" >
                                                        Adicionar Endereço
                                                <span>
                                                    <img src="<?php echo $_SESSION['UrlSite']?>assets/images/add.png" style="margin-left: 10px; cursor: pointer;" onclick="addAddress()" alt="Adicionar Endereço" title="Adicionar Endereço">
                                                </span>
                                                    </label>
                                                </div>
                                                <div id="contentAddress" class="row" ></div>
                                            </div>
                                            <!--Fim Endereço-->
                                        </div>

                                    </div>



                                </div>
                                    <div class="ln_solid"></div>
                                    <div class="form-group">
                                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                            <button type="button" class="btn btn-primary" onclick="returnGrid()">Cancelar</button>
                                            <button type="button" class="btn btn-success" onclick="registerUpdate()">Enviar</button>
                                        </div>
                                    </div>
                                <input type="hidden" id="Id" name="Id"  class="cleanField form-control col-md-7 col-xs-12" value="">
                            </form>

                    </div>
                </div>
                <!--Fim FORM-->
        </div>


      </div>
        <div id="contentButton" class="row">
            <button type="button" class="btn btn-success" onclick="register()">Cadastrar</button>
        </div>
        <div id="contentGrid" class="row">


            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">

                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>


                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <table id="datatable" class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th>Cliente</th>
                                    <th>Tipo</th>
                                    <th>CPF/CNPJ</th>
                                    <th>Action</th>
                                </tr>
                                </thead>


                                <tbody id="bodyGrid">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                </div>




        </div>
        <!-- /page content -->
        <!-- footer content -->
        <footer>
            <div class="pull-right">
                Gentelella - Bootstrap Admin Template by <a href="https://colorlib.com">Colorlib</a>
            </div>
            <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->

    </div>

    <!-- jQuery -->
    <script src="assets/vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="assets/vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="assets/vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="assets/vendors/nprogress/nprogress.js"></script>
    <!-- Chart.js -->
    <script src="assets/vendors/Chart.js/dist/Chart.min.js"></script>
    <!-- gauge.js -->
    <script src="assets/vendors/gauge.js/dist/gauge.min.js"></script>
    <!-- bootstrap-progressbar -->
    <script src="assets/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
    <!-- iCheck -->
    <script src="assets/vendors/iCheck/icheck.min.js"></script>
    <!-- Skycons -->
    <script src="assets/vendors/skycons/skycons.js"></script>
    <!-- Flot -->
    <script src="assets/vendors/Flot/jquery.flot.js"></script>
    <script src="assets/vendors/Flot/jquery.flot.pie.js"></script>
    <script src="assets/vendors/Flot/jquery.flot.time.js"></script>
    <script src="assets/vendors/Flot/jquery.flot.stack.js"></script>
    <script src="assets/vendors/Flot/jquery.flot.resize.js"></script>
    <!-- Flot plugins -->
    <script src="assets/vendors/flot.orderbars/js/jquery.flot.orderBars.js"></script>
    <script src="assets/vendors/flot-spline/js/jquery.flot.spline.min.js"></script>
    <script src="assets/vendors/flot.curvedlines/curvedLines.js"></script>
    <!-- DateJS -->
    <script src="assets/vendors/DateJS/build/date.js"></script>
    <!-- JQVMap -->
    <script src="assets/vendors/jqvmap/dist/jquery.vmap.js"></script>
    <script src="assets/vendors/jqvmap/dist/maps/jquery.vmap.world.js"></script>
    <script src="assets/vendors/jqvmap/examples/js/jquery.vmap.sampledata.js"></script>
    <!-- bootstrap-daterangepicker -->
    <script src="assets/vendors/moment/min/moment.min.js"></script>
    <script src="assets/vendors/bootstrap-daterangepicker/daterangepicker.js"></script>

  <!-- Datatables -->
  <script src="assets/vendors/datatables.net/js/jquery.dataTables.min.js"></script>
  <script src="assets/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
  <script src="assets/vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
  <script src="assets/vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
  <script src="assets/vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
  <script src="assets/vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
  <script src="assets/vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
  <script src="assets/vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
  <script src="assets/vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
  <script src="assets/vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
  <script src="assets/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
  <!-- bootstrap-wysiwyg -->
  <script src="assets/vendors/bootstrap-wysiwyg/js/bootstrap-wysiwyg.min.js"></script>
  <script src="assets/vendors/jquery.hotkeys/jquery.hotkeys.js"></script>
  <script src="assets/vendors/google-code-prettify/src/prettify.js"></script>


    <!-- Custom Theme Scripts -->
    <script src="assets/build/js/custom.min.js"></script>
    <script src="assets/js/jquery.mask.js"></script>
    <script src="assets/js/function.js"></script>

          <!-- bootstrap-wysiwyg -->
          <script>
              $(document).ready(function() {
                  function initToolbarBootstrapBindings() {
                      var fonts = ['Serif', 'Sans', 'Arial', 'Arial Black', 'Courier',
                              'Courier New', 'Comic Sans MS', 'Helvetica', 'Impact', 'Lucida Grande', 'Lucida Sans', 'Tahoma', 'Times',
                              'Times New Roman', 'Verdana'
                          ],
                          fontTarget = $('[title=Font]').siblings('.dropdown-menu');
                      $.each(fonts, function(idx, fontName) {
                          fontTarget.append($('<li><a data-edit="fontName ' + fontName + '" style="font-family:\'' + fontName + '\'">' + fontName + '</a></li>'));
                      });
                      $('a[title]').tooltip({
                          container: 'body'
                      });
                      $('.dropdown-menu input').click(function() {
                          return false;
                      })
                          .change(function() {
                              $(this).parent('.dropdown-menu').siblings('.dropdown-toggle').dropdown('toggle');
                          })
                          .keydown('esc', function() {
                              this.value = '';
                              $(this).change();
                          });

                      $('[data-role=magic-overlay]').each(function() {
                          var overlay = $(this),
                              target = $(overlay.data('target'));
                          overlay.css('opacity', 0).css('position', 'absolute').offset(target.offset()).width(target.outerWidth()).height(target.outerHeight());
                      });

                      if ("onwebkitspeechchange" in document.createElement("input")) {
                          var editorOffset = $('#editor').offset();

                          $('.voiceBtn').css('position', 'absolute').offset({
                              top: editorOffset.top,
                              left: editorOffset.left + $('#editor').innerWidth() - 35
                          });
                      } else {
                          $('.voiceBtn').hide();
                      }
                  }

                  function showErrorAlert(reason, detail) {
                      var msg = '';
                      if (reason === 'unsupported-file-type') {
                          msg = "Unsupported format " + detail;
                      } else {
                          console.log("error uploading file", reason, detail);
                      }
                      $('<div class="alert"> <button type="button" class="close" data-dismiss="alert">&times;</button>' +
                      '<strong>File upload error</strong> ' + msg + ' </div>').prependTo('#alerts');
                  }

                  initToolbarBootstrapBindings();

                 // $('#editor').wysiwyg({
                 //     fileUploadError: showErrorAlert
                //  });

                  window.prettyPrint;
                  prettyPrint();
              });
          </script>
          <!-- /bootstrap-wysiwyg -->




  </body>
</html>
