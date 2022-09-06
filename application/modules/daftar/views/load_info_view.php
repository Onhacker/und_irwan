<div class="tab-pane show" id="info1">

    <div class="col-12">
        <div class="card-box">

            <div class="clearfix">
                <div class="text-center">
                    <h4 class="m-0 d-print-none">BIMTEK<br><?php echo ucwords(strtolower($this->fm->web_me()->nama_website))." Se - ".ucwords(strtolower($this->fm->web_me()->kota)) ?>  </h4>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-sm-6">
                    <h4>Tempat Pelaksanaan : </h4>
                    <address>
                        <span class="text-blue"><?php echo ucwords(strtolower($this->fm->web_me()->hotel)) ?> </span>
                    </address>
                </div>
                <div class="col-sm-6">
                    <h4>Tanggal Pelaksanaan : </h4>
                    <address>
                        <span class="text-blue"><?php echo ucwords(strtolower($this->fm->web_me()->tgl_acara)) ?></span>
                    </address>
                </div>
                <div class="col-sm-6">
                    <h4>Kontak Person : </h4>
                    <address>
                        <span class="text-blue"><?php echo ($this->fm->web_me()->no_telp). " a/n ".$this->fm->web_me()->kadis ?></span>
                    </address>
                </div> 

            </div> 
            <hr>

            <div class="row">
                <div class="col-md-12">
                    <!-- <div class="mt-3"> -->
                        <p><b>Metode Pembayaran</b></p>
                        <p class="text-dark">Silahkan Lakukan Pembayaran Silahkan Lakukan Transfer Ke</p>

                        <table class="table mt-4 table-centered" style="padding: 2px !important">
                            <tr>
                                <td><strong>Rekening</strong></td>
                                <td>:</td>
                                <td>Bank BNI Cab. Pecenongan Jakarta</td>
                            </tr>
                            <tr>
                                <td><strong>Nomor Rekening</strong></td>
                                <td>:</td>
                                <td>028.7989.244</td>
                            </tr>
                            <tr>
                                <td><strong>Nama Rekening</strong></td>
                                <td>:</td>
                                <td>Pusat Konsultasi Pemerintahan Daerah</td>
                            </tr>
                            <tr>
                                <td><strong>Jumlah Transfer</strong></td>
                                <td>:</td>
                                <td>Rp <?php echo uang($this->fm->web_me()->uang) ?> / <?php echo ($this->fm->web_me()->per) ?></td>
                            </tr>
                        </table>
                    <!-- </div> -->
                    

                </div>
            </div>                        
        </div> 
    </div>
</div>