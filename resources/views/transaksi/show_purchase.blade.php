@extends('master')

@section('content')
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Lihat Pembelian
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="{{ url('purchase') }}">Proses Pembelian</a></li>
        <li><a href="javascript:void(0)">Lihat Pembelian</a></li>
        
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box" style="width: 60%;">
        
        <div class="box-body">
                <table class="table table-bordered table-hover">
                  <tr>
                    <td width="45%">TGL</td>
                    <td width="2%">:</td>
                    <td width="*">{{ $purchase->created_at }}</td>
                  </tr>
                  <tr>
                    <td width="45%">INVOICE</td>
                    <td width="2%">:</td>
                    <td width="*">{{ $purchase->invoice }}</td>
                  </tr>
                  <tr>
                    <td width="45%">SUPPLIER</td>
                    <td width="2%">:</td>
                    <td width="*">{{ $purchase->supplier_name }}</td>
                  </tr>
                  <tr>
                    <td width="45%"></td>
                    <td width="2%">:</td>
                    <td width="*">{{ $purchase->supplier_address }}</td>
                  </tr>
                  <tr>
                    <td width="45%"></td>
                    <td width="2%">:</td>
                    <td width="*">{{ $purchase->supplier_phone }}</td>
                  </tr>
                  <tr>
                    <td width="45%">PEMBAYARAN</td>
                    <td width="2%">:</td>
                    <td width="*"><?php if($purchase->tipe =="1"){ echo "Cash"; }else{ echo "Credit";};?></td>
                  </tr>
                  <tr>
                    <td width="45%">JATUH TEMPO</td>
                    <td width="2%">:</td>
                    <td width="*">{{ $purchase->hari }} Hari <i class="fa fa-arrow-right"></i> Tanggal : {{ date('d-m-Y', strtotime('+'.$purchase->hari. 'days', strtotime(date("Y-m-d")))) }}</td>
                  </tr>
                  <tr>
                    <td width="45%">KETERANGAN</td>
                    <td width="2%">:</td>
                    <td width="*">{{ $purchase->description }}</td>
                  </tr>

                  
                </table>
            
                <table class="table table-bordered table-hover">
                    <tr>
                         <td colspan="6" style="text-align: center;"><strong>ITEM PEMBELIAN</strong></td>
                    </tr>
                    <tr>
                        <td>Kode</td>
                        <td>Nama Barang</td>
                        <td>Satuan</td>
                        <td>Jumlah</td>
                        <td>Harga</td>
                        <td>Total</td>

                    </tr>
                    @foreach($details as $key)
                    <tr>
                      <td>{{ $key->item_cd }}</td>
                      <td>{{ $key->material_name}}</td>
                      <td>{{ $key->item_unit}}</td>
                      <td style="text-align: right;">{{ $key->quantity }}</td>
                      <td style="text-align: right;">{{ number_format($key->item_price) }}</td>
                      <td style="text-align: right;">{{ number_format($key->item_total) }}</td>
                    </tr>
                    @endforeach
                    <tr>
                      <td colspan="5" style="text-align: right;">Total Rp. </td>
                      <td style="text-align: right;"><strong>{{ number_format($purchase->total) }}</strong></td>
                    </tr>
                    <tr>
                      <td colspan="5" style="text-align: right;">Down Payment (DP) Rp. </td>
                      <td style="text-align: right;"><strong>({{ number_format($purchase->dp) }}) </strong></td>
                    </tr>
                    <tr>
                      <td colspan="5" style="text-align: right;">Sisa Rp. </td>
                      <td style="text-align: right;"><strong>{{ number_format($purchase->total - $purchase->dp) }}</strong></td>
                    </tr>
                </table>
                
        
        
        </div>
        <a href="{{ url('purchase') }}"><button class="btn btn-sm btn-info"><i class="fa fa-arrow-left"></i> Kembali</button></a>
      
      </div>



     
      <!-- /.box -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->


@endsection