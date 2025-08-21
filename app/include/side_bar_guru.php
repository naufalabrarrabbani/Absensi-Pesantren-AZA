<aside id="leftsidebar" class="sidebar">
            <!-- User Info -->
            <div class="user-info">
                <div class="image">
                    <img src="../images/logo smp.png"" width="90" height="100" alt="User" />
                </div>
                <div class="info-container">
                    <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?=$_SESSION['nama'];?></div>
                    <div class="email"></div>
                    <div class="btn-group user-helper-dropdown">
                        <i class="material-icons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">keyboard_arrow_down</i>
                        <ul class="dropdown-menu pull-right">
                           <li><a href="../controllers/logout"><i class="material-icons">input</i>Sign Out</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- #User Info -->
            <!-- Menu -->
            <div class="menu">
                <ul class="list">
                    
                    <li>
                        <a href="home_modern.php">
                            <i class="material-icons">home</i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="karyawan">
                            <i class="material-icons">supervisor_account</i>
                            <span>Data Siswa</span>
                        </a>
                    </li>
                    <li class="active">
                        <a href="guru">
                            <i class="material-icons">school</i>
                            <span>Data Guru</span>
                        </a>
                    </li>
                    <li>
                        <a href="absensi">
                            <i class="material-icons">access_alarms</i>
                            <span>Absensi Siswa</span>
                        </a>
                    </li>
                    <li>
                        <a href="absensi_guru">
                            <i class="material-icons">access_time</i>
                            <span>Absensi Guru</span>
                        </a>
                    </li>
					<li>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">date_range</i>
                            <span>Proses Ijin</span>
                        </a>
                        <ul class="ml-menu">
                            <li>
                                <a href="ijin">Ijin Siswa</a>
                            </li>
                            <li>
                                <a href="ijin_guru">Ijin Guru</a>
                            </li>
                            
                        </ul>
                    </li>
					<li >
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">assignment</i>
                            <span>Laporan</span>
                        </a>
                        <ul class="ml-menu">
                            <li>
                                <a href="absensi_all">Absensi Siswa</a>
                            </li>
                            <li>
                                <a href="absensi_guru_all">Absensi Guru</a>
                            </li>
                            <li>
                                <a href="absensi_time">Timesheet Siswa</a>
                            </li>
                            <li>
                                <a href="absensi_guru_time">Timesheet Guru</a>
                            </li>
                            <li>
                                <a href="absensi_ijin">Siswa Ijin</a>
                            </li>
                            <li>
                                <a href="absensi_guru_ijin">Guru Ijin</a>
                            </li>
                        </ul>
                    </li>
                    
					<li>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">cloud</i>
                            <span>Master Data</span>
                        </a>
                        <ul class="ml-menu">
                            <li>
                                <a href="lokasi">Lokasi</a>
                            </li>
                            <li>
                                <a href="area">Area</a>
                            </li>
							
							<li>
                                <a href="job_title">Status Siswa</a>
                            </li>
                            <li>
                                <a href="mata_pelajaran">Mata Pelajaran</a>
                            </li>
                            
                        </ul>
                    </li>
					<?php if($_SESSION['area']=='all') { ?>
					<li>
                        <a href="setting">
                            <i class="material-icons">settings</i>
                            <span>Setting</span>
                        </a>
                    </li>
					<?php ;} else { echo'';}?>
                </ul>
            </div>
            <!-- #Menu -->
            <!-- Footer -->
            <div class="legal">
                <div class="copyright">
                   © SMP Al-Azhar 
                </div>
                
            </div>
            <!-- #Footer -->
        </aside>
