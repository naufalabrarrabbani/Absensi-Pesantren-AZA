<div class="container-fluid">
			<div class="row clearfix">
			<div class="block-header">
                <h2><?php $tanggal = date('d M Y');
								$day = date('D', strtotime($tanggal));
								$dayList = array(
									'Sun' => 'Minggu',
									'Mon' => 'Senin',
									'Tue' => 'Selasa',
									'Wed' => 'Rabu',
									'Thu' => 'Kamis',
									'Fri' => 'Jumat',
									'Sat' => 'Sabtu'
								);
								echo $dayList[$day].", ".$tanggal;?></h2>
            </div>
            <div class="body"><?php if($_SESSION['area']=='all') { ?>
                            <div class="icon-and-text-button-demo">
                                <button type="button" class="btn btn-primary waves-effect" data-color="indigo" data-toggle="modal" data-target="#largeModal">
                                    <i class="material-icons">add_box</i>
                                    <span>TAMBAH</span>
                                </button>
								
								
							</div> <?php ;} else {echo'';} ?>
            </div>    
            </div>
			
            <div class="row clearfix">
			 <div class="card">
                        <div class="header">
                            <h2>
                                MASTER LOKASI
                            </h2>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                        <tr>
											<th></th>
                                            <th>Kode Lokasi</th>
                                            <th>Nama Lokasi</th>
                                        </tr>
                                    </thead>
                                    
                                    <tbody>
									<?php
										$s_karyawan = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM lokasi");
										while ($d_karyawan=mysqli_fetch_array($s_karyawan)){
									?>
                                        <tr>
											<td><?php if($_SESSION['area']=='all') { ?><div class="btn-group">
												<button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
													 <span class="caret"></span>
												</button>
												<ul class="dropdown-menu">
													<li><a class="pilih_lokasi" href="" data-toggle="modal" data-target="#edit" l1="<?= $d_karyawan['id'];?>" l2="<?= $d_karyawan['kode'];?>" l3="<?= $d_karyawan['lokasi'];?>">Edit</a></li>
													<li><a href="controller/lokasi_hapus?id=<?= $d_karyawan['id'];?>" onclick="return confirm('Apakah Lokasi <?= $d_karyawan['kode'];?> <?= $d_karyawan['lokasi'];?> akan dihapus ?')">Hapus</a></li>
												</ul>
											</div><?php ;} else {echo'';} ?></td>
                                            <td><?= $d_karyawan['kode'];?></td>
                                            <td><?= $d_karyawan['lokasi'];?></td>
                                           
                                        </tr>
									<?php ;} ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
			</div>
</div>

							<div class="modal fade" id="largeModal" tabindex="-1" role="dialog">
								<div class="modal-dialog modal-sm" role="document">
									<div class="modal-content">
										<div class="modal-header">
											<h4 class="modal-title" id="largeModalLabel">Tambah Lokasi</h4>
										</div>
										<div class="modal-body">
										 
											<form action="controller/lokasi_simpan" class="form-horizontal" method="POST" enctype="multipart/form-data">
												<div class="row clearfix">
													<div class="col-sm-7">
														<div class="form-group">
															<div class="form-line">
																<input type="text" name="kode" class="form-control" placeholder="Masukkan Kode" required>
															</div>
														</div>
													</div>
												</div>
												<div class="row clearfix">
													
													<div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
														<div class="form-group">
															<div class="form-line">
																<input type="text"  name="lokasi" class="form-control" placeholder="Nama Lokasi" required>
															</div>
														</div>
													</div>
												</div>
											
										</div>
										<div class="modal-footer">
											<button type="submit" class="btn btn-success waves-effect">SAVE CHANGES</button>
											<button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">CLOSE</button>
										</div>
										</form>
									</div>
								</div>
							</div>
							
							
							<div class="modal fade" id="edit" tabindex="-1" role="dialog">
								<div class="modal-dialog modal-sm" role="document">
									<div class="modal-content">
										<div class="modal-header">
											<h4 class="modal-title" id="largeModalLabel">Edit Lokasi</h4>
										</div>
										<div class="modal-body">
										 
											<form action="controller/lokasi_edit" class="form-horizontal" method="POST" enctype="multipart/form-data">
												<div class="row clearfix">
													<div class="col-sm-7">
														<div class="form-group">
															<div class="form-line">
																<input type="hidden" id="id" name="id" class="form-control" required>															
																<input type="text" id="kode" name="kode" class="form-control" placeholder="Masukkan Kode" required>
															</div>
														</div>
													</div>
												</div>
												<div class="row clearfix">
													
													<div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
														<div class="form-group">
															<div class="form-line">
																<input type="text" id="lokasi" name="lokasi" class="form-control" placeholder="Nama Lokasi" required>
															</div>
														</div>
													</div>
												</div>
											
										</div>
										<div class="modal-footer">
											<button type="submit" class="btn btn-success waves-effect">SAVE CHANGES</button>
											<button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">CLOSE</button>
										</div>
										</form>
									</div>
								</div>
							</div>