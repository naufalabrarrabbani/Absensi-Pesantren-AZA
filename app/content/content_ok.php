<div class="container-fluid">
    <div class="row clearfix">
	<?php
				/* handle error */
					if (isset($_GET['sukses'])) : ?>
                  <div class="alert bg-green alert-dismissible" role="alert">
                     <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                
                    <?=base64_decode($_GET['sukses']);?>
                  </div>
                <?php endif;?>
					<div class="card">
                        <div class="body">
							<div class="row">
									<form id="search" method="get">
									<div class="col-md-12">
									<div class="input-group input-group-lg">
                                        <span class="input-group-addon">
                                            <i class="material-icons">phone</i>
                                        </span>
                                        <div class="form-line">
                                            <input type="number" name="hp" class="form-control" value="<?= $_GET['hp'] ?>" placeholder="Cari No Telepon">
                                        </div>
										<span class="input-group-addon">
                                            <button type="submit" class="btn bg-purple btn-circle-lg waves-effect waves-circle waves-float">
												<i class="material-icons">search</i>
											</button>
                                        </span>
                                    </div>
									</div>
									
									</form>
									
									<?php
									$s_order = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * from orderan where no_hp='$_GET[hp]' AND status='0' order by id DESC");
									$cek=mysqli_num_rows($s_order);
									
									?>
	                        </div>        
                        </div>
                    </div>
					<div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                               <b><?php
									$s_pelanggan= mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * from pelanggan where no_hp='$_GET[hp]' ");
									$cek_pelanggan =mysqli_num_rows($s_pelanggan);
									$d_pelanggan = mysqli_fetch_array($s_pelanggan);
									if ($cek_pelanggan ==0){
									echo 'data tidak ditemukan' ;}
									else {echo $d_pelanggan['nama'];}
									?></b> - <?= $d_pelanggan['alamat'];?>
                            </h2>
                            
                        </div>
                        <div class="body table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Masuk</th>
                                        <th>Selesai</th>
                                        <th>Jumlah</th>
										<th>Total</th>
										<th></th>
                                    </tr>
                                </thead>
                                <tbody>
								<?php 
								$a=1;
								while ($d_order = mysqli_fetch_array($s_order)){ ?>
                                    <tr>
                                        <th scope="row"><?= $a++ ?></th>
                                        <td><?= $d_order['tgl_masuk']; ?></td>
                                        <td><?= $d_order['tgl_selesai']; ?></td>
                                        <td><?= $d_order['kilogram']; ?> Kg</td>
										<td><?= $d_order['total']; ?></td>
                                        <td><?php if ($d_order['status']==1){ echo'selesai';} else  if ($d_order['status']==0){ ?><a href="controller/laundry_ok?id=<?=$d_order['id'];?>"><button class="btn btn-success"><i class="assignment_turned_in"></i> selesai</button></a>
										<?php ;}else  if ($d_order['status']==2){echo'sudah diambil';} ?></td>
                                    </tr>
                                <?php ;} ?>    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
                
            </div>
           
</div>