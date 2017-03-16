<?php
	require_once('services/services.php');
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
      <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>EBook createur Dal'Alu</title>
	<!-- BOOTSTRAP STYLES-->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
     <!-- FONTAWESOME STYLES-->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
     <!-- MORRIS CHART STYLES-->
   
        <!-- CUSTOM STYLES-->
    <link href="assets/css/custom.css" rel="stylesheet" />
     <!-- GOOGLE FONTS-->
   	<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
     <!-- TABLE STYLES-->
    <link href="assets/js/dataTables/dataTables.bootstrap.css" rel="stylesheet" />
</head>
<body>	
    <div id="wrapper">
        <nav class="navbar navbar-default navbar-cls-top " role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="accueil.html">DAL'ALU</a> 
            </div>
				  <div style="color: white;
				padding: 15px 50px 5px 50px;
				float: right;
				font-size: 16px;"> Bonjour Dal'Alu &nbsp; <a href="index.html" class="btn btn-danger square-btn-adjust">Déconnexion</a> </div>
        </nav>   
           <!-- /. NAV TOP  -->
        <nav class="navbar-default navbar-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav" id="main-menu">
				<li class="text-center">
                    <img src="assets/img/find_user.png" class="user-image img-responsive"/>
				</li>
				
					
                    <li>
                        <a class="active-menu"  href="index.html"><i class="fa fa-dashboard fa-3x"></i> Dashboard</a>
                    </li>	
                </ul>
               
            </div>
            
        </nav>  
        <!-- /. NAV SIDE  -->
        <div id="page-wrapper" >
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                     <h2>Blank Page</h2>   
                        <h5>Welcome Jhon Deo , Love to see you back. </h5>
                       
                    </div>
                </div>
                 <!-- /. ROW  -->
                 <hr />
             <div class="panel-group" id="accordion"> 
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" class="collapsed">Créer un E-book</a>
                        </h4>
                    </div>
                    <div id="collapseTwo" class="panel-collapse in" style="height: auto;">
                    	<form method="post" action="services/services.php" enctype="multipart/form-data">
                    		<input type="hidden" name="creation" value="creation">
	                        <div class="panel-body">
								<div class="form-group">
									<label>Titre de l'E-book</label>
									<input class="form-control" name="titre"/>
								</div>
								<div class="form-group">
									<label>Premiere de couverture</label>
									<input type="file" name="Page0" />
								</div>
								<div class="form-group">
									<label>Page 1</label>
									<input type="file" name="Page1"/>
								</div>
								<div id="pageAdded2" class="form-group">
									<label>Page 2</label>
									<input type="file" name="Page2"/>
								</div>
								<div class="form-group">
									<label>Derniere de couverture</label>
									<input type="file" name="PageEnd"/>
								</div>
								<button type="button" id="addPage" class="btn btn-default">Ajouter une page</button>
								<button type="button" id="removePage" class="btn btn-primary">Supprimer une page</button>	
								<div class="form-group" style="margin-top:20px;">
									<button type="submit" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">
									  Générer l'E-book
									</button>
								</div>							
							</form>							 
						</div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree">Historique des E-books</a>
                        </h4>
                    </div>
                    <div id="collapseThree" class="panel-collapse collapse">
                        <div class="panel-body">
                        <?php
							$liste_ebooks = recupererListeEbook();			
							if(sizeof($liste_ebooks) > 0) {								
						?>
                        <div class="table-responsive">
							<table class="table table-striped table-bordered table-hover" id="dataTables-example">
								<thead>
									<tr>
										<th>Titre</th>
										<th>Téléchargement</th>
										<th>Visualisation</th>
										<th>Supression</th>
									</tr>
								</thead>
								<tbody>	
									<?php										
										foreach($liste_ebooks as $ebook) {											
									?>								
									<tr class="odd">
										<td><?php echo $ebook->getTitre() ?></td>
										<td class="center">
											<form method="post" action="services/services.php" target="_blank">
												<a href="<?php echo $ebook->getPDF() ?>" target="_blank" class="btn btn-primary btn-xs">PDF</a>											
												<input type="hidden" name="zip" value="<?php echo $ebook->getTitre() ?>">
												<button type="submit" class="btn btn-primary btn-xs">Ebook</button>
											</form>
										</td>
										<td class="center">
											<a href="<?php echo $ebook->getIndex() ?>" target="_blank" class="btn btn-success btn-xs">Visualiser</a>
										</td>
										<td class="center">
											<form method="post" action="services/services.php">
												<input type="hidden" name="suppression" value="<?php echo $ebook->getTitre() ?>">
												<button type="submit" class="btn btn-danger btn-xs">Supprimer</button>
											</form>
										</td>
									</tr>		
									<?php
										}
									?>							
								</tbody>
							</table>
						</div>
						<?php
							} else {
						?>
						<div class="col-md-12">
							Aucun ebook n'a été créé.
						</div>
						<?php
							} 
						?>
						</div>
                    </div>
                </div>
			</div>
    </div>
	
							
             <!-- /. PAGE INNER  -->
            </div>
         <!-- /. PAGE WRAPPER  -->
        </div>
     <!-- /. WRAPPER  -->
    <!-- SCRIPTS -AT THE BOTOM TO REDUCE THE LOAD TIME-->
    <!-- JQUERY SCRIPTS -->
    <script src="assets/js/jquery-1.10.2.js"></script>
      <!-- BOOTSTRAP SCRIPTS -->
    <script src="assets/js/bootstrap.min.js"></script>
    <!-- METISMENU SCRIPTS -->
    <script src="assets/js/jquery.metisMenu.js"></script>

    <script src="assets/js/accueil.js"></script>
    <!-- CUSTOM SCRIPTS -->
    <script src="assets/js/custom.js"></script>

   
   
</body>
</html>
