<!DOCTYPE html>
<html lang="en">

<?php
include "connection/koneksi.php";
session_start();
ob_start();

$id = $_SESSION['id_user'];

if (isset($_SESSION['edit_order'])) {
    //echo $_SESSION['edit_order'];
    unset($_SESSION['edit_order']);
}

if (isset($_SESSION['username'])) {

    $query = "select * from tb_user natural join tb_level where id_user = $id";

    mysqli_query($conn, $query);
    $sql = mysqli_query($conn, $query);

    while ($r = mysqli_fetch_array($sql)) {

        $nama_user = $r['nama_user'];

        ?>
        <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
            <meta name="description" content="Start your development with a Dashboard for Bootstrap 4.">
            <meta name="author" content="Creative Tim">
            <title>Laporan Hari Ini</title>

            <meta charset="UTF-8" />
            <meta name="viewport" content="width=device-width, initial-scale=1.0" />
            <link rel="stylesheet" href="template/dashboard/css/bootstrap.min.css" />
            <link rel="stylesheet" href="template/dashboard/css/bootstrap-responsive.min.css" />
            <link rel="stylesheet" href="template/dashboard/css/fullcalendar.css" />
            <link rel="stylesheet" href="template/dashboard/css/matrix-style.css" />
            <link rel="stylesheet" href="template/dashboard/css/matrix-media.css" />
            <link href="template/dashboard/font-awesome/css/font-awesome.css" rel="stylesheet" />
            <link rel="stylesheet" href="template/dashboard/css/jquery.gritter.css" />
            <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800' rel='stylesheet' type='text/css'>

            <style>
                @page {
                    size: auto;
                }

                body {
                    background: rgb(204, 204, 204);
                }

                page {
                    background: white;
                    display: block;
                    margin: 0 auto;
                    margin-bottom: 0.5cm;
                    box-shadow: 0 0 0.1cm rgba(0, 0, 0, 0.5);
                }

                page[size="A4"] {
                    width: 29.7cm;
                    height: 21cm;
                }

                page[size="A4"][layout="potrait"] {
                    width: 29.7cm;
                    height: 21cm;
                }

                page[size="A3"] {
                    width: 29.7cm;
                    height: 42cm;
                }

                page[size="A3"][layout="landscape"] {
                    width: 42cm;
                    height: 29.7cm;
                }

                page[size="A5"] {
                    width: 14.8cm;
                    height: 21cm;
                }

                page[size="A5"][layout="landscape"] {
                    width: 21cm;
                    height: 19.8cm;
                }

                page[size="dipakai"][layout="landscape"] {
                    width: 20cm;
                    height: 20cm;
                }

                @media print {
                    body,
                    page {
                        margin: auto;
                        box-shadow: 0;
                    }
                }
            </style>
        </head>

        <body>

            <page size="dipakai" layout="landscape">
                <br>
                <div class="container">
                    <span id="remove">
                        <a class="btn btn-success" id="printLaporan"><span class="icon-print"></span> CETAK</a>
                    </span>
                </div>
                <?php
                    $uang = 0;
                    $query_lihat_menu = "select * from tb_menu";
                    $sql_lihat_menu = mysqli_query($conn, $query_lihat_menu);
                    ?>
                    <center>
                        <h4>
                            RESTAURANT CEPAT SAJI
                        </h4>
                        <span>
                            Jl. Imam Bonjol No. 103 Ds. Tembarak, Kec. Kertosono, Kab. Nganjuk, Jatim<br>
                            Telp. +6289 xxx xxx xxx || E-mail exsample@gmail.com
                        </span>
                    </center>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="head0">No.</th>
                                <th class="head1">Menu</th>
                                <th class="head0 right">Jumlah Terjual</th>
                                <th class="head1 right">Harga</th>
                                <th class="head0 right">Total Masukan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $no = 1;
                                while ($r_lihat_menu = mysqli_fetch_array($sql_lihat_menu)) {
                                    ?>
                                    <tr>
                                        <td><center><?php echo $no++; ?>.</center></td>
                                        <td><?php echo $r_lihat_menu['nama_masakan']; ?></td>
                                        <td>
                                            <center>
                                                <?php
                                                    $id_masakan = $r_lihat_menu['id_masakan'];
                                                    $query_lihat_stok = "select * from tb_transaksi left join tb_pesanan on tb_transaksi.id_pesan = tb_pesanan.id_pesan left join tb_menu on tb_pesanan.id_masakan = tb_menu.id_masakan where status_cetak = 'belum cetak'";
                                                    $query_jumlah = "select sum(jumlah_terjual) as jumlah_terjual from tb_transaksi left join tb_pesanan on tb_transaksi.id_pesan = tb_pesanan.id_pesan left join tb_menu on tb_pesanan.id_masakan = tb_menu.id_masakan where status_cetak = 'belum cetak' and tb_pesanan.id_masakan = $id_masakan";
                                                    $sql_lihat_stok = mysqli_query($conn, $query_lihat_stok);
                                                    $sql_jumlah = mysqli_query($conn, $query_jumlah);
                                                    $r_jumlah = mysqli_fetch_array($sql_jumlah);
                                                    echo $r_jumlah['jumlah_terjual'];
                                                ?>
                                            </center>
                                        </td>
                                        <td class="right">Rp. <?php echo $r_lihat_menu['harga']; ?>,-</td>
                                        <td class="right">
                                            <strong>
                                                Rp.
                                                <?php
                                                    $total_masukan = $r_lihat_menu['harga'] * $r_jumlah['jumlah_terjual'];
                                                    $uang += $total_masukan;
                                                    echo $total_masukan;
                                                ?>,-
                                            </strong>
                                        </td>
                                    </tr>
                                <?php
                                }
                                ?>
                        </tbody>
                    </table>

                    <hr>

                    <center>
                        <h5>
                            TOTAL UANG MASUK HARI INI: Rp. <?php echo $uang; ?>,-
                        </h5>
                    </center>
                    <hr>
            </page>
        </body>

        <script type="text/javascript">
            document.getElementById('printLaporan').onclick = function () {
                $("#remove").remove();
                window.print();
            };
            $(document).ready(function () {
                $("remove").remove();
            });
        </script>

        <script src="template/dashboard/js/excanvas.min.js"></script>
        <script src="template/dashboard/js/jquery.min.js"></script>
        <script src="template/dashboard/js/jquery.ui.custom.js"></script>
        <script src="template/dashboard/js/bootstrap.min.js"></script>
        <script src="template/dashboard/js/jquery.flot.min.js"></script>
        <script src="template/dashboard/js/jquery.flot.resize.min.js"></script>
        <script src="template/dashboard/js/jquery.peity.min.js"></script>
        <script src="template/dashboard/js/fullcalendar.min.js"></script>
        <script src="template/dashboard/js/matrix.js"></script>
        <script src="template/dashboard/js/matrix.dashboard.js"></script>
        <script src="template/dashboard/js/jquery.gritter.min.js"></script>
        <script src="template/dashboard/js/matrix.interface.js"></script>
        <script src="template/dashboard/js/matrix.chat.js"></script>
        <script src="template/dashboard/js/jquery.validate.js"></script>
        <script src="template/dashboard/js/matrix.form_validation.js"></script>
        <script src="template/dashboard/js/jquery.wizard.js"></script>
        <script src="template/dashboard/js/jquery.uniform.js"></script>
        <script src="template/dashboard/js/select2.min.js"></script>
        <script src="template/dashboard/js/matrix.popover.js"></script>
        <script src="template/dashboard/js/jquery.dataTables.min.js"></script>
        <script src="template/dashboard/js/matrix.tables.js"></script>
    </html>

<?php
    }
}
?>
